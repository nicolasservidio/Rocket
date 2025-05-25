<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Primero se traen los datos de la Entrega para mostrar en pantalla y permitir modificar la oficina de retiro
if (isset($_GET['id'])) {
    $idEntrega = $_GET['id'];

    $entrega = array();

    // Obtener los datos del contrato seleccionado
    $SQL = "SELECT ev.idEntrega as evIdEntrega,
                    ev.fechaEntrega as evFechaEntrega,
                    ev.horaEntrega as evHoraEntrega,
                    ev.idCliente as evIdCliente,
                    ev.idContrato as evIdContrato,
                    
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
                FROM `entregas-vehiculos` ev, `contratos-alquiler` ca, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g, sucursales s, `estados-contratos` ec 
                WHERE ev.idEntrega = $idEntrega
                AND c.idCliente = ev.idCliente 
                AND ca.idContrato = ev.idContrato 
                AND ca.idCliente = c.idCliente 
                AND ca.idVehiculo = v.idVehiculo 
                AND v.idModelo = m.idModelo 
                AND v.idGrupoVehiculo = g.idGrupo 
                AND v.idSucursal = s.idSucursal 
                AND ca.IdEstadoContrato = ec.idEstadoContrato; ";


    $rs = mysqli_query($conexion, $SQL);

    $entrega = mysqli_fetch_array($rs);

    // Se traen todas las sucursales disponibles:
    $sucursalesDisponibles = array();
    
    require_once 'funciones/Select_Tablas.php';
    $sucursalesDisponibles = Listar_Sucursal($conexion);
    $cantidadSucursales = count($sucursalesDisponibles);

} 

else {
    // Si no se pasa un ID, se redirige al listado de entregas
    header("Location: entregaVehiculo.php?mensaje=No se encontró la entrega seleccionada. ");
    exit();
}



// Por último se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden del form debajo)
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarEntrega'])) {

    $idVehiculo = $entrega['IdVehiculo'];  // El vehículo retirado por el cliente
    $idSucursal = $_POST['SucursalesDisponibles']; // La nueva sucursal seleccionada del combo box
    $identificadorContrato = $entrega['evIdContrato'];


    $ModificacionSucursal = "UPDATE vehiculos 
                                SET idSucursal = $idSucursal 
                                WHERE idVehiculo = $idVehiculo; "; 

    $rs = mysqli_query($conexion, $ModificacionSucursal);

    if (!$rs) {

        $mensajeError = "No se pudo acceder al vehículo y su correspondiente sucursal en la base de datos";
        header("Location: entregaVehiculo.php?mensaje=" . urlencode($mensajeError));
        exit();
    }
    else {

        // Redirigir después de la actualización
        $mensajeError = "Se modificó exitosamente la oficina de retiro (sucursal) en la que se entregará el vehículo al cliente. Número de contrato asociado: {$identificadorContrato}. ";
        echo "<script> 
            alert('$mensajeError');
            window.location.href = 'entregaVehiculo.php?NumeroContrato={$identificadorContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&EntregaDesde=&EntregaHasta=&BotonFiltrar=FiltrandoEntregas';
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
                        echo "Error al intentar modificar la entrega. <br><br>"; 
                        echo $mensajeError; 
                    ?>        
                </div>
            <?php 
            } 
            ?>

            <h5 class="mb-4 text-secondary">
                <strong>Modificar oficina de retiro asociada a la la Entrega</strong>
            </h5>
            
            <!-- ALERTA -->
            <?php 
                $alerta = "";

                if($entrega['ecEstadoContrato'] == "Renovado" || $entrega['ecEstadoContrato'] == "Finalizado") {
                    $alerta = "danger";
                }
                else {
                    $alerta = "success";
                }
            ?> 
            <div class="alert alert-<?php echo $alerta; ?> mt-5"> 
                <?php 
                    // Si el estado del contrato es "Renovado" o "Finalizado", alerta señala que no se pueden realizar modificaciones 
                    if ($entrega['ecEstadoContrato'] == "Renovado" || $entrega['ecEstadoContrato'] == "Finalizado") {
                        echo "<br><h6 class='mb-4' style='color: #d62606;' >El vehículo ya fue entregado o el contrato finalizó </h6>";
                    }
                    // Caso contrario, campo habilitado y alerta señala que debe llenarse obligatoriamente:
                    else { 
                        echo "<br><h6 class='mb-4 text-secondary' >Es obligatorio especificar la oficina de retiro </h6>"; 
                    }
                ?>     
            </div><br><br>


            <!-- Formulario para modificar la oficina de retiro -->
            <form method="POST">

                <div class="mb-3">
                    <label for="idcontrato" class="form-label">Nº Contrato</label>
                    <input type="text" class="form-control" id="idcontrato" name="IdContrato" 
                        value="Identificador del contrato: <?php echo htmlspecialchars($entrega['evIdContrato']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="fechaentrega" class="form-label">Fecha de Entrega</label>
                    <input type="date" class="form-control" id="fechaentrega" name="FechaEntrega" 
                        value="<?php echo htmlspecialchars($entrega['evFechaEntrega']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="horaentrega" class="form-label">Hora de Entrega</label>
                    <input type="text" class="form-control" id="horaentrega" name="HoraEntrega" 
                        value="<?php echo htmlspecialchars($entrega['evHoraEntrega']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="NombreCompletoCliente" 
                        value="<?php echo htmlspecialchars($entrega['cApellidoCliente']); echo ", "; 
                                      echo htmlspecialchars($entrega['cNombreCliente']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="documento" class="form-label">Documento del Cliente</label>
                    <input type="text" class="form-control" id="documento" name="DocumentoCliente" 
                        value=" <?php echo htmlspecialchars($entrega['cDniCliente']); ?> " disabled>
                </div>
                
                <div class="mb-3">
                    <label for="vehiculo" class="form-label">Vehículo</label>
                    <input type="text" class="form-control" id="vehiculo" name="VehiculoEntregado" 
                        value="<?php  echo "Patente: "; echo htmlspecialchars($entrega['matricula']); echo ". Vehículo: "; 
                                      echo htmlspecialchars($entrega['modelo']); echo ", ";
                                      echo htmlspecialchars($entrega['grupo']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="sucursalesdisponibles" class="form-label"> Oficina de Retiro </label>
                    <select class="form-select" aria-label="Selector" id="sucursalesdisponibles" 
                            name="SucursalesDisponibles"
                            <?php 
                                // Si el estado del contrato es "Renovado" o "Finalizado", entonces 
                                // no se puede cambiar la oficina de retiro. Campo deshabilitado:
                                if ($entrega['ecEstadoContrato'] == "Renovado" || $entrega['ecEstadoContrato'] == "Finalizado") {
                                    echo "title='El vehículo ya fue entregado o el contrato finalizó' disabled";
                                }
                                // caso contrario obligatorio llenar el campo 
                                else {                                    
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
                                $selected = (!empty($entrega['sIdSucursal']) && $entrega['sIdSucursal'] == $sucursalesDisponibles[$i]['IdSucursal']) ? 'selected' : '';
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

                <button type="submit" class="btn btn-dark" name="BotonModificarEntrega" 
                        value="modificandoEntrega"; 
                        <?php 
                            // Si el estado del contrato es "Renovado" o "Finalizado", entonces 
                            // no se puede cambiar la oficina de retiro. Campo deshabilitado:
                            if ($entrega['ecEstadoContrato'] == "Renovado" || $entrega['ecEstadoContrato'] == "Finalizado") {
                                echo "disabled";
                            }
                            // caso contrario obligatorio llenar el campo 
                            else {                                    
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