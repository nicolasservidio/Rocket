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

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">
        <div class="container" style="max-width: 97%;">
            
            <div class="table-responsive p-5 mb-4 bg-white shadow-sm" style="max-width: 97%; max-height: 700px; margin-top: 10%; border: 2px solid #a80a0a; border-radius: 14px;">

                <h2 class="mb-4 " style="color: #a80a0a; padding: 0 0 20px 0;" >
                    <strong>Reporte: Contratos de arrendamiento de vehículos </strong>
                </h2>
                
                <!-- Tabla con reporte de contratos -->

                <table class="table table-striped table-hover" id="tablaContratos">
                    <thead>
                        <tr>
                            <th style='color: #c7240e;'><h3>#</h3></th>
                            <th>Contrato</th>
                            <th>Fecha Ret.</th>
                            <th>Fecha Dev.</th>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Matrícula</th>
                            <th>Vehículo</th>
                            <th>Oficina Ret.</th>
                            <th>Oficina Dev.</th>
                            <th>Estado Contrato</th>
                            <th>Precio día</th>
                            <th>Cantidad días</th>
                            <th>Monto total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 1; 

                        for ($i=0; $i < $CantidadContratos; $i++) { ?>     

                            <tr class='contrato' data-id='<?php echo $ListadoContratos[$i]['IdContrato']; ?>' 
                                onclick="selectRow(this, '<?= $ListadoContratos[$i]['IdContrato'] ?>')">

                                <td><span style='color: #c7240e;'><h4> <?php echo $contador; ?> </h4></span></td>
                                <td> <?php echo $ListadoContratos[$i]['IdContrato']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['FechaInicioContrato']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['FechaFinContrato']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['apellidoCliente']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['nombreCliente']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['dniCliente']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['vehiculoMatricula']; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['vehiculoModelo']}, {$ListadoContratos[$i]['vehiculoGrupo']}"; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['CiudadSucursal']}, {$ListadoContratos[$i]['DireccionSucursal']}"; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['CiudadSucursal']}, {$ListadoContratos[$i]['DireccionSucursal']}"; ?> </td>
                                <td> <span class="badge badge-success"> <?php echo $ListadoContratos[$i]['EstadoContrato']; ?> </span> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['PrecioPorDiaContrato']} US$"; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['CantidadDiasContrato']} días"; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['MontoTotalContrato']} US$"; ?> </td>
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
                    <a href="contratosAlquiler.php"> <button class="btn" style="color: white; background-color: #a80a0a;" >
                        Volver
                    </button></a>
                </span>

                <a href="ReporteContratos_pdf.php"> <button class="btn btn-warning" >
                    Imprimir
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