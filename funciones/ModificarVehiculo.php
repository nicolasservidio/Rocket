<?php

$MensajeModificacion = '';

function Corroborar_Modificacion($matri, $dispo, $model, $grup, $combus, $sucurs) {

    // Verificar si se recibieron los datos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $disponibilidad = '';
        if (empty($dispo) || $dispo == "N") {
            $dispo = "N";
            $disponibilidad = "No";
        }
        else {
            $dispo = "S";
            $disponibilidad = "Sí";
        }

        $model = trim($model);
        $grup = trim($grup);
        $model = strip_tags($model);
        $grup = strip_tags($grup);

        if (empty($model)) {
            $model = "empty";
        }

        if (empty($grup)) {
            $grup = "empty";
        }

        if (empty($combus)) {
            $combus = "empty";
        }

        if (empty($sucurs)) {
            $sucurs = "empty";
        }

        // este mensaje no se muestra ni sirve para nada en el código, me sobró de una implementación que no funcionó. Lo dejo por si sirve a futuro
        $mensaje = "Usted está queriendo modificar el vehiculo de matricula <strong>$matri</strong>.  <br><br>Parámetros: <br><br> 
                    <strong>Modelo:</strong> $model. <br>
                    <strong>Grupo:</strong> $grup. <br>
                    <strong>Grupo:</strong> $combus. <br>
                    <strong>Grupo:</strong> $sucurs. <br>
                    <strong>Disponibilidad:</strong> $disponibilidad. "; 
        
        return $mensaje;
    } 
}



function Modificar_Vehiculo($matri, $dispo, $model, $grup, $combus, $sucurs, $conexion) {

    // Modificar la DISPONIBILIDAD del vehiculo
    $SQL = "UPDATE vehiculos 
            SET disponibilidad='$dispo' 
            WHERE matricula='$matri'; ";

    $rs = mysqli_query($conexion, $SQL);

    if (!$rs) {
        //si surge un error, finalizo la ejecucion del script con un mensaje
        die('<h4>Error al intentar modificar el vehículo.</h4>');
    }



    // Modificar el MODELO del vehiculo
    if ($model != "empty") {

        $SQL = "UPDATE vehiculos 
        SET idModelo = $model 
        WHERE matricula='$matri'; ";

        $rs = mysqli_query($conexion, $SQL);

        if (!$rs) {
            //si surge un error, finalizo la ejecucion del script con un mensaje
            die('<h4>Error al intentar modificar el vehículo.</h4>');
        }
    }



    // Modificar el GRUPO del vehiculo
    if ($grup != "empty") {

        $SQL = "UPDATE vehiculos 
        SET idGrupoVehiculo = $grup 
        WHERE matricula='$matri'; ";

        $rs = mysqli_query($conexion, $SQL);

        if (!$rs) {
            //si surge un error, finalizo la ejecucion del script con un mensaje
            die('<h4>Error al intentar modificar el vehículo.</h4>');
        }
    }


    // Modificar el COMBUSTIBLE del vehiculo
    if ($combus != "empty") {

        $SQL = "UPDATE vehiculos 
        SET idCombustible = $combus 
        WHERE matricula='$matri'; ";

        $rs = mysqli_query($conexion, $SQL);

        if (!$rs) {
            //si surge un error, finalizo la ejecucion del script con un mensaje
            die('<h4>Error al intentar modificar el vehículo.</h4>');
        }
    }


    // Modificar la SUCURSAL del vehiculo
    if ($sucurs != "empty") {

        $SQL = "UPDATE vehiculos 
        SET idSucursal = $sucurs 
        WHERE matricula='$matri'; ";

        $rs = mysqli_query($conexion, $SQL);

        if (!$rs) {
            //si surge un error, finalizo la ejecucion del script con un mensaje
            die('<h4>Error al intentar modificar el vehículo.</h4>');
        }
    }

}

?>
