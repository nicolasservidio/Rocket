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
$queryProveedores = "SELECT * FROM proveedores ORDER BY nombreProveedor";
$proveedores = mysqli_query($conexion, $queryProveedores);

// Obtener estados
$queryEstados = "SELECT * FROM `estados-pedidoaproveedor`";
$estados = mysqli_query($conexion, $queryEstados);

// Determinar restricciones según el estado actual del pedido recuperado
$estadoPedidoActual = intval($pedido['idEstadoPedido']);
$deshabilitado = in_array($estadoPedidoActual, [3, 6, 7]); // Pedido Cancelado, Entregado o Devuelto
$mensajeRestriccion = "";

if ($estadoPedidoActual == 3) {
    $mensajeRestriccion = "⚠ Este pedido ha sido CANCELADO y ya no puede modificarse.";
} elseif ($estadoPedidoActual == 6) {
    $mensajeRestriccion = "⚠ Este pedido ya ha sido ENTREGADO. Solo puedes marcarlo como DEVUELTO.";
} elseif ($estadoPedidoActual == 7) {
    $mensajeRestriccion = "⚠ Este pedido ha sido DEVUELTO y ya no puede modificarse.";
}

$bloqueoPorConfirmacion = strpos($pedido['aclaracionesEstadoPedido'], '[Bloqueado para devolución]') !== false;


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

                <h2 class="mb-4">Modificar Pedido a Proveedor #<?= $pedido['idPedido'] ?></h2><br>

                <!-- Mostrar mensaje de restricción si corresponde -->
                <?php if ($mensajeRestriccion): ?>
                    <div class="alert alert-danger"><?= $mensajeRestriccion ?></div>
                <?php endif; ?><br>

                <form method="POST" action="Actualizar_Pedido_Proveedor.php">
                    <input type="hidden" name="idPedido" value="<?= $pedido['idPedido'] ?>">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="fechaPedido" class="form-label">Fecha Pedido</label>
                            <input type="date" name="fechaPedido" id="fechaPedido" class="form-control" value="<?= $pedido['fechaPedido'] ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="fechaEntregaPedido" class="form-label">Fecha Entrega</label>
                            <input type="date" name="fechaEntregaPedido" id="fechaEntregaPedido" class="form-control" value="<?= $pedido['fechaEntregaPedido'] ?>" <?= $deshabilitado ? 'disabled' : '' ?>>
                        </div>
                        <div class="col-md-4">
                            <label for="idProveedor" class="form-label">Proveedor</label>
                            <select name="idProveedor" id="idProveedor" class="form-control" readonly>
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
                            <select name="idEstadoPedido" id="idEstadoPedido" class="form-control" <?= ($estadoPedidoActual == 7 || $estadoPedidoActual == 3 || $bloqueoPorConfirmacion) ? 'disabled' : '' ?> required>
                                <?php while ($est = mysqli_fetch_assoc($estados)): ?>
                                    <?php
                                    $estadoID = intval($est['idEstadoPedido']);
                                    $bloqueado = ($estadoPedidoActual == 6 && $estadoID != 7) || ($estadoPedidoActual == 7); // Si está en "Entregado", solo permitir "Devuelto"
                                    ?>
                                    <option value="<?= $est['idEstadoPedido'] ?>" <?= $estadoID == $pedido['idEstadoPedido'] ? 'selected' : '' ?> <?= $bloqueado ? 'disabled' : '' ?>>
                                        <?= htmlspecialchars($est['estadoPedido']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="aclaracionesEstadoPedido" class="form-label">Aclaraciones Estado</label>
                            <input type="text" name="aclaracionesEstadoPedido" id="aclaracionesEstadoPedido" class="form-control" value="<?= htmlspecialchars($pedido['aclaracionesEstadoPedido']) ?>" <?= $deshabilitado ? 'disabled' : '' ?>>
                        </div>
                        <div class="col-md-4">
                            <label for="condicionesDeEntrega" class="form-label">Condiciones de Entrega</label>
                            <input type="text" name="condicionesDeEntrega" id="condicionesDeEntrega" class="form-control" value="<?= htmlspecialchars($pedido['condicionesDeEntrega']) ?>" <?= $deshabilitado ? 'disabled' : '' ?>>
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
                                    $nombre = obtenerNombre($conexion, 'repuestos-vehiculos', 'idRepuesto', $d['idRepuestoVehiculo'], 'nombreRepuesto');
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
                                <td><input type="number" step="0.01" name="precioPorUnidad[]" class="form-control" value="<?= $d['precioPorUnidad'] ?>" readonly></td>
                                <td><input type="number" name="cantidadUnidades[]" class="form-control" value="<?= $d['cantidadUnidades'] ?>" readonly></td>
                                <td><input type="number" step="0.01" name="subtotal[]" class="form-control" value="<?= $d['subtotal'] ?>" readonly></td>
                                <input type="hidden" name="idDetalle[]" value="<?= $d['idDetallePedidoAProveedor'] ?>">
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <label for="totalPedido" class="form-label">Total del Pedido</label>
                        <input type="number" step="0.01" name="totalPedido" id="totalPedido" class="form-control" value="<?= $pedido['totalPedido'] ?>" readonly>
                    </div>

                    <!-- Botones de acción --> <br>
                    <button type="submit" class="btn btn-primary" <?= $deshabilitado ? 'disabled' : '' ?>>Guardar Cambios</button>
                    <a href="pedidosProveedores.php" class="btn btn-secondary">Cancelar</a>
                </form><br>
                
                <?php if ($estadoPedidoActual == 6 && strpos($pedido['aclaracionesEstadoPedido'], '[Bloqueado para devolución]') === false): ?>
                    <form method="POST" action="Deshabilitar_Cambio_Estado.php">
                        <input type="hidden" name="idPedido" value="<?= $pedido['idPedido'] ?>">
                        <button type="submit" class="btn btn-warning">Deshabilitar la Devolución</button>
                    </form>
                <?php endif; ?>

            </div>            
        </div>
    </div>
</body>
</html>

