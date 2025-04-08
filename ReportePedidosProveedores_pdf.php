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

<body class="bg-light" style="margin-top: 2%; margin-bottom: 0;">

    <!-- Logo Header --> <!-- CUIDADO: Arroja error fatal si no tienen instalada la extensión "GD" de PHP en XAMPP. Para resolver el error, seguir instructivo: https://www.geeksforgeeks.org/how-to-install-php-gd-in-windows/ -->  
    <div style="margin: 0 auto; padding: 0 0 20px 45%;">
        <span style=""> 
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Proyectos/Rocket/assets/img/logo-red.png" height="20" width="" alt="navbar brand" srcset="" /> 
        </span>
    </div>
    <!-- End Logo Header -->

    <div style="margin: 0 auto; max-width: 100%;">
        <div class="" style="">
            
            <div class="p-5 mb-4 bg-white shadow-sm table-responsive" 
                 style="margin: 0; padding: 20px; ">

                <h4 class="mb-4 text-secondary" style="padding-bottom: 10px;">
                    <strong>Reporte: Listado de pedidos a proveedores </strong>
                </h4>
                
                <!-- Tabla con reporte de pedidos a proveedores -->
                <table class="table table-striped table-hover" id="tablaPedidos">
                    <thead>
                        <tr>
                            <th style="margin: 0 auto; padding: 0 5px 0 0; color: #d45313; font-size: 22px;">
                                <h3>#</h3>
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                ID Pedido
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Fecha Pedido
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Fecha Entrega
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Estado del Pedido
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Aclaraciones sobre el Estado
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Condiciones de Entrega
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Datos del Proveedor
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; background-color: #a80a0a; color: white; font-size: 14px;">
                                Monto Total
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        foreach ($ListadoPedidos as $ppIdPedido => $Pedido) { ?>

                            <tr class='pedido' data-id='<?php echo $Pedido['ppIdPedido']; ?>' 
                                onclick="selectRow(this, '<?php $Pedido['ppIdPedido']; ?>')">

                                <!-- Encabezado principal para cada pedido -->
                                <tr>
                                    <th colspan="9" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; "> 
                                        <h3 style="color:rgb(175, 41, 4); font-family: Segoe UI; text-align: left;">
                                            PEDIDO #<?php echo $Pedido['ppIdPedido']; ?> 
                                        </h3> 
                                    </th>
                                </tr>

                                <!-- Datos del pedido -->
                                <td>
                                    <span style='text-align: center; margin: 0 auto; color: #c7240e; font-size: 22px; padding: 0 0 20px 0;'>
                                        <h4> fila </br> <?php echo $contador; ?> </h4>
                                    </span>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; "> 
                                    <?php echo "<b> ID: {$Pedido['ppIdPedido']} </b>"; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $Pedido['FechaPedido']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $Pedido['FechaEntrega']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <span class="badge badge-success"> 
                                        <?php echo $Pedido['EstadoPedido']; ?> 
                                    </span> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $Pedido['AclaracionesEstadoPedido']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $Pedido['CondicionesDeEntrega']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php 
                                        echo "{$Pedido['NombreProveedor']} </br> 
                                        <strong>CUIT:</strong> {$Pedido['CuitProveedor']} </br> 
                                        <strong>IVA:</strong> {$Pedido['IvaProveedor']} </br></br> 
                                        <strong>Correo:</strong> {$Pedido['MailProveedor']}
                                        <strong>Dirección:</strong> {$Pedido['DireccionProveedor']}, {$Pedido['LocalidadProveedor']}"; 
                                    ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$Pedido['TotalPedido']} USD"; ?> 
                                </td> 

                                <!-- Encabezado para los artículos del pedido -->

                                <tr>
                                    <th colspan="9" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; "> 
                                        <h5 style="color:rgb(175, 41, 4); font-family: Segoe UI; text-align: left;">
                                            ARTÍCULOS
                                        </h5> 
                                    </th>
                                </tr>

                                <tr style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                    <th colspan="1" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                        Tipo de insumo</th>
                                    <th colspan="2" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                        Nombre</th>
                                    <th colspan="3" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                        Descripción</th>
                                    <th colspan="1" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                        Precio unitario</th>
                                    <th colspan="1" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                        Cantidad</th>
                                    <th colspan="1" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                        Subtotal</th>
                                </tr>
                                
                                <!-- Detalles del pedido -->
                                <?php 
                                // Iterar sobre los detalles del pedido actual
                                foreach ($Pedido['Detalles'] as $detalleId => $Detalle) { ?>
                                    <tr> 
                                        <td title="Tipo de insumo" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                            <?php echo $Detalle['TipoInsumo']; ?>
                                        </td>
                                        <td colspan="2" title="Nombre del insumo" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
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
                                        <td colspan="3" title="Descripción del insumo" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
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
                                        <td colspan="1" title="Precio por unidad" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                            <?php echo "{$Detalle['PrecioPorUnidad']} USD"; ?>
                                        </td>
                                        <td colspan="1" title="Cantidad de unidades compradas" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                            <?php echo $Detalle['CantidadUnidades']; ?>
                                        </td>
                                        <td colspan="1" title="Subtotal del artículo" style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; ">
                                            <?php echo "{$Detalle['Subtotal']} USD"; ?>
                                        </td>
                                    </tr>
                                <?php 
                                } ?>

                            </tr>
                            <?php $contador++; ?>
                        </br>
                        <?php 
                        } 
                        ?>
                    </tbody>
                </table>                    

            </div>
        </div>
    </div>


