<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "rocket");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$documento = $_POST['documento'];
$fechaNac = $_POST['fechaNac'];
$apellido = $_POST['apellido'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$pais = $_POST['pais'];
$ciudad = $_POST['ciudad'];
$email = $_POST['email'];
$registroCond = $_POST['registroCond'];
$paisExp = $_POST['paisExp'];
$fechaExp = $_POST['fechaExp'];
$fechaVenc = $_POST['fechaVenc'];
$tarjeta = $_POST['tarjeta'];
$vto = $_POST['vto'];

// Insertar los datos en la tabla
$sql = "INSERT INTO clientes (documento, fechaNac, apellido, nombre, direccion, telefono, celular, pais, ciudad, email, registroCond, paisExp, fechaExp, fechaVenc, tarjeta, vto) 
        VALUES ('$documento', '$fechaNac', '$apellido', '$nombre', '$direccion', '$telefono', '$celular', '$pais', '$ciudad', '$email', '$registroCond', '$paisExp', '$fechaExp', '$fechaVenc', '$tarjeta', '$vto')";

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
