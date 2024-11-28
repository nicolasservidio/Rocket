<?php
// Inicializar la variable de error
$error_message = '';
$validaciones = '';

if (isset($_POST['userId']) && isset($_POST['password'])) {
    $tbl_name = "usuarios"; // Nombre de la tabla
    
    require_once 'funciones/login validacion credenciales.php';
    $validaciones = ValidarUsuario();

    if (empty($validaciones)) {

        $username = $_POST['userId']; // Usuario ingresado, procesado y validado
        $password = $_POST['password']; // Contraseña ingresada, procesada y validada
    
        require "conn/conexion.php";
        $conexion = ConexionBD();
    
        $stmt = $conexion->prepare("SELECT * FROM $tbl_name WHERE usuario = ? AND contrasena = ?");
        $stmt->bind_param("ss", $username, $password);
    
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conexion->close();
    
        if ($result->num_rows == 1) {

            // Usuario encontrado, se cargan datos en sesión y se redirige al correspondiente panel
            $conexion = ConexionBD();
            require "funciones/iniciar sesion.php";
            Iniciar_Sesion($_POST['userId'], $_POST['password'], $conexion);
        } 
        else {
            // Usuario o contraseña incorrectos
            $error_message = "Las credenciales no existen.";
        }
    }
    else {
        $error_message = "Los datos son incorrectos. Intenta nuevamente. ";
    }

}

if ($error_message): ?>
    <div class="alert alert-danger mt-3">
        <?php 
        echo $error_message; 
        echo $validaciones;
        ?>        
    </div>
<?php endif; ?>
