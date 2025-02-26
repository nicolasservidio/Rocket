<?php

function ConexionBD($Host = "localhost", $User = "root", $Password = "", $BaseDeDatos = "rocket") {
    
    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos,);
    mysqli_set_charset($linkConexion, "utf8mb4");
    if ($linkConexion != false) {
        return $linkConexion;
    } 
    else {
        die("No se pudo establecer la conexión.");
    }
}

?>