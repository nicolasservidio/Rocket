<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'numero' => isset($_GET['NumeroContrato']) ? trim($_GET['NumeroContrato']) : '',
    'matricula' => isset($_GET['MatriculaContrato']) ? trim($_GET['MatriculaContrato']) : '',
    'apellido' => isset($_GET['ApellidoContrato']) ? trim($_GET['ApellidoContrato']) : '',
    'nombre' => isset($_GET['NombreContrato']) ? trim($_GET['NombreContrato']) : '',
    'documento' => isset($_GET['DocContrato']) ? trim($_GET['DocContrato']) : '',
    'estado' => isset($_GET['EstadoContrato']) ? trim($_GET['EstadoContrato']) : '',
    'preciodia' => isset($_GET['PrecioDiaContrato']) ? trim($_GET['PrecioDiaContrato']) : '',
    'cantidaddias' => isset($_GET['CantidadDiasContrato']) ? trim($_GET['CantidadDiasContrato']) : '',
    'montototal' => isset($_GET['MontoTotalContrato']) ? trim($_GET['MontoTotalContrato']) : '',
    'retirodesde' => isset($_GET['RetiroDesde']) ? trim($_GET['RetiroDesde']) : '',
    'retirohasta' => isset($_GET['RetiroHasta']) ? trim($_GET['RetiroHasta']) : '',
    'devoluciondesde' => isset($_GET['DevolucionDesde']) ? trim($_GET['DevolucionDesde']) : '',
    'devolucionhasta' => isset($_GET['DevolucionHasta']) ? trim($_GET['DevolucionHasta']) : '',
];


