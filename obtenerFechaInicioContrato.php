
<?php
// Este archivo toma la "fechaInicioContrato" en la tabla "contratos-alquiler" para pasársela a "entregaVehiculo.php" y colocarla en
// el modal de registro de una nueva entrega, cada vez que el usuario cambia el contrato en el combo box desplegable

require_once "conn/conexion.php";
$conexion = ConexionBD();

if ($_POST['idContrato']) {

    $idContrato = intval($_POST['idContrato']); // Sanitiza el input

    $query = "SELECT fechaInicioContrato FROM `contratos-alquiler` WHERE idContrato = $idContrato LIMIT 1";
    $resultado = mysqli_query($conexion, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $fechaInicioContrato = $fila['fechaInicioContrato'];

        // Convertir formato por si es necesario
        $fechaFormateada = date('m-d-Y', strtotime($fechaInicioContrato));

        echo $fechaFormateada; // Devuelve la fecha al AJAX del modal en "entregaVehiculo.php"
    } 
    else {
        echo ''; // Si no se encuentra el contrato, devuelve vacío
    }
}
?>
