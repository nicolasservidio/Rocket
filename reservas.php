<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Generación del listado de reservas
require_once 'funciones/CRUD-Reservas.php';
$ListadoReservas = Listar_Reservas($conexion);
$CantidadReservas = count($ListadoReservas);



include('head.php');

?>

<body >

    <div class="wrapper">

        <?php 
        include('sidebarGOp.php');
        include('topNavBar.php');    
        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%;">
            <h3 class="fw-bold my-3">Reservas</h3>

            <!-- Formulario de filtros -->
            <form class="row g-3" method="post">

                <div class="col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" name="NumeroReserva" value="">
                </div>

                <div class="col-md-2">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="MatriculaReserva" value="">
                </div>

                <div class="col-md-2">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="ApellidoReserva" value="">
                </div>

                <div class="col-md-2">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="NombreReserva" value="">
                </div>

                <div class="col-md-2">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="text" class="form-control" id="documento" name="DocReserva" value="">
                </div>

                <div class="col-md-3">
                    <label for="retiro" class="form-label">Retiro entre</label>
                    <div class="d-flex">
                        <input type="date" class="form-control me-2" name="RetiroDesde" value="">
                        <input type="date" class="form-control" name="RetiroHasta" value="">
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
            </form>

            <!-- Tabla de reservas -->
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style='color: #0a8acf;'><h3>#</h3></th>
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

                            <tr onclick="selectRow(this, '<?= $ListadoReservas[$i]['idReserva'] ?>')">
                                <td><span style='color: #0a8acf;'><h4> <?php echo $contador; ?> </h4></span></td>
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

            <!-- Botones de acción -->
            <div style="margin-top: 8%;">
                <div class="container d-flex justify-content-center">
                    <button type="button" class="btn btn-danger me-2">Nuevo</button>
                    <button type="button" class="btn btn-danger me-2">Modificar</button>
                    <button type="button" class="btn btn-danger me-2">Imprimir</button>
                    <button type="button" class="btn btn-danger">Anular</button>
                </div>
            </div>
        </div>

        <div style="">
            <?php require_once "foot.php"; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    
</body>

</html>