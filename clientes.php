<?php include('head.php') ?>

<<body class="bg-light">
    <div class="wrapper">

        <?php 
        include('conn/conexion.php');
        $MiConexion = ConexionBD();
        include('sidebarGOp.php');
        include('topNavBar.php');
        include('ListadoClientes.php');
        $ListadoClientes = Listar_Clientes($MiConexion);
$CantidadClientes = count($ListadoClientes);

        ?>

        <div class="container mt-4">
            <!-- Sección de Clientes -->
            <div class="p-4 mb-4 border border-primary rounded bg-white shadow-sm">
                <h5 class="mb-4 text-primary"><strong>Clientes</strong></h5>

                <!-- Mostrar mensaje de éxito si está presente -->
                <?php if (isset($_GET['mensajeExito'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_GET['mensajeExito']); ?>
                </div>
                <?php endif; ?>


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


            <!-- Sección de Listado Clientes -->
<div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm">
    <h5 class="mb-4 text-secondary"><strong>Listado Clientes</strong></h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Número</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody id="tablaClientes">
            <?php
            for ($i = 0; $i < $CantidadClientes; $i++) {
                echo "<tr class='cliente' 
                        onclick='seleccionarCliente(this)'
                        data-id='" . $ListadoClientes[$i]['ID'] . "' 
                        data-documento='" . $ListadoClientes[$i]['DOCUMENTO'] . "' 
                        data-nombre='" . $ListadoClientes[$i]['NOMBRE'] . "' 
                        data-apellido='" . $ListadoClientes[$i]['APELLIDO'] . "' 
                        data-email='" . $ListadoClientes[$i]['EMAIL'] . "' 
                        data-telefono='" . $ListadoClientes[$i]['TELEFONO'] . "'>
                    <td>" . $ListadoClientes[$i]['ID'] . "</td>
                    <td>" . $ListadoClientes[$i]['DOCUMENTO'] . "</td>
                    <td>" . $ListadoClientes[$i]['NOMBRE'] . "</td>
                    <td>" . $ListadoClientes[$i]['APELLIDO'] . "</td>
                    <td>" . $ListadoClientes[$i]['EMAIL'] . "</td>
                    <td>" . $ListadoClientes[$i]['TELEFONO'] . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Botones -->
<div class="d-flex justify-content-between">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
        <i class="fas fa-plus-circle"></i> Nuevo
    </button>
    <div>
        <button class="btn btn-secondary" id="btnModificar" disabled data-bs-toggle="modal"
            data-bs-target="#modificarClienteModal">
            <i class="fas fa-edit"></i> Modificar
        </button>
        <button class="btn btn-danger" id="btnEliminar" disabled data-bs-toggle="modal" data-bs-target="#eliminarClienteModal">
            <i class="fas fa-trash-alt"></i> Eliminar
        </button>
    </div>
</div>

<!-- Modal para modificar cliente -->
<div class="modal fade" id="modificarClienteModal" tabindex="-1" aria-labelledby="modificarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="ModificarCliente.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarClienteModalLabel">Modificar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" id="modificarId" name="id">
                        <div class="col-md-3">
                            <label for="modificarDocumento" class="form-label">Documento</label>
                            <input type="text" class="form-control" id="modificarDocumento" name="documento" required>
                        </div>
                        <!-- Replicar más campos aquí -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para eliminar cliente -->
<div class="modal fade" id="eliminarClienteModal" tabindex="-1" aria-labelledby="eliminarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="EliminarCliente.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarClienteModalLabel">Eliminar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar al cliente <strong id="eliminarNombre"></strong>?</p>
                    <input type="hidden" id="eliminarId" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let clienteSeleccionado = null;

    function seleccionarCliente(fila) {
        // Resaltar fila seleccionada
        document.querySelectorAll('.cliente').forEach(f => f.classList.remove('table-primary'));
        fila.classList.add('table-primary');
        clienteSeleccionado = fila.dataset;

        // Activar botones
        document.getElementById('btnModificar').disabled = false;
        document.getElementById('btnEliminar').disabled = false;

        // Cargar datos en el modal de modificar
        document.getElementById('modificarId').value = clienteSeleccionado.id;
        document.getElementById('modificarDocumento').value = clienteSeleccionado.documento;

        // Configurar el modal de eliminar
        document.getElementById('eliminarId').value = clienteSeleccionado.id;
        document.getElementById('eliminarNombre').textContent = clienteSeleccionado.nombre + ' ' + clienteSeleccionado.apellido;
    }
</script>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>