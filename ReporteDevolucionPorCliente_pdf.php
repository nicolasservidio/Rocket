<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

$idCliente = $_GET['mensaje'];

// Generación del listado de Devolucion
require_once 'funciones/CRUD-Devolucion.php';
$ListadoDevolucion = Listar_DevolucionSegunCliente($idCliente, $conexion);
$CantidadDevolucion = count($ListadoDevolucion);

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
                <h3 class="mb-4 text-secondary" style="padding-bottom: 10px; color:rgb(14, 94, 199);">
                    <strong>Reporte: Devolucion de vehículos según cliente </strong>
                </h3>

                <h5 class="mb-4 " style="color: black; padding: 0 0 30px 0;">
                    Cliente: 
                    <?php echo "{$ListadoDevolucion[0]['apellidoCliente']} {$ListadoDevolucion[0]['nombreCliente']} (DNI: {$ListadoDevolucion[0]['dniCliente']})"; ?>
                </h5>

                <!-- Tabla con reporte de contratos -->
                <table class="table table-striped table-hover" id="tablaDevolucion">
                    <thead>
                        <tr>
                            <th style="margin: 0 auto; padding: 0 5px 0 0; color: #d45313; font-size: 22px;">
                                <h3>#</h3>
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color:rgb(14, 94, 199); color: white; font-size: 16px;">
                                Nº Contrato.
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color:rgb(14, 94, 199); color: white; font-size: 16px;">
                                Fecha Dev.
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color:rgb(14, 94, 199); color: white; font-size: 16px;">
                                Hora Dev.
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color:rgb(14, 94, 199); color: white; font-size: 16px;">
                                Cliente
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color:rgb(14, 94, 199); color: white; font-size: 16px;">
                                Vehículo
                            </th>
                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color:rgb(14, 94, 199); color: white; font-size: 16px;">
                                Oficina Dev.
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1; 
                        for ($i=0; $i < $CantidadDevolucion; $i++) { ?>   
                            <tr class='devolucion' data-id='<?php echo $ListadoDevolucion[$i]['IdDevolucion']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoDevolucion[$i]['IdDevolucion'] ?>')">
                                <td>
                                    <span style='color:rgb(14, 94, 199); font-size: 17px; margin: 0 auto; padding: 0;'>
                                        <h4> <?php echo $contador; ?> </h4>
                                    </span>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px; "> 
                                    <?php echo $ListadoDevolucion[$i]['IdContrato']; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoDevolucion[$i]['FechaDevolucion']; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo $ListadoDevolucion[$i]['HoraDevolucion']; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo "{$ListadoDevolucion[$i]['apellidoCliente']}, {$ListadoDevolucion[$i]['nombreCliente']} </br> DNI: {$ListadoDevolucion[$i]['dniCliente']}"; ?>
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo "Patente {$ListadoDevolucion[$i]['vehiculoMatricula']} </br> {$ListadoDevolucion[$i]['vehiculoModelo']}, {$ListadoDevolucion[$i]['vehiculoGrupo']}"; ?> 
                                </td>
                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; font-size: 14px;"> 
                                    <?php echo "{$ListadoDevolucion[$i]['CiudadSucursal']}, {$ListadoDevolucion[$i]['DireccionSucursal']}"; ?>
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

$dompdf->stream("Reporte-Devolucion-por-Cliente", array("Attachment" => false)); // false es para que se abra directamente en el navegador. True es para que se descargue

?>