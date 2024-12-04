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

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        header("Location: contratosAlquiler.php?mensaje=" . urlencode($mensaje));
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
                $mensaje = "Transacción completada exitosamente.";
            }
        } 
    }

    // Redirigir con un mensaje
    header("Location: contratosAlquiler.php?mensaje=" . urlencode($mensaje));
    exit();
}

?>
