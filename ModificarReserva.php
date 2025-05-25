<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Primero se traen los datos de la reserva y de vehículos disponibles para mostrar en pantalla y permitir la selección
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    $reserva = array();

    // Obtener los datos de la reserva
    $ConsultaReservas = "SELECT r.idReserva,
                        r.numeroReserva as NumeroReserva,
                        r.fechaInicioReserva as FechaRetiro,
                        r.FechaFinReserva as FechaDevolucion,
                        r.precioPorDiaReserva as PrecioDiario,
                        r.idCliente as IDCliente,
                        r.idVehiculo as IDVehiculo,
                        r.idContrato as IDContrato,
                        c.idCliente,
                        c.nombreCliente as NombreCliente,
                        c.apellidoCliente as ApellidoCliente,
                        c.nacionalidadCliente, 
                        c.dniCliente as DocumentoCliente,
                        v.idVehiculo,
                        v.matricula as Matricula,
                        v.disponibilidad as Disponibilidad,
                        v.idModelo,
                        v.idGrupoVehiculo,
                        m.idModelo, 
                        m.nombreModelo as Modelo,
                        m.descripcionModelo,
                        g.idGrupo,
                        g.nombreGrupo as Grupo,
                        g.descripcionGrupo 
                 FROM `reservas-vehiculos` r, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g 
                 WHERE r.idReserva = $idReserva 
                 AND r.idCliente = c.idCliente 
                 AND r.idVehiculo = v.idVehiculo 
                 AND v.idModelo = m.idModelo 
                 AND v.idGrupoVehiculo = g.idGrupo; ";


    $rs = mysqli_query($conexion, $ConsultaReservas);

    $reserva = mysqli_fetch_array($rs);

    // Además se trae el contrato asociado a la reserva, en caso de existir, para corroborar si el estado es "En Preparación"
    $estadoContrato = "";

    if(!empty($reserva['IDContrato'])) {

        $idContrato = $reserva['IDContrato'];

        $contrato = array();

        // Obtener los datos del contrato
        $ConsultaContrato = "SELECT co.idContrato,
                                    co.idEstadoContrato as IdEstadoContrato,
                                    e.idEstadoContrato,
                                    e.estadoContrato as EstadoContrato,
                                    e.descripcionEstadoContrato as DescripcionEstado 
                    FROM `contratos-alquiler` co, `estados-contratos` e 
                    WHERE co.idContrato = $idContrato 
                    AND e.idEstadoContrato = co.idEstadoContrato; ";

        $rs = mysqli_query($conexion, $ConsultaContrato);

        $contrato = mysqli_fetch_array($rs);
        
        if ($contrato['EstadoContrato'] == "En Preparación") {
            $estadoContrato = "En Preparación";
        }
    }
    else {
        $estadoContrato = "No existe";
    }

    // Se traen todos los vehículos disponibles para dropdown list:
    $vehiculosDisponibles = array();
    
    require_once 'funciones/Select_Tablas.php';
    $vehiculosDisponibles = Listar_Vehiculos_Disponibles($conexion);
    $cantidadVehiculos = count($vehiculosDisponibles);
} 

else {
    // Si no se pasa un ID, se redirige al listado de reservas
    header('Location: reservas.php');
    exit();
}


