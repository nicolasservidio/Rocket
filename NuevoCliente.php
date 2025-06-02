<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = strip_tags($_POST['documento']);
    $documento = trim($documento);
    $nombre = strip_tags($_POST['nombre']);
    $nombre = trim($nombre);
    $apellido = strip_tags($_POST['apellido']);
    $apellido = trim($apellido);
    $email = strip_tags($_POST['email']);
    $email = trim($email);
    $telefono = strip_tags($_POST['telefono']);
    $telefono = trim($telefono);
    $direccion = strip_tags($_POST['direccion']);
    $direccion = trim($direccion);

    // Validaciones básicas
    $mensaje = "";
    $errores = [];

    if (empty($documento) || !is_numeric($documento) || $documento < 1000000 || $documento > 999999999999) {
        $errores[] = "El documento debe ser un número con 7 a 12 dígitos.";
    }
    if (empty($nombre) || strlen($nombre) < 3) {
        $errores[] = "El nombre es obligatorio y no puede presentar menos de 3 caracteres.";
    }
    if (strlen($nombre) > 50) {
        $errores[] = "El nombre no puede presentar más de 50 caracteres.";
    }
    if (empty($apellido) || strlen($apellido) < 3) {
        $errores[] = "El apellido es obligatorio y no puede presentar menos de 3 caracteres.";
    }
    if (strlen($apellido) > 50) {
        $errores[] = "El apellido no puede presentar más de 50 caracteres.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    if (strlen($email) > 50) {
        $errores[] = "El correo electrónico no puede presentar más de 50 caracteres.";
    }
    if (empty($telefono) || !preg_match('/^[0-9]{7,15}$/', $telefono)) {
        $errores[] = "El teléfono debe contener entre 7 y 15 dígitos.";
    }
    if (empty($direccion) || strlen($direccion) < 5) {
        $errores[] = "La dirección es obligatoria y no puede presentar menos de 5 caracteres.";
    }
    if (strlen($direccion) > 50) {
        $errores[] = "La dirección no puede presentar más de 50 caracteres.";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {

        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'clientes.php';
        </script>";
        exit();
    }

    // Conexión y consulta
    $MiConexion = ConexionBD();

    $query = "INSERT INTO clientes (dniCliente, nombreCliente, apellidoCliente, mailCliente, telefonoCliente, direccionCliente) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $MiConexion->prepare($query);

    // Vinculamos los valores en el orden correcto
    $stmt->bind_param("isssss", $documento, $nombre, $apellido, $email, $telefono, $direccion);

    if ($stmt->execute()) {
        $mensaje = "Cliente agregado exitosamente. Número de documento: {$documento}.";
    } else {
        $mensaje = "Error al agregar cliente: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'clientes.php?documento={$documento}&nombre=&apellido=&email=&telefono=&direccion=';
    </script>";
    exit();

}
?>