<footer id="footer" class="footer" style="margin-top: 80px; background: #b54d0d; margin: #333333; border: #333333; ">
    
    <div style="color: white; background: #b54d0d; margin: #333333; border: #333333; text-align: center; padding-top: 2%; padding-bottom: 2%; ">
        <div class="copyright">
        &copy; Copyright <strong><span>Rocket</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        Developed by <span style="color: white;">Rocket Team</span>: <a href="https://www.linkedin.com/in/nicolas-servidio-del-monte/" style="color: black;" >NS</a> - <a href="https://www.linkedin.com/in/bruno-carossi-1b43b8178/" style="color: black;" >BC</a> - <a href="https://www.linkedin.com/in/facundo-mota-123380257/" style="color: black;" >FM</a>
        </div>
    </div>
</footer><!-- End Footer -->

</body>
</html>

<?php
$html = ob_get_clean();
// echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

// Creando un objeto de tipo Dompdf para trabajar con todas las funcionalidades de conversión del documento HTML a PDF
require_once 'administrador/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();  // Este objeto me permitirá trabajar con todas las funcionalidades de conversión de HTML a PDF

// Activamos la opción que nos permite mostrar imágenes, por si la tabla llegara a contenerlas
$options = $dompdf->getOptions();  // solo recupero la opción
$options->set(array('isRemoteEnabled' => true));  // estoy activando con true esa opción, que es "isRemoteEnabled" 
$dompdf->setOptions($options);  // y se lo estoy pasando nuevamente al objeto $dompdf, para que se pueda mostrar dicha imagen

// Probemos:
$dompdf->loadHtml($html);

// genero el documento PDF:
$dompdf->setPaper('A4', 'letter');  // el formato entre paréntesis. Probar "letter" en lugar de los dos argumentos que se usan aquí

// Hacemos el render, es decir todo lo que le asignamos al objeto $dompdf se renderiza, se hace visible
$dompdf->render();

// Pero, para que podamos ver el documento en el navegador y para que podamos descargarlo desde el navegador, necesitamos trabajar con "dompdf" y "stream" señalando el nombre del archivo:

$dompdf->stream("ReporteEntregas", array("Attachment" => false)); // false es para que se abra directamente en el navegador. True es para que se descargue

?>