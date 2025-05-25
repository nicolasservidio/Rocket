<?php

session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idContrato = $_POST['idContrato'];
    $fechadevolucion = $_POST['fechadevolucion'];
    $horadevolucion = $_POST['horadevolucion'];


    // Validaciones básicas
    $errores = [];

    if (empty($idContrato)) {
        $errores[] = "La selección de un contrato es obligatoria. ";
    }
    if (empty($fechadevolucion)) {
        $errores[] .= "Registrá la fecha de devolucion al cliente. ";
    }
    if (empty($horadevolucion)) {
        $errores[] .= "Registrá la hora de devolucion al cliente.";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        header("Location: devolucionVehiculo.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    // Procesamiento de las fechas
    $fechaEspanol = date_parse($fechadevolucion);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechadevolucionIngles = "$year-$mo-$day";
    
    // Procesamiento de horas
    // no se requiere 

    // Conexión y consulta
    $MiConexion = ConexionBD();


    // Antes de insertar la devolucion a cliente, necesito el ID del cliente asociado al contrato, tal como se encuentra especificado en la tabla "contratos-alquiler"    
    $IdCliente = array();

    $SQL_IdCliente = "SELECT idCliente FROM `contratos-alquiler` WHERE idContrato = $idContrato; ";

    $rs = mysqli_query($MiConexion, $SQL_IdCliente);
    $data = mysqli_fetch_array($rs);
    $IdCliente['IdCliente'] = $data['idCliente'];

    $IdCliente = $IdCliente['IdCliente'];

    // Ahora sí, registro la devolucion del vehículo
    $SQL_DevolucionVehiculo = "INSERT INTO `devoluciones-vehiculos` (fechaDevolucion,
                                                                    horaDevolucion, 
                                                                    idCliente,
                                                                    idContrato,
                                                                    estadoDevolucion,
                                                                    aclaracionesDevolucion,
                                                                    infraccionesDevolucion,
                                                                    costosInfracciones,
                                                                    montoExtra) 
                            VALUES ('$fechadevolucionIngles', 
                                    '$horadevolucion', 
                                    $IdCliente,
                                    $idContrato,
                                    'Sin cambios',
                                    'Sin aclaraciones',
                                    'Ninguna',
                                    '0',
                                    '0'); ";

    
    $rs = mysqli_query($MiConexion, $SQL_DevolucionVehiculo);

    if (!$rs) {
        $mensaje = "Error al registrar la devolucion del cliente";
        header("Location: devolucionVehiculo.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    else {
        $mensaje = "Devolucion del cliente registrada exitosamente. ";

        // A continuación debemos cambiar el estado del contrato, de "Activo" o "Renovado" a "Finalizado", e incluir la 
        // fecha de devolución en la tabla "contratos-alquiler"
        $SQL_Update = "UPDATE `contratos-alquiler` 
                        SET idEstadoContrato=6, 
                            fechaDevolucion = '$fechadevolucionIngles' 
                        WHERE idContrato=$idContrato; ";

        $recordUpdate = mysqli_query($MiConexion, $SQL_Update);

        if (!$recordUpdate) {

            //si surge un error, finalizo la ejecucion del script con un mensaje
            $mensaje = "Error al intentar cambiar el estado del contrato a Finalizado.";
            header("Location: devolucionVehiculo.php?mensaje=" . urlencode($mensaje));
            exit();
        }
        else {

            // Redirigir con un mensaje
            $mensaje.="El estado del contrato pasó a Finalizado. Número identificador del contrato: {$idContrato}. ";
            echo "<script> 
                alert('$mensaje');
                window.location.href = 'devolucionVehiculo.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoDevolucion';
            </script>";
            exit(); 
        }
    }

}

?>
