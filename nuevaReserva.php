<?php include('head.php')?>

<body >
    <?php 
    include('sidebarGOp.php');
    include('topNavBar.php');    
    ?>


    <div class="container my-4 overflow-auto flex-grow-1">
        <h3 class="fw-bold">Nueva Reserva</h3>
        
        <!-- Datos del Cliente -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Datos del Cliente</h5>
            </div>
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento">
                    </div>
                    <div class="col-md-4">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido">
                    </div>
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre">
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion">
                    </div>
                    <div class="col-md-4">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad">
                    </div>
                    <div class="col-md-4">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono">
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                </form>
            </div>
        </div>

        <!-- Datos de la Reserva -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Datos de la Reserva</h5>
            </div>
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label for="fechaRetiro" class="form-label">Fecha de Retiro</label>
                        <input type="date" class="form-control" id="fechaRetiro">
                    </div>
                    <div class="col-md-4">
                        <label for="horaRetiro" class="form-label">Hora de Retiro</label>
                        <input type="time" class="form-control" id="horaRetiro">
                    </div>
                    <div class="col-md-4">
                        <label for="oficinaRetiro" class="form-label">Oficina de Retiro</label>
                        <input type="text" class="form-control" id="oficinaRetiro">
                    </div>
                    <div class="col-md-4">
                        <label for="fechaDevolucion" class="form-label">Fecha de Devolución</label>
                        <input type="date" class="form-control" id="fechaDevolucion">
                    </div>
                    <div class="col-md-4">
                        <label for="horaDevolucion" class="form-label">Hora de Devolución</label>
                        <input type="time" class="form-control" id="horaDevolucion">
                    </div>
                    <div class="col-md-4">
                        <label for="oficinaDevolucion" class="form-label">Oficina de Devolución</label>
                        <input type="text" class="form-control" id="oficinaDevolucion">
                    </div>
                    <div class="col-md-4">
                        <label for="grupo" class="form-label">Grupo/Categoría</label>
                        <input type="text" class="form-control" id="grupo">
                    </div>
                    <div class="col-md-4">
                        <label for="vehiculo" class="form-label">Vehículo Asignado</label>
                        <input type="text" class="form-control" id="vehiculo">
                    </div>
                    <div class="col-md-4">
                        <label for="tarifa" class="form-label">Tarifa</label>
                        <input type="text" class="form-control" id="tarifa">
                    </div>
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" rows="3"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger me-2">Guardar</button>
            <button type="button" class="btn btn-secondary">Cancelar</button>
        </div>
    </div>
    </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
