<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Filtrado de vehículos

$matricula = isset($_POST['Matricula']) ? $_POST['Matricula'] : '';
$modelo = isset($_POST['Modelo']) ? $_POST['Modelo'] : '';
$grupo = isset($_POST['Grupo']) ? $_POST['Grupo'] : '';

// Incluyo el script con la funcion que genera mi listado
require_once 'funciones/vehiculos listado.php';


// Consulta por medio de formulario de Filtro
if (!empty($_POST['BotonFiltro'])) {

    require_once 'funciones/vehiculo consulta.php';
    Procesar_Consulta();

    $ListadoVehiculos = array();
    $CantidadVehiculos = '';
    $ListadoVehiculos = Consulta_Vehiculo($_POST['Matricula'], $_POST['Modelo'], $_POST['Grupo'], $conexion);
    $CantidadVehiculos = count($ListadoVehiculos);
}
else {

    // Listo la totalidad de los registros en la tabla "vehiculos" 
    $ListadoVehiculos = Listar_Vehiculos($conexion);
    $CantidadVehiculos = count($ListadoVehiculos);
}

if (!empty($_POST['BotonDesfiltrar'])) {

        // Listo la totalidad de los registros en la tabla "vehiculos" 
        $ListadoVehiculos = Listar_Vehiculos($conexion);
        $CantidadVehiculos = count($ListadoVehiculos);
}


// Modificacion de vehiculo
$matri = '';
$dispo = '';
$model = '';
$grup = '';
$combus = '';
$sucurs = '';
require_once 'funciones/ModificarVehiculo.php';

if (!empty($_POST['ModificarVehiculo'])) {

    $matri = $_POST['MatriculaMOD'];
    $dispo = $_POST['DisponibilidadMOD'];
    $model = $_POST['ModeloMOD'];
    $grup = $_POST['GrupoMOD'];
    $combus = $_POST['CombustibleMOD'];
    $sucurs = $_POST['SucursalMOD'];

    $MensajeModificacion = Corroborar_Modificacion($matri, $dispo, $model, $grup, $combus, $sucurs);

    Modificar_Vehiculo($matri, $dispo, $model, $grup, $combus, $sucurs, $conexion);

    $_POST = array();
    header('Location: OpVehiculos.php');
    die();
}

// SELECCIONES para combo boxes
require_once 'funciones/Select_Tablas.php';

$ListadoGrupo = Listar_Grupo($conexion);
$CantidadGrupo = count($ListadoGrupo);

$ListadoModelo = Listar_Modelo($conexion);
$CantidadModelo = count($ListadoModelo);

$ListadoCombustible = Listar_Combustible($conexion);
$CantidadCombustible = count($ListadoCombustible);

$ListadoSucursal = Listar_Sucursal($conexion);
$CantidadSucursal = count($ListadoSucursal);


require_once "head.php";
?>

<body>

<?php
require_once "topNavBar.php";
require_once "sidebarGop.php";
?>


<main class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light bg-gradient p-4">

    <div class="card col-8 bg-white p-4 rounded shadow mb-4">
        <h4 class="text-center mb-4">Filtrar Vehículos</h4>

        <form method="post">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="Matricula" value="<?php echo !empty($_POST['Matricula']) ? $_POST['Matricula'] : ''; ?> ">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="grupo" class="form-label">Grupo</label>
                    <input type="text" class="form-control" id="grupo" name="Grupo" value="<?php echo !empty($_POST['Grupo']) ? $_POST['Grupo'] : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="Modelo" value="<?php echo !empty($_POST['Modelo']) ? $_POST['Modelo'] : ''; ?>">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="BotonFiltro" value="Filtrando">Filtrar</button>
            <button type="submit" class="btn btn-primary btn-danger" name="BotonDesfiltrar" value="Desfiltrando" style="margin-left: 4%;">Limpiar Filtros</button>
        </form>

    </div>

    <div class="card col-8 bg-white p-4 rounded shadow mb-4">
        <h4 class="text-center mb-3">Lista de Vehículos</h4>
        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="vehicleTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Matrícula</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Grupo</th>
                        <th scope="col">Combustible</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">Disponibilidad</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    for ($i=0; $i < $CantidadVehiculos; $i++) { ?>
                    
                    <tr onclick="selectRow(this, '<?= $ListadoVehiculos[$i]['vMatricula'] ?>')">
                        <td> <?php echo $ListadoVehiculos[$i]['vMatricula']; ?> </td>
                        <td> <?php echo $ListadoVehiculos[$i]['vModelo']; ?> </td>
                        <td> <?php echo $ListadoVehiculos[$i]['vGrupo']; ?> </td>
                        <td> <?php echo $ListadoVehiculos[$i]['vCombustible']; ?> </td>
                        <td> <?php echo "{$ListadoVehiculos[$i]['vSucursalDireccion']}, 
                                         {$ListadoVehiculos[$i]['vSucursalCiudad']}"; ?> </td>
                        <td> <?php echo $ListadoVehiculos[$i]['vDisponibilidad']; ?> </td>
                    </tr>
                    <?php 
                    } 
                    ?>

                </tbody>
                
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between col-8">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoVehiculo">Nuevo</button>
        <button type="button" class="btn btn-primary" onclick="modificarVehiculo()">Modificar</button>
        <button type="button" class="btn btn-warning" onclick="renovarVehiculo()">Eliminar</button>
    </div>

