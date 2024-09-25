<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambia según tu configuración
$username = "root";
$password = "";
$dbname = "rocket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió la matrícula
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];

    // Eliminar el vehículo
    $sql = "DELETE FROM vehiculos WHERE Matricula=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);

    if ($stmt->execute()) {
        echo "Vehículo eliminado exitosamente.";
    } else {
        echo "Error al eliminar vehículo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>