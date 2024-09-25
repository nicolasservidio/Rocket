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

// Verificar si se recibieron los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $modelo = $_POST['modelo'];
    $grupo = $_POST['grupo'];
    $disponible = $_POST['disponible'];

    // Actualizar los datos del vehículo
    $sql = "UPDATE vehiculos SET Modelo=?, Grupo=?, Disponible=? WHERE Matricula=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $modelo, $grupo, $disponible, $matricula);

    if ($stmt->execute()) {
        echo "Vehículo modificado exitosamente.";
    } else {
        echo "Error al modificar vehículo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Redirigir de vuelta a la página anterior
header("Location: OpVehiculos.php"); 
exit();
?>
