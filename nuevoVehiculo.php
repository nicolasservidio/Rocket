<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rocket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $modelo = $_POST['modelo'];
    $grupo = $_POST['grupo'];
    $disponible = $_POST['disponible'];

    $sql = "INSERT INTO vehiculos (matricula, modelo, grupo, disponible) VALUES ('$matricula', '$modelo', '$grupo', '$disponible')";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo vehículo agregado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: OpVehiculos.php");
?>
