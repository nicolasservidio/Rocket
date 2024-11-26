<?php include('head.php')?>

<body class="bg-light">

    <div class="wrapper">
    
    <?php 
    include('sidebarVentas.php');
    include('topNavBar.php');
    
    ?>

      

    <div class="container my-5 p-4 bg-white shadow rounded">
        <h3 class="fw-bold text-primary mb-4">Nuevo Contrato</h3>

        <!-- Formulario de cabecera -->
        <form class="row g-3 mb-4 p-3 border border-primary rounded">
            <div class="col-md-3">
                <label for="nEmp" class="form-label">N° Emp</label>
                <input type="text" class="form-control border-primary" id="nEmp">
            </div>
            <div class="col-md-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control border-primary" id="contrasena">
            </div>
            <div class="col-md-3">
                <label for="reserva" class="form-label">Reserva</label>
                <input type="text" class="form-control border-primary" id="reserva">
            </div>
        </form>

        <!-- Sección de datos personales -->
        <div class="p-3 mb-4 border border-success rounded bg-light">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="doc" class="form-label">Doc. N°</label>
                    <input type="text" class="form-control" id="doc">
                </div>
                <div class="col-md-3">
                    <label for="paisDoc" class="form-label">País Doc.</label>
                    <input type="text" class="form-control" id="paisDoc">
                </div>
                <div class="col-md-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido">
                </div>
                <div class="col-md-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre">
                </div>
                <div class="col-md-3">
                    <label for="fecNac" class="form-label">Fec. Nac.</label>
                    <input type="text" class="form-control" id="fecNac" placeholder="dd/mm/aa">
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="col-md-3">
                    <label for="registro" class="form-label">Registro</label>
                    <input type="text" class="form-control" id="registro">
                </div>
                <div class="col-md-3">
                    <label for="paisExp" class="form-label">País Exp.</label>
                    <input type="text" class="form-control" id="paisExp">
                </div>
                <div class="col-md-3">
                    <label for="fechaExp" class="form-label">Fecha Exp.</label>
                    <input type="text" class="form-control" id="fechaExp">
                </div>
                <div class="col-md-3">
                    <label for="vencimiento" class="form-label">Vencimiento</label>
                    <input type="text" class="form-control" id="vencimiento">
                </div>
                <div class="col-md-3">
                    <label for="tarjeta" class="form-label">Tarjeta</label>
                    <input type="text" class="form-control" id="tarjeta">
                </div>
                <div class="col-md-2">
                    <label for="cvc" class="form-label">CVC</label>
                    <input type="text" class="form-control" id="cvc">
                </div>
                <div class="col-md-3">
                    <label for="dirLocal" class="form-label">Dir. Local</label>
                    <input type="text" class="form-control" id="dirLocal">
                </div>
                <div class="col-md-3">
                    <label for="ciudadLoc" class="form-label">Ciudad Loc.</label>
                    <input type="text" class="form-control" id="ciudadLoc">
                </div>
                <div class="col-md-3">
                    <label for="telefonoLoc" class="form-label">Teléfono Loc.</label>
                    <input type="text" class="form-control" id="telefonoLoc">
                </div>
            </div>
        </div>

        <!-- Sección de reserva -->
        <div class="p-3 mb-4 border border-warning rounded bg-light">
            <div class="row g-3">
                <div class="col-md-2">
                    <label for="ofSalida" class="form-label">Of. Salida</label>
                    <input type="text" class="form-control" id="ofSalida">
                </div>
                <div class="col-md-3">
                    <label for="fecSalida" class="form-label">Fec. Salida</label>
                    <input type="text" class="form-control" id="fecSalida" placeholder="dd/mm/aa">
                </div>
                <div class="col-md-2">
                    <label for="horaSalida" class="form-label">Hora</label>
                    <input type="text" class="form-control" id="horaSalida">
                </div>
                <div class="col-md-2">
                    <label for="ofEntrada" class="form-label">Of. Entrada</label>
                    <input type="text" class="form-control" id="ofEntrada">
                </div>
                <div class="col-md-3">
                    <label for="fecDev" class="form-label">Fecha Prev. Dev.</label>
                    <input type="text" class="form-control" id="fecDev" placeholder="dd/mm/aa">
                </div>
                <div class="col-md-2">
                    <label for="horaDev" class="form-label">Hora</label>
                    <input type="text" class="form-control" id="horaDev">
                </div>
                <div class="col-md-2">
                    <label for="tarifa" class="form-label">Tarifa</label>
                    <input type="text" class="form-control" id="tarifa">
                </div>
                <div class="col-md-2">
                    <label for="grupo" class="form-label">Grupo</label>
                    <input type="text" class="form-control" id="grupo">
                </div>
                <div class="col-md-2">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="text" class="form-control" id="hora">
                </div>
                <div class="col-md-2">
                    <label for="dia" class="form-label">Día</label>
                    <input type="text" class="form-control" id="dia">
                </div>
                <div class="col-md-12">
                    <label for="condiciones" class="form-label">Condiciones Especiales</label>
                    <input type="text" class="form-control" id="condiciones">
                </div>
            </div>
        </div>

        <!-- Sección de vehículo -->
        <div class="p-3 mb-4 border border-info rounded bg-light">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" id="matricula">
                </div>
                <div class="col-md-2">
                    <label for="grupoVehiculo" class="form-label">Grupo</label>
                    <input type="text" class="form-control" id="grupoVehiculo">
                </div>
                <div class="col-md-3">
                    <label for="kmsSalida" class="form-label">Kms Salida</label>
                    <input type="text" class="form-control" id="kmsSalida">
                </div>
                <div class="col-md-2">
                    <label for="combustible" class="form-label">Comb. Salida</label>
                    <input type="text" class="form-control" id="combustible">
                </div>
                <div class="col-md-2">
                    <label for="observaciones" class="form-label">Obs.</label>
                    <input type="text" class="form-control" id="observaciones">
                </div>
            </div>
        </div>

        <!-- Sección de costos -->
        <div class="p-3 mb-4 border border-danger rounded bg-light">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="parcial" class="form-label">PARCIAL</label>
                    <input type="text" class="form-control" id="parcial">
                </div>
                <div class="col-md-2">
                    <label for="dias" class="form-label">Días</label>
                    <input type="text" class="form-control" id="dias">
                </div>
                <div class="col-md-3">
                    <label for="total" class="form-label">TOTAL</label>
                    <input type="text" class="form-control" id="total">
                </div>
                <div class="col-md-2">
                    <label for="responsabilidad" class="form-label">Responsabilidad</label>
                    <input type="text" class="form-control" id="responsabilidad">
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger btn-lg"><i class="fas fa-undo-alt"></i> Volver</button>
            <button class="btn btn-success btn-lg"><i class="fas fa-check"></i> Confirmar</button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
