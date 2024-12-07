<?php

function Registrar_Vehiculo($matricula, $modelo, $grupo, $disponible, $conn) {

    // Preprocesamiento
    $matricula = trim($matricula);
    $matricula = strip_tags($matricula);

    // Validaciones
    if (strlen($matricula) > 7 || empty($matricula)) {

        $matricula = "0000000";
    }

    if (!empty($matricula)) {

        // Inserto en la BD
        $SQL = "INSERT INTO vehiculos (matricula, fechaCompra, idModelo, idGrupoVehiculo, disponibilidad, idCombustible, idSucursal) 
                VALUES ('$matricula', NOW(), $modelo, $grupo, '$disponible', 9, 3); ";
        

        $rs = mysqli_query($conn, $SQL);

        if (!$rs) {
            //si surge un error, finalizo la ejecucion del script con un mensaje
            die('<h4>Error al intentar agregar el vehículo.</h4>');
        }
    }
}

?>