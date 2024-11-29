<?php


session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include("/administrador/");

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

                <h5 class="mb-4 text-secondary"><strong>Reporte: Reservas de vehículos </strong></h5>
                
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
                                    onclick="selectRow(this, '<?= $ListadoReservas[$i]['idReserva'] ?>')">

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