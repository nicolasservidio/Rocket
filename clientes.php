<?php include('head.php')?>

<body class="bg-light">

    <div class="wrapper">
    
    <?php 
    include('sidebarGOp.php');
    include('topNavBar.php');
    
    ?>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Sección de Clientes -->
        <div class="p-4 mb-4 border border-primary rounded bg-white shadow-sm">
            <h5 class="mb-4 text-primary"><strong>Clientes</strong></h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="text" class="form-control" id="documento">
                </div>
                <div class="col-md-3">
                    <label for="fechaNac" class="form-label">F. Nac.</label>
                    <input type="date" class="form-control" id="fechaNac">
                </div>
                <div class="col-md-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido">
                </div>
                <div class="col-md-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre">
                </div>
                <div class="col-md-6">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion">
                </div>
                <div class="col-md-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono">
                </div>
                <div class="col-md-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular">
                </div>
                <div class="col-md-3">
                    <label for="pais" class="form-label">País</label>
                    <input type="text" class="form-control" id="pais">
                </div>
                <div class="col-md-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad">
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="col-md-4">
                    <label for="registroCond" class="form-label">Registro cond.</label>
                    <input type="text" class="form-control" id="registroCond">
                </div>
                <div class="col-md-2">
                    <label for="paisExp" class="form-label">País exp.</label>
                    <input type="text" class="form-control" id="paisExp">
                </div>
                <div class="col-md-3">
                    <label for="fechaExp" class="form-label">Fecha exp.</label>
                    <input type="date" class="form-control" id="fechaExp">
                </div>
                <div class="col-md-3">
                    <label for="fechaVenc" class="form-label">Fecha venc.</label>
                    <input type="date" class="form-control" id="fechaVenc">
                </div>
                <div class="col-md-3">
                    <label for="tarjeta" class="form-label">Tarjeta</label>
                    <input type="text" class="form-control" id="tarjeta">
                </div>
                <div class="col-md-3">
                    <label for="vto" class="form-label">Vto.</label>
                    <input type="date" class="form-control" id="vto">
                </div>
            </div>
            <!-- Botón filtrar -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>

        <!-- Sección de Contratos anteriores -->
        <div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm">
            <h5 class="mb-4 text-secondary"><strong>Contratos anteriores</strong></h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Fecha Sal</th>
                        <th>Fecha Dev</th>
                        <th>Cat.</th>
                        <th>Seguro</th>
                        <th>Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">Sin datos</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Sección de Comentarios -->
        <div class="p-4 mb-4 border border-warning rounded bg-white shadow-sm">
            <h5 class="mb-4 text-warning"><strong>Comentarios</strong></h5>
            <textarea class="form-control" rows="5" placeholder="Escriba aquí..."></textarea>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger"><i class="fas fa-plus-circle"></i> Nuevo</button>
            <div>
                <button class="btn btn-secondary"><i class="fas fa-edit"></i> Modificar</button>
                <button class="btn btn-secondary"><i class="fas fa-print"></i> Imprimir</button>
                <button class="btn btn-dark"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
