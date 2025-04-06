<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

if (isset($_GET['id'])) {
    $idProveedor = $_GET['id'];

    // Obtener los datos del Proveedor
    $consulta = "SELECT * FROM proveedores WHERE idProveedor = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idProveedor);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $proveedor = $resultado->fetch_assoc();
} else {
    // Si no se pasa un ID, redirigir al listado
    header('Location: proveedores.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cuit = $_POST['cuit'];
    $iva = $_POST['iva'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Actualizar los datos del Proveedor
    $consulta = "UPDATE proveedores SET nombreProveedor = ?, cuitProveedor = ?, ivaProveedor = ?, mailProveedor = ?, telefonoProveedor = ?, direccionProveedor = ? WHERE idProveedor = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("sissisi", $nombre, $cuit, $iva, $email, $telefono, $direccion, $idProveedor);
    $stmt->execute();

    // Redirigir después de la actualización
    header('Location: proveedores.php');
    exit();
}
?>

<body class="bg-light">
    <div style="min-height: 100%">
        <div class="wrapper">
            <?php include('sidebarGOp.php'); include('topNavBar.php'); ?>
            
            <div class="p-5 mb-4 bg-white shadow-sm" style="margin-top: 10%; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px;">

                <h5 class="mb-4 text-secondary"><strong>Modificar Proveedor</strong></h5>

                <!-- Formulario para modificar el Proveedor -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($proveedor['nombreProveedor']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cuit" class="form-label">Cuit</label>
                        <input type="text" class="form-control" id="cuit" name="cuit" value="<?php echo htmlspecialchars($proveedor['cuitProveedor']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="iva" class="form-label">Condicion IVA</label>
                        <input type="text" class="form-control" id="iva" name="iva" value="<?php echo htmlspecialchars($proveedor['ivaProveedor']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($proveedor['mailProveedor']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($proveedor['telefonoProveedor']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($proveedor['direccionProveedor']); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>