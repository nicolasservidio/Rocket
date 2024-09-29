<?php

if (isset($_POST['userId']) && isset($_POST['password'])) {

    $tbl_name="usuarios"; // Table name

    $username=$_POST['userId']; // username sent from form
    $password=$_POST['password']; // password sent from form

    require "conn/conexion.php";

    $stmt = $conexion->prepare("SELECT * FROM $tbl_name WHERE usuario = ? AND contrasena = ?");
    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();
    $conexion->close();


    if ($result->num_rows == 1) {
        // Usuario encontrado, hacer algo aquí
        header('location: indexGOp.php');
        die();
    } else {
        // Usuario no encontrado
        $popup = '<script> function loginIncorrecto() { alert("Login fallido. Usuario o contraseña incorrectos."); window.location = "index.php"; } </script>'.
        '<script>loginIncorrecto();</script>';
        echo $popup;
        // echo "Login fallido. Usuario o contraseña incorrectos.";
    }

}
?>