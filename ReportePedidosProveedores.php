<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();


// Generación del listado de pedidos a proveedores
require_once 'funciones/CRUD-PedidosProv.php'; 
$ListadoPedidos = Listar_PedidosProveedores($conexion); 
$CantidadPedidos = count($ListadoPedidos);

include('head.php');

?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 0; min-height: 100%;">
        <div class="container" style="max-width: 97%;">
            
            <div class="table-responsive p-5 mb-4 bg-white shadow-sm" style="max-width: 97%; max-height: 700px; margin-top: 10%;">

                <h2 class="mb-4 " style="color: #a80a0a; padding: 0 0 20px 0;" >
                    <strong>Reporte: Listado de pedidos a proveedores </strong>
                </h2>
                
                <!-- Tabla de pedidos a proveedores -->
                <div class="table-responsive mt-4">
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
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1; 

                            // Iterar sobre los pedidos en el array $ListadoPedidos
                            foreach ($ListadoPedidos as $ppIdPedido => $Pedido) { ?>

                                <tr class='pedido' data-id='<?php echo $Pedido['ppIdPedido']; ?>' 
                                    onclick="selectRow(this, '<?php $Pedido['ppIdPedido']; ?>')">
                                    
                                    <!-- Encabezado principal para cada pedido -->
                                    <tr>
                                        <th colspan="9"> 
                                            <h3 style="color:rgb(175, 41, 4); font-family: Segoe UI; text-align: left; padding: 20px 0 0 0;">
                                                PEDIDO #<?php echo $Pedido['ppIdPedido']; ?> 
                                            </h3> 
                                        </th>
                                    </tr>

                                    <!-- Datos del pedido -->
                                    <td>
                                        <span style='color: #c7240e;'>
                                            <h4> <?php echo $contador; ?> </h4>
                                        </span>
                                    </td>

                                    <td title="ID del Pedido"> 
                                        <?php echo "<b> ID: {$Pedido['ppIdPedido']} </b>"; ?> 
                                    </td>

                                    <td title="Fecha de pedido"> 
                                        <?php echo $Pedido['FechaPedido']; ?> 
                                    </td>
                                    
                                    <td title="Fecha de entrega"> 
                                        <?php echo $Pedido['FechaEntrega']; ?> 
                                    </td>

                                    <td title="Estado del pedido"> 
                                        <span> 
                                            <?php echo $Pedido['EstadoPedido']; ?> 
                                        </span> 
                                    </td>

                                    <td title="Aclaraciones sobre el estado del pedido"> 
                                        <?php echo $Pedido['AclaracionesEstadoPedido']; ?> 
                                    </td>

                                    <td title="Condiciones de entrega"> 
                                        <?php echo $Pedido['CondicionesDeEntrega']; ?> 
                                    </td>

                                    <td title="Información sobre el proveedor"> 
                                        <?php 
                                        echo "{$Pedido['NombreProveedor']} </br> 
                                        <strong>CUIT:</strong> {$Pedido['CuitProveedor']} </br> 
                                        <strong>IVA:</strong> {$Pedido['IvaProveedor']} </br></br> 
                                        <strong>Correo:</strong> {$Pedido['MailProveedor']}
                                        <strong>Dirección:</strong> {$Pedido['DireccionProveedor']}, {$Pedido['LocalidadProveedor']}"; 
                                        ?> 
                                    </td>

                                    <td title="Monto total de la compra"> 
                                        <?php echo "{$Pedido['TotalPedido']} USD"; ?> 
                                    </td>                                

                                    <!-- Encabezado para los artículos del pedido -->
                                    <tr>
                                        <th colspan="9"> 
                                            <h5 style="color:rgb(175, 41, 4); font-family: Segoe UI; text-align: left;">
                                                ARTÍCULOS
                                            </h5> 
                                        </th>
                                    </tr>

                                    <tr>
                                        <th colspan="1">Tipo de insumo</th>
                                        <th colspan="2">Nombre</th>
                                        <th colspan="3">Descripción</th>
                                        <th colspan="1">Precio unitario</th>
                                        <th colspan="1">Cantidad</th>
                                        <th colspan="1">Subtotal</th>
                                    </tr>

                                    <!-- Detalles del pedido -->
                                    <?php 
                                    // Iterar sobre los detalles del pedido actual
                                    foreach ($Pedido['Detalles'] as $detalleId => $Detalle) { ?>
                                        <tr> 
                                            <td title="Tipo de insumo">
                                                <?php echo $Detalle['TipoInsumo']; ?>
                                            </td>
                                            <td colspan="2" title="Nombre del insumo">
                                                <?php
                                                if ($Detalle['TipoInsumo'] == "Repuesto") {
                                                    echo $Detalle['NombreRepuesto'];
                                                } elseif ($Detalle['TipoInsumo'] == "Producto") {
                                                    echo $Detalle['NombreProducto'];
                                                } elseif ($Detalle['TipoInsumo'] == "Accesorio") {
                                                    echo $Detalle['NombreAccesorio'];
                                                }
                                                ?>
                                            </td>
                                            <td colspan="3" title="Descripción del insumo">
                                                <?php
                                                if ($Detalle['TipoInsumo'] == "Repuesto") {
                                                    echo $Detalle['DescripcionRepuesto'];
                                                } elseif ($Detalle['TipoInsumo'] == "Producto") {
                                                    echo $Detalle['DescripcionProducto'];
                                                } elseif ($Detalle['TipoInsumo'] == "Accesorio") {
                                                    echo $Detalle['DescripcionAccesorio'];
                                                }
                                                ?>
                                            </td>
                                            <td colspan="1" title="Precio por unidad">
                                                <?php echo "{$Detalle['PrecioPorUnidad']} USD"; ?>
                                            </td>
                                            <td colspan="1" title="Cantidad de unidades compradas">
                                                <?php echo $Detalle['CantidadUnidades']; ?>
                                            </td>
                                            <td colspan="1" title="Subtotal del artículo">
                                                <?php echo "{$Detalle['Subtotal']} USD"; ?>
                                            </td>
                                        </tr>
                                    <?php 
                                    } ?>

                                </tr>
                            <?php 
                            $contador++;
                            } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Botón de acción -->
        <div style="margin-top: 5%; margin-bottom: 5%;">
            <div class="container d-flex justify-content-center">
                <span style="margin-right: 10%;">
                    <a href="pedidosProveedores.php"> <button class="btn" style="color: white; background-color: #a80a0a;" >
                        Volver
                    </button></a>
                </span>

                <a href="ReportePedidosProveedores_pdf.php"> <button class="btn btn-warning" >
                    Exportar
                </button></a>
            </div>
        </div>

        <div style="">
            <?php require_once "foot.php"; ?>
        </div>

    </div>

</body>
</html>

<?php
$html = ob_get_clean();
echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

?>

