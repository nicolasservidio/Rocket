<?php

session_start();

require_once 'corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

$conexion = ConexionBD();

// Verificar si se recibió la matrícula
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];

    // Eliminar el vehículo
    $sql = "DELETE FROM vehiculos WHERE matricula=?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $matricula);

    if ($stmt->execute()) {
        echo "Vehículo eliminado exitosamente.";
    } else {
        echo "Error al eliminar vehículo: " . $stmt->error;
    }

    $stmt->close();
}

// Necesario adjuntar aquí la conexión
function ConexionBD($Host = "localhost", $User = "root", $Password = "root", $BaseDeDatos = "rocket") {
    
    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos,);

    if ($linkConexion != false) {
        return $linkConexion;
    } 
    else {
        die("No se pudo establecer la conexión.");
    }
}


?>