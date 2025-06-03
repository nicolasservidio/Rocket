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

    if (empty($cuit) || !is_numeric($cuit) || $cuit < 10000000 || $cuit > 999999999999) {
        $errores[] = "El cuit debe ser contener entre 8 y 12 dígitos.";
    }
    if (empty($nombre) || strlen($nombre) >= 50 ) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($iva)) {
        $errores[] = "La condición frente al IVA es obligatoria.";
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
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'proveedores.php';
        </script>";
        exit();
    }

    // Conexión y consultas
    $MiConexion = ConexionBD();

    // Validación de existencia del CUIT en la base de datos
    $SQL_VERIFICAR = "SELECT COUNT(*) AS total FROM proveedores WHERE cuitProveedor = ?";
    $stmt_verificar = $MiConexion->prepare($SQL_VERIFICAR);
    $stmt_verificar->bind_param("i", $cuit);
    $stmt_verificar->execute();
    $resultado_verificar = $stmt_verificar->get_result();
    $fila_verificar = $resultado_verificar->fetch_assoc();

    if ($fila_verificar['total'] > 0) {
        $errores[] = "El CUIT ya está registrado en el sistema. Por favor, ingresa otro.";
    }

    $stmt_verificar->close();

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'proveedores.php';
        </script>";
        exit();
    }

    // registro del nuevo proveedor
    $query = "INSERT INTO proveedores (cuitProveedor, nombreProveedor, ivaProveedor, mailProveedor, telefonoProveedor, direccionProveedor, localidadProveedor) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $MiConexion->prepare($query);

    // Vinculamos los valores en el orden correcto
    $stmt->bind_param("isssiss", $cuit, $nombre, $iva, $email, $telefono, $direccion, $localidad);

    if ($stmt->execute()) {
        $mensaje = "Proveedor agregado exitosamente. CUIT: {$cuit}.";
    } 
    else {
        $mensaje = "Error al agregar Proveedor: " . $MiConexion->error;
    }

    $stmt->close();
    $MiConexion->close();

    // Redirigir con un mensaje
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'proveedores.php?cuit={$cuit}&nombre=&iva=&email=&telefono=&direccion=&localidad=';
    </script>";
    exit();

}
?>