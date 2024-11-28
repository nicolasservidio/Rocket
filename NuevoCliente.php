<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = trim($_POST['documento']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);

    // Validaciones básicas
    $errores = [];

    if (empty($documento) || !is_numeric($documento) || $documento <= 0) {
        $errores[] = "El documento debe ser un número mayor a 0.";
    }
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($apellido)) {
        $errores[] = "El apellido es obligatorio.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    if (empty($telefono) || !preg_match('/^[0-9]{7,15}$/', $telefono)) {
        $errores[] = "El teléfono debe contener entre 7 y 15 dígitos.";
    }
    if (empty($direccion)) {
        $errores[] = "La dirección es obligatoria.";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        header("Location: clientes.php?mensaje=" . urlencode($mensaje));
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
        $mensaje = "Cliente agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar cliente: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    header("Location: clientes.php?mensaje=" . urlencode($mensaje));
    exit();
}
?>
