<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();


// Primero se traen los datos del vehículo para mostrar en pantalla y permitir modificar cualquiera de sus campos
if (isset($_GET['id'])) {
    $idVehiculo = $_GET['id'];

    $vehiculo = array();

    // Obtener los datos del contrato seleccionado
    $SQL = "SELECT v.idVehiculo as vID,
                   v.matricula as vMatricula, 
                   v.color as vColor,
                   v.fechaCompra as vFechaCompra,
                   v.precioCompra as vPrecioCompra,
                   v.anio as vAnio,
                   v.numeroMotor as vNumeroMotor,
                   v.numeroChasis as vNumeroChasis,
                   v.puertas as vNumeroPuertas,
                   v.asientos as vNumeroAsientos,
                   v.esAutomatico as vAutomatico,
                   v.aireAcondicionado as vAire,
                   v.dirHidraulica as vHidraulica,
                   v.estadoFisicoDelVehiculo as vEstadoFisico,
                   v.disponibilidad as vDisponibilidad,
                   v.kilometraje as vKilometraje,
                   v.idModelo as vIdModelo,
                   v.idCombustible as vIdCombustible,
                   v.idGrupoVehiculo as vIdGrupoVehiculo,
                   v.idSucursal as vIdSucursal,
                   m.idModelo,
                   m.nombreModelo as vModelo,
                   m.descripcionModelo as vDescripcionModelo,
                   c.idCombustible,
                   c.tipoCombustible as vCombustible,
                   g.idGrupo,
                   g.nombreGrupo as vGrupo,
                   g.descripcionGrupo as vDescripcionGrupo,
                   s.idSucursal as sIdSucursal,
                   s.numeroSucursal as vSucursal,
                   s.direccionSucursal as vSucursalDireccion,
                   s.ciudadSucursal as vSucursalCiudad,
                   s.telefonoSucursal as vSucursalTel
            FROM vehiculos v, modelos m, combustibles c, `grupos-vehiculos` g, sucursales s
            WHERE v.idVehiculo = $idVehiculo 
            AND m.idModelo = v.idModelo  
            AND c.idCombustible = v.idCombustible 
            AND g.idGrupo = v.idGrupoVehiculo
            AND s.idSucursal = v.idSucursal; ";


    $rs = mysqli_query($conexion, $SQL);

    $vehiculo = mysqli_fetch_array($rs);


    // También se traen todas las sucursales disponibles para el dropdown list:
    $sucursalesDisponibles = array();
    
    require_once 'funciones/Select_Tablas.php';
    $sucursalesDisponibles = Listar_Sucursal($conexion);
    $cantidadSucursales = count($sucursalesDisponibles);

    // Se traen todos los modelos y grupos de vehículos disponibles para los correspondientes dropdown lists:
    $gruposDisponibles = array();
    $gruposDisponibles = Listar_Grupo($conexion);
    $cantidadGrupos = count($gruposDisponibles);

    $modelosDisponibles = array();
    $modelosDisponibles = Listar_Modelo($conexion);
    $cantidadModelos = count($modelosDisponibles);

    // Se traen todos los tipos de combustibles disponibles para el correspondiente dropdown list:
    $combustiblesDisponibles = array();
    $combustiblesDisponibles = Listar_Combustible($conexion);
    $cantidadCombustibles = count($combustiblesDisponibles);

} 

else {
    // Si no se pasó correctamente un ID de vehículo, se redirige al módulo:
    header("Location: OpVehiculos.php?mensaje=No se tomó el ID del vehículo seleccionado");
    exit();
}


