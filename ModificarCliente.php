<<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rocket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibieron los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Asegúrate de que el formulario incluya este campo oculto
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];

    // Actualizar los datos del cliente
    $sql = "UPDATE clientes SET Nombre=?, Apellido=?, Dni=? WHERE Id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id);

    if ($stmt->execute()) {
        echo "Cliente modificado exitosamente.";
    } else {
        echo "Error al modificar cliente: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Redirigir de vuelta a la página anterior
header("Location: ListadoClientes.php");
exit();
?>