</main>

<!-- Modal para nuevo vehículo -->
<div class="modal fade" id="nuevoVehiculo" tabindex="-1" aria-labelledby="nuevoVehiculoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoVehiculoLabel">Agregar Nuevo Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Form para agregar vehículo -->
                <form action="NuevoVehiculo.php" method="post">

                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" name="matricula" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" name="modelo" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="grupo" class="form-label">Grupo</label>
                        <select class="form-select" aria-label="Selector" id="selector" name="Grupo">
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                            if (!empty($ListadoGrupo)) {
                                $selected = '';
                                for ($i = 0; $i < $CantidadGrupo; $i++) {
                                    // Lógica para verificar si el grupo debe estar seleccionado
                                    $selected = (!empty($_POST['Grupo']) && $_POST['Grupo'] == $ListadoGrupo[$i]['IdGrupo']) ? 'selected' : '';
                                    echo "<option value='{$ListadoGrupo[$i]['IdGrupo']}' $selected>{$ListadoGrupo[$i]['NombreGrupo']}</option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron grupos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="disponible" class="form-label">Disponible</label>
                        <select class="form-select" name="disponible">
                            <option value="Sí">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal para modificar vehículo -->
<div class="modal fade" id="modificarVehiculoModal" tabindex="-1" aria-labelledby="modificarVehiculoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarVehiculoModalLabel">Modificar Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Form para modificar -->
                <form id="modificarVehiculoForm" method="post">

                    <input type="hidden" id="modificarMatricula" name="MatriculaMOD">

                    <div class="mb-3">
                        <label for="modificarModelo" class="form-label">Modelo</label>
                        <select class="form-select" aria-label="Selector" id="modificarModelo" name="ModeloMOD" required>
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            // Asegúrate de que $ListadoModelo contiene datos antes de procesarlo
                            if (!empty($ListadoModelo)) {
                                $selected = '';
                                for ($i = 0; $i < $CantidadModelo; $i++) {
                                    // Lógica para verificar si el grupo debe estar seleccionado
                                    $selected = (!empty($_POST['ModeloMOD']) && $_POST['ModeloMOD'] == $ListadoModelo[$i]['IdModelo']) ? 'selected' : '';
                                    echo "<option value='{$ListadoModelo[$i]['IdModelo']}' $selected>{$ListadoModelo[$i]['NombreModelo']}</option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron grupos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modificarGrupo" class="form-label">Grupo</label>
                        <select class="form-select" aria-label="Selector" id="modificarGrupo" name="GrupoMOD" required>
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                            if (!empty($ListadoGrupo)) {
                                $selected = '';
                                for ($i = 0; $i < $CantidadGrupo; $i++) {
                                    // Lógica para verificar si el grupo debe estar seleccionado
                                    $selected = (!empty($_POST['GrupoMOD']) && $_POST['GrupoMOD'] == $ListadoGrupo[$i]['IdGrupo']) ? 'selected' : '';
                                    echo "<option value='{$ListadoGrupo[$i]['IdGrupo']}' $selected>{$ListadoGrupo[$i]['NombreGrupo']}</option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron grupos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modificarCombustible" class="form-label">Combustible</label>
                        <select class="form-select" aria-label="Selector" id="modificarCombustible" name="CombustibleMOD" required>
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                            if (!empty($ListadoCombustible)) {
                                $selected = '';
                                for ($i = 0; $i < $CantidadCombustible; $i++) {
                                    // Lógica para verificar si el grupo debe estar seleccionado
                                    $selected = (!empty($_POST['CombustibleMOD']) && $_POST['CombustibleMOD'] == $ListadoCombustible[$i]['IdCombustible']) ? 'selected' : '';
                                    echo "<option value='{$ListadoCombustible[$i]['IdCombustible']}' $selected>{$ListadoCombustible[$i]['TipoCombustible']}</option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron grupos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modificarSucursal" class="form-label">Sucursal</label>
                        <select class="form-select" aria-label="Selector" id="modificarSucursal" name="SucursalMOD" required>
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                            if (!empty($ListadoSucursal)) {
                                $selected = '';
                                for ($i = 0; $i < $CantidadSucursal; $i++) {
                                    // Lógica para verificar si el grupo debe estar seleccionado
                                    $selected = (!empty($_POST['SucursalMOD']) && $_POST['SucursalMOD'] == $ListadoSucursal[$i]['IdSucursal']) ? 'selected' : '';
                                    echo "<option value='{$ListadoSucursal[$i]['IdSucursal']}' $selected> {$ListadoSucursal[$i]['DireccionSucursal']}, {$ListadoSucursal[$i]['CiudadSucursal']} </option>";
                                }
                            } 
                            else {
                                echo "<option value=''>No se encontraron grupos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modificarDisponible" class="form-label">Disponible</label>
                        <select class="form-select" id="modificarDisponible" name="DisponibilidadMOD" required>
                            <option value="S">Sí</option>
                            <option value="N">No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name="ModificarVehiculo" value="Modificando">Modificar</button>                    
                </form>






            </div>
        </div>
    </div>
</div>

<div style="padding-bottom: 20px;">
    <?php require_once "foot.php"; ?>
</div>

<script>
let selectedRow = null;

function selectRow(row, matricula) {
    if (selectedRow) {
        selectedRow.classList.remove('selected-row');
    }
    selectedRow = row;
    selectedRow.classList.add('selected-row');
    
    // Guardar matrícula del vehículo seleccionado
    document.getElementById('modificarMatricula').value = matricula;
}

function modificarVehiculo() {
    if (!selectedRow) {
        alert("Por favor, selecciona un vehículo.");
        return;
    }

    // Obtener datos de la fila seleccionada
    const matricula = selectedRow.cells[0].innerText;
    const modelo = selectedRow.cells[1].innerText;
    const grupo = selectedRow.cells[2].innerText;
    const combustible = selectedRow.cells[3].innerText;
    const sucursal = selectedRow.cells[4].innerText;
    const disponible = selectedRow.cells[5].innerText;

    // Cargar datos en el formulario del modal
    document.getElementById('modificarMatricula').value = matricula;
    document.getElementById('modificarModelo').value = modelo;
    document.getElementById('modificarGrupo').value = grupo;
    document.getElementById('modificarCombustible').value = combustible;
    document.getElementById('modificarSucursal').value = sucursal;
    document.getElementById('modificarDisponible').value = disponible;

    // Mostrar el modal
    const modificarModal = new bootstrap.Modal(document.getElementById('modificarVehiculoModal'));
    modificarModal.show();
}

function renovarVehiculo() {
    if (!selectedRow) {
        alert("Por favor, selecciona un vehículo.");
        return;
    }
    
    const matricula = selectedRow.cells[0].innerText; // Obtener matrícula de la fila seleccionada
    if (confirm(`¿Estás seguro de que deseas eliminar el vehículo con matrícula ${matricula}?`)) {
        // Realizar llamada AJAX para eliminar el vehículo
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "EliminarVehiculo.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Vehículo eliminado exitosamente.");
                selectedRow.remove(); // Eliminar la fila de la tabla
                selectedRow = null; // Resetear la selección
            } else {
                alert("Error al eliminar el vehículo: " + xhr.responseText);
            }
        };
        xhr.send("matricula=" + encodeURIComponent(matricula));
    }
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


