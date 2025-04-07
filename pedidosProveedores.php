<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'numero' => isset($_GET['NumeroContrato']) ? trim($_GET['NumeroContrato']) : '',
    'matricula' => isset($_GET['MatriculaContrato']) ? trim($_GET['MatriculaContrato']) : '',
    'apellido' => isset($_GET['ApellidoContrato']) ? trim($_GET['ApellidoContrato']) : '',
    'nombre' => isset($_GET['NombreContrato']) ? trim($_GET['NombreContrato']) : '',
    'documento' => isset($_GET['DocContrato']) ? trim($_GET['DocContrato']) : '',
    'estado' => isset($_GET['EstadoContrato']) ? trim($_GET['EstadoContrato']) : '',
    'preciodia' => isset($_GET['PrecioDiaContrato']) ? trim($_GET['PrecioDiaContrato']) : '',
    'cantidaddias' => isset($_GET['CantidadDiasContrato']) ? trim($_GET['CantidadDiasContrato']) : '',
    'montototal' => isset($_GET['MontoTotalContrato']) ? trim($_GET['MontoTotalContrato']) : '',
    'retirodesde' => isset($_GET['RetiroDesde']) ? trim($_GET['RetiroDesde']) : '',
    'retirohasta' => isset($_GET['RetiroHasta']) ? trim($_GET['RetiroHasta']) : '',
    'devoluciondesde' => isset($_GET['DevolucionDesde']) ? trim($_GET['DevolucionDesde']) : '',
    'devolucionhasta' => isset($_GET['DevolucionHasta']) ? trim($_GET['DevolucionHasta']) : '',
];


// Generación del listado de pedidos a proveedores
require_once 'funciones/CRUD-PedidosProv.php'; 
$ListadoPedidos = Listar_PedidosProveedores($conexion); 
$CantidadPedidos = count($ListadoPedidos);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_ConsultaContratos();

    $ListadoPedidos = array();
    $CantidadPedidos = '';
    $ListadoPedidos = Consulta_Contratos($_GET['NumeroContrato'], $_GET['MatriculaContrato'], $_GET['ApellidoContrato'], $_GET['NombreContrato'], $_GET['DocContrato'], $_GET['EstadoContrato'], $_GET['PrecioDiaContrato'], $_GET['CantidadDiasContrato'], $_GET['MontoTotalContrato'], $_GET['RetiroDesde'], $_GET['RetiroHasta'], $_GET['DevolucionDesde'], $_GET['DevolucionHasta'], $conexion);
    $CantidadPedidos = count($ListadoPedidos);
}
else {

    // Listo la totalidad de los registros en la tabla "contratos". 
    $ListadoPedidos = Listar_PedidosProveedores($conexion);
    $CantidadPedidos = count($ListadoPedidos);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: contratosAlquiler.php');
    die();
}


// SELECCIONES para combo boxes
require_once 'funciones/Select_Tablas.php';

