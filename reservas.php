<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');

?>

<body >

    <div class="wrapper">

        <?php 
        include('sidebarGOp.php');
        include('topNavBar.php');    
        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%;">
            <h3 class="fw-bold my-3">Reservas</h3>

            <!-- Formulario de filtros -->
            <form class="row g-3">
                <div class="col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero">
                </div>
                <div class="col-md-2">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" id="matricula">
                </div>
                <div class="col-md-2">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido">
                </div>
                <div class="col-md-3">
                    <label for="retiro" class="form-label">Retiro entre</label>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" placeholder="dd/mm/aa">
                        <input type="text" class="form-control" placeholder="dd/mm/aa">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="ofSalida" class="form-label">Of. Salida</label>
                    <input type="text" class="form-control" id="ofSalida">
                </div>
                <div class="col-md-2">
                    <label for="entrada" class="form-label">Entrada</label>
                    <input type="text" class="form-control" id="entrada" placeholder="dd/mm/aa">
                </div>
                <div class="col-md-2">
                    <label for="ofEntrada" class="form-label">Of. Entrada</label>
                    <input type="text" class="form-control" id="ofEntrada">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
            </form>

            <!-- Tabla de reservas -->
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Apellido</th>
                            <th>Fec. Ret.</th>
                            <th>Hora</th>
                            <th>Of. S.</th>
                            <th>Fec. Dev.</th>
                            <th>Hora</th>
                            <th>Of. D.</th>
                            <th>Tarifa</th>
                            <th>Grp</th>
                            <th>Matrícula</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas de datos se generarían dinámicamente aquí -->
                    </tbody>
                </table>
            </div>

            <!-- Botones de acción -->
            <div style="margin-top: 8%;">
                <div class="container d-flex justify-content-center">
                    <button type="button" class="btn btn-danger me-2">Nuevo</button>
                    <button type="button" class="btn btn-danger me-2">Modificar</button>
                    <button type="button" class="btn btn-danger me-2">Imprimir</button>
                    <button type="button" class="btn btn-danger">Anular</button>
                </div>
            </div>
        </div>

        <div style="">
            <?php require_once "foot.php"; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    
</body>

</html>