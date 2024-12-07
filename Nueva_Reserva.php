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

    // Validaciones básicas
    $errores = [];

    if (empty($numreserva) || !is_numeric($numreserva) || $numreserva <= 0) {
        $errores[] = "El número de reserva debe ser un número mayor a 0.";
    }
    if (empty($idCliente)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($idVehiculo)) {
        $errores[] = "La matricula es obligatoria.";
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
        header("Location: reservas.php?mensaje=" . urlencode($mensaje));
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

    // Conexión y consulta
    $MiConexion = ConexionBD();

    // Insertando la reserva en la tabla de reservas 
    $SQL = "INSERT INTO `reservas-vehiculos` (numeroReserva,
                                             fechaReserva, 
                                             fechaInicioReserva, 
                                             FechaFinReserva, 
                                             idCliente, 
                                             idVehiculo) 
              VALUES ($numreserva, 
                     NOW(), 
                     '$fecharetiroIngles', 
                     '$fechadevolucionIngles', 
                     $idCliente, 
                     $idVehiculo); ";

    
    $rs = mysqli_query($MiConexion, $SQL);

    if (!$rs) {
        $mensaje = "Error al agregar reserva: ";
    }
    else {

        $estadocontrato = 1;
        $preciopordia = 0;
        $diferenciaDias = 0;
        $montoTotal = 0;

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

                            $mensaje = "Reserva agregada exitosamente. El contrato se encuentra asociado y en preparación.";
                        }
                    }
                }
            }
        }
    }

    // Redirigir con un mensaje
    header("Location: reservas.php?mensaje=" . urlencode($mensaje));
    exit();
}

?>