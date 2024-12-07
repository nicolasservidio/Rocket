<?php

session_start();

// Este archivo es necesario para que se carguen correctamente los datos del vehículo en el modal para su modificación.
// Se guardan los datos del vehículo en variables de sesión que luego son utilizadas para cargar los datos en el modal de "modificación de vehículo":

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['matriculaModal'] = $_POST['matriculaModal'];
    $_SESSION['modeloModal'] = $_POST['modeloModal'];
    $_SESSION['grupoModal'] = $_POST['grupoModal'];
    $_SESSION['combustibleModal'] = $_POST['combustibleModal'];
    $_SESSION['sucursalModal'] = $_POST['sucursalModal'];
    $_SESSION['disponibilidadModal'] = $_POST['disponibilidadModal'];

    echo "Datos del vehículo guardados en variables PHP.";
}
else {
    echo "Método de solicitud no permitido.";
}

?>