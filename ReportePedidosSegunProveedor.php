<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {?>

    <?php

    $idProveedor = $_POST['idProveedor'];

    // Generación del listado de pedidos a proveedores
    require_once 'funciones/CRUD-PedidosProv.php';
    $ListadoPedidos = Listar_PedidosProveedoresSegunProveedor($conexion, $idProveedor);
    $CantidadPedidos = count($ListadoPedidos);

    include('head.php');

    ?>

    <body class="bg-light" style="margin: 0 auto;">
        <div class="wrapper" style="margin-bottom: 0; min-height: 100%;">
            <div class="container" style="max-width: 97%;">
                
                <div class="table-responsive p-5 mb-4 bg-white shadow-sm" style="max-width: 97%; max-height: 700px; margin-top: 10%;">

                    <h3 class="mb-4 " style="color: rgb(18, 55, 78); padding: 0 0 20px 0;" >
                        <strong>Reporte: Pedidos a proveedores según proveedor </strong>
                    </h3>


                    <?php // solo genero el reporte si $ListadoPedidos no está vacío
                    
                    if(!empty($ListadoPedidos)) { 

                        $primerPedido = reset($ListadoPedidos); // Obtiene el primer elemento del array asociativo 
                    ?>


                        <h5 class="mb-4 " style="color:rgb(18, 55, 78); padding: 0 0 20px 0;">
                            Proveedor: <?= "{$primerPedido['NombreProveedor']} (CUIT: {$primerPedido['CuitProveedor']})"; ?>
                        </h5>

                        <!-- Tabla de pedidos según proveedor -->
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
                                    <td>
                                        <?php
                                        // Definir los colores según el estado del pedido
                                        $coloresEstados = [
                                            "Pendiente" => "badge-secondary",
                                            "Confirmado" => "badge-primary",
                                            "Cancelado" => "badge-danger",
                                            "En Preparación" => "badge-warning",
                                            "Enviado" => "badge-info",
                                            "Entregado" => "badge-success",
                                            "Devuelto" => "badge-danger"
                                        ];
                                        
                                        // Obtener la clase de color correspondiente
                                        $claseEstado = $coloresEstados[$Pedido['EstadoPedido']] ?? "badge-secondary"; 
                                        ?>

                                        <span class="badge <?= $claseEstado ?>"><?= $Pedido['EstadoPedido'] ?></span>
                                    </td>
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
                    <?php } 

                    else { ?>  

                        <h5 class="mb-4 " style="color:rgb(18, 55, 78); padding: 0 0 20px 0;">
                            No existen registros asociados al proveedor 
                        </h5>                        

                    <?php } ?>

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

                    <?php if(!empty($ListadoPedidos)) {?> 
                    <a href="ReportePedidosSegunProveedor_pdf.php?mensaje=<?php echo urlencode($idProveedor); ?> "> 
                        <button class="btn btn-warning" >
                            Exportar                            
                        </button>
                    </a>
                    <?php } ?>
                </div>
            </div>

        </div>

        <div style="">
            <?php require_once "foot.php"; ?>
        </div>

    </body>
    </html>

<?php } ?>

<?php
$html = ob_get_clean();
echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

?>