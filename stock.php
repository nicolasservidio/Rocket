<?php include('head.php')?>

<body class="bg-light">

    <div class="wrapper">
    
    <?php 
    include('sidebarVentas.php');
    include('topNavBar.php');
    
    ?>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Sección de Movimientos de Stock -->
        <div class="p-4 mb-4 border border-info rounded bg-white shadow-sm">
            <h5 class="mb-4 text-info"><strong>Movimientos de Stock</strong></h5>
            <div class="row g-3">
                <div class="col-md-2">
                    <label for="desde" class="form-label">Desde</label>
                    <input type="date" class="form-control" id="desde">
                </div>
                <div class="col-md-2">
                    <label for="hasta" class="form-label">Hasta</label>
                    <input type="date" class="form-control" id="hasta">
                </div>
                <div class="col-md-4">
                    <label for="articulo" class="form-label">Artículo</label>
                    <input type="text" class="form-control" id="articulo">
                </div>
                <div class="col-md-4">
                    <label for="proveedor" class="form-label">Proveedor</label>
                    <input type="text" class="form-control" id="proveedor">
                </div>
                <div class="col-md-4">
                    <label for="tipoMov" class="form-label">Tipo Mov.</label>
                    <select class="form-select" id="tipoMov">
                        <option selected>(Todos)</option>
                        <option>Ingreso</option>
                        <option>Egreso</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="deposito" class="form-label">Depósito</label>
                    <select class="form-select" id="deposito">
                        <option selected>(Todos)</option>
                        <option>Principal</option>
                        <option>Secundario</option>
                    </select>
                </div>
            </div>
            <!-- Botón filtrar -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-info btn-sm"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>

        <!-- Tabla de Movimientos -->
        <div class="p-4 mb-4 border border-primary rounded bg-white shadow-sm">
            <h5 class="mb-4 text-primary"><strong>Lista de Movimientos</strong></h5>
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Fecha</th>
                        <th>Artículo</th>
                        <th>Descripción</th>
                        <th>Tipo Mov.</th>
                        <th>Matrícula</th>
                        <th>Cant.</th>
                        <th>Proveedor</th>
                        <th>Observaciones</th>
                        <th>Depósito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="text-center">No hay movimientos registrados</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Botones de acciones -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger"><i class="fas fa-plus-circle"></i> Nuevo</button>
            <div>
                <button class="btn btn-secondary"><i class="fas fa-edit"></i> Modificar</button>
                <button class="btn btn-secondary"><i class="fas fa-print"></i> Imprimir</button>
                <button class="btn btn-dark"><i class="fas fa-trash-alt"></i> Anular</button>
                <button class="btn btn-success"><i class="fas fa-list"></i> Imprimir listado</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
