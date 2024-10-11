<?php
// Inicializar la variable de error
$error_message = '';

if (isset($_POST['userId']) && isset($_POST['password'])) {
    $tbl_name = "usuarios"; // Nombre de la tabla
    $username = $_POST['userId']; // Usuario ingresado
    $password = $_POST['password']; // Contraseña ingresada

    require "conn/conexion.php";

    $stmt = $conexion->prepare("SELECT * FROM $tbl_name WHERE usuario = ? AND contrasena = ?");
    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conexion->close();

    if ($result->num_rows == 1) {
        // Usuario encontrado, redirigir a la página principal
        header('location: indexGOp.php');
        exit();
    } else {
        // Usuario o contraseña incorrectos
        $error_message = "Usuario o contraseña incorrectos";
    }
}
?>

<?php if ($error_message): ?>
    <div class="alert alert-danger mt-3">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>