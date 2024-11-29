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
    $fechaEspanol = $fecharetiro;
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $$fecharetiro = "$year-$mo-$day";
    
    $fechaEspanol = $fechadevolucion;
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechadevolucion = "$year-$mo-$day";

    // Conexión y consulta
    $MiConexion = ConexionBD();

    $SQL = "INSERT INTO `reservas-vehiculos` (numeroReserva,
                                                fechaReserva, 
                                                fechaInicioReserva, 
                                                FechaFinReserva, 
                                                idCliente, 
                                                idVehiculo) 
              VALUES ($numreserva, 
                     NOW(), 
                     $fecharetiro, 
                     $fechadevolucion, 
                     $idCliente, 
                     $idVehiculo); ";

    
    $rs = mysqli_query($MiConexion, $SQL);

    if (!$rs) {
        $mensaje = "Error al agregar reserva: ";
    }
    else {
        $mensaje = "Reserva agregada exitosamente.";
    }

    // Redirigir con un mensaje
    header("Location: reservas.php?mensaje=" . urlencode($mensaje));
    exit();
}

?>