// Por último se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden del form debajo)
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarVehiculo'])) {

    // Primero capturo todos los valores del formulario
    $idVehiculo = $vehiculo['vID'];  // El vehículo devuelto por la consulta SQL
    $matricula = strip_tags(trim($_POST['Matricula'])); // La matrícula tomada del formulario
    $idGrupo = $_POST['GrupoVehiculo']; 
    $idModelo = $_POST['ModeloVehiculo']; 
    $idCombustible = $_POST['Combustible']; 
    $color = strip_tags(trim($_POST['Color']));
    $anioFabricacion = $_POST['AnioFabricacion'];
    
    // Proceso la fecha de compra para que sea compatible con formato de MySQL, y almaceno
    if (!empty($_POST['FechaCompra'])) {
        $fechaCompra = date("Y-m-d", strtotime($_POST['FechaCompra']));
    } 
    else {
        $fechaCompra = null;
    }

    $precioCompra = $_POST['PrecioCompra'];

    $numeroMotor = strip_tags(trim($_POST['NumeroMotor']));
    $numeroChasis = strip_tags(trim($_POST['NumeroChasis']));
    $numeroPuertas = $_POST['NumeroPuertas'];
    $numeroAsientos = $_POST['NumeroAsientos'];

    if ($_POST['Automatico'] == "S" || $_POST['Automatico'] == "N") {
        $automatico = $_POST['Automatico'];
    } 
    else {
        $automatico = null;
    }

    if ($_POST['AireAcondicionado'] == "S" || $_POST['AireAcondicionado'] == "N") {
        $aireAcondicionado = $_POST['AireAcondicionado'];
    } 
    else {
        $aireAcondicionado = null;
    }

    if ($_POST['DireccionHidraulica'] == "S" || $_POST['DireccionHidraulica'] == "N") {
        $direccionHidraulica = $_POST['DireccionHidraulica'];
    } 
    else {
        $direccionHidraulica = null;
    }

    if ($_POST['Disponibilidad'] == "S" || $_POST['Disponibilidad'] == "N") {
        $disponibilidad = $_POST['Disponibilidad'];
    } 
    else {
        $disponibilidad = null;
    }
    
    $estadoVehiculo = strip_tags(trim($_POST['AclaracionesEstadoVehiculo']));
    $kilometraje = strip_tags(trim($_POST['Kilometraje']));    
    $idSucursal = $_POST['Sucursal'];


    // MODIFICANDO el vehículo

    $SqlUpdate = "UPDATE vehiculos 
                                        SET matricula = '$matricula', 
                                            color = '$color', 
                                            anio = '$anioFabricacion', 
                                            fechaCompra = '$fechaCompra', 
                                            precioCompra = '$precioCompra', 
                                            numeroMotor = '$numeroMotor', 
                                            numeroChasis = '$numeroChasis', 
                                            puertas = '$numeroPuertas', 
                                            asientos = '$numeroAsientos', 
                                            esAutomatico = '$automatico', 
                                            aireAcondicionado = '$aireAcondicionado', 
                                            dirHidraulica = '$direccionHidraulica', 
                                            estadoFisicoDelVehiculo = '$estadoVehiculo', 
                                            kilometraje = '$kilometraje', 
                                            disponibilidad = '$disponibilidad', 
                                            idModelo = '$idModelo', 
                                            idCombustible = '$idCombustible', 
                                            idGrupoVehiculo = '$idGrupo', 
                                            idSucursal = '$idSucursal' 
                                        WHERE idVehiculo = $idVehiculo; "; 

    $rs = mysqli_query($conexion, $SqlUpdate);

    if (!$rs) {

        $mensajeError .= "No se pudo actualizar el vehiculo";
        header("Location: OpVehiculos.php?mensaje=" . urlencode($mensajeError));
        exit();
    }
    else {

        // Redirigir después de la actualización
        header("Location: OpVehiculos.php?mensaje=Vehiculo actualizado exitosamente");
        exit();
    }

}


?>

