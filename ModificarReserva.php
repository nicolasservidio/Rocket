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
                        r.idCliente as IDCliente,
                        r.idVehiculo as IDVehiculo,
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
                 WHERE idReserva = $idReserva 
                 AND r.idCliente = c.idCliente 
                 AND r.idVehiculo = v.idVehiculo 
                 AND v.idModelo = m.idModelo 
                 AND v.idGrupoVehiculo = g.idGrupo; ";


    $rs = mysqli_query($conexion, $ConsultaReservas);

    $reserva = mysqli_fetch_array($rs);

    // Se traen todos los vehículos disponibles:

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
/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCliente = $_POST['idCliente'];
    $numreserva = $_POST['numreserva'];
    $idVehiculo = $_POST['idVehiculo'];
    $fecharetiro = $_POST['fecharetiro'];
    $fechadevolucion = $_POST['fechadevolucion'];

    // Actualizar los datos del cliente
    $consulta = "UPDATE `reservas-vehiculos` 
                 SET numeroReserva = ?, idVehiculo = ?, mailCliente = ?, telefonoCliente = ?, direccionCliente = ? 
                 WHERE idCliente = ?";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $direccion, $idReserva);
    $stmt->execute();

    // Redirigir después de la actualización
    header('Location: clientes.php');
    exit();
}
*/

?>

<body class="bg-light">
    <div class="wrapper">
        <?php include('sidebarGOp.php'); include('topNavBar.php'); ?>
        
        <div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm">
            <h5 class="mb-4 text-secondary"><strong>Modificar Reserva</strong></h5>

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
                    <select class="form-select" aria-label="Selector" id="vehiculosdisponibles" name="VehiculosDisponibles" >
                        <option value="" selected>Selecciona una opción</option>

                        <?php 
                        if (!empty($vehiculosDisponibles)) {
                            $selected = '';

                            for ($i = 0; $i < $cantidadVehiculos; $i++) {
                                // Lógica para verificar si el grupo debe estar seleccionado
                                $selected = (!empty($_POST['VehiculosDisponibles']) && $_POST['VehiculosDisponibles'] == $vehiculosDisponibles[$i]['IdVehiculo']) ? 'selected' : '';
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
                           value=" <?php echo htmlspecialchars($reserva['FechaRetiro']); ?> " required>
                </div>

                <div class="mb-3">
                    <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                    <input type="date" class="form-control" id="fechadevolucion" name="FechaDevolucion" 
                           value=" <?php echo htmlspecialchars($reserva['FechaDevolucion']); ?> " required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>

        </div>
    </div>

</body>
</html>