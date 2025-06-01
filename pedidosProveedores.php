<?php

session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'Identificador-Pedido' => isset($_GET['Identificador-Pedido']) ? trim($_GET['Identificador-Pedido']) : '',
    'Estado-Pedido' => isset($_GET['Estado-Pedido']) ? trim($_GET['Estado-Pedido']) : '',
    'Nombre-Proveedor' => isset($_GET['Nombre-Proveedor']) ? trim($_GET['Nombre-Proveedor']) : '',
    'CUIT-Proveedor' => isset($_GET['CUIT-Proveedor']) ? trim($_GET['CUIT-Proveedor']) : '',
    'IVA-Proveedor' => isset($_GET['IVA-Proveedor']) ? trim($_GET['IVA-Proveedor']) : '',
    'Localidad-Proveedor' => isset($_GET['Localidad-Proveedor']) ? trim($_GET['Localidad-Proveedor']) : '',
    'Direccion-Proveedor' => isset($_GET['Direccion-Proveedor']) ? trim($_GET['Direccion-Proveedor']) : '',
    'Precio-Unitario' => isset($_GET['Precio-Unitario']) ? trim($_GET['Precio-Unitario']) : '',
    'Cantidad-Producto' => isset($_GET['Cantidad-Producto']) ? trim($_GET['Cantidad-Producto']) : '',
    'MontoTotal-Pedido' => isset($_GET['MontoTotal-Pedido']) ? trim($_GET['MontoTotal-Pedido']) : '',
    'Tipo-Insumo' => isset($_GET['Tipo-Insumo']) ? trim($_GET['Tipo-Insumo']) : '',
    'Nombre-Insumo' => isset($_GET['Nombre-Insumo']) ? trim($_GET['Nombre-Insumo']) : '',
    'Descripcion-Insumo' => isset($_GET['Descripcion-Insumo']) ? trim($_GET['Descripcion-Insumo']) : '',
    'FechaPedido-Desde' => isset($_GET['FechaPedido-Desde']) ? trim($_GET['FechaPedido-Desde']) : '',
    'FechaPedido-Hasta' => isset($_GET['FechaPedido-Hasta']) ? trim($_GET['FechaPedido-Hasta']) : '',
    'FechaEntrega-Desde' => isset($_GET['FechaEntrega-Desde']) ? trim($_GET['FechaEntrega-Desde']) : '',
    'FechaEntrega-Hasta' => isset($_GET['FechaEntrega-Hasta']) ? trim($_GET['FechaEntrega-Hasta']) : '',
];


// Generación del listado de pedidos a proveedores
require_once 'funciones/CRUD-PedidosProv.php';
$ListadoPedidos = Listar_PedidosProveedores($conexion);
$CantidadPedidos = count($ListadoPedidos);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    Procesar_ConsultaPedidosProveedores();

    $ListadoPedidos = array();
    $CantidadPedidos = '';
    $ListadoPedidos = Consulta_PedidosAProveedor($_GET['Identificador-Pedido'], $_GET['Estado-Pedido'], $_GET['Nombre-Proveedor'], $_GET['CUIT-Proveedor'], $_GET['IVA-Proveedor'], $_GET['Localidad-Proveedor'], $_GET['Direccion-Proveedor'], $_GET['Precio-Unitario'], $_GET['Cantidad-Producto'], $_GET['MontoTotal-Pedido'], $_GET['Tipo-Insumo'], $_GET['Nombre-Insumo'], $_GET['Descripcion-Insumo'], $_GET['FechaPedido-Desde'], $_GET['FechaPedido-Hasta'], $_GET['FechaEntrega-Desde'], $_GET['FechaEntrega-Hasta'], $conexion);
    $CantidadPedidos = count($ListadoPedidos);
} else {

    // Listo la totalidad de los registros en la tabla "contratos". 
    $ListadoPedidos = Listar_PedidosProveedores($conexion);
    $CantidadPedidos = count($ListadoPedidos);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: pedidosProveedores.php');
    die();
}


// SELECCIONES para combo boxes
require_once 'funciones/Select_Tablas.php';

$ListadoProveedores = Listar_Proveedores_OrderByLocalidadDireccionNombre($conexion);
$CantidadProveedores = count($ListadoProveedores);

$ListadoTiposInsumos = Listar_TiposInsumos($conexion);
$CantidadTiposInsumos = count($ListadoTiposInsumos);