<body class="bg-light" style="margin: 0 auto;">
    <div style="min-height: 100%; margin-bottom: 100px;">
        <div class="wrapper">
            <?php 
            
            include('sidebarGOp.php'); 
            include('topNavBar.php'); 
            
            ?>
            
            <div class="p-5 mb-4 bg-white shadow-sm" 
                 style="margin-top: 10%; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px;">
                
                <?php 

                if ($mensajeError) { ?>
                    <div class="alert alert-danger mt-3"> 
                        <?php 
                            echo "Error al intentar modificar el vehículo. <br><br>"; 
                            echo $mensajeError; 
                        ?>        
                    </div>
                <?php 
                } 
                ?>

                <h5 class="mb-4 text-secondary">
                    <strong>Modificar Vehículo</strong>
                </h5>
                
                <!-- Formulario para modificar el vehículo -->
                <form method="POST">

                    <div class="mb-3">
                        <label for="idvehiculo" class="form-label">ID del Vehículo</label>
                        <input type="text" class="form-control" id="idvehiculo" name="IdVehiculo" 
                            value="Identificador del vehículo: <?php echo htmlspecialchars($vehiculo['vID']); ?> " disabled>
                    </div>

                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula del vehículo</label>
                        <input type="text" maxlength="7" class="form-control" id="matricula" name="Matricula" 
                            value="<?php echo htmlspecialchars($vehiculo['vMatricula']); ?> ">
                    </div>

                    <div class="mb-3">
                        <label for="grupovehiculo" class="form-label">Grupo </label>
                        <select class="form-select" aria-label="Selector" id="grupovehiculo" 
                                title="Grupo al que pertenece el vehículo" 
                                name="GrupoVehiculo">
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            if (!empty($gruposDisponibles)) {
                                $selected = '';

                                for ($i = 0; $i < $cantidadGrupos; $i++) {  
                                    // Lógica para verificar el grupo que ya se encuentra seleccionado:
                                    $selected = (!empty($vehiculo['vIdGrupoVehiculo']) && $vehiculo['vIdGrupoVehiculo'] == $gruposDisponibles[$i]['IdGrupo']) ? 'selected' : '';
                                    // Generación de opciones:
                                    echo "<option value='{$gruposDisponibles[$i]['IdGrupo']}' $selected > 
                                            {$gruposDisponibles[$i]['NombreGrupo']} 
                                          </option>";
                                }
                            } 
                            else {
                                echo "<option value=''> No se encuentran grupos disponibles. </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modelovehiculo" class="form-label">Modelo </label>
                        <select class="form-select" aria-label="Selector" id="modelovehiculo" 
                                title="Modelo del vehículo" 
                                name="ModeloVehiculo">
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            if (!empty($modelosDisponibles)) {
                                $selected = '';

                                for ($i = 0; $i < $cantidadModelos; $i++) {  
                                    // Lógica para verificar el modelo que ya se encuentra seleccionado:
                                    $selected = (!empty($vehiculo['vIdModelo']) && $vehiculo['vIdModelo'] == $modelosDisponibles[$i]['IdModelo']) ? 'selected' : '';
                                    // Generación de opciones:
                                    echo "<option value='{$modelosDisponibles[$i]['IdModelo']}' $selected > 
                                            {$modelosDisponibles[$i]['NombreModelo']} 
                                          </option>";
                                }
                            } 
                            else {
                                echo "<option value=''> No se encuentran modelos disponibles. </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="combustible" class="form-label">Combustible preferente </label>
                        <select class="form-select" aria-label="Selector" id="combustible" 
                                title="Combustible preferente para el vehículo" 
                                name="Combustible">
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            if (!empty($combustiblesDisponibles)) {
                                $selected = '';

                                for ($i = 0; $i < $cantidadCombustibles; $i++) {  
                                    // Lógica para verificar el combustible que ya se encuentra seleccionado:
                                    $selected = (!empty($vehiculo['vIdCombustible']) && $vehiculo['vIdCombustible'] == $combustiblesDisponibles[$i]['IdCombustible']) ? 'selected' : '';
                                    // Generación de opciones:
                                    echo "<option value='{$combustiblesDisponibles[$i]['IdCombustible']}' $selected > 
                                            {$combustiblesDisponibles[$i]['TipoCombustible']} 
                                          </option>";
                                }
                            } 
                            else {
                                echo "<option value=''> No se encuentran combustibles disponibles. </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color del vehículo</label>
                        <input type="text" maxlength="20" class="form-control" id="color" name="Color" 
                            value="<?php echo htmlspecialchars($vehiculo['vColor']); ?> ">
                    </div>

                    <br>
                    <div class="mb-3">
                        <label for="aniofabricacion" class="form-label">Año de fabricación del vehículo</label>
                        <input type="number" step="1" min="1900" max="2100" class="form-control" id="aniofabricacion" 
                            name="AnioFabricacion" 
                            title="No corresponde al año de adquisición del vehículo por parte de la empresa, es el año de fabricación"
                            value="<?php echo htmlspecialchars($vehiculo['vAnio']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="fechacompra" class="form-label">Fecha de Compra</label>
                        <input type="date" class="form-control" id="fechacompra" title="Fecha de adquisición del vehículo por parte de la empresa" 
                            name="FechaCompra" 
                            value="<?php echo htmlspecialchars($vehiculo['vFechaCompra']); ?>" >
                    </div>

                    <div class="mb-3">
                        <label for="preciocompra" class="form-label">Precio de compra</label>
                        <input type="number" step="0.01" min="0" max="1000000000" class="form-control" id="preciocompra" 
                            name="PrecioCompra" 
                            title="Precio al que la empresa adquirió el vehículo"
                            value="<?php echo htmlspecialchars($vehiculo['vPrecioCompra']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="numeromotor" class="form-label">Número de motor</label>
                        <input type="text" maxlength="50" class="form-control" id="numeromotor" name="NumeroMotor" 
                            title="El número de motor de un automóvil es un código alfanumérico único que identifica el motor específico instalado en un vehículo. Generalmente se encuentra en el bloque del motor, aunque su ubicación puede variar según el modelo del vehículo."
                            value="<?php echo htmlspecialchars($vehiculo['vNumeroMotor']); ?> ">
                    </div>

                    <div class="mb-3">
                        <label for="numerochasis" class="form-label">Número de chasis</label>
                        <input type="text" maxlength="17" class="form-control" id="numerochasis" name="NumeroChasis" 
                            title="El número de chasis de un auto, también conocido como VIN (Vehicle Identification Number), es un código alfanumérico único de 17 dígitos que identifica cada vehículo. Este número contiene información clave sobre el vehículo, como su país de fabricación, el modelo y las características específicas."
                            value="<?php echo htmlspecialchars($vehiculo['vNumeroChasis']); ?> ">
                    </div>

                    <div class="mb-3">
                        <label for="numeropuertas" class="form-label">Número de puertas</label>
                        <input type="number" step="1" min="1" max="10" class="form-control" id="numeropuertas" 
                            name="NumeroPuertas" 
                            title="Número de puertas del vehículo"
                            value="<?php echo htmlspecialchars($vehiculo['vNumeroPuertas']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="numeroasientos" class="form-label">Número de asientos (pasajeros)</label>
                        <input type="number" step="1" min="1" max="20" class="form-control" id="numeroasientos" 
                            name="NumeroAsientos" 
                            title="Número de asientos o pasajeros"
                            value="<?php echo htmlspecialchars($vehiculo['vNumeroAsientos']); ?>">
                    </div>

                    <div class="mb-3">
                        <?php
                        if ($vehiculo['vAutomatico'] == null) { ?>
                            
                            <label for="automatico" class="form-label">Automático</label>
                            <select class="form-select" id="automatico" name="Automatico">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vAutomatico'] == "S") { ?>
                            
                            <label for="automatico" class="form-label">Automático</label>
                            <select class="form-select" id="automatico" name="Automatico">
                                <option>Seleccionar...</option>
                                <option value="S" selected>Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vAutomatico'] == "N") { ?>
                            
                            <label for="automatico" class="form-label">Automático</label>
                            <select class="form-select" id="automatico" name="Automatico">
                                <option>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N" selected>No</option>
                            </select>
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <?php
                        if ($vehiculo['vAire'] == null) { ?>
                            
                            <label for="aireacondicionado" class="form-label">Aire Acondicionado</label>
                            <select class="form-select" id="aireacondicionado" name="AireAcondicionado">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vAire'] == "S") { ?>
                            
                            <label for="aireacondicionado" class="form-label">Aire Acondicionado</label>
                            <select class="form-select" id="aireacondicionado" name="AireAcondicionado">
                                <option>Seleccionar...</option>
                                <option value="S" selected>Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vAire'] == "N") { ?>
                            
                            <label for="aireacondicionado" class="form-label">Aire Acondicionado</label>
                            <select class="form-select" id="aireacondicionado" name="AireAcondicionado">
                                <option>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N" selected>No</option>
                            </select>
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <?php
                        if ($vehiculo['vHidraulica'] == null) { ?>
                            
                            <label for="direccionhidraulica" class="form-label">Dirección hidráulica</label>
                            <select class="form-select" id="direccionhidraulica" name="DireccionHidraulica">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vHidraulica'] == "S") { ?>
                            
                            <label for="direccionhidraulica" class="form-label">Dirección hidráulica</label>
                            <select class="form-select" id="direccionhidraulica" name="DireccionHidraulica">
                                <option>Seleccionar...</option>
                                <option value="S" selected>Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vHidraulica'] == "N") { ?>
                            
                            <label for="direccionhidraulica" class="form-label">Dirección hidráulica</label>
                            <select class="form-select" id="direccionhidraulica" name="DireccionHidraulica">
                                <option>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N" selected>No</option>
                            </select>
                        <?php } ?>
                    </div>
                    
                    <br>
                    <div class="mb-3">
                        <label for="aclaracionesestadovehiculo" class="form-label">
                            Aclaraciones sobre el estado físico del vehículo 
                        </label>
                        <textarea class="form-control" id="aclaracionesestadovehiculo" maxlength="200" 
                            name="AclaracionesEstadoVehiculo" 
                            rows="5" cols="33" 
                            value="<?php echo htmlspecialchars($vehiculo['vEstadoFisico']); ?>" ><?php echo htmlspecialchars($vehiculo['vEstadoFisico']); ?></textarea>
                    </div>
                    <br>

                    <div class="mb-3">
                        <label for="kilometraje" class="form-label">Kilometraje y fecha</label>
                        <input type="text" maxlength="50" class="form-control" id="kilometraje" name="Kilometraje" 
                            title="Se sugiere colocar la fecha de medición junto al valor del kilometraje"
                            value="<?php echo htmlspecialchars($vehiculo['vKilometraje']); ?> ">
                    </div>

                    <div class="mb-3">
                        <?php
                        if ($vehiculo['vDisponibilidad'] == null) { ?>
                            
                            <label for="disponibilidad" class="form-label" title="Disponibilidad para la reserva por parte de clientes">
                                Disponibilidad
                            </label>
                            <select class="form-select" id="disponibilidad" name="Disponibilidad" title="Disponibilidad para la reserva">
                                <option selected>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vDisponibilidad'] == "S") { ?>
                            
                            <label for="disponibilidad" class="form-label" title="Disponibilidad para la reserva por parte de clientes">
                                Disponibilidad
                            </label>
                            <select class="form-select" id="disponibilidad" name="Disponibilidad" title="Disponibilidad para la reserva">
                                <option>Seleccionar...</option>
                                <option value="S" selected>Sí</option>
                                <option value="N">No</option>
                            </select>
                        <?php } ?>

                        <?php 
                        if ($vehiculo['vDisponibilidad'] == "N") { ?>
                            
                            <label for="disponibilidad" class="form-label" title="Disponibilidad para la reserva por parte de clientes">
                                Disponibilidad
                            </label>
                            <select class="form-select" id="disponibilidad" name="Disponibilidad" title="Disponibilidad para la reserva">
                                <option>Seleccionar...</option>
                                <option value="S">Sí</option>
                                <option value="N" selected>No</option>
                            </select>
                        <?php } ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sucursales" class="form-label"> Sucursal </label>
                        <select class="form-select" aria-label="Selector" id="sucursales" 
                                title="Sucursal en la que se encuentra el vehículo" 
                                name="Sucursal">
                            <option value="" selected>Selecciona una opción</option>

                            <?php 
                            if (!empty($sucursalesDisponibles)) {
                                $selected = '';

                                for ($i = 0; $i < $cantidadSucursales; $i++) {  
                                    // Lógica para verificar la sucursal seleccionada:
                                    $selected = (!empty($vehiculo['vIdSucursal']) && $vehiculo['vIdSucursal'] == $sucursalesDisponibles[$i]['IdSucursal']) ? 'selected' : '';
                                    // Generación de opciones:
                                    echo "<option value='{$sucursalesDisponibles[$i]['IdSucursal']}' $selected > 
                                            Ciudad: {$sucursalesDisponibles[$i]['CiudadSucursal']} - Dirección: {$sucursalesDisponibles[$i]['DireccionSucursal']} 
                                          </option>";
                                }
                            } 
                            else {
                                echo "<option value=''> No se encuentran sucursales disponibles. </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-dark" name="BotonModificarVehiculo" value="modificandoVehiculo"; >
                        Guardar Cambios
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
