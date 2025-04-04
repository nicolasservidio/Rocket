<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();


// Generación del listado de entregas
require_once 'funciones/CRUD-Entregas.php';
$ListadoEntregas = Listar_Entregas($conexion);
$CantidadEntregas = count($ListadoEntregas);

include('head.php');

?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 0; min-height: 100%;">
        <div class="container" style="max-width: 97%;">
            
            <div class="table-responsive p-5 mb-4 bg-white shadow-sm" style="max-width: 97%; max-height: 700px; margin-top: 10%; border: 2px solid #a80a0a; border-radius: 14px;">

                <h2 class="mb-4 " style="color: #a80a0a; padding: 0 0 20px 0;" >
                    <strong>Reporte: Listado de entregas a clientes </strong>
                </h2>
                
                <!-- Tabla de entregas a clientes -->
                <table class="table table-striped table-hover" id="tablaEntregas">
                    <thead>
                        <tr>
                            <th style='color: #c7240e;'><h3>#</h3></th>
                            <th>Contrato</th>
                            <th>Fecha Ret.</th>
                            <th>Hora Ret.</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Oficina Ret.</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        for ($i=0; $i < $CantidadEntregas; $i++) { ?>     

                            <tr class='entrega' data-id='<?php echo $ListadoEntregas[$i]['IdEntrega']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoEntregas[$i]['IdEntrega'] ?>')">

                                <td><span style='color: #c7240e;'><h4> <?php echo $contador; ?> </h4></span></td>
                                <td> <?php echo $ListadoEntregas[$i]['IdContrato']; ?> </td>
                                <td> <?php echo $ListadoEntregas[$i]['FechaEntrega']; ?> </td>
                                <td> <?php echo $ListadoEntregas[$i]['HoraEntrega']; ?> </td>
                                <td> <?php echo "{$ListadoEntregas[$i]['apellidoCliente']}, {$ListadoEntregas[$i]['nombreCliente']} </br> DNI: {$ListadoEntregas[$i]['dniCliente']}"; ?> </td>
                                <td> <?php echo "Patente {$ListadoEntregas[$i]['vehiculoMatricula']} </br> {$ListadoEntregas[$i]['vehiculoModelo']}, {$ListadoEntregas[$i]['vehiculoGrupo']}"; ?> </td>
                                <td> <?php echo "{$ListadoEntregas[$i]['CiudadSucursal']}, {$ListadoEntregas[$i]['DireccionSucursal']}"; ?> </td>
                            </tr>
                            <?php $contador++; ?>
                        <?php 
                        } 
                        ?>

                    </tbody>
                </table>

            </div>
        </div>

        <!-- Botón de acción -->
        <div style="margin-top: 5%; margin-bottom: 5%;">
            <div class="container d-flex justify-content-center">
                <span style="margin-right: 10%;">
                    <a href="entregaVehiculo.php"> <button class="btn" style="color: white; background-color: #a80a0a;" >
                        Volver
                    </button></a>
                </span>

                <a href="ReporteEntregas_pdf.php"> <button class="btn btn-warning" >
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