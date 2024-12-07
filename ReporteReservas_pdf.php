<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();


// Generación del listado de reservas
require_once 'funciones/CRUD-Reservas.php';
$ListadoReservas = Listar_Reservas($conexion);
$CantidadReservas = count($ListadoReservas);

include('head.php');

?>

<body class="bg-light" style="margin-top: 2%; margin-bottom: 0;">

    <!-- Logo Header --> <!-- CUIDADO: Arroja error fatal si no tienen instalada la extensión "GD" de PHP en XAMPP. Para resolver el error, seguir instructivo: https://www.geeksforgeeks.org/how-to-install-php-gd-in-windows/ -->  
    <div style="margin: 0 auto; padding: 0 0 20px 41%;">
        <span style=""> 
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Rocket/assets/img/logo-red.png" height="20" width="" alt="navbar brand" srcset="" /> 
        </span>
    </div>
    <!-- End Logo Header -->

    <div style="margin: 0 auto; max-width: 95%;">
        <div class="" style="">
            
            <div class="p-5 mb-4 bg-white shadow-sm" 
                 style="margin: 0; padding: 20px; border: 2px solid #a80a0a; border-radius: 14px;">

                <h2 class="mb-4 text-secondary" style="padding-bottom: 10px;">
                    <strong>Reporte: Reservas de vehículos </strong>
                </h2>
                
                <!-- Tabla con reporte de reservas -->
                <table class="table table-striped table-hover" id="tablaReservas">
                    <thead>
                        <tr>
                            <th style="margin: 0 auto; padding: 0 5px 0 0; color: #d45313; font-size: 22px;">
                                <h3>#</h3>
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Nro
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Apellido
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Nombre
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                DNI
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Matrícula
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Grupo
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Modelo
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Fecha Ret.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Fecha Dev.
                            </th>

                            <th style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000; border-radius: 7px; background-color: #a80a0a; color: white;">
                                Monto
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        for ($i=0; $i < $CantidadReservas; $i++) { ?>     

                            <tr class='reserva' data-id='<?php echo $ListadoReservas[$i]['idReserva']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoReservas[$i]['idReserva'] ?>')" >

                                <td style="">
                                    <span style="color: #d45313; font-size: 17px; margin: 0 auto; padding: 0;"> 
                                        <h4> <?php echo $contador; ?> </h4>
                                    </span>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['numeroReserva']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['apellidoCliente']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['nombreCliente']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['dniCliente']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['vehiculoMatricula']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['vehiculoGrupo']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <?php echo $ListadoReservas[$i]['vehiculoModelo']; ?> 
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <span style="font-size: 11px;">
                                        <?php echo $ListadoReservas[$i]['fechaInicioReserva']; ?> 
                                    </span>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <span style="font-size: 11px;"> 
                                        <?php echo $ListadoReservas[$i]['fechaFinReserva']; ?> 
                                    </span>
                                </td>

                                <td style="margin: 0 auto; padding: 0 5px 0 5px; border: 1px solid #000000;"> 
                                    <span style="font-size: 12px; color: #a80a0a;"> 
                                        <?php echo "$ {$ListadoReservas[$i]['precioPorDiaReserva']} USD/día <br>
                                                    {$ListadoReservas[$i]['cantidadDiasReserva']} días <br> 
                                                    Total: $ {$ListadoReservas[$i]['totalReserva']} USD"; 
                                        ?> 
                                    </span> 
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