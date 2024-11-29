<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

// Verificar si el ID de la reserva está presente en la URL
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    // Consulta para eliminar el cliente de la base de datos
    $SQLdelete = "DELETE FROM `reservas-vehiculos` 
                  WHERE idReserva = ?";

    $stmt = $MiConexion->prepare($SQLdelete);
    $stmt->bind_param("i", $idReserva);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Redirigir al listado de clientes con un mensaje de éxito
        header('Location: reservas.php?mensaje=El cliente ha sido eliminado correctamente.');
        exit();
    } else {
        // Si no se eliminó ningún registro, mostrar un mensaje de error
        header('Location: reservas.php?mensaje=Error al eliminar el cliente.');
        exit();
    }
} 
else {
    // Si no se pasó un ID, redirigir al listado de reservas
    header('Location: reservas.php');
    exit();
}


?>