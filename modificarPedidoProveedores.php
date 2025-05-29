<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');
include('conn/conexion.php');
$conexion = ConexionBD();
// Validar ID de pedido
if (!isset($_GET['id'])) {
    die("ID de pedido no proporcionado.");
}
$idPedido = intval($_GET['id']);

// Obtener datos del pedido
$queryPedido = "SELECT * FROM `pedido-a-proveedor` WHERE idPedido = $idPedido";
$resultPedido = mysqli_query($conexion, $queryPedido);
$pedido = mysqli_fetch_assoc($resultPedido);

// Obtener proveedor
$queryProveedores = "SELECT * FROM proveedores";
$proveedores = mysqli_query($conexion, $queryProveedores);

// Obtener estados
$queryEstados = "SELECT * FROM `estados-pedidoaproveedor`";
$estados = mysqli_query($conexion, $queryEstados);

// Obtener detalles del pedido
$queryDetalles = "SELECT * FROM `detalle-pedidoaproveedor` WHERE idPedido = $idPedido";
$detalles = mysqli_query($conexion, $queryDetalles);

// Utilidades para obtener nombres/descripciones
function obtenerNombre($conexion, $tabla, $idCampo, $id, $nombreCampo) {
    $res = mysqli_query($conexion, "SELECT $nombreCampo FROM `$tabla` WHERE $idCampo = $id");
    $row = mysqli_fetch_assoc($res);
    return $row ? $row[$nombreCampo] : '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .form-container {
            margin-top: 10%;
            margin-left: 1%;
            max-width: 98%;
            background-color: white;
            border: 1px solid #444444;
            border-radius: 14px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        h2, h4 {
            color: #6c757d; /* text-secondary color */
            font-weight: 700;
        }
        label.form-label {
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-light">
    <div style="min-height: 100%">
        <div class="wrapper">
            <?php include('sidebarGOp.php'); include('topNavBar.php'); ?>

            <div class="form-container">

                <h2 class="mb-4">Modificar Pedido a Proveedor #<?= $pedido['idPedido'] ?></h2>
                <form method="POST" action="Actualizar_Pedido_Proveedor.php">
                    <input type="hidden" name="idPedido" value="<?= $pedido['idPedido'] ?>">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="fechaPedido" class="form-label">Fecha Pedido</label>
                            <input type="date" name="fechaPedido" id="fechaPedido" class="form-control" value="<?= $pedido['fechaPedido'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="fechaEntregaPedido" class="form-label">Fecha Entrega</label>
                            <input type="date" name="fechaEntregaPedido" id="fechaEntregaPedido" class="form-control" value="<?= $pedido['fechaEntregaPedido'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="idProveedor" class="form-label">Proveedor</label>
                            <select name="idProveedor" id="idProveedor" class="form-control">
                                <?php while ($prov = mysqli_fetch_assoc($proveedores)): ?>
                                    <option value="<?= $prov['idProveedor'] ?>" <?= $prov['idProveedor'] == $pedido['idProveedor'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prov['nombreProveedor']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="idEstadoPedido" class="form-label">Estado del Pedido</label>
                            <select name="idEstadoPedido" id="idEstadoPedido" class="form-control">
                                <?php while ($est = mysqli_fetch_assoc($estados)): ?>
                                    <option value="<?= $est['idEstadoPedido'] ?>" <?= $est['idEstadoPedido'] == $pedido['idEstadoPedido'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($est['estadoPedido']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="aclaracionesEstadoPedido" class="form-label">Aclaraciones Estado</label>
                            <input type="text" name="aclaracionesEstadoPedido" id="aclaracionesEstadoPedido" class="form-control" value="<?= htmlspecialchars($pedido['aclaracionesEstadoPedido']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="condicionesDeEntrega" class="form-label">Condiciones de Entrega</label>
                            <input type="text" name="condicionesDeEntrega" id="condicionesDeEntrega" class="form-control" value="<?= htmlspecialchars($pedido['condicionesDeEntrega']) ?>">
                        </div>
                    </div>

                    <h4 class="mt-4 mb-3">Artículos del Pedido</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Precio por Unidad</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($d = mysqli_fetch_assoc($detalles)):
                                $tipo = $nombre = '';
                                if ($d['idRepuestoVehiculo']) {
                                    $tipo = 'Repuesto';
                                    $nombre = obtenerNombre($conexion, 'repuestos-vehiculos', 'idRepuesto', $d['idRepuestoVehiculo'], 'descripcionRepuesto');
                                } elseif ($d['idProductoVehiculo']) {
                                    $tipo = 'Producto';
                                    $nombre = obtenerNombre($conexion, 'productos-vehiculo', 'idProducto', $d['idProductoVehiculo'], 'nombreProducto');
                                } elseif ($d['idAccesorioVehiculo']) {
                                    $tipo = 'Accesorio';
                                    $nombre = obtenerNombre($conexion, 'accesorios-vehiculos', 'idAccesorio', $d['idAccesorioVehiculo'], 'nombreAccesorio');
                                }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($tipo) ?></td>
                                <td><?= htmlspecialchars($nombre) ?></td>
                                <td><input type="number" step="0.01" name="precioPorUnidad[]" class="form-control" value="<?= $d['precioPorUnidad'] ?>"></td>
                                <td><input type="number" name="cantidadUnidades[]" class="form-control" value="<?= $d['cantidadUnidades'] ?>"></td>
                                <td><input type="number" step="0.01" name="subtotal[]" class="form-control" value="<?= $d['subtotal'] ?>"></td>
                                <input type="hidden" name="idDetalle[]" value="<?= $d['idDetallePedidoAProveedor'] ?>">
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <label for="totalPedido" class="form-label">Total del Pedido</label>
                        <input type="number" step="0.01" name="totalPedido" id="totalPedido" class="form-control" value="<?= $pedido['totalPedido'] ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="pedidosProveedores.php" class="btn btn-secondary">Cancelar</a>
                </form>

            </div>
        </div>
    </div>
</body>
</html>

