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

<body class="bg-light">
    <div style="min-height: 100%; margin: auto; max-width: 70%;">
        <div class="wrapper">
            
            <div class="p-5 mb-4 bg-white shadow-sm" style="margin-top: 10%; margin-left: 1%; border: 1px solid #444444; border-radius: 14px;">

                <h2 class="mb-4 text-secondary"><strong>Reporte: Reservas de vehículos </strong></h2>
                
                <!-- Tabla con reporte de reservas -->
                <table class="table table-striped table-hover" id="tablaReservas">
                        <thead>
                            <tr>
                                <th style='color: #d19513;'><h3>#</h3></th>
                                <th>Nro</th>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Matrícula</th>
                                <th>Grupo</th>
                                <th>Modelo</th>
                                <th>Fec. Ret.</th>
                                <th>Fec. Dev.</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1; 

                            for ($i=0; $i < $CantidadReservas; $i++) { ?>     

                                <tr class='reserva' data-id='<?php echo $ListadoReservas[$i]['idReserva']; ?>' 
                                    onclick="selectRow(this, '<?= $ListadoReservas[$i]['idReserva'] ?>')" >

                                    <td><span style='color: #d19513;'><h4> <?php echo $contador; ?> </h4></span></td>
                                    <td> <?php echo $ListadoReservas[$i]['numeroReserva']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['apellidoCliente']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['nombreCliente']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['dniCliente']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['vehiculoMatricula']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['vehiculoGrupo']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['vehiculoModelo']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['fechaInicioReserva']; ?> </td>
                                    <td> <?php echo $ListadoReservas[$i]['fechaFinReserva']; ?> </td>
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

    <div style="">
            <?php require_once "foot.php"; ?>
        </div>

</body>
</html>

<?php
$html = ob_get_clean();
// echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

// Creando un objeto de tipo Dompdf para trabajar con todas las funcionalidades de conversión del documento HTML a PDF
require_once 'administrador/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();



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