$ListadoProveedores = Listar_Proveedores_OrderByLocalidadDireccionNombre($conexion);
$CantidadProveedores = count($ListadoProveedores);


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
        include('topNavBar.php');    

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <div style="margin-bottom: 110px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #c7240e; border-radius: 14px;">
                <div style='color: #c7240e; margin-bottom: 30px;'> 
                    <h3 class="fw-bold"> Pedidos a Proveedores </h3> 
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="contratosAlquiler.php" method="get">

                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="NumeroContrato" 
                               value="<?= htmlspecialchars($filtros['numero']) ?>" >
                    </div>

                    <div class="col-md-2">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" id="matricula" name="MatriculaContrato" 
                               value="<?= htmlspecialchars($filtros['matricula']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="ApellidoContrato" 
                               value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="NombreContrato" 
                               value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="DocContrato" 
                               value="<?= htmlspecialchars($filtros['documento']) ?>">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-2">
                        <label for="estado" class="form-label">Estado del Contrato</label>
                        <input type="text" class="form-control" id="estado" name="EstadoContrato" 
                               value="<?= htmlspecialchars($filtros['estado']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="preciodia" class="form-label">Precio por día</label>
                        <input type="number" min="20" max="999999999" step="0.01" class="form-control" id="preciodia" name="PrecioDiaContrato" 
                               value="<?= htmlspecialchars($filtros['preciodia']) ?>" title="Filtrar por precio hasta los..." >
                    </div>

                    <?php 
                    $minCantDias = 1;
                    $maxCantDias = 45;
                    ?>
                    <div class="col-md-2">
                        <label for="cantidaddias" class="form-label">Cantidad de días</label>
                        <input type="number" min="<? echo $minCantDias; ?>" max="<?php echo $maxCantDias; ?>" class="form-control" id="cantidaddias" name="CantidadDiasContrato" 
                               value="<?= htmlspecialchars($filtros['cantidaddias']) ?>" title="Cantidad exacta de días entre 1 y 45">
                    </div>

                    <div class="col-md-2">
                        <label for="montototal" class="form-label">Monto total</label>
                        <input type="number" min="20" max="999999999" step="0.01" class="form-control" id="montototal" name="MontoTotalContrato" 
                               value="<?= htmlspecialchars($filtros['montototal']) ?>" title="Filtrar por monto total hasta los...">
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-4">
                        <label for="retiro" class="form-label">Retiro entre</label>
                        <div class="d-flex">
                            <input type="date" id="retirodesde" class="form-control me-2" name="RetiroDesde" 
                                   value="<?= htmlspecialchars($filtros['retirodesde']) ?>">

                            <input type="date" id="retirohasta" class="form-control" name="RetiroHasta" 
                                   value="<?= htmlspecialchars($filtros['retirohasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="devolucion" class="form-label">Devolución entre</label>
                        <div class="d-flex">
                            <input type="date" id="devoluciondesde" class="form-control me-2" name="DevolucionDesde" 
                                   value="<?= htmlspecialchars($filtros['devoluciondesde']) ?>">

                            <input type="date" id="devolucionhasta" class="form-control" name="DevolucionHasta" 
                                   value="<?= htmlspecialchars($filtros['devolucionhasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" style="background-color: #c7240e; color: white;" class="btn w-100" name="BotonFiltrar" value="FiltrandoContratos">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100" name="BotonLimpiarFiltros" value="LimpiandoFiltros">
                            <i class="fas fa-ban"></i> LimpiarFiltros
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de pedidos a proveedores -->
            <div style="margin-top: 5%; padding-bottom: 100px;">
                <div class="table-responsive mt-4" style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaPedidos">
                        <thead>
                            <tr>
                                <th style='color: #c7240e;'><h3>#</h3></th>
                                <th>ID Pedido</th>
                                <th>Fecha Pedido</th>
                                <th>Fecha Entrega</th>
                                <th>Estado del Pedido</th>
                                <th>Aclaraciones sobre el Estado</th>
                                <th>Condiciones de Entrega</th>
                                <th>Datos del Proveedor</th>
                                <th>Monto Total</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1; 

                            for ($i=1; $i <= $CantidadPedidos; $i++) { 
                                
                                if (!isset($ListadoPedidos[$i])) continue; // Validación básica 
                                ?>

                                <tr class='pedido' data-id='<?php echo $ListadoPedidos[$i]['ppIdPedido']; ?>' 
                                    onclick="selectRow(this, '<?php $ListadoPedidos[$i]['ppIdPedido']; ?>')">

                                    <td>
                                        <span style='color: #c7240e;'>
                                            <h4> <?php echo $contador; ?> </h4>
                                        </span>
                                    </td>

                                    <td> 
                                        <?php echo $ListadoPedidos[$i]['ppIdPedido']; ?> 
                                    </td>

                                    <td> 
                                        <?php echo $ListadoPedidos[$i]['FechaPedido']; ?> 
                                    </td>
                                    
                                    <td> 
                                        <?php echo $ListadoPedidos[$i]['FechaEntrega']; ?> 
                                    </td>

                                    <td> 
                                        <span class="badge badge-success"> 
                                            <?php echo $ListadoPedidos[$i]['EstadoPedido']; ?> 
                                        </span> 
                                    </td>

                                    <td> 
                                        <?php echo $ListadoPedidos[$i]['AclaracionesEstadoPedido']; ?> 
                                    </td>

                                    <td> 
                                        <?php echo $ListadoPedidos[$i]['CondicionesDeEntrega']; ?> 
                                    </td>

                                    <td> 
                                        <?php 
                                        echo "{$ListadoPedidos[$i]['NombreProveedor']} </br> 
                                        <strong>CUIT:</strong> {$ListadoPedidos[$i]['CuitProveedor']} </br> 
                                        <strong>IVA:</strong> {$ListadoPedidos[$i]['IvaProveedor']} </br></br> 
                                        <strong>Correo:</strong> {$ListadoPedidos[$i]['MailProveedor']}
                                        <strong>Dirección:</strong> {$ListadoPedidos[$i]['DireccionProveedor']}, {$ListadoPedidos[$i]['LocalidadProveedor']}"; 
                                        ?> 
                                    </td>

                                    <td> 
                                        <?php echo $ListadoPedidos[$i]['TotalPedido']; ?> 
                                    </td>

                                    <td> 
                                        <?php

                                        // A continuación genero una fila por cada registro asociado en la tabla "Detalle" 
                                        $CantidadDetalles = count($ListadoPedidos[$i]['Detalles']);

                                        for ($j=1; $j <= $CantidadDetalles; $j++) { ?> 

                                            <ul>
                                                <?php 
                                                // Primero evalúo si se trata de un repuesto, producto genérico o accesorio

                                                // REPUESTO?
                                                if (!empty($ListadoPedidos[$i]['Detalles'][$j]['Repuestos'])) { ?>
                                                    
                                                    <li> 
                                                        <?php echo "<strong>Tipo de insumo:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Repuestos']['TipoInsumo']"; ?> </br>
                                                        <?php echo "<strong>Nombre:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Repuestos']['NombreRepuesto']"; ?> </br>
                                                        <?php echo "<strong>Descripción:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Repuestos']['DescripcionRepuesto']"; ?> </br>
                                                    </li>
                                                <?php 
                                                } 
                                                
                                                // PRODUCTO GENÉRICO?
                                                if (!empty($ListadoPedidos[$i]['Detalles'][$j]['Productos'])) { ?>
                                                    
                                                    <li> 
                                                        <?php echo "<strong>Tipo de insumo:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Productos']['TipoInsumo']"; ?> </br>
                                                        <?php echo "<strong>Nombre:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Productos']['NombreProducto']"; ?> </br>
                                                        <?php echo "<strong>Descripción:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Productos']['DescripcionProducto']"; ?> </br>
                                                    </li>
                                                <?php 
                                                } 
                                                
                                                // ACCESORIO?
                                                if (!empty($ListadoPedidos[$i]['Detalles'][$j]['Accesorios'])) { ?>
                                                    
                                                    <li> 
                                                        <?php echo "<strong>Tipo de insumo:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Accesorios']['TipoInsumo']"; ?> </br>
                                                        <?php echo "<strong>Nombre:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Accesorios']['NombreAccesorio']"; ?> </br>
                                                        <?php echo "<strong>Descripción:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Accesorios']['DescripcionAccesorio']"; ?> </br>
                                                    </li>
                                                <?php 
                                                } 
                                                ?>

                                                <li> 
                                                    <?php echo "<strong>Precio unitario:</strong> $ListadoPedidos[$i]['Detalles'][$j]['PrecioPorUnidad']"; ?> </br>
                                                    <?php echo "<strong>Cantidad:</strong> $ListadoPedidos[$i]['Detalles'][$j]['CantidadUnidades']"; ?> </br>
                                                    <?php echo "<strong>Subtotal:</strong> $ListadoPedidos[$i]['Detalles'][$j]['Subtotal']"; ?> </br>
                                                </li>
                                            </ul>
                                        
                                        <?php 
                                        }                                        
                                        ?> 
                                    </td>
                                    
                                </tr>
                                <?php $contador++; ?>
                            <?php 
                            } 
                            ?>

                        </tbody>
                    </table>
                </div>
            

                <!-- Botones de acción -->
                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nuevo
                        </button>

                        <button class="btn btn-danger me-2" id="btnModificar" onclick="modificarPedido()" disabled>
                            Modificar
                        </button>

                        <button class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarPedido()" disabled>
                            Eliminar
                        </button>

                        <a href="ReporteContratos.php"> <button class="btn btn-info">
                            Imprimir
                        </button></a>
                    </div>

                </div>

                <!-- Reportes estadísticos -->
                <div style="margin: auto; max-width: 95%; padding: 150px 0 5px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h2 class="mb-1 " style="padding: 0; margin: 10px 0 0 0;" >
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
                        <h4 class="mb-1 " style="padding: 0; margin: 30px 0 0 0;" >
                            <strong style="color: #a80a0a;">Reporte:</strong> <a href="ReporteContratos_FrecMensuales.php" style="color: black;">Contratos por mes segmentados por estado </a>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16"> <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/> </svg> 
                                    Reporte
                                </button>
                            </a>
                        </div>

                    </div>
                </div>


                <!-- Modal para Nuevo Contrato -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg"> <!-- Aumentamos el tamaño para acomodar la tabla dinámica --> 
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Registrar nuevo Pedido a Proveedor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="Nuevo_Pedido_Proveedor.php" method="post"> <!-- Revisar "Nuevo_Contrato.php" para construir transacción --> 
                                <div class="modal-body">

                                    <!-- Información general del pedido (encabezado) -->
                                    <div class="mb-3">
                                        <label for="fechapedido" class="form-label">Fecha del Pedido</label>
                                        <input type="date" class="form-control" id="fechapedido" title="Obligatorio" name="fechapedido" value="" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaentrega" class="form-label">Fecha de Entrega</label>
                                        <input type="date" class="form-control" id="fechaentrega" name="fechaentrega" 
                                                title="Si contás con una fecha estimativa de arribo, colocala aquí" value="">
                                    </div>

                                    <div class="mb-3">
                                        <label for="idProveedor" class="form-label">Proveedor</label>
                                        <select class="form-select" aria-label="Selector" id="selector" title="Obligatorio" name="idProveedor" required>
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
                                            } 
                                            else {
                                                echo "<option value=''>No se encontraron proveedores</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="aclaracionesestadopedido" class="form-label">Aclaraciones sobre el estado del pedido </label>
                                        <textarea class="form-control" id="aclaracionesestadopedido" name="aclaracionesestadopedido" 
                                            rows="2" cols="33" title="Campo opcional que permite incorporar información adicional sobre el estado del pedido" 
                                            value=""> </textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="condicionesdeentrega" class="form-label">Condiciones de entrega </label>
                                        <textarea class="form-control" id="condicionesdeentrega" name="condicionesdeentrega" 
                                            rows="2" cols="33" title="Campo opcional que permite registrar condiciones pactadas de entrega" 
                                            value=""> </textarea>
                                    </div>

                                    </br></br>

                                    <!-- Detalle del pedido -->
                                    <h5><i class="fas fa-rocket" style="color: red; padding: 0 10px 0 10px;"></i> Detalle del pedido </h5>
                                    </br>

                                    <div class="mb-3" style="overflow-x: auto;"> <!-- Contenedor desplazable -->
                                        <table class="table table-bordered" id="tablaDetalles">
                                            <thead>
                                                <tr>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Tipo de Insumo
                                                    </th>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Nombre
                                                    </th>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Descripción
                                                    </th>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Precio Unitario
                                                    </th>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Cantidad
                                                    </th>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Subtotal
                                                    </th>
                                                    <th style="border: 2px solid #c7240e !important; text-align: center; background-color: #f9f9f9; ">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Filas dinámicas se generarán aquí -->
                                            </tbody>
                                        </table>

                                        </br></br>
                                        <button type="button" class="btn btn-primary" id="btnAgregarFila">Agregar Artículo</button>
                                        </br></br></br>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div style="">
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
        
                imageElement.style.transform = `perspective(500px) rotateY(${dx * 5}deg) rotateX(${-dy * 5}deg)`;
                };

                const handleMouseLeave = () => {
                imageElement.style.transform = "";
                };

                imageElement.addEventListener('mousemove', handleMouseMove);
                imageElement.addEventListener('mouseleave', handleMouseLeave);
            }
        }

    </script>

    <script>
        let pedidoSeleccionado = null;

        // Selección de fila en la Tabla de Pedidos a Proveedores al hacer clic en la misma
        document.querySelectorAll('#tablaPedidos .pedido').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.pedido').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                pedidoSeleccionado = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a la página de modificaciones con el ID del pedido seleccionado (recordá que el elemento del array ya contiene en su interior toda la información que le corresponde)
        function modificarPedido() {
            if (pedidoSeleccionado) {
                window.location.href = 'modificarPedidoProveedor.php?id=' + pedidoSeleccionado;
            }
        }

        // Función para redirigir a la página de eliminaciones con el ID del pedido seleccionado (recordá que el elemento del array ya contiene en su interior toda la información que le corresponde)
        function eliminarPedido() {
            if (pedidoSeleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este pedido?')) {
                    window.location.href = 'EliminarPedidoProveedor.php?id=' + pedidoSeleccionado;
                }
            }
        }
    </script>


    <script> // Para la tabla del modal que permite registrar nuevos pedidos a proveedores

        document.addEventListener("DOMContentLoaded", function () {
            const tablaDetalles = document.getElementById("tablaDetalles").querySelector("tbody");
            const btnAgregarFila = document.getElementById("btnAgregarFila");

            btnAgregarFila.addEventListener("click", function () {
                // Crear una nueva fila
                const nuevaFila = document.createElement("tr");
                nuevaFila.innerHTML = `
                    <td>
                        <select name="tipoInsumo[]" class="form-select" style="min-width: 120px;" required>
                            <option value="" selected>Selecciona una opción...</option>
                            <option value="Repuesto">Repuesto</option>
                            <option value="Producto">Producto</option>
                            <option value="Accesorio">Accesorio</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="nombreInsumo[]" class="form-control" style="min-width: 150px;" required>
                    </td>
                    <td>
                        <input type="text" name="descripcionInsumo[]" class="form-control" style="min-width: 170px;">
                    </td>
                    <td>
                        <input type="number" name="precioUnidad[]" class="form-control" step="0.01" style="min-width: 100px;" required>
                    </td>
                    <td>
                        <input type="number" name="cantidad[]" class="form-control" style="min-width: 100px;" required>
                    </td>
                    <td>
                        <input type="number" name="subtotal[]" class="form-control" step="0.01" style="min-width: 100px;" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btnEliminarFila">Eliminar</button>
                    </td>
                `;
                tablaDetalles.appendChild(nuevaFila);

                // Configurar el botón de eliminar fila
                nuevaFila.querySelector(".btnEliminarFila").addEventListener("click", function () {
                    nuevaFila.remove();
                });

                // Calcular subtotal automáticamente
                nuevaFila.querySelector("input[name='cantidad[]']").addEventListener("input", calcularSubtotal);
                nuevaFila.querySelector("input[name='precioUnidad[]']").addEventListener("input", calcularSubtotal);
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