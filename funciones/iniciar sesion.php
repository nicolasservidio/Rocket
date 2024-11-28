<?php 

function Iniciar_Sesion($usuario, $clave, $conexion) {

    $SQL = "SELECT u.id as ID, 
                   u.nombre as Nombre,
                   u.usuario as Usuario, 
                   u.contrasena as Clave, 
                   u.id_cargo, 
                   c.id,
                   c.descripcion as CargoDescripcion
        FROM usuarios u, cargo c
        WHERE u.usuario = '$usuario'
        AND u.contrasena = '$clave' 
        AND u.id_cargo = c.id; ";

    $rs = mysqli_query($conexion, $SQL);   // Envío la consulta para su ejecución. Asigno el resultado a variable "$rs"    
    $data = mysqli_fetch_array($rs);   // Se organiza en filas y estas se almacenan en un array

    if (!empty($data)) {
        // Genero los valores de la Sesión de Usuario (sesión de inicio)
        $_SESSION['ID'] = $data['ID'];
        $_SESSION['Nombre'] = $data['Nombre'];
        $_SESSION['Usuario'] = $data['Usuario'];
        $_SESSION['Cargo'] = $data['CargoDescripcion'];
    }


    // REDIRECCIONAMIENTOS a diferentes paneles según Cargo de usuario. También se modifican de Nombres de Cargos almacenados en la sesión:
    
    if ($_SESSION['Cargo'] == "ADMINISTRADOR") {
        
        $_SESSION['Cargo'] = 'Administrador';

        // Redireccionamiento al panel principal:
        header('location: indexGOp.php');
        exit();
    }

    if ($_SESSION['Cargo'] == "GERENTE_OPERACIONES") {

        $_SESSION['Cargo'] = 'Gerente de Operaciones';

        // Redireccionamiento al panel principal:
        header('location: indexGOp.php');
        exit();
    }

    if ($_SESSION['Cargo'] == "GERENTE_COMERCIAL") {

        $_SESSION['Cargo'] = 'Gerente Comercial';

        // Redireccionamiento al panel principal:
        header('location: indexGOp.php');
        exit();
    }

    if ($_SESSION['Cargo'] == "GERENTE_TALLER") {

        $_SESSION['Cargo'] = 'Gerente de Taller';

        // Redireccionamiento al panel principal:
        header('location: indexGOp.php');
        exit();
    }

}


?>