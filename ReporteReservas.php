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
    <div style="margin: auto; max-width: 80%;">
        <div class="" style="margin-bottom: 120px;">
            
            <div class="p-5 mb-4 bg-white shadow-sm" style="margin-top: 10%; border: 2px solid #5250ab; border-radius: 14px;">

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
                            <th>Montos</th>
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

                                <td> 
                                    <span style="font-size: 12px; color: purple;"> 
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

                <!-- Botón de acción -->
                <div style="margin-top: 5%; margin-bottom: 3%;">
                    <div class="container d-flex justify-content-center">
                        <span style="margin-right: 10%;">
                            <a href="reservas.php"> <button class="btn" style="color: white; background-color: #5250ab;" >
                                Volver
                            </button></a>
                        </span>

                        <a href="ReporteReservas_pdf.php"> <button class="btn btn-warning" >
                            Imprimir
                        </button></a>
                    </div>
                </div>

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
echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

?>