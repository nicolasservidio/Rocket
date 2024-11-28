
<?php
session_start();

// Destruyo la sesión de usuario en dos pasos:
$_SESSION = array(); 
session_destroy();

// Y por último redirijo al login:
header('Location: index.php');
exit;

?>
