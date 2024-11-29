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


// Consulta por medio de formulario de Filtro
if (!empty($_POST['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_Consulta();

    $ListadoReservas = array();
    $CantidadReservas = '';
    $ListadoReservas = Consulta_Reservas($_POST['NumeroReserva'], $_POST['MatriculaReserva'], $_POST['ApellidoReserva'], $_POST['NombreReserva'], $_POST['DocReserva'], $_POST['RetiroDesde'], $_POST['RetiroHasta'], $conexion);
    $CantidadReservas = count($ListadoReservas);
}
else {

    // Listo la totalidad de los registros en la tabla "vehiculos". 
    $ListadoReservas = Listar_Reservas($conexion);
    $CantidadReservas = count($ListadoReservas);
}


if (!empty($_POST['BotonLimpiarFiltros'])) {

    header('Location: reservas.php');
    die();
}


// SELECCIONES para combo boxes
require_once 'funciones/Select_Tablas.php';

$ListadoVehiculos = Listar_VehiculosReservados($conexion);
$CantidadVehiculos = count($ListadoVehiculos);

$ListadoClientes = Listar_Clientes($conexion);
$CantidadClientes = count($ListadoClientes);



include('head.php');

?>

<body >

    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php 
        include('sidebarGOp.php');
        include('topNavBar.php');    
        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <div style="margin-bottom: 110px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #16719e; border-radius: 14px;">
                <div style='color: #0a8acf; margin-bottom: 30px;'> <h3 class="fw-bold"> Reservas </h3> </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" method="post">

                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="NumeroReserva" value=" <?php echo !empty($_POST['NumeroReserva']) ? $_POST['NumeroReserva'] : ''; ?> ">
                    </div>

                    <div class="col-md-2">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" id="matricula" name="MatriculaReserva" value=" <?php echo !empty($_POST['MatriculaReserva']) ? $_POST['MatriculaReserva'] : ''; ?> ">
                    </div>

                    <div class="col-md-2">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="ApellidoReserva" value=" <?php echo !empty($_POST['ApellidoReserva']) ? $_POST['ApellidoReserva'] : ''; ?> ">
                    </div>

                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="NombreReserva" value=" <?php echo !empty($_POST['NombreReserva']) ? $_POST['NombreReserva'] : ''; ?> ">
                    </div>

                    <div class="col-md-2">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="DocReserva" value=" <?php echo !empty($_POST['DocReserva']) ? $_POST['DocReserva'] : ''; ?> ">
                    </div>

                    <div class="col-md-3">
                        <label for="retiro" class="form-label">Retiro entre</label>
                        <div class="d-flex">
                            <input type="date" class="form-control me-2" name="RetiroDesde" value=" <?php echo !empty($_POST['RetiroDesde']) ? $_POST['RetiroDesde'] : ''; ?> ">
                            <input type="date" class="form-control" name="RetiroHasta" value=" <?php echo !empty($_POST['RetiroHasta']) ? $_POST['RetiroHasta'] : ''; ?> ">
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-info w-100" name="BotonFiltrar" value="FiltrandoReservas">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100" name="BotonLimpiarFiltros" value="LimpiandoFiltros">
                            <i class="fas fa-ban"></i> LimpiarFiltros
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de reservas -->
            <div style="margin-top: 5%; padding-bottom: 100px;">
                <div class="table-responsive mt-4" style="max-width: 97%; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover">
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

                                <tr class='reserva' data-id='<?php $ListadoReservas[$i]['idReserva'] ?>' 
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
            

                <!-- Botones de acción -->
                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nueva
                        </button>

                        <button class="btn btn-primary me-2" id="btnModificar" onclick="modificarReserva()" disabled>
                            Modificar
                        </button>

                        <button class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarReserva()" disabled>
                            Eliminar
                        </button>

                        <button type="button" class="btn btn-info">
                            Imprimir
                        </button>
                    </div>
                </div>


                <!-- Modal para Nueva Reserva -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nueva Reserva</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="Nueva_Reserva.php" method="post">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="idCliente" class="form-label">Cliente</label>

                                        <select class="form-select" aria-label="Selector" id="selector" name="idCliente" required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php 
                                            // Asegúrate de que $ListadoClientes contiene datos antes de procesarlo
                                            if (!empty($ListadoClientes)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadClientes; $i++) {
                                                    // Lógica para verificar si el grupo debe estar seleccionado
                                                    $selected = (!empty($_POST['idCliente']) && $_POST['idCliente'] == $ListadoClientes[$i]['idCliente']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoClientes[$i]['idCliente']}' $selected> 
                                                        {$ListadoClientes[$i]['apellidoCliente']} {$ListadoClientes[$i]['nombreCliente']} ({$ListadoClientes[$i]['dniCliente']}) <br> 
                                                        TEL: {$ListadoClientes[$i]['telefonoCliente']} 
                                                    </option>";
                                                }
                                            } 
                                            else {
                                                echo "<option value=''>No se encontraron clientes</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="numreserva" class="form-label">Número de reserva</label>
                                        <input type="text" class="form-control" id="numreserva" name="numreserva" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="idVehiculo" class="form-label">Vehículo</label>

                                        <select class="form-select" aria-label="Selector" id="selector" name="idVehiculo" required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php 
                                            // Asegúrate de que $ListadoVehiculos contiene datos antes de procesarlo
                                            if (!empty($ListadoVehiculos)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadVehiculos; $i++) {
                                                    // Lógica para verificar si el grupo debe estar seleccionado
                                                    $selected = (!empty($_POST['idVehiculo']) && $_POST['idVehiculo'] == $ListadoVehiculos[$i]['IdVehiculo']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoVehiculos[$i]['IdVehiculo']}' $selected> {$ListadoVehiculos[$i]['matricula']} - {$ListadoVehiculos[$i]['modelo']} - {$ListadoVehiculos[$i]['grupo']}  </option>";
                                                }
                                            } 
                                            else {
                                                echo "<option value=''>No se encontraron vehículos</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecharetiro" class="form-label">Fecha de Retiro</label>
                                        <input type="date" class="form-control" id="fecharetiro" name="fecharetiro" value="" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                                        <input type="date" class="form-control" id="fechadevolucion" name="fechadevolucion" value="" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
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