include('head.php');

?>

<body style="margin: 0 auto;">

    <style>
    .form-control:focus {
        border-color: #c7240e;
    }
    </style>

    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php
        include('sidebarGOp.php');
        $tituloPagina = "PEDIDOS A PROVEEDORES";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <div
                style="margin-bottom: 110px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #c7240e; border-radius: 14px;">
                <div style='color: #c7240e; margin-bottom: 30px;'>
                    <h3 class="fw-bold"> Pedidos a Proveedores </h3>
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="pedidosProveedores.php" method="get">

                    <div class="col-md-2">
                        <label for="identificadorpedido" class="form-label">Identificador de Pedido</label>
                        <input type="text" class="form-control" id="identificadorpedido" name="Identificador-Pedido"
                            value="<?= htmlspecialchars($filtros['Identificador-Pedido']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="estadopedido" class="form-label">Estado del Pedido</label>
                        <input type="text" class="form-control" id="estadopedido" name="Estado-Pedido"
                            title="Pendiente, Confirmado, Cancelado, En Preparación, Enviado, Entregado o Devuelto"
                            value="<?= htmlspecialchars($filtros['Estado-Pedido']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="nombreproveedor" class="form-label">Razón Social</label>
                        <input type="text" class="form-control" id="nombreproveedor" name="Nombre-Proveedor"
                            value="<?= htmlspecialchars($filtros['Nombre-Proveedor']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="cuitproveedor" class="form-label">CUIT Proveedor</label>
                        <input type="text" class="form-control" id="cuitproveedor" name="CUIT-Proveedor"
                            value="<?= htmlspecialchars($filtros['CUIT-Proveedor']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="ivaproveedor" class="form-label">IVA Proveedor</label>
                        <input type="text" class="form-control" id="ivaproveedor" name="IVA-Proveedor"
                            value="<?= htmlspecialchars($filtros['IVA-Proveedor']) ?>">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->

                    <div class="col-md-2">
                        <label for="localidadproveedor" class="form-label">Localidad Proveedor</label>
                        <input type="text" class="form-control" id="localidadproveedor" name="Localidad-Proveedor"
                            value="<?= htmlspecialchars($filtros['Localidad-Proveedor']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="direccionproveedor" class="form-label">Dirección Proveedor</label>
                        <input type="text" class="form-control" id="direccionproveedor" name="Direccion-Proveedor"
                            value="<?= htmlspecialchars($filtros['Direccion-Proveedor']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="preciounitario" class="form-label">Precio unitario</label>
                        <input type="number" min="0" max="999999999" step="0.01" class="form-control"
                            id="preciounitario" name="Precio-Unitario"
                            value="<?= htmlspecialchars($filtros['Precio-Unitario']) ?>"
                            title="Filtrar por precio unitario (hasta los...)">
                    </div>

                    <?php
                    $minCantidad = 1;
                    $maxCantidad = 9999999;
                    ?>
                    <div class="col-md-2">
                        <label for="cantidadproducto" class="form-label">Cantidad </label>
                        <input type="number" min="<? echo $minCantidad; ?>" max="<?php echo $maxCantidad; ?>"
                            class="form-control" id="cantidadproducto" name="Cantidad-Producto"
                            value="<?= htmlspecialchars($filtros['Cantidad-Producto']) ?>"
                            title="Cantidad exacta de unidades del producto">
                    </div>

                    <div class="col-md-2">
                        <label for="montototal" class="form-label">Monto total</label>
                        <input type="number" min="1" max="999999999" step="0.01" class="form-control" id="montototal"
                            name="MontoTotal-Pedido" value="<?= htmlspecialchars($filtros['MontoTotal-Pedido']) ?>"
                            title="Filtrar por monto total (hasta los...)">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->

                    <div class="col-md-2">
                        <label for="tipodeinsumo" class="form-label">Tipo de Insumo</label>
                        <input type="text" class="form-control" id="tipodeinsumo" name="Tipo-Insumo"
                            value="<?= htmlspecialchars($filtros['Tipo-Insumo']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label for="nombredeinsumo" class="form-label">Nombre del Insumo</label>
                        <input type="text" class="form-control" id="nombredeinsumo" name="Nombre-Insumo"
                            title="Nombre del repuesto, producto o accesorio"
                            value="<?= htmlspecialchars($filtros['Nombre-Insumo']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="descripciondeinsumo" class="form-label">Descripción del Insumo</label>
                        <input type="text" class="form-control" id="descripciondeinsumo" name="Descripcion-Insumo"
                            title="Filtrar por palabra clave en la descripción"
                            value="<?= htmlspecialchars($filtros['Descripcion-Insumo']) ?>">
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->

                    <div class="col-md-4">
                        <label for="fechadepedido" class="form-label">Fecha de Pedido</label>
                        <div class="d-flex">
                            <input type="date" id="fechadepedidodesde" class="form-control me-2"
                                name="FechaPedido-Desde" title="desde..."
                                value="<?= htmlspecialchars($filtros['FechaPedido-Desde']) ?>">

                            <input type="date" id="fechadepedidohasta" class="form-control" name="FechaPedido-Hasta"
                                title="hasta..." value="<?= htmlspecialchars($filtros['FechaPedido-Hasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="fechadeentrega" class="form-label">Fecha de Entrega</label>
                        <div class="d-flex">
                            <input type="date" id="fechadeentregadesde" class="form-control me-2"
                                name="FechaEntrega-Desde" title="desde..."
                                value="<?= htmlspecialchars($filtros['FechaEntrega-Desde']) ?>">

                            <input type="date" id="fechadeentregahasta" class="form-control" name="FechaEntrega-Hasta"
                                title="hasta..." value="<?= htmlspecialchars($filtros['FechaEntrega-Hasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="d-flex flex-wrap justify-content-between align-items-end mt-3">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" style="background-color: #c7240e; color: white;" class="btn"
                                name="BotonFiltrar" value="FiltrandoPedidos">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button type="submit" class="btn btn-warning" name="BotonLimpiarFiltros"
                                value="LimpiandoFiltros">
                                <i class="fas fa-ban"></i> Limpiar Filtros
                            </button>
                        </div>
                        <span class="fw-bold mt-2 mt-md-0">Cant. pedidos listados:
                            <?php echo $CantidadPedidos; ?></span>
                    </div>

                </form>
            </div>

            <?php
                if (isset($_GET['msg']) && $_GET['msg'] == 'modificado') {
                    echo "<div class='alert alert-success' role='alert' style='max-width: 97%; margin: 20px auto;'>
                     Pedido modificado correctamente.
                        </div>";
                }