// Generación del listado de contratos
require_once 'funciones/CRUD-Contratos.php';
$ListadoContratos = Listar_Contratos($conexion);
$CantidadContratos = count($ListadoContratos);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_ConsultaContratos();

    $ListadoContratos = array();
    $CantidadContratos = '';
    $ListadoContratos = Consulta_Contratos($_GET['NumeroContrato'], $_GET['MatriculaContrato'], $_GET['ApellidoContrato'], $_GET['NombreContrato'], $_GET['DocContrato'], $_GET['EstadoContrato'], $_GET['PrecioDiaContrato'], $_GET['CantidadDiasContrato'], $_GET['MontoTotalContrato'], $_GET['RetiroDesde'], $_GET['RetiroHasta'], $_GET['DevolucionDesde'], $_GET['DevolucionHasta'], $conexion);
    $CantidadContratos = count($ListadoContratos);
}
else {

    // Listo la totalidad de los registros en la tabla "contratos". 
    $ListadoContratos = Listar_Contratos($conexion);
    $CantidadContratos = count($ListadoContratos);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: contratosAlquiler.php');
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

<body style="margin: 0 auto;">

<style>

.form-control:focus {
    border-color: #c7240e;
}

</style>

    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php 
        include('sidebarGOp.php');
        include('topNavBar.php');    

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <div style="margin-bottom: 110px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #c7240e; border-radius: 14px;">
                <div style='color: #c7240e; margin-bottom: 30px;'> 
                    <h3 class="fw-bold"> Contratos </h3> 
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="contratosAlquiler.php" method="get">

                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="NumeroContrato" 
                               value="<?= htmlspecialchars($filtros['numero']) ?>" >
                    </div>

                    <div class="col-md-2">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" id="matricula" name="MatriculaContrato" 
                               value="<?= htmlspecialchars($filtros['matricula']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="ApellidoContrato" 
                               value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="NombreContrato" 
                               value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="DocContrato" 
                               value="<?= htmlspecialchars($filtros['documento']) ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="estado" class="form-label">Estado del Contrato</label>
                        <input type="text" class="form-control" id="estado" name="EstadoContrato" 
                               value="<?= htmlspecialchars($filtros['estado']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="preciodia" class="form-label">Precio por día</label>
                        <input type="number" min="20" max="999999999" step="0.01" class="form-control" id="preciodia" name="PrecioDiaContrato" 
                               value="<?= htmlspecialchars($filtros['preciodia']) ?>" title="Filtrar por precio hasta los..." >
                    </div>

                    <?php 
                    $minCantDias = 1;
                    $maxCantDias = 45;
                    ?>
                    <div class="col-md-2">
                        <label for="cantidaddias" class="form-label">Cantidad de días</label>
                        <input type="number" min="<? echo $minCantDias; ?>" max="<?php echo $maxCantDias; ?>" class="form-control" id="cantidaddias" name="CantidadDiasContrato" 
                               value="<?= htmlspecialchars($filtros['cantidaddias']) ?>" title="Cantidad exacta de días entre 1 y 45">
                    </div>

                    <div class="col-md-2">
                        <label for="montototal" class="form-label">Monto total</label>
                        <input type="number" min="20" max="999999999" step="0.01" class="form-control" id="montototal" name="MontoTotalContrato" 
                               value="<?= htmlspecialchars($filtros['montototal']) ?>" title="Filtrar por monto total hasta los...">
                    </div>

                    <div class="col-md-2" style="margin-bottom: 100px;">
                    </div>

                    <div class="col-md-3">
                        <label for="retiro" class="form-label">Retiro entre</label>
                        <div class="d-flex">
                            <input type="date" id="retirodesde" class="form-control me-2" name="RetiroDesde" 
                                   value="<?= htmlspecialchars($filtros['retirodesde']) ?>">

                            <input type="date" id="retirohasta" class="form-control" name="RetiroHasta" 
                                   value="<?= htmlspecialchars($filtros['retirohasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="devolucion" class="form-label">Devolución entre</label>
                        <div class="d-flex">
                            <input type="date" id="devoluciondesde" class="form-control me-2" name="DevolucionDesde" 
                                   value="<?= htmlspecialchars($filtros['devoluciondesde']) ?>">

                            <input type="date" id="devolucionhasta" class="form-control" name="DevolucionHasta" 
                                   value="<?= htmlspecialchars($filtros['devolucionhasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" style="background-color: #c7240e; color: white;" class="btn w-100" name="BotonFiltrar" value="FiltrandoContratos">
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

            <!-- Tabla de contratos -->
            <div style="margin-top: 5%; padding-bottom: 100px;">
                <div class="table-responsive mt-4" style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
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
                                <th>Vehiculo</th>
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
            

                <!-- Botones de acción -->
                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nuevo
                        </button>

                        <button class="btn btn-danger me-2" id="btnModificar" onclick="modificarContrato()" disabled>
                            Modificar
                        </button>

                        <button class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarContrato()" disabled>
                            Eliminar
                        </button>

                        <a href="ReporteContratos.php"> <button class="btn btn-info">
                            Imprimir
                        </button></a>
                    </div>

                </div>

                <!-- Reportes estadísticos -->
                <div style="margin: auto; max-width: 95%; padding: 150px 0 5px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h2 class="mb-1 " style="padding: 0; margin: 10px 0 0 0;" >
                            <strong style="color: #a80a0a;">Reportes Estadísticos</strong> 
                        </h2>
                    </div>
                </div>

                <div style="margin: auto; max-width: 95%; padding: 10px 0 40px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h4 class="mb-1 " style="padding: 0; margin: 30px 0 0 0;" >
                            <strong style="color: #a80a0a;">Reporte:</strong> <a href="ReporteContratos_FrecMensuales.php" style="color: black;">Contratos por mes segmentados por estado </a>
                        </h4>
                        <a href="ReporteContratos_FrecMensuales.php" style="color: black;"> 
                            <div class="mb-1 " style="padding: 0; margin: 50px 0 0 0;">
                                <img src="assets/img/reports/reporte-contratosmensualesestados.png" alt="Contratos por mes segmentados por estado" 
                                    style="max-width: 99%; border-radius: 25px;">
                            </div>
                        </a>

                        <style>
                            .btn-inversion {
                                padding-left: 30px; 
                                padding-right: 30px; 
                                background-color: #122010; 
                                color: red; 
                                border: 1px solid red; 
                                border-radius: 14px;

                                transition: all 0.5s ease-in-out;
                                -webkit-transition: all 0.5s ease-in-out;
                                -moz-transition: all 0.5s ease-in-out;
                                -o-transition: all 0.5s ease-in-out;
                            }
                            .btn-inversion:hover {
                                background-color: #a80a0a;
                                color: white;
                                border: 1px solid #a80a0a;
                            }
                        </style>
                        
                        <div class="container d-flex justify-content-center" style="margin: 70px 0 50px 0;">
                            <a href="ReporteContratos_FrecMensuales.php"> 
                                <button class="btn btn-inversion">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16"> <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/> </svg> 
                                Reporte
                                </button>
                            </a>
                        </div>

                    </div>
                </div>


                <!-- Modal para Nuevo Contrato -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nuevo Contrato</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="Nuevo_Contrato.php" method="post">
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
                                        <!-- 
                                    <div class="mb-3">
                                        <label for="numreserva" class="form-label">Número de reserva</label>
                                        <input type="text" class="form-control" id="numreserva" name="numreserva" required>
                                    </div>
                                    -->

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

                                    <div class="mb-3">
                                        <label for="preciopordia" class="form-label">Precio por día</label>
                                        <input type="number" min="20" max="999999999" step="0.01" title="Superior a 20 USD obligatoriamente."
                                               class="form-control" id="preciopordia" name="precioporDia" required>
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


    <script>
        let reservaSeleccionada = null;

        // Selección de fila en la Tabla de Contratos al hacer clic en la misma
        document.querySelectorAll('#tablaContratos .contrato').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.contrato').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                reservaSeleccionada = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a ModificarCliente.php con el ID del cliente seleccionado
        function modificarContrato() {
            if (reservaSeleccionada) {
                window.location.href = 'ModificarContrato.php?id=' + reservaSeleccionada;
            }
        }

        // Función para redirigir a EliminarCliente.php con el ID del cliente seleccionado
        function eliminarContrato() {
            if (reservaSeleccionada) {
                if (confirm('¿Estás seguro de que quieres eliminar este contrato?')) {
                    window.location.href = 'EliminarContrato.php?id=' + reservaSeleccionada;
                }
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    
</body>

</html>