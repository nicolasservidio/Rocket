<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();


// Generación del listado de Devolucion
require_once 'funciones/CRUD-Devolucion.php';
$ListadoDevolucion = Listar_Devolucion($conexion);
$CantidadDevolucion = count($ListadoDevolucion);

include('head.php');

?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 0; min-height: 100%;">
        <div class="container" style="max-width: 97%;">
            
            <div class="table-responsive p-5 mb-4 bg-white shadow-sm" style="max-width: 97%; max-height: 700px; margin-top: 10%; border: 2px solid #a80a0a; border-radius: 14px;">

                <h2 class="mb-4 " style="color: #a80a0a; padding: 0 0 20px 0;" >
                    <strong>Reporte: Listado de Devolucion a clientes </strong>
                </h2>
                
                <!-- Tabla de Devolucion a clientes -->
                <table class="table table-striped table-hover" id="tablaDevolucion">
                    <thead>
                        <tr>
                            <th style='color: #c7240e;'><h3>#</h3></th>
                            <th>Contrato</th>
                            <th>Fecha Dev.</th>
                            <th>Hora Dev.</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Oficina Dev.</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        for ($i=0; $i < $CantidadDevolucion; $i++) { ?>     

                            <tr class='devolucion' data-id='<?php echo $ListadoDevolucion[$i]['Iddevolucion']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoDevolucion[$i]['Iddevolucion'] ?>')">

                                <td><span style='color: #c7240e;'><h4> <?php echo $contador; ?> </h4></span></td>
                                <td> <?php echo $ListadoDevolucion[$i]['IdContrato']; ?> </td>
                                <td> <?php echo $ListadoDevolucion[$i]['Fechadevolucion']; ?> </td>
                                <td> <?php echo $ListadoDevolucion[$i]['Horadevolucion']; ?> </td>
                                <td> <?php echo "{$ListadoDevolucion[$i]['apellidoCliente']}, {$ListadoDevolucion[$i]['nombreCliente']} </br> DNI: {$ListadoDevolucion[$i]['dniCliente']}"; ?> </td>
                                <td> <?php echo "Patente {$ListadoDevolucion[$i]['vehiculoMatricula']} </br> {$ListadoDevolucion[$i]['vehiculoModelo']}, {$ListadoDevolucion[$i]['vehiculoGrupo']}"; ?> </td>
                                <td> <?php echo "{$ListadoDevolucion[$i]['CiudadSucursal']}, {$ListadoDevolucion[$i]['DireccionSucursal']}"; ?> </td>
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
                    <a href="devolucionVehiculo.php"> <button class="btn" style="color: white; background-color: #a80a0a;" >
                        Volver
                    </button></a>
                </span>

                <a href="ReporteDevoluciones_pdf.php"> <button class="btn btn-warning" >
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