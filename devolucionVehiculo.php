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
    'devoluciondesde' => isset($_GET['DevolucionDesde']) ? trim($_GET['DevolucionDesde']) : '',
    'devolucionhasta' => isset($_GET['DevolucionHasta']) ? trim($_GET['DevolucionHasta']) : '',
];


// Generación del listado de Devolucion
require_once 'funciones/CRUD-Devolucion.php';
$ListadoDevolucion = Listar_Devolucion($conexion);
$CantidadDevolucion = count($ListadoDevolucion);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_ConsultaDevolucion();

    $ListadoDevolucion = array();
    $CantidadDevolucion = '';
    $ListadoDevolucion = Consulta_Devolucion($_GET['NumeroContrato'], $_GET['MatriculaContrato'], $_GET['ApellidoContrato'], $_GET['NombreContrato'], $_GET['DocContrato'], $_GET['DevolucionDesde'], $_GET['DevolucionHasta'], $conexion);
    $CantidadDevolucion = count($ListadoDevolucion);
}
else {

    // Listo la totalidad de los registros en la tabla "Devolucion". 
    $ListadoDevolucion = Listar_Devolucion($conexion);
    $CantidadDevolucion = count($ListadoDevolucion);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: devolucionVehiculo.php');
    die();
}


// SELECCIONES para combo boxes del modal para registrar "Nueva Devolucion"
require_once 'funciones/Select_Tablas.php';

$ListadoContratos = ListarContratos_ActivosRenovados($conexion);
$CantidadContratos = count($ListadoContratos);

// SELECCIONES para combo boxes del modal para generar reporte "Devolucion de vehículos según cliente"
require_once 'funciones/Select_Tablas.php';

$ListadoClientes = Listar_Clientes_AtoZ($conexion);
$CantidadClientes = count($ListadoClientes);


include('head.php');
?>