// A continuación se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden de este mismo archivo)
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarReserva'])) {

    $idCliente = $reserva['IDCliente'];
    $numreserva = $reserva['NumeroReserva'];
    $idVehiculo = $_POST['VehiculosDisponibles'];
    $precioDiarioReserva = $reserva['PrecioDiario'];

    
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
            window.location.href = 'reservas.php';
        </script>";
        exit();
    }

    // Se calcula cantidad de días de reserva
    $fechaInicial = new DateTime($_POST['FechaRetiro']);
    $fechaFinal = new DateTime($_POST['FechaDevolucion']);
    // Calcular la diferencia de días
    $intervalo = $fechaInicial->diff($fechaFinal);
    $diferenciaDias = $intervalo->days; // Obtiene la cantidad de días exacta
    // Se calcula monto total
    $montoTotal = $precioDiarioReserva * $diferenciaDias;

    // Se cambia formato de las fechas y se almacenan para el update:
    $fechaEspanol = $_POST['FechaRetiro'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year-$mo-$day";
    $fecharetiro = $fechaIngles;

    $fechaEspanol = $_POST['FechaDevolucion'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year-$mo-$day";
    $fechadevolucion = $fechaIngles;

    require_once 'funciones/CRUD-Reservas.php';
    
    if ($idVehiculo) {   

        // Actualizar los datos del cliente
        $ModificacionReserva = "UPDATE `reservas-vehiculos` 
                                SET numeroReserva = $numreserva, 
                                    fechaReserva = NOW(), 
                                    fechaInicioReserva = '$fecharetiro', 
                                    FechaFinReserva = '$fechadevolucion', 
                                    cantidadDiasReserva = '$diferenciaDias',
                                    totalReserva = '$montoTotal',
                                    idCliente = $idCliente, 
                                    idVehiculo = $idVehiculo 
                                WHERE idReserva = $idReserva"; 

        $rs = mysqli_query($conexion, $ModificacionReserva);

        if (!$rs) {

            $mensajeError = "No se pudo acceder a la base de datos. Error al intentar modificar la reserva";
            //si surge un error, finalizo la ejecucion del script con un mensaje 
            header("Location: reservas.php?mensaje=" . urlencode($mensajeError));
            exit();
        }
        else {

            // Redirigir después de la actualización
            $mensajeError = "Reserva número {$numreserva} modificada exitosamente.";
            echo "<script> 
                alert('$mensajeError');
                window.location.href = 'reservas.php?NumeroReserva={$numreserva}&MatriculaReserva=&ApellidoReserva=&NombreReserva=&DocReserva=&RetiroDesde=&RetiroHasta=&BotonFiltrar=FiltrandoReservas';
            </script>";
            exit();
        }
    }

    else {
        $mensajeError = "No se puede realizar la reserva.";
    }
}


?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

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
                        echo "Error al intentar modificar el vehículo. <br><br>"; 
                        echo $mensajeError; 
                    ?>        
                </div>
            <?php } 
            ?>

            <h5 class="mb-4 text-secondary"><strong>Modificar Reserva</strong></h5>

            <!-- ALERTA -->
            <?php 
                $alerta = "";

                if($estadoContrato == "En Preparación" || $estadoContrato == "No existe") {
                    $alerta = "success";
                }
                else {
                    $alerta = "danger";
                }
            ?> 
            <div class="alert alert-<?php echo $alerta; ?> mt-5"> 
                <?php 
                    // Si aún no hay contrato asociado a la reserva o el estado es "En Preparación", entonces 
                    // obligatorio llenar el campo
                    if ($estadoContrato == "En Preparación" || $estadoContrato == "No existe") {
                        echo "<br><h6 class='mb-4 text-secondary' >Todos los campos son obligatorios </h6>";
                    }
                    // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                    else {
                        echo "<br><h6 class='mb-4' style='color: #d62606;' >El contrato ya fue firmado o cancelado </h6>";
                    }
                ?>     
            </div><br><br>

            <!-- Formulario para modificar la reserva -->
            <form method="POST">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="NombreCliente" 
                        value=" <?php echo htmlspecialchars($reserva['NombreCliente']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="ApellidoCliente" 
                        value=" <?php echo htmlspecialchars($reserva['ApellidoCliente']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="text" class="form-control" id="documento" name="DocumentoCliente" 
                        value=" <?php echo htmlspecialchars($reserva['DocumentoCliente']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="numero" class="form-label">Número de Reserva</label>
                    <input type="text" class="form-control" id="numero" name="NumeroReserva" 
                        value=" <?php echo htmlspecialchars($reserva['NumeroReserva']); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="vehiculosdisponibles" class="form-label"> Vehículos disponibles </label>
                    <select class="form-select" aria-label="Selector" id="vehiculosdisponibles" 
                            name="VehiculosDisponibles" 
                            <?php 
                                // Si no hay contrato asociado a la reserva o el estado es "En Preparación", entonces 
                                // obligatorio llenar el campo
                                if ($estadoContrato == "En Preparación" || $estadoContrato == "No existe") {
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
                        if (!empty($vehiculosDisponibles)) {
                            $selected = '';

                            for ($i = 0; $i < $cantidadVehiculos; $i++) {
                                // Lógica para verificar si el grupo debe estar seleccionado
                                $selected = (!empty($reserva['IDVehiculo']) && $reserva['IDVehiculo'] == $vehiculosDisponibles[$i]['IdVehiculo']) ? 'selected' : '';
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
                        value="<?php echo htmlspecialchars($reserva['FechaRetiro']); ?>"  
                        <?php 
                            // Si no hay contrato asociado a la reserva o el estado es "En Preparación", entonces 
                            // obligatorio llenar el campo
                            if ($estadoContrato == "En Preparación" || $estadoContrato == "No existe") {
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
                        value="<?php echo htmlspecialchars($reserva['FechaDevolucion']); ?>" 
                        <?php 
                            // Si no hay contrato asociado a la reserva o el estado es "En Preparación", entonces 
                            // obligatorio llenar el campo
                            if ($estadoContrato == "En Preparación" || $estadoContrato == "No existe") {
                                echo "required";
                            }
                            // Caso contrario (contrato firmado, activo, etc), campo deshabilitado:
                            else {
                                echo "title='El contrato ya fue firmado o cancelado' disabled";
                            }
                        ?>
                    >
                </div>

                <button type="submit" class="btn btn-primary" name="BotonModificarReserva" 
                        value="modificandoReserva"; 
                        <?php 
                            // Si no hay contrato asociado a la reserva o el estado es "En Preparación", entonces 
                            // obligatorio llenar el campo
                            if ($estadoContrato == "En Preparación" || $estadoContrato == "No existe") {
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