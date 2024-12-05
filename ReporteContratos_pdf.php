<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();


// Generación del listado de contratos
require_once 'funciones/CRUD-Contratos.php';
$ListadoContratos = Listar_Contratos($conexion);
$CantidadContratos = count($ListadoContratos);

include('head.php');

?>

<body class="bg-light" style="margin-top: 2%; margin-bottom: 0;">

    <!-- Logo Header --> <!-- CUIDADO: Arroja error fatal si no tienen instalada la extensión "GD" de PHP en XAMPP. Para resolver el error, seguir instructivo: https://www.geeksforgeeks.org/how-to-install-php-gd-in-windows/ -->  
    <div style="margin: 0 auto; padding: 0 0 20px 50%;">
        <span style=""> 
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Rocket/assets/img/logo-red.png" height="20" width="" alt="navbar brand" srcset="" /> 
        </span>
    </div>
    <!-- End Logo Header -->

    <div style="margin: 0 auto; max-width: 100%;">
        <div class="" style="">
            
            <div class="p-5 mb-4 bg-white shadow-sm" 
                 style="margin: 0; padding: 20px; border: 2px solid #a80a0a; border-radius: 14px;">

                <h2 class="mb-4 text-secondary" style="padding-bottom: 10px;">
                    <strong>Reporte: Contratos de alquiler de vehículos </strong>
                </h2>
                
                <!-- Tabla con reporte de contratos -->
                <table class="table table-striped table-hover" id="tablaReservas">
                    <thead>
                        <tr>
                            <th style="margin: 0 auto; padding: 0 5px 0 0; color: #d45313; font-size: 22px;">
                                <h3>#</h3>
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Núm.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Fecha Ret.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Fecha Dev.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Apellido
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Nombre
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                DNI
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Matrícula
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Vehículo
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Oficina Ret.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Oficina Dev.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Estado Contrato
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Precio día
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Cantidad días
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 14px;">
                                Monto total
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        for ($i=0; $i < $CantidadContratos; $i++) { ?>     

                            <tr class='contrato' data-id='<?php echo $ListadoContratos[$i]['IdContrato']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoContratos[$i]['IdContrato'] ?>')">

                                <td>
                                    <span style='color: #c7240e; font-size: 17px; margin: 0 auto; padding: 0;'>
                                        <h4> <?php echo $contador; ?> </h4>
                                    </span>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px; "> 
                                    <?php echo $ListadoContratos[$i]['IdContrato']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['FechaInicioContrato']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['FechaFinContrato']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['apellidoCliente']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['nombreCliente']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['dniCliente']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['vehiculoMatricula']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$ListadoContratos[$i]['vehiculoModelo']}, {$ListadoContratos[$i]['vehiculoGrupo']}"; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$ListadoContratos[$i]['CiudadSucursal']}, {$ListadoContratos[$i]['DireccionSucursal']}"; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$ListadoContratos[$i]['CiudadSucursal']}, {$ListadoContratos[$i]['DireccionSucursal']}"; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo $ListadoContratos[$i]['EstadoContrato']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$ListadoContratos[$i]['PrecioPorDiaContrato']} US$"; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$ListadoContratos[$i]['CantidadDiasContrato']} días"; ?> 
                                </td>
                                
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 12px;"> 
                                    <?php echo "{$ListadoContratos[$i]['MontoTotalContrato']} US$"; ?> 
                                </td>

                            </tr>
                            <?php $contador++; ?>
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
$dompdf->setPaper('A4', 'landscape');  // el formato entre paréntesis. Probar "letter" en lugar de los dos argumentos que se usan aquí

// Hacemos el render, es decir todo lo que le asignamos al objeto $dompdf se renderiza, se hace visible
$dompdf->render();

// Pero, para que podamos ver el documento en el navegador y para que podamos descargarlo desde el navegador, necesitamos trabajar con "dompdf" y "stream" señanando el nombre del archivo:

$dompdf->stream("reporte_reservas.pdf", array("Attachment" => false)); // false es para que se abra directamente en el navegador. True es para que se descargue

?>