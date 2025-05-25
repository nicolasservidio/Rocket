<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Primero se traen los datos del contrato para mostrar en pantalla y permitir modificar las fechas, precio por día, total y el estado
if (isset($_GET['id'])) {
    $idContrato = $_GET['id'];

    $contrato = array();

    // Obtener los datos del contrato seleccionado
    $SQL = "SELECT c.idContrato as cIdContrato, 
                    c.fechaInicioContrato as cFechaInicioContrato, 
                    c.fechaFinContrato as cFechaFinContrato, 
                    c.fechaEntrega as cFechaEntrega, 
                    c.fechaDevolucion as cFechaDevolucion, 
                    c.idCliente as cIdCliente, 
                    c.idVehiculo as cIdVehiculo, 
                    c.idVendedor as cIdVendedor, 
                    c.idDetalleContrato as cIdDetalleContrato, 
                    c.idEstadoContrato as cIdEstadoContrato,

                    cl.idCliente as clIdCliente,
                    cl.nombreCliente as clNombreCliente,
                    cl.apellidoCliente as clApellidoCliente,
                    cl.dniCliente as clDniCliente,

                    v.idVehiculo as vIdVehiculo,
                    v.matricula as vMatricula,
                    v.idModelo as vIdModelo,
                    v.idGrupoVehiculo as vIdGrupoVehiculo,
                    v.idSucursal as vIdSucursal, 

                    m.idModelo as  mIdModelo,
                    m.nombreModelo as mNombreModelo,
                    g.idGrupo as gIdGrupo,
                    g.nombreGrupo as gNombreGrupo, 

                    s.idSucursal as sIdSucursal, 
                    s.direccionSucursal as sDireccionSucursal, 
                    s.ciudadSucursal as sCiudadSucursal, 

                    dc.idDetalleContrato as dcIdDetalleContrato, 
                    dc.precioPorDiaContrato as dcPrecioPorDiaContrato, 
                    dc.cantidadDiasContrato as dcCantidadDiasContrato, 
                    dc.montoTotalContrato as dcMontoTotalContrato, 
                    
                    ec.idEstadoContrato as ecIdEstadoContrato, 
                    ec.estadoContrato as ecEstadoContrato 
            FROM `contratos-alquiler` c, clientes cl, vehiculos v, modelos m, `grupos-vehiculos` g, `detalle-contratos` dc, `estados-contratos` ec, sucursales s   
            WHERE c.idContrato = $idContrato 
            AND c.idCliente = cl.idCliente 
            AND c.idVehiculo = v.idVehiculo 
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND v.idSucursal = s.idSucursal 
            AND c.idDetalleContrato = dc.idDetalleContrato
            AND c.idEstadoContrato = ec.idEstadoContrato; ";


    $rs = mysqli_query($conexion, $SQL);

    $contrato = mysqli_fetch_array($rs);

    // Se traen todos los vehículos disponibles:

    $vehiculosDisponibles = array();
    
    require_once 'funciones/Select_Tablas.php';
    $vehiculosDisponibles = Listar_Vehiculos_Disponibles($conexion);
    $cantidadVehiculos = count($vehiculosDisponibles);

    $estadosContrato = Listar_EstadosContrato($conexion);
    $cantidadEstados = count($estadosContrato);
} 

else {
    // Si no se pasa un ID, se redirige al listado de contratos
    header("Location: contratosAlquiler.php?mensaje=No se encontró el contrato seleccionado. ");
    exit();
}

