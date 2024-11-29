<?php

if (!empty($BotonRegistrarVehiculo)) {

    // Conexión
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "rocket";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Registro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Capturo los datos
        $matricula = $_POST['MatriculaREG'];
        $modelo = $_POST['ModeloREG'];
        $grupo = $_POST['GrupoREG'];
        $disponible = $_POST['DisponibilidadREG'];

        // Preprocesamiento
        $matricula = trim($matricula);
        $matricula = strip_tags($matricula);

        // Validaciones
        if(strlen($matricula) > "7" || empty($matricula)) {
            $matricula = "0000000";
        }
        else {

            // Inserto en la BD
            $sql = "INSERT INTO vehiculos (matricula, idModelo, idGrupoVehiculo, disponibilidad) 
                    VALUES ('$matricula', '$modelo', '$grupo', '$disponible')";

            if ($conn->query($sql) === TRUE) {
                echo "Nuevo vehículo agregado correctamente.";
            } 
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
    header("Location: OpVehiculos.php");
    die();
}

?>
