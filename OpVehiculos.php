<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Incluyo el script con la funcion que genera mi listado
require_once 'funciones/vehiculos listado.php';
$ListadoVehiculos = Listar_Vehiculos($conexion);
$CantidadVehiculos = count($ListadoVehiculos);


// Filtrado de vehículos

$matricula = isset($_POST['Matricula']) ? $_POST['Matricula'] : '';
$modelo = isset($_POST['Modelo']) ? $_POST['Modelo'] : '';
$grupo = isset($_POST['Grupo']) ? $_POST['Grupo'] : '';
$color = isset($_POST['Color']) ? $_POST['Color'] : '';
$combustible = isset($_POST['Combustible']) ? $_POST['Combustible'] : '';
$disponibilidad = isset($_POST['Disponibilidad']) ? $_POST['Disponibilidad'] : '';
$ciudadsucursal = isset($_POST['CiudadSucursal']) ? $_POST['CiudadSucursal'] : '';
$direccionsucursal = isset($_POST['DireccionSucursal']) ? $_POST['DireccionSucursal'] : '';
$telsucursal = isset($_POST['TelSucursal']) ? $_POST['TelSucursal'] : '';
$puertas = isset($_POST['Puertas']) ? $_POST['Puertas'] : '';
$asientos = isset($_POST['Asientos']) ? $_POST['Asientos'] : '';
$automatico = isset($_POST['Automatico']) ? $_POST['Automatico'] : '';
$aireacondicionado = isset($_POST['AireAcondicionado']) ? $_POST['AireAcondicionado'] : '';
$direccionhidraulica = isset($_POST['DireccionHidraulica']) ? $_POST['DireccionHidraulica'] : '';
$fabricaciondesde = isset($_POST['FabricacionDesde']) ? $_POST['FabricacionDesde'] : '';
$fabricacionhasta = isset($_POST['FabricacionHasta']) ? $_POST['FabricacionHasta'] : '';
$adquisiciondesde = isset($_POST['AdquisicionDesde']) ? $_POST['AdquisicionDesde'] : '';
$adquisicionhasta = isset($_POST['AdquisicionHasta']) ? $_POST['AdquisicionHasta'] : '';
$preciodesde = isset($_POST['PrecioDesde']) ? $_POST['PrecioDesde'] : '';
$preciohasta = isset($_POST['PrecioHasta']) ? $_POST['PrecioHasta'] : '';

// Consulta por medio de formulario de Filtro
if (!empty($_POST['BotonFiltro'])) {

    require_once 'funciones/vehiculo consulta.php';
    Procesar_Consulta();

    $ListadoVehiculos = array();
    $CantidadVehiculos = '';
    $ListadoVehiculos = Consulta_Vehiculo($_POST['Matricula'], $_POST['Modelo'], $_POST['Grupo'], $_POST['Color'], $_POST['Combustible'], $_POST['Disponibilidad'], $_POST['CiudadSucursal'], $_POST['DireccionSucursal'], $_POST['TelSucursal'], $_POST['Puertas'], $_POST['Asientos'], $_POST['Automatico'], $_POST['AireAcondicionado'], $_POST['DireccionHidraulica'], $_POST['FabricacionDesde'], $_POST['FabricacionHasta'], $_POST['AdquisicionDesde'], $_POST['AdquisicionHasta'], $_POST['PrecioDesde'], $_POST['PrecioHasta'], $conexion);
    $CantidadVehiculos = count($ListadoVehiculos);
}
else {

    // Listo la totalidad de los registros en la tabla "vehiculos". 
    $ListadoVehiculos = Listar_Vehiculos($conexion);
    $CantidadVehiculos = count($ListadoVehiculos);
}

