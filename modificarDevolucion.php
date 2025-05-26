<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();


// Primero se traen los datos de la Devolución para mostrar en pantalla y permitir modificar la oficina de devolución
if (isset($_GET['id'])) {
    $idDevolucion = $_GET['id'];

    $devolucion = array();

    $SQL = "SELECT dv.idDevolucion as dvIdDevolucion,
                    dv.fechaDevolucion as dvFechaDevolucion,
                    dv.horaDevolucion as dvHoraDevolucion,
                    dv.idCliente as dvIdCliente,
                    dv.idContrato as dvIdContrato,
                    dv.estadoDevolucion as dvEstadoDevolucion,
                    dv.aclaracionesDevolucion as dvAclaracionesDevolucion,
                    dv.infraccionesDevolucion as dvInfraccionesDevolucion,
                    dv.costosInfracciones as dvCostosInfracciones,
                    dv.montoExtra as dvMontoExtra,
                    dv.actualizacion as dvActualizacion,
                    
                    ca.idContrato as caIdContrato, 
                    ca.idCliente as caIdCliente,
                    ca.idVehiculo as caIdVehiculo,
                    ca.idEstadoContrato as caIdEstadoContrato,

                    c.idCliente as cIdCliente,
                    c.nombreCliente as cNombreCliente,
                    c.apellidoCliente as cApellidoCliente,
                    c.dniCliente as cDniCliente,

                    ec.idEstadoContrato as ecIdEstadoContrato,
                    ec.estadoContrato as ecEstadoContrato,
                    ec.descripcionEstadoContrato as ecDescripcionEstadoContrato,

                    v.idVehiculo as IdVehiculo,
                    v.matricula as matricula,
                    v.disponibilidad, 
                    v.idModelo,
                    v.idGrupoVehiculo,
                    v.idSucursal as vIdSucursal,

                    m.idModelo, 
                    m.nombreModelo as modelo, 
                    m.descripcionModelo, 

                    g.idGrupo,
                    g.nombreGrupo as grupo,

                    s.idSucursal as sIdSucursal,
                    s.numeroSucursal as sNumeroSucursal,
                    s.direccionSucursal as sDireccionSucursal,
                    s.ciudadSucursal as sCiudadSucursal,
                    s.telefonoSucursal as sTelSucursal 
                FROM `devoluciones-vehiculos` dv, `contratos-alquiler` ca, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g, sucursales s, `estados-contratos` ec 
                WHERE dv.idDevolucion = $idDevolucion 
                AND c.idCliente = dv.idCliente 
                AND ca.idContrato = dv.idContrato 
                AND ca.idCliente = c.idCliente 
                AND ca.idVehiculo = v.idVehiculo 
                AND v.idModelo = m.idModelo 
                AND v.idGrupoVehiculo = g.idGrupo 
                AND v.idSucursal = s.idSucursal 
                AND ca.IdEstadoContrato = ec.idEstadoContrato; ";


    $rs = mysqli_query($conexion, $SQL);

    $devolucion = mysqli_fetch_array($rs);

    // Se almacena la variable que define si podemos actualizar el vehículo (solo se permite una modificación de cada registro)
    $actualizado = $devolucion['dvActualizacion'];

    // Se traen todas las sucursales disponibles:
    $sucursalesDisponibles = array();
    
    require_once 'funciones/Select_Tablas.php';
    $sucursalesDisponibles = Listar_Sucursal($conexion);
    $cantidadSucursales = count($sucursalesDisponibles);

} 

else {
    // Si no se pasa un ID, se redirige al listado de devoluciones
    header("Location: devolucionVehiculo.php?mensaje=No se encontró la devolucion seleccionada");
    exit();
}


