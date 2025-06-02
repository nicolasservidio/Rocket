<?php

session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numreserva = strip_tags($_POST['numreserva']);
    $numreserva = trim($numreserva);

    $idCliente = $_POST['idCliente'];
    $idVehiculo = $_POST['idVehiculo'];
    $fecharetiro = $_POST['fecharetiro'];
    $fechadevolucion = $_POST['fechadevolucion'];
    $preciopordia = $_POST['PrecioPorDia'];
    $estadocontrato = 1;

    // Validaciones básicas
    $errores = [];

    if (empty($numreserva) || !is_numeric($numreserva) || $numreserva <= 0) {
        $errores[] = "El número de reserva debe ser un número mayor a 0.";
    }
    if (empty($idCliente)) {
        $errores[] = "El cliente es obligatorio.";
    }
    if (empty($idVehiculo)) {
        $errores[] = "La vehículo es obligatorio.";
    }
    if (empty($preciopordia)) {
        $errores[] = "El precio por día es obligatorio.";
    }
    if (empty($fecharetiro)) {
        $errores[] = "La fecha de retiro es obligatoria.";
    }
    if (empty($fechadevolucion)) {
        $errores[] = "La fecha de devolución es obligatoria.";
    }

    // Verificación de fechas
    if (!empty($fecharetiro) && !empty($fechadevolucion)) {
        $fechaRetiro = new DateTime($fecharetiro);
        $fechaDevolucion = new DateTime($fechadevolucion);

        if ($fechaRetiro > $fechaDevolucion) {
            $errores[] = "La fecha de retiro no puede ser posterior a la fecha de devolución.";
        }
        else {
            // Validación de duración máxima de reserva (1 mes)
            $intervalo = $fechaRetiro->diff($fechaDevolucion);
            if ($intervalo->days > 30) { 
                $errores[] = "Las reservas no pueden superar 1 mes de duración.";
            }
        }
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'reservas.php';
        </script>";
        exit();
    }

    // Validación de existencia del número de reserva, no se admiten duplicaciones

    // Primero la conexión
    $MiConexion = ConexionBD();

    // consulta
    $SQL_VERIFICAR = "SELECT COUNT(*) AS total FROM `reservas-vehiculos` WHERE numeroReserva = $numreserva;";
    $rs_verificar = mysqli_query($MiConexion, $SQL_VERIFICAR);
    $fila_verificar = mysqli_fetch_assoc($rs_verificar);

    if ($fila_verificar['total'] > 0) {
        $errores[] = "El número de reserva ya está registrado. Por favor, ingresa otro número.";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'reservas.php';
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

    
    // Antes de insertar la reserva, necesito el ID de la sucursal en la que se encuentra el vehículo, tal como se encuentra especificado en la tabla "vehiculos"    
    $IdSucursal = array();

    $SQL_IdSucursal = "SELECT idSucursal FROM vehiculos WHERE idVehiculo = $idVehiculo; ";

    $rs = mysqli_query($MiConexion, $SQL_IdSucursal);
    $data = mysqli_fetch_array($rs);
    $IdSucursal['IdSucursal'] = $data['idSucursal'];

    $idSucursal = $IdSucursal['IdSucursal'];


    // Ahora sí, insertando la reserva en la tabla de reservas 
    $SQL = "INSERT INTO `reservas-vehiculos` (numeroReserva,
                                             fechaReserva, 
                                             fechaInicioReserva, 
                                             FechaFinReserva, 
                                             precioPorDiaReserva,
                                             cantidadDiasReserva, 
                                             totalReserva, 
                                             idCliente, 
                                             idSucursal, 
                                             idVehiculo) 
              VALUES ($numreserva, 
                     NOW(), 
                     '$fecharetiroIngles', 
                     '$fechadevolucionIngles', 
                     $preciopordia,
                     $diferenciaDias,
                     $montoTotal, 
                     $idCliente, 
                     $idSucursal, 
                     $idVehiculo); ";

    
    $rs = mysqli_query($MiConexion, $SQL);

    if (!$rs) {
        $mensaje = "Error al agregar reserva: ";
    }
    else {

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

            $mensaje = "Reserva y Detalle del contrato agregados exitosamente. ";

            $idDetalle = array();
    
            // Seleccionamos y congelamos (bloqueamos) el último "id" agregado a la tabla "Detalle del contrato" para su uso en una transacción:
            $SQL_SeleccionIdDetalle = "SELECT idDetalleContrato 
                                        FROM `detalle-contratos` 
                                        ORDER BY idDetalleContrato DESC LIMIT 1 FOR UPDATE;";
    
            $recordId = mysqli_query($MiConexion, $SQL_SeleccionIdDetalle);

            if (!$recordId) {
                $mensaje.="Error al seleccionar el ID del detalle del contrato. ";
            }

            else {

                $mensaje.="Detalle bloqueado correctamente. ";

                $data = mysqli_fetch_array($recordId);
                $idDetalle['IdDetalle'] = $data['idDetalleContrato'];
    
                $IdDetalleContrato = $idDetalle['IdDetalle'];
    
                // Se realiza el registro en el encabezado de la transacción (la tabla de contratos):
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
                    $mensaje.="Error al insertar en contratos. ";
                }
    
                else {

                    $mensaje = "Falta agregar ID del contrato en la tabla de reservas. ";

                    $idContratoParaReservas = array();
            
                    // Seleccionamos y congelamos (bloqueamos) el último "id" agregado a la tabla "Contratos" para su uso en tabla de Reservas:
                    $SQL_SeleccionIdContrato = "SELECT idContrato 
                                                FROM `contratos-alquiler` 
                                                ORDER BY idContrato DESC LIMIT 1 FOR UPDATE;";
            
                    $recordId = mysqli_query($MiConexion, $SQL_SeleccionIdContrato);
        
                    if (!$recordId) {
                        $mensaje.="Error al seleccionar el ID del contrato. ";
                    }

                    else {

                        $mensaje.="Contrato bloqueado correctamente. ";

                        $data = mysqli_fetch_array($recordId);
                        $idContratoParaReservas['IdContrato'] = $data['idContrato'];
            
                        $IdContratoRecuperado = $idContratoParaReservas['IdContrato']; // El ID del contrato que voy a insertar en la tabla de Reservas


                        // Ahora necesito recuperar el último ID agregado en la tabla de Reservas, para saber en dónde insertar el ID del contrato

                        $idReservaAgregada = array();
                        // Seleccionamos y congelamos (bloqueamos) el último ID agregado a la tabla "Reservas" para saber en donde insertar el ID del contrato:
                        $SQL_SeleccionIdReserva = "SELECT idReserva 
                                                    FROM `reservas-vehiculos` 
                                                    ORDER BY idReserva DESC LIMIT 1 FOR UPDATE;";
                
                        $recordId = mysqli_query($MiConexion, $SQL_SeleccionIdReserva);
                        $data = mysqli_fetch_array($recordId);
                        $idReservaAgregada['IdReserva'] = $data['idReserva'];
            
                        $IdReservaRecuperada = $idReservaAgregada['IdReserva']; // El ID de la reserva en donde voy a insertar el ID del Contrato


                        // Ahora sí, por último, se realiza el registro del ID del contrato en la tabla de Reservas (actualización del registro):
                        $SQL_Reserva = "UPDATE `reservas-vehiculos` 
                                        SET idContrato = $IdContratoRecuperado 
                                        WHERE idReserva = $IdReservaRecuperada ; ";
        
                        $rss = mysqli_query($MiConexion, $SQL_Reserva);
            
                        if (!$rss) {
                            $mensaje.="Error al actualizar número de contrato en la tabla de reservas. ";
                        }

                        else {

                            $mensaje = "Reserva número {$numreserva} agregada exitosamente. El contrato que le corresponde se encuentra asociado y en preparación.";
                            echo "<script> 
                                alert('$mensaje');
                                window.location.href = 'reservas.php?NumeroReserva={$numreserva}&MatriculaReserva=&ApellidoReserva=&NombreReserva=&DocReserva=&RetiroDesde=&RetiroHasta=&BotonFiltrar=FiltrandoReservas';
                            </script>";
                            exit();
                        }
                    }
                }
            }
        }
    }

    // Redirigir con un mensaje en caso de que haya ocurrido cualquiera de los errores anteriormente especificados
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'reservas.php';
    </script>";
    exit();
}

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

