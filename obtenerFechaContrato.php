
<?php
// Este archivo toma la "fechaFinContrato" en la tabla "contratos-alquiler" para pasársela a "devolucionVehiculo.php" y colocarla en
// el modal de registro de una nueva devolución, cada vez que el usuario cambia el contrato en el combo box desplegable

require_once "conn/conexion.php";
$conexion = ConexionBD();

if ($_POST['idContrato']) {

    $idContrato = intval($_POST['idContrato']); // Sanitiza el input

    $query = "SELECT fechaFinContrato FROM `contratos-alquiler` WHERE idContrato = $idContrato LIMIT 1";
    $resultado = mysqli_query($conexion, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $fechaFinContrato = $fila['fechaFinContrato'];

        // Convertir formato por si es necesario
        $fechaFormateada = date('m-d-Y', strtotime($fechaFinContrato));

        echo $fechaFormateada; // Devuelve la fecha al AJAX del modal en "devolucionVehiculo.php"
    } 
    else {
        echo ''; // Si no se encuentra el contrato, devuelve vacío
    }
}
?>
