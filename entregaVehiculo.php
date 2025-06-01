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
    'estadocontrato' => isset($_GET['EstadoContrato']) ? trim($_GET['EstadoContrato']) : '',
    'entregadesde' => isset($_GET['EntregaDesde']) ? trim($_GET['EntregaDesde']) : '',
    'entregahasta' => isset($_GET['EntregaHasta']) ? trim($_GET['EntregaHasta']) : '',
];


// Generación del listado de entregas
require_once 'funciones/CRUD-Entregas.php';
$ListadoEntregas = Listar_Entregas($conexion);
$CantidadEntregas = count($ListadoEntregas);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_ConsultaEntregas();

    $ListadoEntregas = array();
    $CantidadEntregas = '';
    $ListadoEntregas = Consulta_Entregas($_GET['NumeroContrato'], $_GET['MatriculaContrato'], $_GET['ApellidoContrato'], $_GET['NombreContrato'], $_GET['DocContrato'], $_GET['EstadoContrato'], $_GET['EntregaDesde'], $_GET['EntregaHasta'], $conexion);
    $CantidadEntregas = count($ListadoEntregas);
} else {

    // Listo la totalidad de los registros en la tabla "entregas". 
    $ListadoEntregas = Listar_Entregas($conexion);
    $CantidadEntregas = count($ListadoEntregas);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: entregaVehiculo.php');
    die();
}


// SELECCIONES para combo boxes del modal para registrar "Nueva entrega"
require_once 'funciones/Select_Tablas.php';

$ListadoContratos = Listar_Contratos_Firmados($conexion);
$CantidadContratos = count($ListadoContratos);

// SELECCIONES para combo boxes del modal para generar reporte "Entregas de vehículos según cliente"
require_once 'funciones/Select_Tablas.php';

$ListadoClientes = Listar_Clientes_AtoZ($conexion);
$CantidadClientes = count($ListadoClientes);


include('head.php');

?>

