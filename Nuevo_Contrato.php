<?php

session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idCliente = $_POST['idCliente'];
    $idVehiculo = $_POST['idVehiculo'];
    $fecharetiro = $_POST['fecharetiro'];
    $fechadevolucion = $_POST['fechadevolucion'];
    $estadocontrato = 1;
    $preciopordia = $_POST['precioporDia'];


    // Validaciones básicas
    $errores = [];

    if (empty($preciopordia) || !is_numeric($preciopordia) || $preciopordia <= 0) {
        $errores[] = "El precio por día es obligatorio.";
    }
    if (empty($idCliente)) {
        $errores[] = "El cliente es obligatorio.";
    }
    if (empty($idVehiculo)) {
        $errores[] = "El vehículo es obligatoria.";
    }
    if (empty($fecharetiro)) {
        $errores[] = "La fecha de retiro es obligatoria.";
    }
    if (empty($fechadevolucion)) {
        $errores[] = "La fecha de devolución es obligatoria.";
    }

    // Validación de fechas
    if (!empty($fecharetiro) && !empty($fechadevolucion)) {
        $fechaRetiroValidacion = new DateTime($fecharetiro);
        $fechaDevolucionValidacion = new DateTime($fechadevolucion);

        if ($fechaRetiroValidacion > $fechaDevolucionValidacion) {
            $errores[] = "La fecha de retiro no puede ser posterior a la fecha de devolución.";
        }
        else {
            // Validación de duración máxima de contrato (1 mes)
            $intervalo = $fechaRetiroValidacion->diff($fechaDevolucionValidacion);
            if ($intervalo->days > 30) { 
                $errores[] = "Los contratos no pueden superar 1 mes de duración.";
            }
        }
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'contratosAlquiler.php';
        </script>";
        exit();
    }

    // Procesamiento de las fechas
    $fechaEspanol = date_parse($fecharetiro);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fecharetiroIngles = "$year-$mo-$day";
    
    $fechaEspanol = date_parse($fechadevolucion);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechadevolucionIngles = "$year-$mo-$day";

    // Cálculo de cantidad de días
    $min_date = "$fecharetiroIngles";
    $max_date = "$fechadevolucionIngles";
    $dif_min = new DateTime($min_date);
    $dif_max = new DateTime($max_date);
    $intervalo = $dif_min->diff($dif_max);
    $diferenciaDias = $intervalo->days;
    $diferenciaDias = intval($diferenciaDias);
/*    $horas_totales = $intervalo->format('%d:%H:%i'); */


    // Monto total:
    $montoTotal = $diferenciaDias * $preciopordia;

    // Conexión y consulta
    $MiConexion = ConexionBD();

    // Registro en el 'Detalle del Contrato'
    $SQL_DetalleContrato = "INSERT INTO `detalle-contratos` (precioPorDiaContrato,
                                                            cantidadDiasContrato, 
                                                            montoTotalContrato) 
                            VALUES ($preciopordia, 
                                    $diferenciaDias, 
                                    $montoTotal); ";

    
    $rs = mysqli_query($MiConexion, $SQL_DetalleContrato);

    if (!$rs) {
        $mensaje = "Error al agregar detalle del contrato: ";
    }

    else {
        $mensaje = "Detalle del contrato agregado exitosamente.";
        $idDetalle = array();

        // Seleccionamos y congelamos (bloqueamos) el último "id" agregado a la tabla "Detalle del contrato" para su uso en una transacción:
        $SQL_SeleccionIdDetalle = "SELECT idDetalleContrato 
                                    FROM `detalle-contratos` 
                                    ORDER BY idDetalleContrato DESC LIMIT 1 FOR UPDATE;";

        $recordId = mysqli_query($MiConexion, $SQL_SeleccionIdDetalle);

        if (!$recordId) {
            $mensaje = "Error al seleccionar el ID del detalle del contrato: ";
        }
        
        else {
            $mensaje = "Detalle bloqueado correctamente.";

            $data = mysqli_fetch_array($recordId);
            $idDetalle['IdDetalle'] = $data['idDetalleContrato'];

            $IdDetalleContrato = $idDetalle['IdDetalle'];

            // Se realiza el registro en el encabezado de la transacción:

            $SQL_Contrato = "INSERT INTO `contratos-alquiler` (fechaInicioContrato,
                                                               fechaFinContrato, 
                                                               idCliente,
                                                               idVehiculo,
                                                               idDetalleContrato,
                                                               idEstadoContrato) 
                            VALUES ('$fecharetiroIngles', 
                            '$fechadevolucionIngles', 
                            $idCliente, 
                            $idVehiculo, 
                            $IdDetalleContrato, 
                            $estadocontrato); ";


            $rss = mysqli_query($MiConexion, $SQL_Contrato);

            if (!$rss) {
                $mensaje = "Error al realizar la transacción. ";
            }

            else {

                // Seleccionamos y bloqueamos el ID del contrato que acabamos de agregar, para mostrar al usuario
                $numeroContrato = array();

                $SQL_SeleccionIdContrato = "SELECT idContrato 
                                            FROM `contratos-alquiler` 
                                            ORDER BY idContrato DESC 
                                            LIMIT 1;";

                $recordId = mysqli_query($MiConexion, $SQL_SeleccionIdContrato);
                $data = mysqli_fetch_array($recordId);
                $numeroContrato['idContrato'] = $data['idContrato'];
                $numeroContratoMensaje = $numeroContrato['idContrato'];

                $mensaje = "Transacción completada exitosamente. Contrato número {$numeroContratoMensaje}. Retiro: {$fecharetiroIngles}. Devolución: {$fechadevolucionIngles}. Precio por día: {$preciopordia} USD (a {$diferenciaDias} días). Monto total: {$montoTotal} USD.";
                echo "<script> 
                    alert('$mensaje');
                    window.location.href = 'contratosAlquiler.php?NumeroContrato={$numeroContratoMensaje}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
                </script>";
                exit();
            }
        } 
    }

    // Redirigir con un mensaje
    if (!empty($mensaje)) {
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'contratosAlquiler.php';
        </script>";
        exit();
    }

}

?>
