<?php 
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('conn/conexion.php');
$MiConexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'cuit' => isset($_GET['cuit']) ? trim($_GET['cuit']) : '',
    'nombre' => isset($_GET['nombre']) ? trim($_GET['nombre']) : '',
    'iva' => isset($_GET['iva']) ? trim($_GET['iva']) : '',
    'email' => isset($_GET['email']) ? trim($_GET['email']) : '',
    'telefono' => isset($_GET['telefono']) ? trim($_GET['telefono']) : '',
    'direccion' => isset($_GET['direccion']) ? trim($_GET['direccion']) : '',
    'localidad' => isset($_GET['localidad']) ? trim($_GET['localidad']) : '',    
];

// Generar consulta filtrada
include('ListadoProveedores.php');
$ListadoProveedores = Listar_Proveedores($MiConexion, $filtros);
$CantidadProveedores = count($ListadoProveedores);

include('head.php');
?>

<body class="bg-light">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">
        
        <?php 
        include('sidebarGOp.php');
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }
        ?>

        <div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm" 
            style="margin-left: 2%; margin-right: 2%; margin-top: 8%;"> 
            <h5 class="mb-4 text-secondary"><strong>Filtrar Proveedores</strong></h5>

            <!-- Formulario de filtro -->
            <form action="proveedores.php" method="GET">
                <div class="row">
                    <div class="col-md-2">
                        <label for="cuit" class="form-label">Cuit</label>
                        <input type="text" class="form-control" id="cuit" name="cuit" 
                            value="<?= htmlspecialchars($filtros['cuit']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre (Razon Social)</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                            value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="iva" class="form-label">Condicion IVA</label>
                        <input type="text" class="form-control" id="iva" name="iva" 
                            value="<?= htmlspecialchars($filtros['iva']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" 
                            value="<?= htmlspecialchars($filtros['email']) ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" 
                            value="<?= htmlspecialchars($filtros['telefono']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" 
                            value="<?= htmlspecialchars($filtros['direccion']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="localidad" class="form-label">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" 
                            value="<?= htmlspecialchars($filtros['localidad']) ?>">
                    </div>                    
                </div>
                <br>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="Proveedores.php" class="btn btn-secondary">Limpiar Filtros</a>
                </div>
            </form>
        </div>

        <!-- Sección de Listado Proveedores -->
        <div class="table-responsive p-4 mb-4 border border-secondary rounded bg-white shadow-sm" 
             style="max-width: 97%; max-height: 700px; margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            <h5 class="mb-4 text-secondary"><strong>Listado Proveedores</strong></h5>
            <table class="table table-hover" id="tablaProveedores" >
                <thead>
                    <tr>
                        <th style='color: #bd399e;'><h3>#</h3></th>
                        <th>ID Proveedor</th>
                        <th>Cuit</th>
                        <th>Nombre/ <br> Razon Social<br> </th>
                        <th>Condicion IVA</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Localidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = "1";

                    for ($i = 0; $i < $CantidadProveedores; $i++) {
                        echo "<tr class='Proveedor' data-id='" . $ListadoProveedores[$i]['ID'] . "'>
                            <td><span style='color: #bd399e;'><h3>" . $contador . "</h3></span></td>
                            <td>" . $ListadoProveedores[$i]['ID'] . "</td>
                            <td>" . $ListadoProveedores[$i]['CUIT'] . "</td>
                            <td>" . $ListadoProveedores[$i]['NOMBRE'] . "</td>
                            <td>" . $ListadoProveedores[$i]['IVA'] . "</td>
                            <td>" . $ListadoProveedores[$i]['EMAIL'] . "</td>
                            <td>" . $ListadoProveedores[$i]['TELEFONO'] . "</td>
                            <td>" . $ListadoProveedores[$i]['DIRECCION'] . "</td>
                            <td>" . $ListadoProveedores[$i]['LOCALIDAD'] . "</td>
                        </tr>";
                        $contador++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nuevoProveedorModal">
                <i class="fas fa-plus-circle"></i> Nuevo
            </button>
            <div>
                <button class="btn btn-primary" id="btnModificar" onclick="modificarProveedor()" disabled>Modificar Proveedor</button>
                <button class="btn btn-danger" id="btnEliminar" onclick="eliminarProveedor()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>

        <!-- Modal para Nuevo Proveedor -->
        <div class="modal fade" id="nuevoProveedorModal" tabindex="-1" aria-labelledby="nuevoProveedorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoProveedorModalLabel">Agregar Nuevo Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="NuevoProveedor.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="cuit" class="form-label">Cuit</label>
                                <input type="text" class="form-control" id="cuit" name="cuit" title="El Cuit debe ser un número mayor a 0" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre o Razon Social</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" title="Campo obligatorio" required>
                            </div>
                            <div class="mb-3">
                                <label for="iva" class="form-label">Condicion IVA</label>
                                <input type="text" class="form-control" id="iva" name="iva" title="Campo obligatorio" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" title="Campo obligatorio" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" title="El teléfono debe contener entre 7 y 15 dígitos" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" title="Campo obligatorio" required>
                            </div>
                            <div class="mb-3">
                                <label for="localidad" class="form-label">Localidad</label>
                                <input type="text" class="form-control" id="localidad" name="localidad" title="Campo obligatorio" required>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="padding-top: 5%; padding-bottom: 20px;">
            <?php require_once "foot.php"; ?>
        </div>

    </div>

    <script>
        let Proveedoreseleccionado = null;

        // Selección de Proveedor al hacer clic en una fila
        document.querySelectorAll('#tablaProveedores .Proveedor').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.Proveedor').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                Proveedoreseleccionado = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a ModificarProveedor.php con el ID del Proveedor seleccionado
        function modificarProveedor() {
            if (Proveedoreseleccionado) {
                window.location.href = 'ModificarProveedor.php?id=' + Proveedoreseleccionado;
            }
        }

        // Función para redirigir a EliminarProveedor.php con el ID del Proveedor seleccionado
        function eliminarProveedor() {
            if (Proveedoreseleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este Proveedor?')) {
                    window.location.href = 'EliminarProveedor.php?id=' + Proveedoreseleccionado;
                }
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