<body style="margin: 0 auto;">

    <style>
        .form-control:focus {
            border-color: rgb(223, 115, 14);
        }
    </style>

    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php
        include('sidebarGOp.php');
        $tituloPagina = "ENTREGAS DE VEHÍCULOS";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <div
                style="margin-bottom: 110px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid rgb(223, 115, 14); border-radius: 14px;">
                <div style='color:rgb(223, 115, 14); margin-bottom: 30px;'>
                    <h3 class="fw-bold"> Entregas de vehículos </h3>
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="entregaVehiculo.php" method="get">

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
                    <div class="col-md-2">
                        <label for="estadocontrato" class="form-label">Estado del Contrato</label>
                        <input type="text" class="form-control" id="estadocontrato" name="EstadoContrato"
                            value="<?= htmlspecialchars($filtros['estadocontrato']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="retiro" class="form-label">Entrega entre</label>
                        <div class="d-flex">
                            <input type="date" id="entregadesde" class="form-control me-2" name="EntregaDesde"
                                value="<?= htmlspecialchars($filtros['entregadesde']) ?>">

                            <input type="date" id="entregahasta" class="form-control" name="EntregaHasta"
                                value="<?= htmlspecialchars($filtros['entregahasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="d-flex flex-wrap justify-content-between align-items-end mt-3">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" style="background-color: rgb(223, 115, 14); color: white;" class="btn" name="BotonFiltrar" value="FiltrandoEntregas">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button type="submit" class="btn btn-warning" name="BotonLimpiarFiltros" value="LimpiandoFiltros">
                                <i class="fas fa-ban"></i> Limpiar Filtros
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Tabla de entregas -->
            <div style="margin-top: 5%; padding-bottom: 100px;">
                <div class="table-responsive mt-4"
                    style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaEntregas">
                        <thead>
                            <tr>
                                <th style='color:rgb(223, 115, 14);'>
                                    <h3>#</h3>
                                </th>
                                <th>Contrato</th>
                                <th>Estado Contrato</th>
                                <th title="Fecha de inicio del contrato. No corresponde necesariamente con la fecha de entrega del vehículo.">
                                    Inicio Contrato
                                </th>
                                <th title="Fecha efectiva de entrega del vehículo al cliente">
                                    Fecha de Entrega
                                </th>
                                <th>Hora de Entrega</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Oficina Ret.</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1;

                            for ($i = 0; $i < $CantidadEntregas; $i++) { ?>

                                <tr class='entrega' data-id='<?php echo $ListadoEntregas[$i]['IdEntrega']; ?>'
                                    onclick="selectRow(this, '<?= $ListadoEntregas[$i]['IdEntrega'] ?>')">

                                    <td><span style='color:rgb(223, 115, 14);'>
                                            <h4> <?php echo $contador; ?> </h4>
                                        </span></td>
                                    <td> <?php echo $ListadoEntregas[$i]['IdContrato']; ?> </td>

                                    <td><?php
                                        $estado = strtolower($ListadoEntregas[$i]['EstadoContrato']);
                                        $clase = '';

                                        switch ($estado) {
                                            case 'firmado':
                                                $clase = 'primary'; // azul
                                                break;
                                            case 'activo':
                                                $clase = 'success'; // verde
                                                break;
                                            case 'cancelado':
                                                $clase = 'danger'; // rojo
                                                break;
                                            case 'finalizado':
                                                $clase = 'warning'; // naranja
                                                break;
                                            case 'renovado':
                                                $clase = 'secondary'; // púrpura
                                                break;
                                            default:
                                                $clase = 'info'; // celeste
                                                break;
                                        }
                                        echo "<span class='badge badge-$clase'>" . $ListadoEntregas[$i]['EstadoContrato'] . "</span>"; ?>
                                    </td>

                                    <td title="Fecha de inicio del contrato. No corresponde necesariamente con la fecha de entrega del vehículo.">
                                        <?php echo $ListadoEntregas[$i]['FechaInicioContrato']; ?>
                                    </td>
                                    <td title="Fecha efectiva de entrega del vehículo al cliente">
                                        <?php echo $ListadoEntregas[$i]['FechaEntrega']; ?>
                                    </td>
                                    <td> <?php echo $ListadoEntregas[$i]['HoraEntrega']; ?> </td>
                                    <td> <?php echo "{$ListadoEntregas[$i]['apellidoCliente']}, {$ListadoEntregas[$i]['nombreCliente']} </br> DNI: {$ListadoEntregas[$i]['dniCliente']}"; ?>
                                    </td>
                                    <td> <?php echo "Patente {$ListadoEntregas[$i]['vehiculoMatricula']} </br> {$ListadoEntregas[$i]['vehiculoModelo']}, {$ListadoEntregas[$i]['vehiculoGrupo']}"; ?>
                                    </td>
                                    <td> <?php echo "{$ListadoEntregas[$i]['CiudadSucursal']}, {$ListadoEntregas[$i]['DireccionSucursal']}"; ?>
                                    </td>
                                </tr>
                                <?php $contador++; ?>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <br><br>
                <!-- Recuadro con cantidad total de registros encontrados -->
                <style>
                    .no-btn-effect {
                        pointer-events: none; /* Evita que se comporte como un botón */
                        box-shadow: none !important; 
                        cursor: default !important; /* Hace que el cursor no cambie */
                        border: none; 
                    }
                </style>
                <p class="btn no-btn-effect" style="background-color: rgb(153, 6, 6); color: #ffffff; margin-left: 25px;">
                    Total de registros encontrados: <?php echo $CantidadEntregas; ?>
                </p>

                <!-- Botones de acción -->
                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nueva entrega
                        </button>

                        <button class="btn btn-danger me-2" id="btnModificar" onclick="modificarEntrega()" disabled>
                            Modificar
                        </button>

                        <a href="ReporteEntregas.php">
                            <button class="btn btn-info">
                                Imprimir listado
                            </button>
                        </a>
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
                                data-bs-target="#reporteEntregasPorClienteModal">
                                Reporte:
                            </strong>
                            <a href="#" style="color: black;" data-bs-toggle="modal"
                                data-bs-target="#reporteEntregasPorClienteModal">
                                Entregas de vehículos por cliente
                            </a>
                        </h4>

                        <a href="#" style="color: black;" data-bs-toggle="modal"
                            data-bs-target="#reporteEntregasPorClienteModal">
                            <div class="mb-1 hoverImageWrapper centrar" style="padding: 0; margin: 50px 0 0 0;">
                                <img class="hoverImage" src="assets/img/reports/reporte-entregasporcliente.png"
                                    alt="Entregas de vehículos a cliente seleccionado"
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#reporteEntregasPorClienteModal">
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


                <!-- Modal para Nueva entrega -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nueva Entrega</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="Nueva_Entrega.php" method="post">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="idContrato" class="form-label" title="<?php echo $CantidadContratos ?> contratos firmados encontrados">
                                            Contrato
                                        </label>
                                        <select class="form-select" aria-label="Selector" id="selectorEntrega"
                                            name="idContrato"
                                            title="<?php echo $CantidadContratos ?> contratos firmados encontrados"
                                            required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php
                                            // Asegurate de que $ListadoContratos contiene datos antes de procesarlo
                                            if (!empty($ListadoContratos)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadContratos; $i++) {
                                                    // Lógica para verificar si el grupo debe estar seleccionado
                                                    $selected = (!empty($_POST['idContrato']) && $_POST['idContrato'] == $ListadoContratos[$i]['IdContrato']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoContratos[$i]['IdContrato']}' $selected> 
                                                        NºContrato: {$ListadoContratos[$i]['IdContrato']}. 
                                                        Cliente: {$ListadoContratos[$i]['ApellidoCliente']} {$ListadoContratos[$i]['NombreCliente']} - DNI: {$ListadoContratos[$i]['DniCliente']}. 
                                                        Vehículo: {$ListadoContratos[$i]['matricula']} - {$ListadoContratos[$i]['modelo']} {$ListadoContratos[$i]['grupo']}
                                                    </option>";
                                                }
                                            } else {
                                                echo "<option value=''>No se encontraron contratos con estado Firmado.</option>";
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
                                        <label for="fechainiciocontrato" class="form-label">Fecha de Inicio del contrato</label>
                                        <input type="text" class="form-control" id="fechainiciocontrato"
                                            name="fechaInicioContrato" value="La fecha registrada en el contrato aparecerá aquí"
                                            title="La fecha registrada en el contrato no tiene por qué coincidir con fecha real de entrega" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaentrega" class="form-label">Fecha de Entrega efectiva</label>
                                        <input type="date" class="form-control" id="fechaentrega" name="fechaentrega"
                                            value="" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="horaentrega" class="form-label">Hora de Entrega</label>
                                        <input type="time" class="form-control" id="horaentrega" name="horaentrega"
                                            value="" required>
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


                <!-- Modal para Generar reporte de Entregas de vehículos por Cliente -->
                <div class="modal fade" id="reporteEntregasPorClienteModal" tabindex="-1"
                    aria-labelledby="reporteEntregasPorClienteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reporteEntregasPorClienteModalLabel">Generar reporte:
                                    Entregas por cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="ReporteEntregasPorCliente.php" method="post">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="idCliente" class="form-label">Seleccionar cliente</label>
                                        <select class="form-select" aria-label="Selector" id="selectorCliente" name="idCliente"
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
                                            } else {
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

        <div>
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
        let entregaSeleccionada = null;

        // Selección de fila en la Tabla de Entregas al hacer clic en la misma
        document.querySelectorAll('#tablaEntregas .entrega').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.entrega').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                entregaSeleccionada = row.dataset.id;

                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                //                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a modificarEntrega.php con el ID de la entrega seleccionado
        function modificarEntrega() {
            if (entregaSeleccionada) {
                window.location.href = 'modificarEntrega.php?id=' + entregaSeleccionada;
            }
        }
    </script>

    <!-- Funcion para buscador en dropdown -->
    <script>
        $(document).ready(function() {
            // Inicializar Select2 en el select del modal de entrega
            $('#selectorEntrega').select2({
                dropdownParent: $('#nuevoRegistroModal'),
                width: '100%',
                minimumResultsForSearch: 0 // Forzar que siempre aparezca el buscador
            });
        });
    </script>

    <!-- Capturar fecha de inicio del contrato para el modal de registro de una nueva entrega (con AJAX) -->
    <script>
        $(document).ready(function() {
            $('#selectorEntrega').on('change', function() {
                var idContrato = $(this).val();
                if (idContrato) {
                    $.ajax({
                        type: 'POST',
                        url: 'obtenerFechaInicioContrato.php',
                        data: {
                            idContrato: idContrato
                        },
                        success: function(response) {
                            if (response) {
                                $('#fechainiciocontrato').val(response);
                            } else {
                                $('#fechainiciocontrato').val('');
                            }
                        }
                    });
                } else {
                    $('#fechainiciocontrato').val('');
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Librería y estilo para agregar buscador al dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Requerido por Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>