// Por último se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden del form debajo)
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarEntrega'])) {

    $idVehiculo = $devolucion['IdVehiculo'];  // El vehículo devuelto por el cliente
    $idSucursal = $_POST['SucursalesDisponibles']; // La nueva sucursal seleccionada del combo box

    $idContratoAsociado = $devolucion['dvIdContrato']; // El id del contrato asociado a la devolución

    $id_Devolucion = $_POST['IdDevolucion']; 
    $estadoDevolucion = $_POST['EstadoDevolucion']; 
    $aclaracionesDevolucion = $_POST['AclaracionesDevolucion']; 
    $infraccionesDevolucion = $_POST['InfraccionesDevolucion'];
    $costosInfracciones = $_POST['CostosInfracciones']; 
    $montoExtra = $_POST['MontoExtra']; 
    

    $mensajeError = ' ';

    // MODIFICANDO LA SUCURSAL DE DEVOLUCIÓN

    $ModificacionSucursal = "UPDATE vehiculos
                                SET idSucursal = $idSucursal 
                                WHERE idVehiculo = $idVehiculo; "; 

    $rs = mysqli_query($conexion, $ModificacionSucursal);

    if (!$rs) {
        $mensajeError = "No se pudo acceder al vehículo y correspondiente sucursal en la BD. ";
    }

    // MODIFICANDO Condiciones de devolucion

    $ModificacionEstadoDevolucion = "UPDATE `devoluciones-vehiculos` 
                                        SET estadoDevolucion = '$estadoDevolucion', 
                                            aclaracionesDevolucion = '$aclaracionesDevolucion', 
                                            infraccionesDevolucion = '$infraccionesDevolucion', 
                                            costosInfracciones = '$costosInfracciones', 
                                            montoExtra = '$montoExtra', 
                                            actualizacion = 'S' 
                                        WHERE idDevolucion = $id_Devolucion; "; 

    $rs = mysqli_query($conexion, $ModificacionEstadoDevolucion);

    if (!$rs) {

        $mensajeError .= "No se pudo actualizar el estado de la devolucion";
        header("Location: devolucionVehiculo.php?mensaje=" . urlencode($mensajeError));
        exit();
    }
    else {

        // Redirigir después de la actualización
        $mensajeError = "La devolución correspondiente al contrato número {$idContratoAsociado} fue modificada exitosamente.";
        echo "<script> 
            alert('$mensajeError');
            window.location.href = 'devolucionVehiculo.php?NumeroContrato={$idContratoAsociado}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoDevolucion';
        </script>";
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
                        echo "Error al intentar modificar la devolución. <br><br>"; 
                        echo $mensajeError; 
                    ?>        
                </div>
            <?php 
            } 
            ?>

            <h5 class="mb-4 text-secondary">
                <strong>Modificar Devolución</strong>
            </h5>

            <!-- ALERTA -->
            <?php 
                $alerta = "";

                if($actualizado == "S") {
                    $alerta = "danger";
                }
                if($actualizado == "N") {
                    $alerta = "success";
                }
            ?> 
            <div class="alert alert-<?php echo $alerta; ?> mt-5"> 
                <?php 
                    // Si "actualizado" contiene "S", entonces el registro ya fue modificado previamente y no se puede volver a modificar. Alerta señala que no se pueden realizar modificaciones: 
                    if ($actualizado == "S") {
                        echo "<br><h6 class='mb-4' style='color: #d62606;' >No se pueden realizar cambios porque el registro de devolución ya fue modificado una vez </h6>";
                    }
                    // Caso contrario, campos habilitados y alerta señala que deben llenarse obligatoriamente:
                    if ($actualizado == "N") {
                        echo "<br><h6 class='mb-4 text-secondary' >Recordá que solo podés realizar una modificación del registro. Es obligatorio completar todos los campos. </h6>"; 
                    }
                ?>     
            </div><br><br>
            
            <!-- Formulario para modificar la devolución -->
            <form method="POST">

                <div class="mb-3">
                    <label for="idcontrato" class="form-label">Nº Contrato</label>
                    <input type="text" class="form-control" id="idcontrato" name="IdContrato" 
                        value="Identificador del contrato: <?php echo htmlspecialchars($devolucion['dvIdContrato']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                    <input type="date" class="form-control" id="fechadevolucion" name="FechaDevolucion" 
                        value="<?php echo htmlspecialchars($devolucion['dvFechaDevolucion']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="horadevolucion" class="form-label">Hora de Devolución</label>
                    <input type="text" class="form-control" id="horadevolucion" name="HoraDevolucion" 
                        value="<?php echo htmlspecialchars($devolucion['dvHoraDevolucion']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="NombreCompletoCliente" 
                        value="<?php echo htmlspecialchars($devolucion['cApellidoCliente']); echo ", "; 
                                      echo htmlspecialchars($devolucion['cNombreCliente']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="documento" class="form-label">Documento del Cliente</label>
                    <input type="text" class="form-control" id="documento" name="DocumentoCliente" 
                        value=" <?php echo htmlspecialchars($devolucion['cDniCliente']); ?> " disabled>
                </div>
                
                <div class="mb-3">
                    <label for="vehiculo" class="form-label">Vehículo</label>
                    <input type="text" class="form-control" id="vehiculo" name="VehiculoDevuelto" 
                        value="<?php  echo "Patente: "; echo htmlspecialchars($devolucion['matricula']); echo ". Vehículo: "; 
                                      echo htmlspecialchars($devolucion['modelo']); echo ", ";
                                      echo htmlspecialchars($devolucion['grupo']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="sucursalesdisponibles" class="form-label"> Oficina de Devolución </label>
                    <select class="form-select" aria-label="Selector" id="sucursalesdisponibles" 
                            name="SucursalesDisponibles"
                            <?php 
                                // Si la devolución ya fue modificada, campo deshabilitado: 
                                if ($actualizado == "S") {
                                    echo "title='La devolución ya fue modificada. No puede modificarse nuevamente' disabled";
                                }
                                // caso contrario obligatorio llenar el campo 
                                if ($actualizado == "N") {                                    
                                    echo "required";
                                }
                            ?>
                    >
                        <option value="" selected>Selecciona una opción</option>
                        <?php 
                        if (!empty($sucursalesDisponibles)) {
                            $selected = '';

                            for ($i = 0; $i < $cantidadSucursales; $i++) {  
                                // Lógica para verificar si el grupo debe estar seleccionado
                                $selected = (!empty($devolucion['sIdSucursal']) && $devolucion['sIdSucursal'] == $sucursalesDisponibles[$i]['IdSucursal']) ? 'selected' : '';
                                echo "<option value='{$sucursalesDisponibles[$i]['IdSucursal']}' $selected > 
                                        {$sucursalesDisponibles[$i]['CiudadSucursal']} - {$sucursalesDisponibles[$i]['DireccionSucursal']} 
                                      </option>";
                            }
                        } 
                        else {
                            echo "<option value=''> No se encuentran sucursales disponibles. </option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="iddevolucion" class="form-label">  </label>
                    <input type="hidden" class="form-control" id="iddevolucion" name="IdDevolucion" 
                        value=" <?php echo htmlspecialchars($devolucion['dvIdDevolucion']); ?> ">
                </div>

                <div class="mb-3">
                    <label for="estadodevolucion" class="form-label">Estado del vehículo durante la Devolución </label>
                    <input type="text" class="form-control" id="estadodevolucion" name="EstadoDevolucion" 
                        value="<?php echo htmlspecialchars($devolucion['dvEstadoDevolucion']); ?>" 
                        <?php 
                            // Si la devolución ya fue modificada, campo deshabilitado: 
                            if ($actualizado == "S") {
                                echo "title='La devolución ya fue modificada. No puede modificarse nuevamente' disabled";
                            }
                            // caso contrario obligatorio llenar el campo 
                            if ($actualizado == "N") {                                    
                                echo "required";
                            }
                        ?>
                    >
                </div>

                <div class="mb-3">
                    <label for="aclaracionesdevolucion" class="form-label">Aclaraciones sobre el estado del vehículo </label>
                    <textarea class="form-control" id="aclaracionesdevolucion" name="AclaracionesDevolucion" 
                        rows="5" cols="33" value="<?php echo htmlspecialchars($devolucion['dvAclaracionesDevolucion']); ?>"
                        <?php 
                            // Si la devolución ya fue modificada, campo deshabilitado: 
                            if ($actualizado == "S") {
                                echo "title='La devolución ya fue modificada. No puede modificarse nuevamente' disabled";
                            }
                            // caso contrario obligatorio llenar el campo 
                            if ($actualizado == "N") {                                    
                                echo "required";
                            }
                        ?>
                    ><?php echo htmlspecialchars($devolucion['dvAclaracionesDevolucion']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="infraccionesdevolucion" class="form-label">Infracciones asociadas a la Devolución </label>
                    <input type="text" class="form-control" id="infraccionesdevolucion" name="InfraccionesDevolucion" 
                        title="Una o múltiples" 
                        value="<?php echo htmlspecialchars($devolucion['dvInfraccionesDevolucion']); ?>" 
                        <?php 
                            // Si la devolución ya fue modificada, campo deshabilitado: 
                            if ($actualizado == "S") {
                                echo "disabled";
                            }
                            // caso contrario obligatorio llenar el campo 
                            if ($actualizado == "N") {                                    
                                echo "required";
                            }
                        ?>
                    >
                </div>

                <div class="mb-3">
                    <label for="costosinfracciones" class="form-label">Costos asociados a infracciones</label>
                    <input type="number" step=".01" class="form-control" id="costosinfracciones" name="CostosInfracciones" 
                        title="Cantidad exacta que se debe cubrir con terceros como consecuencia de las infracciones"
                        value="<?php echo htmlspecialchars($devolucion['dvCostosInfracciones']); ?>"
                        <?php 
                            // Si la devolución ya fue modificada, campo deshabilitado: 
                            if ($actualizado == "S") {
                                echo "disabled";
                            }
                            // caso contrario obligatorio llenar el campo 
                            if ($actualizado == "N") {                                    
                                echo "required";
                            }
                        ?>
                    >
                </div>

                <div class="mb-3">
                    <label for="montoextra" class="form-label">Monto adicional</label>
                    <input type="number" step=".01" class="form-control" id="montoextra" name="MontoExtra" title="Sin considerar costos asociados a infracciones"
                        value="<?php echo htmlspecialchars($devolucion['dvMontoExtra']); ?>"
                        <?php 
                            // Si la devolución ya fue modificada, campo deshabilitado: 
                            if ($actualizado == "S") {
                                echo "disabled";
                            }
                            // caso contrario obligatorio llenar el campo 
                            if ($actualizado == "N") {                                    
                                echo "required";
                            }
                        ?>
                    >
                </div>

                <button type="submit" class="btn btn-dark" name="BotonModificarEntrega" 
                        value="modificandoEntrega"; 
                        <?php 
                            // Si la devolución ya fue modificada, boton deshabilitado: 
                            if ($actualizado == "S") {
                                echo "disabled";
                            }
                            // caso contrario  
                            if ($actualizado == "N") {                                    
                                echo " ";
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