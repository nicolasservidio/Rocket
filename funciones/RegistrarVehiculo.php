<?php

function Registrar_Vehiculo($matricula, $modelo, $grupo, $disponible, $conn) {

    // Preprocesamiento
    $matricula = trim($matricula);
    $matricula = strip_tags($matricula);

    // Validaciones
    if (empty($matricula)) {

        // Redirigir con un mensaje
        $mensaje = "Registro fallido. Debe especificar una matrícula. ";
        echo "<script> 
              alert('$mensaje');
              window.location.href = 'OpVehiculos.php';
        </script>";
        exit(); 
    }
    if (strlen($matricula) > 12) {

        // Redirigir con un mensaje
        $mensaje = "Registro fallido. La matrícula no puede exceder los 12 caracteres. ";
        echo "<script> 
              alert('$mensaje');
              window.location.href = 'OpVehiculos.php';
        </script>";
        exit(); 
    }

    // Validación de matrícula existente
    $SQL_verificarMatricula = "SELECT COUNT(*) AS total FROM vehiculos WHERE matricula = '$matricula'";
    $resultado = mysqli_query($conn, $SQL_verificarMatricula);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila['total'] > 0) {
        $mensaje = "Registro fallido. La matrícula ya está registrada en el sistema.";
        echo "<script>alert('$mensaje'); window.location.href = 'OpVehiculos.php';</script>";
        exit();
    }

    // Inserto en la BD
    $SQL = "INSERT INTO vehiculos (matricula, fechaCompra, idModelo, idGrupoVehiculo, disponibilidad, idCombustible, idSucursal) 
            VALUES ('$matricula', NOW(), $modelo, $grupo, '$disponible', 9, 3); ";
    
    $rs = mysqli_query($conn, $SQL);

    if (!$rs) {
        //si surge un error, finalizo la ejecucion del script con un mensaje
        die('<h4>Error al intentar agregar el vehículo.</h4>');
    }

    // Recuperar el ID del vehículo recién insertado
    $id_vehiculo = mysqli_insert_id($conn);
    
    return $id_vehiculo;

}

?>