<body style="margin: 0 auto;">

    <style>
    .form-control:focus {
        border-color: rgb(14, 94, 199);
    }
    </style>

    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php 
        include('sidebarGOp.php');
         $tituloPagina = "<b> Devoluciones de Vehiculos </b>";
        include('topNavBar.php');    

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <div
                style="margin-bottom: 110px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid rgb(14, 94, 199); border-radius: 14px;">
                <div style='color:rgb(14, 94, 199); margin-bottom: 30px;'>
                    <h3 class="fw-bold"> Devolucion de vehículos </h3>
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="devolucionVehiculo.php" method="get">

                    <div class="col-md-2">
                        <label for="numero" class="form-label">Nº contrato</label>
                        <input type="text" class="form-control" id="numero" name="NumeroContrato"
                            value="<?= htmlspecialchars($filtros['numero']) ?>">
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

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-4">
                        <label for="retiro" class="form-label">Devolucion entre</label>
                        <div class="d-flex">
                            <input type="date" id="devoluciondesde" class="form-control me-2" name="DevolucionDesde"
                                value="<?= htmlspecialchars($filtros['devoluciondesde']) ?>">

                            <input type="date" id="devolucionhasta" class="form-control" name="DevolucionHasta"
                                value="<?= htmlspecialchars($filtros['devolucionhasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" style="background-color:rgb(14, 94, 199); color: white;" class="btn w-100"
                            name="BotonFiltrar" value="FiltrandoDevolucion">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100" name="BotonLimpiarFiltros"
                            value="LimpiandoFiltros">
                            <i class="fas fa-ban"></i> Limpiar Filtros
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Devolucion -->
            <div style="margin-top: 5%; padding-bottom: 100px;">
                <div class="table-responsive mt-4"
                    style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaDevolucion">
                        <thead>
                            <tr>
                                <th style='color:rgb(14, 94, 199);'>
                                    <h3>#</h3>
                                </th>
                                <th>Contrato</th>
                                <th>Fecha Dev.</th>
                                <th>Hora Dev.</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Oficina Dev.</th>
                                <th>Estado del vehículo</th>
                                <th>Aclaraciones</th>
                                <th>Infracciones</th>
                                <th>Monto extra</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1; 

                            for ($i=0; $i < $CantidadDevolucion; $i++) { ?>

                            <tr class='Devolucion' data-id='<?php echo $ListadoDevolucion[$i]['IdDevolucion']; ?>'
                                onclick="selectRow(this, '<?= $ListadoDevolucion[$i]['IdDevolucion'] ?>')">

                                <td><span style='color: rgb(14, 94, 199);'>
                                        <h4> <?php echo $contador; ?> </h4>
                                    </span></td>
                                <td> <?php echo $ListadoDevolucion[$i]['IdContrato']; ?> </td>
                                <td> <?php echo $ListadoDevolucion[$i]['FechaDevolucion']; ?> </td>
                                <td> <?php echo $ListadoDevolucion[$i]['HoraDevolucion']; ?> </td>
                                <td> <?php echo "{$ListadoDevolucion[$i]['apellidoCliente']}, {$ListadoDevolucion[$i]['nombreCliente']} </br> DNI: {$ListadoDevolucion[$i]['dniCliente']}"; ?>
                                </td>
                                <td> <?php echo "Patente {$ListadoDevolucion[$i]['vehiculoMatricula']} </br> {$ListadoDevolucion[$i]['vehiculoModelo']}, {$ListadoDevolucion[$i]['vehiculoGrupo']}"; ?>
                                </td>
                                <td> <?php echo "{$ListadoDevolucion[$i]['CiudadSucursal']}, {$ListadoDevolucion[$i]['DireccionSucursal']}"; ?>
                                </td>
                                <td title="Estado del vehículo al momento de la devolución">
                                    <?php echo $ListadoDevolucion[$i]['EstadoDevolucion']; ?> </td>
                                <td title="Aclaraciones sobre el estado del vehículo al momento de la devolución">
                                    <?php echo $ListadoDevolucion[$i]['AclaracionesDevolucion']; ?> </td>

                                <td title="Infracciones cometidas por el cliente">
                                    <?php echo $ListadoDevolucion[$i]['InfraccionesDevolucion']; ?> <br><br>
                                    <b>Costos asociados:</b> <br>
                                    <?php 
                                        if (is_null($ListadoDevolucion[$i]['CostosInfracciones']) || $ListadoDevolucion[$i]['CostosInfracciones'] == 0) {
                                            echo "Sin costos";
                                        }
                                        else {
                                            echo "$ ";
                                            echo $ListadoDevolucion[$i]['CostosInfracciones']; 
                                            echo " USD";
                                        }
                                        ?>
                                </td>

                                <td title="Monto extra a cobrar por infracciones">
                                    <?php 
                                        if (is_null($ListadoDevolucion[$i]['MontoExtra']) || $ListadoDevolucion[$i]['MontoExtra'] == 0) {
                                            echo "Sin costos";
                                        }
                                        else {
                                            echo "$ ";
                                            echo $ListadoDevolucion[$i]['MontoExtra']; 
                                            echo " USD";
                                        }
                                        ?>
                                </td>
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

                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nueva Devolucion
                        </button>

                        <button class="btn btn-danger me-2" id="btnModificar" onclick="modificarDevolucion()" disabled>
                            Modificar datos de Devolucion
                        </button>

                        <a href="ReporteDevoluciones.php"> <button class="btn btn-info">
                                Imprimir listado
                            </button></a>
                    </div>

                </div>

                <!-- Reportes  -->
                <div style="margin: auto; max-width: 95%; padding: 150px 0 5px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h2 class="mb-1 " style="padding: 0; margin: 10px 0 0 0;">
                            <strong style="color: #a80a0a;">Reportes </strong>
                        </h2>
                    </div>
                </div>

                <style>
                .hoverImage {
                    position: relative;
                    align-self: stretch;
                    height: 650px;
                    flex-shrink: 0;
                    object-fit: cover;
                    border-radius: 10px;
                    max-width: 100%;
                }

                .centrar {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                </style>

                <div style="margin: auto; max-width: 95%; padding: 10px 0 40px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h4 class="mb-1 " style="padding: 0; margin: 30px 0 0 0;">
                            <strong style="color: #a80a0a;" data-bs-toggle="modal"
                                data-bs-target="#reporteDevolucionPorClienteModal">
                                Reporte:
                            </strong>
                            <a href="#" style="color: black;" data-bs-toggle="modal"
                                data-bs-target="#reporteDevolucionPorClienteModal">
                                Devolucion de vehículos por cliente
                            </a>
                        </h4>

                        <a href="#" style="color: black;" data-bs-toggle="modal"
                            data-bs-target="#reporteDevolucionPorClienteModal">
                            <div class="mb-1 hoverImageWrapper centrar" style="padding: 0; margin: 50px 0 0 0;">
                                <img class="hoverImage" src="assets/img/reports/reporte-devolucionesporcliente.png"
                                    alt="Devolucion de vehículos a cliente seleccionado"
                                    style="max-width: 99%; border-radius: 25px;">
                            </div>
                        </a>

                        <style>
                        .btn-inversion {
                            padding-left: 30px;
                            padding-right: 30px;
                            background-color: #262626;
                            color: #e04709;
                            font-weight: 500;
                            border: 1px solid #d64004;
                            border-radius: 20px;

                            transition: all 0.5s ease-in-out;
                            -webkit-transition: all 0.5s ease-in-out;
                            -moz-transition: all 0.5s ease-in-out;
                            -o-transition: all 0.5s ease-in-out;
                        }

                        .btn-inversion:hover {
                            background-color: #a80a0a;
                            color: white;
                            font-weight: 100;
                            border: 1px solid #a80a0a;
                        }
                        </style>

                        <div class="container d-flex justify-content-center" style="margin: 70px 0 50px 0;">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#reporteDevolucionPorClienteModal">
                                <button class="btn btn-inversion">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bar-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
                                    </svg>
                                    Reporte
                                </button>
                            </a>
                        </div>

                    </div>
                </div>


                <!-- Modal para Nueva Devolucion -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nueva Devolución</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="Nueva_Devolucion.php" method="post">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="selector" class="form-label" title="<?php echo $CantidadContratos ?> contratos activos encontrados">
                                            Contrato
                                        </label>
                                        <select class="form-select" id="selector" name="idContrato" required>
                                            <option value="" selected>Selecciona una opción</option>
                                            
                                            <?php
                                                if (!empty($ListadoContratos)) {
                                                   for ($i = 0; $i < $CantidadContratos; $i++) {
                                                            $selected = (!empty($_POST['idContrato']) && $_POST['idContrato'] == $ListadoContratos[$i]['IdContrato']) ? 'selected' : '';
                                                             echo "<option value='{$ListadoContratos[$i]['IdContrato']}' $selected>
                                                             NºContrato: {$ListadoContratos[$i]['IdContrato']} - 
                                                            {$ListadoContratos[$i]['ApellidoCliente']} {$ListadoContratos[$i]['NombreCliente']} - 
                                                            DNI: {$ListadoContratos[$i]['DniCliente']} - 
                                                            Vehículo: {$ListadoContratos[$i]['matricula']} {$ListadoContratos[$i]['modelo']} {$ListadoContratos[$i]['grupo']}
                                                            </option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No se encontraron contratos</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                                        <input type="date" class="form-control" id="fechadevolucion"
                                            name="fechadevolucion" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="horadevolucion" class="form-label">Hora de Devolución</label>
                                        <input type="time" class="form-control" id="horadevolucion"
                                            name="horadevolucion" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Inicialización de Select2 -->
                <script>
                $(document).ready(function() {
                    $('#selector').select2({
                        dropdownParent: $('#nuevoRegistroModal'),
                        width: '100%',
                        minimumResultsForSearch: 0 // ⚠️ Forzar siempre el buscador aunque haya pocos elementos
                    });
                });
                </script>


                <!-- Modal para Generar reporte de Devolucion de vehículos por Cliente -->
                <div class="modal fade" id="reporteDevolucionPorClienteModal" tabindex="-1"
                    aria-labelledby="reporteDevolucionPorClienteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reporteDevolucionPorClienteModalLabel">Generar reporte:
                                    Devolucion por cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="ReporteDevolucionPorCliente.php" method="post">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="idCliente" class="form-label">Seleccionar cliente</label>
                                        <select class="form-select" aria-label="Selector" id="selector" name="idCliente"
                                            title="<?php echo $CantidadClientes ?> clientes encontrados" required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php 
                                            // Asegurate de que $ListadoClientes contiene datos antes de procesarlo
                                            if (!empty($ListadoClientes)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadClientes; $i++) {
                                                    // Lógica para verificar si el grupo debe estar seleccionado
                                                    $selected = (!empty($_POST['idCliente']) && $_POST['idCliente'] == $ListadoClientes[$i]['idCliente']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoClientes[$i]['idCliente']}' $selected>  
                                                        {$ListadoClientes[$i]['apellidoCliente']} {$ListadoClientes[$i]['nombreCliente']} (DNI: {$ListadoClientes[$i]['dniCliente']}) 
                                                    </option>";
                                                }
                                            } 
                                            else {
                                                echo "<option value=''>No se encontraron clientes.</option>";
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

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-dark">Generar</button>
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
    // Efecto sobre la imagen del reporte
    window.onload = function() {

        const imageElement = document.querySelector('.hoverImage');

        if (imageElement) {
            const handleMouseMove = (e) => {
                let rect = imageElement.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;

                let dx = (x - rect.width / 2) / (rect.width / 2);
                let dy = (y - rect.height / 2) / (rect.height / 2);

                imageElement.style.transform =
                    `perspective(500px) rotateY(${dx * 5}deg) rotateX(${-dy * 5}deg)`;
            };

            const handleMouseLeave = () => {
                imageElement.style.transform = "";
            };

            imageElement.addEventListener('mousemove', handleMouseMove);
            imageElement.addEventListener('mouseleave', handleMouseLeave);
        }
    }
    </script>

    <script>
    let DevolucionSeleccionada = null;

    // Selección de fila en la Tabla de Devolucion al hacer clic en la misma
    document.querySelectorAll('#tablaDevolucion .Devolucion').forEach(row => {
        row.addEventListener('click', () => {
            // Desmarcar cualquier fila previamente seleccionada
            document.querySelectorAll('.Devolucion').forEach(row => row.classList.remove(
                'table-active'));
            // Marcar la fila seleccionada
            row.classList.add('table-active');
            DevolucionSeleccionada = row.dataset.id;

            // Habilitar los botones
            document.getElementById('btnModificar').disabled = false;
            //                document.getElementById('btnEliminar').disabled = false;
        });
    });

    // Función para redirigir a modificarDevolucion.php con el ID de la Devolucion seleccionado
    function modificarDevolucion() {
        if (DevolucionSeleccionada) {
            window.location.href = 'modificarDevolucion.php?id=' + DevolucionSeleccionada;
        }
    }
    </script>

    <!-- Funcion para buscador en dropdown -->
    <script>
    $(document).ready(function() {
        // Inicializar Select2 dentro del modal
        $('#selector').select2({
            dropdownParent: $('#nuevoRegistroModal'),
            width: '100%',
            minimumResultsForSearch: 0 // Forzar que siempre aparezca el buscador
        });
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Librería y estilo para agregar buscador al dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>