// Por último se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden del form debajo)
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarContrato'])) {

    $idContrato = $contrato['cIdContrato'];
    $idDetalleContrato = $contrato['dcIdDetalleContrato'];
    $idCliente = $contrato['cIdCliente'];
    $idVehiculo = $_POST['VehiculosDisponibles'];
    $estadoContrato = $_POST['EstadoDelContrato']; 
    $precioPorDia = $_POST['PrecioPorDia'];  

    // Validaciones de fechas
    $errores = [];

    if (empty($_POST['FechaRetiro'])) {
        $errores[] = "La fecha de retiro es obligatoria.";
    }
    if (empty($_POST['FechaDevolucion'])) {
        $errores[] = "La fecha de devolución es obligatoria.";
    }
    if (!empty($_POST['FechaRetiro']) && !empty($_POST['FechaDevolucion'])) {
        $fechaRetiro = new DateTime($_POST['FechaRetiro']);
        $fechaDevolucion = new DateTime($_POST['FechaDevolucion']);

        if ($fechaRetiro > $fechaDevolucion) {
            $errores[] = "La fecha de retiro no puede ser posterior a la fecha de devolución.";
        }
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensajeDeError = implode(' ', $errores);
        echo "<script> 
            alert('$mensajeDeError');
            window.location.href = 'contratosAlquiler.php';
        </script>";
        exit();
    }

    // Se cambia formato de las fechas y se almacenan para el update:
    $fechaEspanol = $_POST['FechaRetiro'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaRetiroIngles = "$year-$mo-$day";

    $fecharetiro = $fechaRetiroIngles;

    $fechaEspanol = $_POST['FechaDevolucion'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaDevolucionIngles = "$year-$mo-$day";

    $fechadevolucion = $fechaDevolucionIngles; 


    // Cálculo de cantidad de días
    $min_date = "$fechaRetiroIngles";
    $max_date = "$fechaDevolucionIngles";
    $dif_min = new DateTime($min_date);
    $dif_max = new DateTime($max_date);
    $intervalo = $dif_min->diff($dif_max);
    $diferenciaDias = $intervalo->days;

    $diferenciaDias = intval($diferenciaDias);
/*    $horas_totales = $intervalo->format('%d:%H:%i'); */

    // Monto total:
    $montoTotal = $diferenciaDias * $precioPorDia;


    require_once 'funciones/CRUD-Reservas.php';
    
    if ($idVehiculo) {   

        // Actualizar los datos del detalle del contrato
        $ModificacionDetalleContrato = "UPDATE `detalle-contratos` 
                                        SET precioPorDiaContrato = $precioPorDia, 
                                            cantidadDiasContrato = $diferenciaDias, 
                                            montoTotalContrato = $montoTotal, 
                                            estadoContrato = 'El estado ha sido modificado' 
                                        WHERE idDetalleContrato = $idDetalleContrato; "; 

        $rs = mysqli_query($conexion, $ModificacionDetalleContrato);

        if (!$rs) {

            $mensajeError = "No se pudo acceder al detalle del contrato en la base de datos";
            header("Location: contratosAlquiler.php?mensaje=" . urlencode($mensajeError));
            exit();
        }
        else {

            // Actualizar los datos del contrato
            $ModificacionContrato = "UPDATE `contratos-alquiler` 
                                    SET fechaInicioContrato = '$fecharetiro', 
                                        fechaFinContrato = '$fechadevolucion', 
                                        idCliente = $idCliente, 
                                        idVehiculo = $idVehiculo,
                                        idEstadoContrato = $estadoContrato 
                                    WHERE idContrato = $idContrato; "; 

            $rs = mysqli_query($conexion, $ModificacionContrato);

            if (!$rs) {

                $mensajeError = "No se pudo acceder al encabezado del contrato en la base de datos";
                header("Location: contratosAlquiler.php?mensaje=" . urlencode($mensajeError));
                exit();
            }
            else {

                // Redirigir después de la actualización
                $mensajeError = "Contrato {$idContrato} modificado exitosamente.";
                echo "<script> 
                    alert('$mensajeError');
                    window.location.href = 'contratosAlquiler.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
                </script>";
                exit();
            }
        }
    }

    else {
        header("Location: contratosAlquiler.php?mensaje=No se puede realizar la modificación del contrato.");
        exit();
    }
}


?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="min-height: 100%; margin-bottom: 100px;">

        <?php 
        
        include('sidebarGOp.php'); 
        include('topNavBar.php'); 
        
        ?>
        
        <div class="p-5 mb-4 bg-white shadow-sm" 
             style="margin-top: 150px; margin-bottom: 100px; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px;">
            
            <?php 

            if ($mensajeError) { ?>
                <div class="alert alert-danger mt-3"> 
                    <?php 
                        echo "Error al intentar modificar el contrato. <br><br>"; 
                        echo $mensajeError; 
                    ?>        
                </div>
            <?php } 
            ?>

            <h5 class="mb-4 text-secondary"><strong>Modificar Contrato</strong></h5>

            <!-- ALERTA -->
            <?php 
                $alerta = "";

                if($contrato['ecEstadoContrato'] == "En Preparación") {
                    $alerta = "success";
                }
                else {
                    $alerta = "danger";
                }
            ?> 
            <div class="alert alert-<?php echo $alerta; ?> mt-5"> 
                <?php 
                    // Si el estado es "En Preparación", entonces bligatorio llenar todos los campos
                    if ($contrato['ecEstadoContrato'] == "En Preparación") {
                        echo "<br><h6 class='mb-4 text-secondary' >Todos los campos son obligatorios </h6>";
                    }
                    // Caso contrario (contrato firmado, cancelado, activo, etc), campos deshabilitados:
                    else {
                        echo "<br><h6 class='mb-4' style='color: #d62606;' >El contrato ya fue firmado o cancelado </h6>";
                    }
                ?>     
            </div><br><br>

            <!-- Formulario para modificar el contrato -->
            <form method="POST">

                <div class="mb-3">
                    <label for="idcontrato" class="form-label">Contrato</label>
                    <input type="text" class="form-control" id="idcontrato" name="IdContrato" 
                        value="Identificador del contrato: <?php echo htmlspecialchars($contrato['cIdContrato']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="NombreCompletoCliente" 
                        value="<?php echo htmlspecialchars($contrato['clApellidoCliente']); echo ", "; 
                                      echo htmlspecialchars($contrato['clNombreCliente']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="documento" class="form-label">Documento del Cliente</label>
                    <input type="text" class="form-control" id="documento" name="DocumentoCliente" 
                        value=" <?php echo htmlspecialchars($contrato['clDniCliente']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="vehiculosdisponibles" class="form-label"> Vehículos disponibles </label>
                    <select class="form-select" aria-label="Selector" id="vehiculosdisponibles" 
                            name="VehiculosDisponibles" 
                            <?php 
                                // Si el estado es "En Preparación", entonces obligatorio llenar el campo
                                if ($contrato['ecEstadoContrato'] == "En Preparación") {
                                    echo "required";
                                }
                                // Caso contrario (contrato firmado, cancelado, activo, etc), campo deshabilitado:
                                else {
                                    echo "title='El contrato ya fue firmado o cancelado' disabled";
                                }
                            ?>
                    >
                        <option value="" selected>Selecciona una opción</option>

                        <?php 
                        if (!empty($vehiculosDisponibles)) {
                            $selected = '';

                            for ($i = 0; $i < $cantidadVehiculos; $i++) {  
                                // Lógica para verificar si el grupo debe estar seleccionado
                                $selected = (!empty($contrato['vIdVehiculo']) && $contrato['vIdVehiculo'] == $vehiculosDisponibles[$i]['IdVehiculo']) ? 'selected' : '';
                                echo "<option value='{$vehiculosDisponibles[$i]['IdVehiculo']}' $selected > 
                                        MATRÍCULA: {$vehiculosDisponibles[$i]['matricula']} - {$vehiculosDisponibles[$i]['modelo']}, {$vehiculosDisponibles[$i]['grupo']}  
                                      </option>";
                            }
                        } 
                        else {
                            echo "<option value=''> En este momento no existen vehículos disponibles. </option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecharetiro" class="form-label">Fecha de Retiro</label>
                    <input type="date" class="form-control" id="fecharetiro" name="FechaRetiro" 
                        value="<?php echo htmlspecialchars($contrato['cFechaInicioContrato']); ?>" 
                        <?php 
                            // Si el estado es "En Preparación", entonces obligatorio llenar el campo
                            if ($contrato['ecEstadoContrato'] == "En Preparación") {
                                echo "required";
                            }
                            // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                            else {
                                echo "title='El contrato ya fue firmado o cancelado' disabled";
                            }
                        ?>
                    >
                </div>

                <div class="mb-3">
                    <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                    <input type="date" class="form-control" id="fechadevolucion" name="FechaDevolucion" 
                        value="<?php echo htmlspecialchars($contrato['cFechaFinContrato']); ?>" 
                        <?php 
                            // Si el estado es "En Preparación", entonces obligatorio llenar el campo
                            if ($contrato['ecEstadoContrato'] == "En Preparación") {
                                echo "required";
                            }
                            // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                            else {
                                echo "title='El contrato ya fue firmado o cancelado' disabled";
                            }
                        ?>
                    >
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
                               id="preciopordia" name="PrecioPorDia" title="Superior a $ 20 USD e inferior a $ 1000 USD"
                               value="<?php echo htmlspecialchars($contrato['dcPrecioPorDiaContrato']); ?>" 
                                <?php 
                                    // Si el estado es "En Preparación", entonces obligatorio llenar el campo
                                    if ($contrato['ecEstadoContrato'] == "En Preparación") {
                                        echo "required";
                                    }
                                    // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                                    else {
                                        echo "title='El contrato ya fue firmado o cancelado' disabled";
                                    }
                                ?>
                        > 
                        <span style="padding: 0 0 0 10px;"> $ USD por día </span>

                    </div> 
                </div>

                <div class="mb-3">
                    <label for="estadocontrato" class="form-label"> Estado del Contrato </label>
                    <select class="form-select" aria-label="Selector" id="estadocontrato" name="EstadoDelContrato" 
                        <?php 
                            // Si el estado es "En Preparación", entonces obligatorio llenar el campo
                            if ($contrato['ecEstadoContrato'] == "En Preparación") {
                                echo "required";
                            }
                            // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                            else {
                                echo "title='El contrato ya fue firmado o cancelado' disabled";
                            }
                        ?>
                    >
                        <option value="" selected>Selecciona una opción</option>

                        <?php 
                        if (!empty($estadosContrato)) {
                            $selected = '';

                            for ($i = 0; $i < $cantidadEstados; $i++) {
                                // Lógica para verificar si el grupo debe estar seleccionado
                                $selected = (!empty($contrato['ecIdEstadoContrato']) && $contrato['ecIdEstadoContrato'] == $estadosContrato[$i]['IdEstadoContrato']) ? 'selected' : '';
                                echo "<option value='{$estadosContrato[$i]['IdEstadoContrato']}' $selected > 
                                        {$estadosContrato[$i]['EstadoContrato']}  
                                      </option>";
                            }
                        } 
                        else {
                            echo "<option value=''> No se pueden recuperar los diferentes estados de un contrato. </option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" name="BotonModificarContrato" 
                        value="modificandoContrato"; 
                            <?php 
                                // Si el estado es "En Preparación", entonces obligatorio llenar el campo
                                if ($contrato['ecEstadoContrato'] == "En Preparación") {
                                    echo " ";
                                }
                                // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                                else {
                                    echo "disabled";
                                }
                            ?>
                        >
                    Guardar Cambios
                </button>
            </form>
        </div>

        <div style="margin-top: 100px;">
            <?php require_once "foot.php"; ?>
        </div>

    </div>

</body>
</html>