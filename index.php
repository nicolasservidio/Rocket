<?php 

session_start();

include('head.php');

?>

<body>
<main class="d-flex justify-content-center align-items-center vh-100 bg-dark bg-gradient" id="main">
    <div class="card col-3 bg-light p-5 rounded shadow">
        <div class="text-center mb-4">
            <img src="assets/img/logo_light.png" alt="Logo" class="img-fluid">
        </div>
        <h4 class="text-center mb-4">Iniciar Sesión</h4>
                
        <form method="post" action="index.php">

            <div class="mb-3">
                <label for="userId" class="form-label">Usuario</label>
                <input type="text" class="form-control" placeholder="Nombre del usuario" name="userId" 
                       value="<?php echo isset($_POST['userId']) ? $_POST['userId'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" placeholder="Contraseña" name="password"
                       value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" name="submitBtn">Iniciar Sesión</button> 
                <span style="text-align: center; padding-top: 10px;"> 
                    <a href="cerrarsesion.php"> Cerrar sesión previa</a> 
                </span>
            </div>

<?php require_once "validar_login.php"?>

        </form>
    </div>
</main>
</body>


<?php require_once "foot.php"?>
