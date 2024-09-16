<?php

$conexion= mysqli_connect("localhost","root","root","rocket");
$conexion->set_charset("utf8");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>