<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Obtener los datos del cliente
    $consulta = "SELECT * FROM clientes WHERE idCliente = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $cliente = $resultado->fetch_assoc();
} 
else {
    // Si no se pasa un ID, redirigir al listado
    header('Location: clientes.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Validaciones básicas
    $mensaje = "";
    $errores = [];

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
            window.location.href = 'clientes.php?documento={$cliente['dniCliente']}&nombre=&apellido=&email=&telefono=&direccion=';
        </script>";
        exit();
    }


    // Actualizar los datos del cliente
    $consulta = "UPDATE clientes 
                    SET nombreCliente = ?, 
                        apellidoCliente = ?, 
                        mailCliente = ?, 
                        telefonoCliente = ?, 
                        direccionCliente = ? 
                    WHERE idCliente = ? ";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $direccion, $idCliente);
    $stmt->execute();

    // Redirigir después de la actualización
    $mensaje = "El cliente de ID: {$idCliente} y documento: {$cliente['dniCliente']} ha sido modificado exitosamente.";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'clientes.php?documento={$cliente['dniCliente']}&nombre=&apellido=&email=&telefono=&direccion=';
    </script>";
    exit();
}
?>

<body class="bg-light">
    <div style="min-height: 100%">
        <div class="wrapper">
            <?php include('sidebarGOp.php'); include('topNavBar.php'); ?>
            
            <div class="p-5 mb-4 bg-white shadow-sm" style="margin-top: 10%; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px;">

                <h5 class="mb-4 text-secondary"><strong>Modificar Cliente</strong></h5>

                <!-- Formulario para modificar el cliente -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente['nombreCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($cliente['apellidoCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cliente['mailCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefonoCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($cliente['direccionCliente']); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>