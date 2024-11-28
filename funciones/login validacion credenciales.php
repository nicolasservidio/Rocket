<?php 

// -----------------------------------------------
// Validación de credenciales
function ValidarUsuario() {

    // Preprocesado
    $_POST['userId'] = trim($_POST['userId']);
    $_POST['password'] = trim($_POST['password']);
    
    $_POST['userId'] = strip_tags($_POST['userId']); // evitando inyecciones de código
    $_POST['password'] = strip_tags($_POST['password']); // evitando inyecciones de código

    // Validaciones
    $Errores = '';
    if (empty($_POST['userId'])) {
        $Errores = "- El campo Usuario no puede estar vacío. <br>";
    }
    if (empty($_POST['password'])) {
        $Errores.="- El campo Contraseña no puede estar vacío. <br>";
    }

    if (strlen($_POST['userId']) < 4 || strlen($_POST['userId']) > 20) {
        $Errores.="- El nombre de usuario no puede presentar menos de 4 caracteres ni más de 20. <br>";
    }
    if (strlen($_POST['password']) < 3) {
        $Errores.="- La contraseña no puede presentar menos de 3 caracteres. <br>";
    }

    // Edición del mensaje
    if (!empty($Errores)) {
        $saltodelinea = '<br><br>';
        $saltodelinea.=$Errores;
        $Errores = $saltodelinea;
    }

    return $Errores;
}

?>