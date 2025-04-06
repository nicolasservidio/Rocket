<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

// Verificar si el ID del proveedor está presente en la URL
if (isset($_GET['id'])) {
    $idProveedor = $_GET['id'];

    // Consulta para eliminar el proveedor de la base de datos
    $consulta = "DELETE FROM proveedores WHERE idProveedor = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idProveedor);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Redirigir al listado de proveedors con un mensaje de éxito
        header('Location: proveedores.php?mensaje=El proveedor ha sido eliminado correctamente.');
        exit();
    } else {
        // Si no se eliminó ningún registro, mostrar un mensaje de error
        header('Location: proveedores.php?mensaje=Error al eliminar el proveedor.');
        exit();
    }
} 
else {
    // Si no se pasa un ID, redirigir al listado de proveedors
    header('Location: proveedores.php');
    exit();
}

?>