<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Verificar si el ID del vehículo está presente en la URL
if (isset($_GET['id'])) {
    $idVehiculo = $_GET['id'];

    // Consulta para eliminar el vehículo de la base de datos
    $sql = "DELETE FROM vehiculos WHERE idVehiculo=?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idVehiculo);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Redirigir al listado de vehículos con un mensaje de éxito
        header('Location: OpVehiculos.php?mensaje=El vehículo ha sido eliminado correctamente.');
        exit();
    } else {
        // Si no se eliminó ningún registro, mostrar un mensaje de error
        header('Location: OpVehiculos.php?mensaje=Error al eliminar el vehículo.');
        exit();
    }
}
else {
    // Si no se pasa un ID, redirigir al listado de vehículos
    header('Location: OpVehiculos.php?mensaje=No se reconoce ningún ID.');
    exit();
}

?>