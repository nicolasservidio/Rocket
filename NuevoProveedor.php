<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cuit = strip_tags($_POST['cuit']);
    $cuit = trim($cuit);
    $nombre = strip_tags($_POST['nombre']);
    $nombre = trim($nombre);
    $iva = strip_tags($_POST['iva']);
    $iva = trim($iva);
    $email = strip_tags($_POST['email']);
    $email = trim($email);
    $telefono = strip_tags($_POST['telefono']);
    $telefono = trim($telefono);
    $direccion = strip_tags($_POST['direccion']);
    $direccion = trim($direccion);
    $localidad = strip_tags($_POST['localidad']);
    $localidad = trim($localidad);

    // Validaciones básicas
    $errores = [];

    if (empty($cuit) || !is_numeric($cuit) || $cuit <= 0) {
        $errores[] = "El cuit debe ser un número mayor a 0.";
    }
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($iva)) {
        $errores[] = "El iva es obligatorio.";
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
    if (empty($localidad)) {
        $errores[] = "La localidad es obligatoria.";
    }    

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        header("Location: proveedores.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    // Conexión y consulta
    $MiConexion = ConexionBD();

    $query = "INSERT INTO proveedores (cuitProveedor, nombreProveedor, ivaProveedor, mailProveedor, telefonoProveedor, direccionProveedor, localidadProveedor) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $MiConexion->prepare($query);

    // Vinculamos los valores en el orden correcto
    $stmt->bind_param("isssiss", $cuit, $nombre, $iva, $email, $telefono, $direccion, $localidad);

    if ($stmt->execute()) {
        $mensaje = "Proveedor agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar Proveedor: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    header("Location: proveedores.php?mensaje=" . urlencode($mensaje));
    exit();
}
?>