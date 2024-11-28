<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "rocket");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$id = $_POST['id'];
$documento = $_POST['nombre'];
$apellido = $_POST['apellido'];
$nombre = $_POST['dni'];
$direccion = $_POST['telefono'];
$telefono = $_POST['mail'];
$email = $_POST['direccion'];

// Insertar los datos en la tabla
$sql = "INSERT INTO clientes (IdCliente, nombreCliente, apellidoCliente, dniCliente, telefonoCliente, mailCliente, direccionCliente) 
        VALUES ('$id', '$nombre', '$apellido', '$dni', '$telefono', '$mail', '$direccion')";

if ($conexion->query($sql) === TRUE) {
    $mensajeExito = "Cliente cargado con éxito.";
    // Redirigir a clientes.php con el mensaje de éxito
    header("Location: clientes.php?mensajeExito=" . urlencode($mensajeExito));
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

$conexion->close();
?>
