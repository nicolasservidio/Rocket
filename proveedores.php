

<?php include('head.php')?>

<body class="bg-light">

    <div class="wrapper">
    
    <?php 
    include('sidebarVentas.php');
    include('topNavBar.php');
    
    ?>
    
<body class="bg-light">
    <div class="container mt-4">
        <!-- Sección de Proveedores -->
        <div class="p-4 mb-4 border border-success rounded bg-white shadow-sm">
            <h5 class="mb-4 text-success"><strong>Proveedores</strong></h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="cuit" class="form-label">CUIT</label>
                    <input type="text" class="form-control" id="cuit">
                </div>
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre">
                </div>
                <div class="col-md-4">
                    <label for="provincia" class="form-label">Provincia</label>
                    <select class="form-select" id="provincia">
                        <option selected>(Todos)</option>
                        <option>Buenos Aires</option>
                        <option>Córdoba</option>
                        <option>Santa Fe</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tipoProd" class="form-label">Tipo de prod.</label>
                    <select class="form-select" id="tipoProd">
                        <option selected>(Todos)</option>
                        <option>Materiales</option>
                        <option>Equipamiento</option>
                        <option>Servicios</option>
                    </select>
                </div>
            </div>
            <!-- Botón filtrar -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-danger btn-sm"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>

        <!-- Tabla de Proveedores -->
        <div class="p-4 mb-4 border border-primary rounded bg-white shadow-sm">
            <h5 class="mb-4 text-primary"><strong>Lista de Proveedores</strong></h5>
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Provincia</th>
                        <th>CUIT</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center">No hay proveedores registrados</td>
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
                <button class="btn btn-dark"><i class="fas fa-trash-alt"></i> Eliminar</button>
                <button class="btn btn-success"><i class="fas fa-list"></i> Imprimir listado</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
