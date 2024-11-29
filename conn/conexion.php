<?php

function ConexionBD($Host = "localhost", $User = "root", $Password = "root", $BaseDeDatos = "rocket") {
    
    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos,);

    if ($linkConexion != false) {
        return $linkConexion;
    } 
    else {
        die("No se pudo establecer la conexión.");
    }
}

?>