<?php

session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'numero' => isset($_GET['NumeroReserva']) ? trim($_GET['NumeroReserva']) : '',
    'matricula' => isset($_GET['MatriculaReserva']) ? trim($_GET['MatriculaReserva']) : '',
    'apellido' => isset($_GET['ApellidoReserva']) ? trim($_GET['ApellidoReserva']) : '',
    'nombre' => isset($_GET['NombreReserva']) ? trim($_GET['NombreReserva']) : '',
    'documento' => isset($_GET['DocReserva']) ? trim($_GET['DocReserva']) : '',
    'retirodesde' => isset($_GET['RetiroDesde']) ? trim($_GET['RetiroDesde']) : '',
    'retirohasta' => isset($_GET['RetiroHasta']) ? trim($_GET['RetiroHasta']) : '',
];


// Generación del listado de reservas
require_once 'funciones/CRUD-Reservas.php';
$ListadoReservas = Listar_Reservas($conexion);
$CantidadReservas = count($ListadoReservas);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_ConsultaReservas();

    $ListadoReservas = array();
    $CantidadReservas = '';
    $ListadoReservas = Consulta_Reservas($_GET['NumeroReserva'], $_GET['MatriculaReserva'], $_GET['ApellidoReserva'], $_GET['NombreReserva'], $_GET['DocReserva'], $_GET['RetiroDesde'], $_GET['RetiroHasta'], $conexion);
    $CantidadReservas = count($ListadoReservas);
} else {

    // Listo la totalidad de los registros en la tabla "vehiculos". 
    $ListadoReservas = Listar_Reservas($conexion);
    $CantidadReservas = count($ListadoReservas);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

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

<body>
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php
        include('sidebarGOp.php');
        $tituloPagina = "RESERVAS";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <!-- Algunos efectos moderno para el form de consultas ;) -->
            <style>

                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .filtro-consultas {
                    transition: all 0.4s ease-in-out; 
                    border-radius: 15px; 
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); 
                    animation: fadeInUp 0.8s ease-in-out; /* Hace que el cuadro "aparezca suavemente" */
                }

                .filtro-consultas:hover {
                    transform: translateY(-5px); 
                    box-shadow: 0px 10px 20px rgba(198, 167, 31, 0.5);
                }

                .form-control {
                    transition: all 0.3s ease-in-out;
                    border: 1px solid;
                }

                .form-control:focus {
                    border: 2px solid rgb(160, 4, 4); /* Resalta con dorado */
                    box-shadow: rgba(152, 10, 10, 0.81);
                }

                .btn-filtrar {
                    transition: transform 0.3s ease-in-out;
                }

                .btn-filtrar:hover {
                    transform: scale(1.1); /* Botón se agranda ligeramente */
                }
            </style>

            <div class="filtro-consultas" style="margin-top: 20px;margin-bottom: 80px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #16719e; border-radius: 14px;">
                <div style='color: #0a8acf; margin-bottom: 30px;'>
                    <h3 class="fw-bold"> Reservas </h3>
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="reservas.php" method="get" onsubmit="scrollToTable()">

                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número de Reserva</label>
                        <input type="text" class="form-control" id="numero" name="NumeroReserva"
                            value="<?= htmlspecialchars($filtros['numero']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" id="matricula" name="MatriculaReserva"
                            value="<?= htmlspecialchars($filtros['matricula']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="ApellidoReserva"
                            value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="NombreReserva"
                            value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="DocReserva"
                            value="<?= htmlspecialchars($filtros['documento']) ?>">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-4">
                        <label for="retiro" class="form-label">Retiro entre</label>
                        <div class="d-flex">
                            <input type="date" id="retirodesde" class="form-control me-2" name="RetiroDesde"
                                value="<?= htmlspecialchars($filtros['retirodesde']) ?>">

                            <input type="date" id="retirohasta" class="form-control" name="RetiroHasta"
                                value="<?= htmlspecialchars($filtros['retirohasta']) ?>">
                        </div>
                    </div> 
                    <div class="d-flex flex-wrap justify-content-between align-items-end mt-3" style="padding-top: 20px;">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-info btn-filtrar" name="BotonFiltrar" value="FiltrandoReservas">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button type="submit" class="btn btn-warning btn-filtrar" name="BotonLimpiarFiltros" value="LimpiandoFiltros">
                                <i class="fas fa-ban"></i> Limpiar Filtros
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <div style="padding-bottom: 100px;">

                <!-- Listado de reservas -->
                <h3 class="fw-bold" style="margin-top: 5%;"> Listado de Reservas </h3>
                <div id="tablaReservasContenedor" class="table-responsive mt-4" style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaReservas">
                        <thead>
                            <tr>
                                <th style='color: #d19513;'>
                                    <h3>#</h3>
                                </th>
                                <th>Número Reserva</th>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Matrícula</th>
                                <th>Grupo</th>
                                <th>Modelo</th>
                                <th>Fec. Ret.</th>
                                <th>Fec. Dev.</th>
                                <th>Montos</th>
                                <th>Contrato</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1;

                            for ($i = 0; $i < $CantidadReservas; $i++) { ?>

                                <tr class='reserva' data-id='<?php echo $ListadoReservas[$i]['idReserva']; ?>'
                                    onclick="selectRow(this, '<?= $ListadoReservas[$i]['idReserva'] ?>')">

                                    <td><span style='color: #d19513;'>
                                            <h4> <?php echo $contador; ?> </h4>
                                        </span></td>

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
                                        <span style="font-size: 12px;">
                                            <?php echo "$ {$ListadoReservas[$i]['precioPorDiaReserva']} USD/día <br>
                                                        {$ListadoReservas[$i]['cantidadDiasReserva']} días <br> 
                                                        Total: $ {$ListadoReservas[$i]['totalReserva']} USD";
                                            ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-<?php echo $ListadoReservas[$i]['ContratoColorAdvertencia']; ?>">
                                            <?php echo $ListadoReservas[$i]['ContratoAsociado']; ?>
                                        </span><br><br>
                                        <span>Ver contrato: </span>
                                        <span class='badge badge-warning'> 
                                            <?php
                                            if ($ListadoReservas[$i]['idContrato'] == "No existe") {
                                                echo $ListadoReservas[$i]['idContrato']; 
                                            } 
                                            else {
                                                echo "<a href='contratosAlquiler.php?NumeroContrato={$ListadoReservas[$i]['idContrato']}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos'>ID: {$ListadoReservas[$i]['idContrato']}</a>"; 
                                            } 
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
                    Total de registros encontrados: <?php echo $CantidadReservas; ?>
                </p>


                <!-- Botones de acción -->
                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nueva
                        </button>

                        <button class="btn btn-warning me-2" id="btnModificar" onclick="modificarReserva()" disabled>
                            Modificar
                        </button>

                        <button class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarReserva()" disabled>
                            Eliminar
                        </button>

                        <a href="ReporteReservas.php"> <button class="btn btn-primary">
                                Imprimir
                            </button></a>
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
                                            } else {
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
                                            } else {
                                                echo "<option value=''>No se encontraron vehículos</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <style>
                                        .input-container {

                                            display: flex;
                                            align-items: center;
                                        }
                                    </style>

                                    <div class="mb-3">
                                        <label for="preciopordia" class="form-label">Precio por día</label>
                                        <div class="input-container">
                                            <input type="number" min="20" max="1000" step="0.01" class="form-control" style="max-width: 120px;"
                                                id="preciopordia" name="PrecioPorDia" title="Mínimo $ 20 USD y máximo 1000 USD"
                                                value="" required>
                                            <span style="padding: 0 0 0 10px;"> $ USD por día </span>
                                        </div>
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

        <div>
            <?php require_once "foot.php"; ?>
        </div>
    </div>


    <script>

        // Desplazamiento vertical al listado luego de consulta
        function scrollToTable() {
            localStorage.setItem('scrollToTable', 'true'); // Guardar indicador antes de enviar
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('scrollToTable') === 'true') {
                setTimeout(() => {
                    document.getElementById('tablaReservasContenedor').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500); 
            }
        });

        let reservaSeleccionada = null;

        // Selección de fila en la Tabla de Reservas al hacer clic en la misma
        document.querySelectorAll('#tablaReservas .reserva').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.reserva').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                reservaSeleccionada = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a ModificarCliente.php con el ID del cliente seleccionado
        function modificarReserva() {
            if (reservaSeleccionada) {
                window.location.href = 'ModificarReserva.php?id=' + reservaSeleccionada;
            }
        }

        // Función para redirigir a EliminarCliente.php con el ID del cliente seleccionado
        function eliminarReserva() {
            if (reservaSeleccionada) {
                if (confirm('¿Estás seguro de que quieres eliminar esta reserva?')) {
                    window.location.href = 'EliminarReserva.php?id=' + reservaSeleccionada;
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