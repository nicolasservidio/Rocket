<?php

$MensajeModificacion = '';

function Corroborar_Modificacion($matri, $dispo, $model, $grup) {

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

        $mensaje = "Usted está queriendo modificar el vehiculo de matricula <strong>$matri</strong>.  <br><br>Parámetros: <br><br> 
                    <strong>Modelo:</strong> $model. <br>
                    <strong>Grupo:</strong> $grup. <br>
                    <strong>Disponibilidad:</strong> $disponibilidad. ";
        
        return $mensaje;
    } 
}

function Modificar_Vehiculo($matri, $dispo, $model, $grup, $conexion) {

    // Actualizar los datos del vehículo

    $SQL = "UPDATE vehiculos 
            SET disponibilidad='$dispo' 
            WHERE matricula='$matri'; ";

    $rs = mysqli_query($conexion, $SQL);

    if (!$rs) {
        //si surge un error, finalizo la ejecucion del script con un mensaje
        die('<h4>Error al intentar modificar el vehículo.</h4>');
    }

}

?>
