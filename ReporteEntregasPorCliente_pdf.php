<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

$idCliente = $_GET['mensaje'];

// Generación del listado de entregas
require_once 'funciones/CRUD-Entregas.php';
$ListadoEntregas = Listar_EntregasSegunCliente($idCliente, $conexion);
$CantidadEntregas = count($ListadoEntregas);

include('head.php');

?>


<body class="bg-light" style="margin-top: 2%; margin-bottom: 0;">
    <!-- Logo Header --> <!-- CUIDADO: Arroja error fatal si no tienen instalada la extensión "GD" de PHP en XAMPP. Para resolver el error, seguir instructivo: https://www.geeksforgeeks.org/how-to-install-php-gd-in-windows/ -->  
    <div style="margin: 0 auto; padding: 0 0 20px 90%;">
        <span style=""> 
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Proyectos/Rocket/assets/img/logo-red.png" height="30" width="" alt="navbar brand" srcset="" /> 
        </span>
    </div>
    <!-- End Logo Header -->
    <div style="margin: 0 auto; max-width: 100%;">
        <div class="" style="">
            
            <div class="p-5 mb-4 bg-white shadow-sm" 
                style="margin: 0; padding: 20px; ">
                <h3 class="mb-4 text-secondary" style="padding-bottom: 10px; color:rgb(154, 26, 9);">
                    <strong>Reporte: Entregas de vehículos según cliente </strong>
                </h3>

                <h5 class="mb-4 " style="color: black; padding: 0 0 30px 0;">
                    Cliente: 
                    <?php echo "{$ListadoEntregas[0]['apellidoCliente']} {$ListadoEntregas[0]['nombreCliente']} (DNI: {$ListadoEntregas[0]['dniCliente']})"; ?>
                </h5>

                <!-- Tabla con reporte de contratos -->
                <table class="table table-striped table-hover" id="tablaEntregas">
                    <thead>
                        <tr>
                            <th style="margin: 0 auto; padding: 0 5px 0 0; color: #d45313; font-size: 22px;">
                                <h3>#</h3>
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 16px;">
                                Nº Contrato.
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 16px;">
                                Fecha Ret.
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 16px;">
                                Hora Ret.
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 16px;">
                                Cliente
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 16px;">
                                Vehículo
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white; font-size: 16px;">
                                Oficina Ret.
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1; 
                        for ($i=0; $i < $CantidadEntregas; $i++) { ?>   
                            <tr class='entrega' data-id='<?php echo $ListadoEntregas[$i]['IdEntrega']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoEntregas[$i]['IdEntrega'] ?>')">
                                <td>
                                    <span style='color: #c7240e; font-size: 17px; margin: 0 auto; padding: 0;'>
                                        <h4> <?php echo $contador; ?> </h4>
                                    </span>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px; "> 
                                    <?php echo $ListadoEntregas[$i]['IdContrato']; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoEntregas[$i]['FechaEntrega']; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoEntregas[$i]['HoraEntrega']; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo "{$ListadoEntregas[$i]['apellidoCliente']}, {$ListadoEntregas[$i]['nombreCliente']} </br> DNI: {$ListadoEntregas[$i]['dniCliente']}"; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo "Patente {$ListadoEntregas[$i]['vehiculoMatricula']} </br> {$ListadoEntregas[$i]['vehiculoModelo']}, {$ListadoEntregas[$i]['vehiculoGrupo']}"; ?> 
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo "{$ListadoEntregas[$i]['CiudadSucursal']}, {$ListadoEntregas[$i]['DireccionSucursal']}"; ?>
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

// Pero, para que podamos ver el documento en el navegador y para que podamos descargarlo desde el navegador, necesitamos trabajar con "dompdf" y "stream" señalando el nombre del archivo:

$dompdf->stream("Reporte-Entregas-por-Cliente", array("Attachment" => false)); // false es para que se abra directamente en el navegador. True es para que se descargue

?>