<?php
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
} else {
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

    // Actualizar los datos del cliente
    $consulta = "UPDATE clientes SET nombreCliente = ?, apellidoCliente = ?, mailCliente = ?, telefonoCliente = ?, direccionCliente = ? WHERE idCliente = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $direccion, $idCliente);
    $stmt->execute();

    // Redirigir después de la actualización
    header('Location: clientes.php');
    exit();
}
?>

<body class="bg-light">
    <div class="wrapper">
        <?php include('sidebarGOp.php'); include('topNavBar.php'); ?>
        
        <div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm">
            <h5 class="mb-4 text-secondary"><strong>Modificar Cliente</strong></h5>
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
</body>
</html>