if (!empty($_POST['BotonDesfiltrar'])) {

        // Listo la totalidad de los registros en la tabla "vehiculos" 
        $ListadoVehiculos = Listar_Vehiculos($conexion);
        $CantidadVehiculos = count($ListadoVehiculos);
        $_POST['Matricula'] = "";
        $_POST['Modelo'] = "";
        $_POST['Grupo'] = "";
        $_POST['Color'] = "";
        $_POST['Combustible'] = ""; 
        $_POST['Disponibilidad'] = "";
        $_POST['CiudadSucursal'] = "";
        $_POST['DireccionSucursal'] = "";
        $_POST['TelSucursal'] = "";
        $_POST['Puertas'] = "";
        $_POST['Asientos'] = "";
        $_POST['Automatico'] = "";
        $_POST['AireAcondicionado'] = "";
        $_POST['DireccionHidraulica'] = "";
        $_POST['FabricacionDesde'] = "";
        $_POST['FabricacionHasta'] = "";
        $_POST['AdquisicionDesde'] = "";
        $_POST['AdquisicionHasta'] = "";
        $_POST['PrecioDesde'] = "";
        $_POST['PrecioHasta'] = "";        
}


// Variables usadas en Registros, Modificaciones, etc.
$matri = '';
$dispo = '';
$model = '';
$grup = '';
$combus = '';
$sucurs = '';


// Registrar nuevo vehiculo
require_once 'funciones/RegistrarVehiculo.php';

if (!empty($_POST['BotonRegistrarVehiculo'])) {

    // Capturo los datos
    $matri = $_POST['MatriculaREG'];
    $matri = "$matri";
    $model = $_POST['ModeloREG'];
    $grup = $_POST['GrupoREG'];
    $dispo = $_POST['DisponibilidadREG'];

    Registrar_Vehiculo($matri, $model, $grup, $dispo, $conexion);

    $_POST = array();
    header('Location: OpVehiculos.php');
    die();
}


// Modificacion de vehiculo
require_once 'funciones/ModificarVehiculo.php';

