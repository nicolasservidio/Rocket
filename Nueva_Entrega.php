<?php

session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idContrato = $_POST['idContrato'];
    $fechaentrega = $_POST['fechaentrega'];
    $horaentrega = $_POST['horaentrega'];


    // Validaciones básicas
    $errores = [];

    if (empty($idContrato)) {
        $errores[] = "La selección de un contrato es obligatoria. ";
    }
    if (empty($fechaentrega)) {
        $errores[] .= "Registrá la fecha de entrega al cliente. ";
    }
    if (empty($horaentrega)) {
        $errores[] .= "Registrá la hora de entrega al cliente.";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        header("Location: entregaVehiculo.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    // Procesamiento de las fechas
    $fechaEspanol = date_parse($fechaentrega);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaentregaIngles = "$year-$mo-$day";
    
    // Procesamiento de horas
    // No se requiere

    // Conexión y consulta
    $MiConexion = ConexionBD();


    // Antes de insertar la entrega a cliente, necesito el ID del cliente asociado al contrato, tal como se encuentra especificado en la tabla "contratos-alquiler"    
    $IdCliente = array();

    $SQL_IdCliente = "SELECT idCliente FROM `contratos-alquiler` WHERE idContrato = $idContrato; ";

    $rs = mysqli_query($MiConexion, $SQL_IdCliente);
    $data = mysqli_fetch_array($rs);
    $IdCliente['IdCliente'] = $data['idCliente'];

    $IdCliente = $IdCliente['IdCliente'];

    // Ahora sí, registro la entrega del vehículo
    $SQL_EntregaVehiculo = "INSERT INTO `entregas-vehiculos` (fechaEntrega,
                                                            horaEntrega, 
                                                            idCliente,
                                                            idContrato) 
                            VALUES ('$fechaentregaIngles', 
                                    '$horaentrega', 
                                    $IdCliente,
                                    $idContrato); ";

    
    $rs = mysqli_query($MiConexion, $SQL_EntregaVehiculo);

    if (!$rs) {
        $mensaje = "Error al registrar la entrega a cliente";
        header("Location: entregaVehiculo.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    else {
        $mensaje = "Entrega a cliente registrada exitosamente. ";

        // A continuación debemos cambiar el estado del contrato, de "Firmado" a "Activo"
        $SQL_Update = "UPDATE `contratos-alquiler` 
                        SET idEstadoContrato=4 
                        WHERE idContrato=$idContrato; ";

        $recordUpdate = mysqli_query($MiConexion, $SQL_Update);

        if (!$recordUpdate) {

            //si surge un error, finalizo la ejecucion del script con un mensaje
            $mensaje = "Error al intentar modificar el estado del contrato a Activo.";
            header("Location: entregaVehiculo.php?mensaje=" . urlencode($mensaje));
            exit();
        }
        else {

            // Redirigir con un mensaje
            $mensaje.="El estado del contrato pasó a Activo. Número identificador del contrato: {$idContrato}. ";
            echo "<script> 
                alert('$mensaje');
                window.location.href = 'entregaVehiculo.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&EntregaDesde=&EntregaHasta=&BotonFiltrar=FiltrandoEntregas';
            </script>";
            exit(); 
        }
    }

}

?>
