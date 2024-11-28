
<?php 

function Corroborar_Usuario() {

    // Si elementos de la sesión están vacíos, se redirige a la página de "cerrarsesion.php", destruyendo la sesión y luego
    // redireccionando al login.php:

    if (empty($_SESSION['ID']) || empty($_SESSION['Nombre']) || empty($_SESSION['Usuario']) || empty($_SESSION['Cargo'])) {

        header('Location: cerrarsesion.php');
        exit;
    }
}

?>