?>

            <!-- Tabla de pedidos a proveedores -->
            <div style="margin-top: 5%; padding-bottom: 100px;">
                <div class="table-responsive mt-4"
                    style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaPedidos">
                        <thead>
                            <tr>
                                <th style='color: #c7240e;'>
                                    <h3>#</h3>
                                </th>
                                <th>ID Pedido</th>
                                <th>Fecha Pedido</th>
                                <th>Fecha Entrega</th>
                                <th>Estado del Pedido</th>
                                <th>Aclaraciones sobre el Estado</th>
                                <th>Condiciones de Entrega</th>
                                <th>Datos del Proveedor</th>
                                <th>Monto Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1;

                            // Iterar sobre los pedidos en el array $ListadoPedidos
                            foreach ($ListadoPedidos as $ppIdPedido => $Pedido) { ?>
                            <tr style='border-bottom: 3px solid #b50000;'>
                                <td colspan='9'></td>
                            </tr>

                            <tr class="pedido" data-id="<?= $Pedido['ppIdPedido'] ?>">
                                <td>
                                    <h4 style='color: #c7240e;'><?= $contador ?></h4>
                                </td>
                                <td><b>ID: <?= $Pedido['ppIdPedido'] ?></b></td>
                                <td><?= $Pedido['FechaPedido'] ?></td>
                                <td><?= $Pedido['FechaEntrega'] ?></td>
                                <td><span class="badge badge-success"><?= $Pedido['EstadoPedido'] ?></span></td>
                                <td><?= $Pedido['AclaracionesEstadoPedido'] ?></td>
                                <td><?= $Pedido['CondicionesDeEntrega'] ?></td>
                                <td>
                                    <?= $Pedido['NombreProveedor'] ?><br>
                                    <strong>CUIT:</strong> <?= $Pedido['CuitProveedor'] ?><br>
                                    <strong>IVA:</strong> <?= $Pedido['IvaProveedor'] ?><br><br>
                                    <strong>Correo:</strong> <?= $Pedido['MailProveedor'] ?><br>
                                    <strong>Dirección:</strong> <?= $Pedido['DireccionProveedor'] ?>,
                                    <?= $Pedido['LocalidadProveedor'] ?>
                                </td>
                                <td><?= $Pedido['TotalPedido'] ?> USD</td>
                            </tr>

                            <tr>
                                <th colspan="9" style="padding-top: 10px;">ARTÍCULOS DEL PEDIDO
                                    #<?= $Pedido['ppIdPedido'] ?></th>
                            </tr>
                            <tr>
                                <th>Tipo</th>
                                <th colspan="2">Nombre</th>
                                <th colspan="3">Descripción</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>

                            <?php foreach ($Pedido['Detalles'] as $Detalle): ?>
                            <tr>
                                <td><?= $Detalle['TipoInsumo'] ?></td>
                                <td colspan="2">
                                    <?php
                                         if ($Detalle['TipoInsumo'] == "Repuesto") echo $Detalle['NombreRepuesto'];
                                            elseif ($Detalle['TipoInsumo'] == "Producto") echo $Detalle['NombreProducto'];
                                                else echo $Detalle['NombreAccesorio'];
                                     ?>
                                </td>
                                <td colspan="3">
                                    <?php
                                        if ($Detalle['TipoInsumo'] == "Repuesto") echo $Detalle['DescripcionRepuesto'];
                                         elseif ($Detalle['TipoInsumo'] == "Producto") echo $Detalle['DescripcionProducto'];
                                            else echo $Detalle['DescripcionAccesorio'];
                                        ?>
                                </td>
                                <td><?= $Detalle['PrecioPorUnidad'] ?> USD</td>
                                <td><?= $Detalle['CantidadUnidades'] ?></td>
                                <td><?= $Detalle['Subtotal'] ?> USD</td>
                            </tr>

                            <?php endforeach; ?>

                            </tr>
                            <?php
                                $contador++;
                            } ?>
                        </tbody>
                    </table>
                </div>


                <!-- Botones de acción -->
                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nuevo
                        </button>

                        <button class="btn btn-danger me-2" id="btnModificar" onclick="modificarPedido()" disabled>
                            Modificar
                        </button>

                        <a href="ReportePedidosProveedores.php"> <button class="btn btn-primary">
                                Imprimir
                            </button></a>
                    </div>

                </div>

                <!-- Reportes estadísticos -->
                <div style="margin: auto; max-width: 95%; padding: 150px 0 5px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h2 class="mb-1 " style="padding: 0; margin: 10px 0 0 0;">
                            <strong style="color: #a80a0a;">Reportes Estadísticos</strong>
                        </h2>
                    </div>
                </div>

                <style>
                .hoverImage {
                    position: relative;
                    align-self: stretch;
                    height: 650px;
                    flex-shrink: 0;
                    object-fit: cover;
                    border-radius: 10px;
                    max-width: 100%;
                }

                .centrar {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                </style>

                <div style="margin: auto; max-width: 95%; padding: 10px 0 40px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h4 class="mb-1 " style="padding: 0; margin: 30px 0 0 0;">
                            <strong style="color: #a80a0a;">Reporte:</strong> <a
                                href="ReporteContratos_FrecMensuales.php" style="color: black;">Contratos por mes
                                segmentados por estado </a>
                        </h4>

                        <a href="ReporteContratos_FrecMensuales.php" style="color: black;">
                            <div class="mb-1 hoverImageWrapper centrar" style="padding: 0; margin: 50px 0 0 0;">
                                <img class="hoverImage" src="assets/img/reports/reporte-contratosmensualesestados.jpeg"
                                    alt="Contratos por mes segmentados por estado"
                                    style="max-width: 99%; border-radius: 25px;">
                            </div>
                        </a>

                        <style>
                        .btn-inversion {
                            padding-left: 30px;
                            padding-right: 30px;
                            background-color: #262626;
                            color: #e04709;
                            font-weight: 500;
                            border: 1px solid #d64004;
                            border-radius: 20px;

                            transition: all 0.5s ease-in-out;
                            -webkit-transition: all 0.5s ease-in-out;
                            -moz-transition: all 0.5s ease-in-out;
                            -o-transition: all 0.5s ease-in-out;
                        }

                        .btn-inversion:hover {
                            background-color: #a80a0a;
                            color: white;
                            font-weight: 100;
                            border: 1px solid #a80a0a;
                        }
                        </style>

                        <div class="container d-flex justify-content-center" style="margin: 70px 0 50px 0;">
                            <a href="ReporteContratos_FrecMensuales.php">
                                <button class="btn btn-inversion">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bar-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
                                    </svg>
                                    Reporte
                                </button>
                            </a>
                        </div>

                    </div>
                </div>


                <!-- Modal para Nuevo registro de pedido a proveedor -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <!-- Aumentamos el tamaño para acomodar la tabla dinámica -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Registrar nuevo Pedido a Proveedor
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="Nuevo_Pedido_Proveedor.php" method="post">
                                <div class="modal-body">

                                    <!-- Información general del pedido (encabezado) -->
                                    <div class="mb-3">
                                        <label for="fechapedido" class="form-label">Fecha del Pedido</label>
                                        <input type="date" class="form-control" id="fechapedido" title="Obligatorio"
                                            name="fechapedido" value="" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaentrega" class="form-label">Fecha de Entrega</label>
                                        <input type="date" class="form-control" id="fechaentrega" name="fechaentrega"
                                            title="Si contás con una fecha estimativa de arribo, colocala aquí"
                                            value="">
                                    </div>

                                    <div class="mb-3">
                                        <label for="idProveedor" class="form-label">Proveedor</label>
                                        <select class="form-select" aria-label="Selector" id="selector"
                                            title="Obligatorio" name="idProveedor" required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php
                                            // Asegúrate de que $ListadoProveedores contiene datos antes de procesarlo
                                            if (!empty($ListadoProveedores)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadProveedores; $i++) {
                                                    // Lógica para verificar si el grupo debe estar seleccionado
                                                    $selected = (!empty($_POST['idProveedor']) && $_POST['idProveedor'] == $ListadoProveedores[$i]['idProveedor']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoProveedores[$i]['idProveedor']}' $selected> 
                                                        {$ListadoProveedores[$i]['localidadProveedor']} {$ListadoProveedores[$i]['direccionProveedor']}. <br> 
                                                        Nombre: {$ListadoProveedores[$i]['nombreProveedor']} (CUIT: {$ListadoProveedores[$i]['cuitProveedor']}) 
                                                    </option>";
                                                }
                                            } else {
                                                echo "<option value=''>No se encontraron proveedores</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    </br>

                                    <div class="mb-3">
                                        <label for="aclaracionesestadopedido" class="form-label">Aclaraciones sobre el
                                            estado del pedido </label>
                                        <textarea class="form-control" id="aclaracionesestadopedido"
                                            name="aclaracionesestadopedido" rows="2" cols="33"
                                            title="Campo opcional que permite incorporar información adicional sobre el estado del pedido"
                                            value=""> </textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="condicionesdeentrega" class="form-label">Condiciones de entrega
                                        </label>
                                        <textarea class="form-control" id="condicionesdeentrega"
                                            name="condicionesdeentrega" rows="2" cols="33"
                                            title="Campo opcional que permite registrar condiciones pactadas de entrega"
                                            value=""> </textarea>
                                    </div>

                                    </br></br>

                                    <!-- Detalle del pedido -->
                                    <h5><i class="fas fa-rocket" style="color: red; padding: 0 10px 0 10px;"></i>
                                        Detalle del pedido </h5>
                                    </br>

                                    <div class="mb-3" style="overflow-x: auto;">
                                        <!-- Contenedor desplazable -->
                                        <table class="table table-bordered" id="tablaDetalles">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Tipo de Insumo
                                                    </th>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Nombre
                                                    </th>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Descripción
                                                    </th>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Precio Unitario
                                                    </th>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Cantidad
                                                    </th>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Subtotal
                                                    </th>
                                                    <th
                                                        style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Filas dinámicas se generarán aquí, con los correspondientes controles -->
                                            </tbody>
                                        </table>

                                        </br></br>
                                        <button type="button" class="btn btn-primary" id="btnAgregarFila">Agregar
                                            Artículo</button>
                                        </br></br></br>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div>
            <?php require_once "foot.php"; ?>
        </div>
    </div>

    <script>
    // Efecto sobre la imagen del reporte
    window.onload = function() {

        const imageElement = document.querySelector('.hoverImage');

        if (imageElement) {
            const handleMouseMove = (e) => {
                let rect = imageElement.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;

                let dx = (x - rect.width / 2) / (rect.width / 2);
                let dy = (y - rect.height / 2) / (rect.height / 2);

                imageElement.style.transform =
                    `perspective(500px) rotateY(${dx * 5}deg) rotateX(${-dy * 5}deg)`;
            };

            const handleMouseLeave = () => {
                imageElement.style.transform = "";
            };

            imageElement.addEventListener('mousemove', handleMouseMove);
            imageElement.addEventListener('mouseleave', handleMouseLeave);
        }
    }
    </script>

    <!-- Seleccionar pedido para habilitar boton modificar -->

    <script>
    let pedidoSeleccionado = null;

    // Detectar selección de fila
    document.querySelectorAll('#tablaPedidos .pedido').forEach(row => {
        row.addEventListener('click', () => {
            // Quitar selección anterior
            document.querySelectorAll('.pedido').forEach(r => r.classList.remove('table-active'));

            // Agregar nueva selección
            row.classList.add('table-active');
            pedidoSeleccionado = row.dataset.id;

            // Habilitar botones
            document.getElementById('btnModificar').disabled = false;
            document.getElementById('btnEliminar').disabled = false;
        });
    });

    // Enviar formulario por POST
    function modificarPedido() {
        if (pedidoSeleccionado) {
            window.location.href = 'modificarPedidoProveedores.php?id=' + pedidoSeleccionado;
        }
    }
    </script>

    <!-- Estilo para remarcar bien pedido seleccionado (barra roja lateral) -->

    <style>
    tr.pedido.table-active {
        background-color: #ffe6e6 !important;
        /* fondo rosado claro */
        font-weight: bold;
        border-left: 5px solid #c7240e;
    }

    tr.separator {
        height: 5px;
        background-color: #dddddd;
    }
    </style>


    <script>
    // Para la tabla del modal que permite registrar nuevos pedidos a proveedores

    document.addEventListener("DOMContentLoaded", function() {
        const tablaDetalles = document.getElementById("tablaDetalles").querySelector("tbody");
        const btnAgregarFila = document.getElementById("btnAgregarFila");

        btnAgregarFila.addEventListener("click", function() {
            // Crear una nueva fila
            const nuevaFila = document.createElement("tr");
            nuevaFila.innerHTML = `
                    <td>
                        <select name="tipoInsumo[]" class="form-select" style="min-width: 120px;" title="Obligatorio" required>
                            <option value="" selected>Selecciona una opción...</option>
                            <option value="1">Repuesto</option>
                            <option value="2">Producto</option>
                            <option value="3">Accesorio</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="nombreInsumo[]" class="form-control" style="min-width: 150px;" 
                                title="Obligatorio" value="" required>
                    </td>
                    <td>
                        <input type="text" name="descripcionInsumo[]" class="form-control" style="min-width: 170px;" 
                                title="Opcional" value="">
                    </td>
                    <td>
                        <input type="number" name="precioUnidad[]" class="form-control" step="0.01" style="min-width: 100px;" 
                                title="Obligatorio" value="" required>
                    </td>
                    <td>
                        <input type="number" name="cantidad[]" class="form-control" style="min-width: 100px;" 
                                title="Obligatorio" value="" required>
                    </td>
                    <td>
                        <input type="number" name="subtotal[]" class="form-control" step="0.01" style="min-width: 100px;" 
                                value="" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btnEliminarFila">Eliminar</button>
                    </td>
                `;
            tablaDetalles.appendChild(nuevaFila);

            // Configurar el botón de eliminar fila
            nuevaFila.querySelector(".btnEliminarFila").addEventListener("click", function() {
                nuevaFila.remove();
            });

            // Calcular subtotal automáticamente
            nuevaFila.querySelector("input[name='cantidad[]']").addEventListener("input",
                calcularSubtotal);
            nuevaFila.querySelector("input[name='precioUnidad[]']").addEventListener("input",
                calcularSubtotal);
        });

        function calcularSubtotal(event) {
            const fila = event.target.closest("tr");
            const precio = parseFloat(fila.querySelector("input[name='precioUnidad[]']").value) || 0;
            const cantidad = parseFloat(fila.querySelector("input[name='cantidad[]']").value) || 0;
            fila.querySelector("input[name='subtotal[]']").value = (precio * cantidad).toFixed(2);
        }
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>