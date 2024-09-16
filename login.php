<main class="d-flex justify-content-center align-items-center vh-100 bg-dark bg-gradient" id="main">
    <div class="card col-3 bg-light p-5 rounded shadow">
        <div class="text-center mb-4">
            <img src="assets/img/logo_light.png" alt="Logo" class="img-fluid">
        </div>
        <h4 class="text-center mb-4">Iniciar Sesión</h4>
                
        <form method="post" action="login.php">
            <div class="mb-3">
                <label for="userId" class="form-label">Usuario</label>
                
                <input type="text" class="form-control" name="userId" placeholder="Nombre del usuario" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña" >
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" name="submitBtn">Iniciar Sesión</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p id="wrongPass" class=""></p><br>
        </div>
        
        <!-- <div class="text-center mt-3">
            <a href="#">¿Olvidaste tu contraseña?</a><br>
        </div> -->


        <?php
        include "validar_login.php"
        ?>
    </div>

</main>
</html>
