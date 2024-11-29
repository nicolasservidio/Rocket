<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

// Verificar si el ID del cliente está presente en la URL
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Consulta para eliminar el cliente de la base de datos
    $consulta = "DELETE FROM clientes WHERE idCliente = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Redirigir al listado de clientes con un mensaje de éxito
        header('Location: clientes.php?mensaje=El cliente ha sido eliminado correctamente.');
        exit();
    } else {
        // Si no se eliminó ningún registro, mostrar un mensaje de error
        header('Location: clientes.php?mensaje=Error al eliminar el cliente.');
        exit();
    }
} 
else {
    // Si no se pasa un ID, redirigir al listado de clientes
    header('Location: clientes.php');
    exit();
}

?>