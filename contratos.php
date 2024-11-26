<?php include('head.php')?>

<body>

    <div class="wrapper">

        <?php 
    include('sidebarVentas.php');
    include('topNavBar.php');    
    ?>
    <div class="container">
        <h3 class="fw-bold my-3">Contratos</h3>
        
        <!-- Formulario de filtros -->
        <form class="row g-3">
            <div class="col-md-4">
                <label for="contrato" class="form-label">Contrato</label>
                <input type="text" class="form-control" id="contrato">
            </div>
            <div class="col-md-4">
                <label for="salidaDesde" class="form-label">Salida entre</label>
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
            <div class="col-md-4">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido">
            </div>
            <div class="col-md-4">
                <label for="docId" class="form-label">Doc. Id.</label>
                <input type="text" class="form-control" id="docId">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger w-100"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </form>

        <!-- Tabla de contratos -->
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Contrato</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Matrícula</th>
                        <th>Of. Sal.</th>
                        <th>Salida</th>
                        <th>H.S.</th>
                        <th>Of. Ent</th>
                        <th>Emp. S.</th>
                        <th>Entrada</th>
                        <th>H.E.</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas de datos se generarían dinámicamente aquí -->
                </tbody>
            </table>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-start mt-3">
            <button type="button" class="btn btn-danger me-2">Nuevo</button>
            <button type="button" class="btn btn-danger me-2">Modificar</button>
            <button type="button" class="btn btn-danger me-2">Cierre</button>
            <button type="button" class="btn btn-danger me-2">Anular</button>
            <button type="button" class="btn btn-danger me-2">Cond. Ad.</button>
            <button type="button" class="btn btn-danger me-2">Cambiar auto</button>
            <button type="button" class="btn btn-danger">Imprimir</button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