if (!empty($_POST['BotonModificarVehiculo'])) {

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

    <div style="margin-top: 8%; margin-bottom: 8%; min-height: 100%; ">

        <main class="d-flex flex-column justify-content-center align-items-center h-100 bg-light bg-gradient p-4">

            <div class="card col-10 bg-white p-4 rounded shadow mb-4">
                <h4 class="text-center mb-4">Filtrar Vehículos</h4>

                <form method="post">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="Matricula" value="<?php echo !empty($_POST['Matricula']) ? $_POST['Matricula'] : ''; ?>">
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

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="Color" value="<?php echo !empty($_POST['Color']) ? $_POST['Color'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="combustible" class="form-label">Combustible</label>
                            <input type="text" class="form-control" id="combustible" name="Combustible" value="<?php echo !empty($_POST['Combustible']) ? $_POST['Combustible'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="disponibilidad" class="form-label">Disponibilidad</label>
                            <select class="form-select" id="disponibilidad" name="Disponibilidad">
                                <option selected>Disponibilidad para arrendar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ciudadsucursal" class="form-label">Ciudad de Sucursal</label>
                            <input type="text" class="form-control" id="ciudadsucursal" name="CiudadSucursal" value="<?php echo !empty($_POST['CiudadSucursal']) ? $_POST['CiudadSucursal'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="direccionsucursal" class="form-label">Dirección de Sucursal</label>
                            <input type="text" class="form-control" id="direccionsucursal" name="DireccionSucursal" value="<?php echo !empty($_POST['DireccionSucursal']) ? $_POST['DireccionSucursal'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="telsucursal" class="form-label">Teléfono de Sucursal</label>
                            <input type="text" class="form-control" id="telsucursal" name="TelSucursal" value="<?php echo !empty($_POST['TelSucursal']) ? $_POST['TelSucursal'] : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label for="puertas" class="form-label">Puertas</label>
                            <input type="text" class="form-control" id="puertas" name="Puertas" value="<?php echo !empty($_POST['Puertas']) ? $_POST['Puertas'] : ''; ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="asientos" class="form-label">Asientos</label>
                            <input type="text" class="form-control" id="asientos" name="Asientos" value="<?php echo !empty($_POST['Asientos']) ? $_POST['Asientos'] : ''; ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="automatico" class="form-label">Automático</label>
                            <select class="form-select" id="automatico" name="Automatico">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="aireacondicionado" class="form-label">Aire acondicionado</label>
                            <select class="form-select" id="aireacondicionado" name="AireAcondicionado">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        </div> 
                        <div class="col-md-2 mb-2">
                            <label for="direccionhidraulica" class="form-label">Dirección hidráulica</label>
                            <select class="form-select" id="direccionhidraulica" name="DireccionHidraulica">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        </div> 
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="aniofabricacion" class="form-label">Año de fabricación</label>
                            <div class="d-flex">
                                <input type="number" step="1" min="1900" max="2050" id="fabricaciondesde" title="Desde..." class="form-control me-2" name="FabricacionDesde" 
                                    value="<?php echo !empty($_POST['FabricacionDesde']) ? $_POST['FabricacionDesde'] : ''; ?>">

                                <input type="number" step="1" min="1900" max="2050" id="fabricacionhasta" title="Hasta..." class="form-control" name="FabricacionHasta" 
                                    value="<?php echo !empty($_POST['FabricacionHasta']) ? $_POST['FabricacionHasta'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fechacompra" class="form-label">Fecha de adquisición</label>
                            <div class="d-flex">
                                <input type="date" id="adquisiciondesde" title="Desde..." class="form-control me-2" name="AdquisicionDesde" 
                                    value="<?php echo !empty($_POST['AdquisicionDesde']) ? $_POST['AdquisicionDesde'] : ''; ?>">

                                <input type="date" id="adquisicionhasta" title="Hasta..." class="form-control" name="AdquisicionHasta" 
                                    value="<?php echo !empty($_POST['AdquisicionHasta']) ? $_POST['AdquisicionHasta'] : ''; ?>">
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <label for="precio" class="form-label">Precio vehículo</label>
                            <div class="d-flex">
                                <input type="number" min="0" max="1000000000" id="preciodesde" title="Desde..." class="form-control me-2" name="PrecioDesde" 
                                    value="<?php echo !empty($_POST['PrecioDesde']) ? $_POST['PrecioDesde'] : ''; ?>">

                                <input type="number" min="0" max="1000000000" id="preciohasta" title="Hasta..." class="form-control" name="PrecioHasta" 
                                    value="<?php echo !empty($_POST['PrecioHasta']) ? $_POST['PrecioHasta'] : ''; ?>">
                            </div>
                        </div> 
                    </div>

                    <br><br>
                    <button type="submit" class="btn btn-primary" name="BotonFiltro" value="Filtrando">Filtrar</button>
                    <button type="submit" class="btn btn-primary btn-danger" name="BotonDesfiltrar" value="Desfiltrando" style="margin-left: 4%;">Limpiar Filtros</button>
                </form>

            </div>

            <!-- Tabla de vehículos -->
            <div class="card col-10 bg-white p-4 rounded shadow mb-4" style="margin-top: 5%;">
                <h4 class="text-center mb-3">Listado de Vehículos</h4> <br>
                <div class="table-responsive" style="max-height: 700px;">

                    <table class="table table-bordered table-hover table-striped" id="tablaVehiculos">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col"> # </th>
                                <th scope="col"> Matrícula </th>
                                <th scope="col"> Vehículo </th>
                                <th scope="col"> Combustible </th>
                                <th scope="col"> Sucursal </th>
                                <th scope="col"> Disp. </th>
                                <th scope="col"> Puertas y asientos </th>
                                <th scope="col"> Automático </th>
                                <th scope="col"> Aire acondicionado </th>
                                <th scope="col"> Dirección Hidráulica </th>
                                <th scope="col"> Kilometraje </th>
                                <th scope="col"> Motor y chasis </th>
                                <th scope="col"> Estado físico </th>
                                <th scope="col"> Año de fabricación </th>
                                <th scope="col"> Adquisición </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            for ($i=0; $i < $CantidadVehiculos; $i++) { ?>
                            
                            <tr class='vehiculo'                                 
                                data-matricula="<?= $ListadoVehiculos[$i]['vMatricula'] ?>" 
                                data-modelo="<?= $ListadoVehiculos[$i]['vModelo'] ?>" 
                                data-grupo="<?= $ListadoVehiculos[$i]['vGrupo'] ?>" 
                                data-combustible="<?= $ListadoVehiculos[$i]['vCombustible'] ?>" 
                                data-sucursal="<?= "{$ListadoVehiculos[$i]['vSucursalDireccion']}, {$ListadoVehiculos[$i]['vSucursalCiudad']}" ?>" 
                                data-disponibilidad="<?= $ListadoVehiculos[$i]['vDisponibilidad'] ?>" 
                                onclick="selectRow(this, '<?= $ListadoVehiculos[$i]['vMatricula'] ?>')" >

                                <td> <?php echo $i+1; ?> </td>

                                <td> <?php echo $ListadoVehiculos[$i]['vMatricula']; ?> </td>

                                <td title="Modelo del vehículo y grupo al que pertenece" > 
                                    <b>Modelo:</b> <?php echo $ListadoVehiculos[$i]['vModelo']; ?> <br><br>
                                    <b>Grupo:</b> <?php echo $ListadoVehiculos[$i]['vGrupo']; ?> <br><br>
                                    <b>Color:</b> <?php echo $ListadoVehiculos[$i]['vColor']; ?>
                                </td>

                                <td> <?php echo $ListadoVehiculos[$i]['vCombustible']; ?> </td>

                                <td> <?php echo "{$ListadoVehiculos[$i]['vSucursalCiudad']}, 
                                                {$ListadoVehiculos[$i]['vSucursalDireccion']}"; ?> <br><br>
                                     <b>Tel:</b> <?php echo $ListadoVehiculos[$i]['vSucursalTel']; ?> 
                                </td>

                                <td title="Disponibilidad"> 
                                    <span class="badge badge-<?php echo $ListadoVehiculos[$i]['ColorAdvertencia']; ?>"> 
                                        <?php echo $ListadoVehiculos[$i]['vDisponibilidad']; ?> 
                                    </span>
                                </td>

                                <td> 
                                    <b>Puertas:</b> <?php echo $ListadoVehiculos[$i]['vNumeroPuertas']; ?> <br><br>
                                    <b>Asientos:</b> <?php echo $ListadoVehiculos[$i]['vNumeroAsientos']; ?> pasajeros
                                </td>

                                <td title="Automático"> <?php echo $ListadoVehiculos[$i]['vAutomatico']; ?> </td>

                                <td title="Aire acondicionado"> <?php echo $ListadoVehiculos[$i]['vAire']; ?> </td>

                                <td title="Dirección hidráulica"> <?php echo $ListadoVehiculos[$i]['vHidraulica']; ?> </td>

                                <td title="Kilometraje"> <?php echo $ListadoVehiculos[$i]['vKilometraje']; ?> </td>

                                <td> 
                                    <b>NºMotor:</b> <?php echo $ListadoVehiculos[$i]['vNumeroMotor']; ?> <br><br>
                                    <b>NºChasis:</b> <?php echo $ListadoVehiculos[$i]['vNumeroChasis']; ?> 
                                </td>

                                <td title="Estado físico del vehículo"> <?php echo $ListadoVehiculos[$i]['vEstadoFisico']; ?> </td>

                                <td title="Año de fabricación del vehículo"> <?php echo $ListadoVehiculos[$i]['vAnio']; ?> </td>

                                <td title="Fecha de compra y precio al que la empresa adquirió el vehículo"> 
                                    <b>Fecha:</b><br> <?php echo $ListadoVehiculos[$i]['vFechaCompra']; ?> <br><br>
                                    <b>Precio:</b><br> 
                                    <?php 
                                    if ($ListadoVehiculos[$i]['vPrecioCompra'] != "Sin información") {
                                        echo "$ "; 
                                        echo $ListadoVehiculos[$i]['vPrecioCompra']; 
                                        echo " USD";
                                    }
                                    else {
                                        echo $ListadoVehiculos[$i]['vPrecioCompra']; 
                                    }
                                    ?> 
                                </td>

                            </tr>
                            <?php 
                            } 
                            ?>

                        </tbody>
                        
                    </table>
                </div>
            </div>
            <br><br>
            <div class="d-flex justify-content-between col-8">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoVehiculo">Nuevo</button>
                <button type="button" class="btn btn-primary" onclick="modificarVehiculo()">Modificar</button>
                <button type="button" class="btn btn-warning" onclick="renovarVehiculo()">Eliminar</button>
            </div>

        </main>
    </div>

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
                    <form method="post">

                        <div class="mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" maxlength="7" class="form-control" name="MatriculaREG" value="" required>
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <select class="form-select" aria-label="Selector" id="selector" name="ModeloREG" required>
                                <option value="" selected>Selecciona una opción</option>

                                <?php 
                                // Asegúrate de que $ListadoModelo contiene datos antes de procesarlo
                                if (!empty($ListadoModelo)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadModelo; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = (!empty($_POST['ModeloREG']) && $_POST['ModeloREG'] == $ListadoModelo[$i]['IdModelo']) ? 'selected' : '';
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
                            <label for="grupo" class="form-label">Grupo</label>
                            <select class="form-select" aria-label="Selector" id="selector" name="GrupoREG" required>
                                <option value="" selected>Selecciona una opción</option>

                                <?php 
                                // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                                if (!empty($ListadoGrupo)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadGrupo; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = (!empty($_POST['GrupoREG']) && $_POST['GrupoREG'] == $ListadoGrupo[$i]['IdGrupo']) ? 'selected' : '';
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
                            <select class="form-select" name="DisponibilidadREG" required>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" name="BotonRegistrarVehiculo" value="RegistrandoVehiculo" >Agregar</button>
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

                    <!-- Recupero los datos de la fila seleccionada en el listado -->
                    <?php 

                    // Variables a utilizar en el modal de modificación de vehículos:
                    $matriculaModal = isset($_SESSION['matriculaModal']) ? $_SESSION['matriculaModal'] : '';
                    $modeloModal = isset($_SESSION['modeloModal']) ? $_SESSION['modeloModal'] : '';
                    $grupoModal = isset($_SESSION['grupoModal']) ? $_SESSION['grupoModal'] : '';
                    $combustibleModal = isset($_SESSION['combustibleModal']) ? $_SESSION['combustibleModal'] : '';
                    $sucursalModal = isset($_SESSION['sucursalModal']) ? $_SESSION['sucursalModal'] : '';
                    $disponibilidadModal = isset($_SESSION['disponibilidadModal']) ? $_SESSION['disponibilidadModal'] : '';
                    ?>
                    
                    <!-- Form para modificar -->
                    <form id="modificarVehiculoForm" method="post">

                        <input type="hidden" id="modificarMatricula" name="MatriculaMOD" value="<?php echo $matriculaModal; ?>" > 

                        <div class="mb-3">
                            <label for="modificarModelo" class="form-label">Modelo</label>
                            <select class="form-select" aria-label="Selector" id="modificarModelo" name="ModeloMOD" required>
                                <option> Selecciona una opción </option>

                                <?php 
                                // Asegúrate de que $ListadoModelo contiene datos antes de procesarlo
                                if (!empty($ListadoModelo)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadModelo; $i++) {
                                        // Lógica para verificar si el modelo debe estar seleccionado
                                        $selected = ($modeloModal == $ListadoModelo[$i]['NombreModelo']) ? 'selected' : '';

                                        echo "<option value='{$ListadoModelo[$i]['IdModelo']}' $selected> {$ListadoModelo[$i]['NombreModelo']} </option>";
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
                                <option>Selecciona una opción</option>

                                <?php 
                                // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                                if (!empty($ListadoGrupo)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadGrupo; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = ($grupoModal == $ListadoGrupo[$i]['NombreGrupo']) ? 'selected' : '';
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
                                <option> Selecciona una opción</option>

                                <?php 
                                // Asegúrate de que $ListadoCombustible contiene datos antes de procesarlo
                                if (!empty($ListadoCombustible)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadCombustible; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = ($combustibleModal == $ListadoCombustible[$i]['TipoCombustible']) ? 'selected' : '';
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
                                <option>Selecciona una opción </option>

                                <?php 
                                // Asegúrate de que $ListadoSucursal contiene datos antes de procesarlo
                                if (!empty($ListadoSucursal)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadSucursal; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = ($sucursalModal == "{$ListadoSucursal[$i]['DireccionSucursal']}, {$ListadoSucursal[$i]['CiudadSucursal']}") ? 'selected' : '';
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

                        <button type="submit" class="btn btn-primary" name="BotonModificarVehiculo" value="ModificandoVeh">Modificar</button>                    
                    </form>

                </div>
            </div>
        </div>
    </div>
    

    <script>

    let vehiculoSeleccionado = null;

    // Sombreado de fila en la Tabla de Vehiculos al hacer clic en la misma
    document.querySelectorAll('#tablaVehiculos .vehiculo').forEach(row => {
        row.addEventListener('click', () => {
            // Desmarcar cualquier fila previamente seleccionada
            document.querySelectorAll('.vehiculo').forEach(row => row.classList.remove('table-active'));
            // Marcar la fila seleccionada
            row.classList.add('table-active');
            vehiculoSeleccionado = row.dataset.id;
        });
    });

    // Selección de fila en la Tabla de Vehiculos al hacer clic en la misma
    let selectedRow = null;

    function selectRow(row, matricula) {
        if (selectedRow) {
            selectedRow.classList.remove('selected-row');
        }
        selectedRow = row;
        selectedRow.classList.add('selected-row');
        
        // Guardar matrícula del vehículo seleccionado
        document.getElementById('modificarMatricula').value = matricula;

        // Guardar datos del vehículo seleccionado 
        const matriculaModal = row.dataset.matricula;
        const modeloModal = row.dataset.modelo;
        const grupoModal = row.dataset.grupo;
        const combustibleModal = row.dataset.combustible;
        const sucursalModal = row.dataset.sucursal;
        const disponibilidadModal = row.dataset.disponibilidad;

        // Enviar datos al servidor mediante AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "guardar_datos_vehiculo.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log("Datos del vehículo guardados en variables PHP.");
            } else {
                console.error("Error al guardar los datos del vehículo: " + xhr.responseText);
            }
        };

        xhr.send(`matriculaModal=${encodeURIComponent(matriculaModal)}&modeloModal=${encodeURIComponent(modeloModal)}&grupoModal=${encodeURIComponent(grupoModal)}&combustibleModal=${encodeURIComponent(combustibleModal)}&sucursalModal=${encodeURIComponent(sucursalModal)}&disponibilidadModal=${encodeURIComponent(disponibilidadModal)}`);

    }

    function modificarVehiculo() {
        if (!selectedRow) {
            alert("Por favor, selecciona un vehículo.");
            return;
        }

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
            xhr.open("POST", "funciones/EliminarVehiculo.php", true);
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

    <div style="">
        <?php require_once "foot.php"; ?>
    </div>

</body>
</html>


