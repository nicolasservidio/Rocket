<?php
session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('conn/conexion.php');
$MiConexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'documento' => isset($_GET['documento']) ? trim($_GET['documento']) : '',
    'nombre' => isset($_GET['nombre']) ? trim($_GET['nombre']) : '',
    'apellido' => isset($_GET['apellido']) ? trim($_GET['apellido']) : '',
    'email' => isset($_GET['email']) ? trim($_GET['email']) : '',
    'telefono' => isset($_GET['telefono']) ? trim($_GET['telefono']) : '',
    'direccion' => isset($_GET['direccion']) ? trim($_GET['direccion']) : '',
];

// Generar consulta filtrada
include('ListadoClientes.php');
$ListadoClientes = Listar_Clientes($MiConexion, $filtros);
$CantidadClientes = count($ListadoClientes);

include('head.php');
?>

<body class="bg-light">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php
        include('sidebarGOp.php');
        $tituloPagina = "CLIENTES";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }
        ?>

        <!-- Algunos efectos moderno para el form de consultas ;) -->
        <style>

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .filtro-consultas {
                transition: all 0.4s ease-in-out; 
                border-radius: 15px; 
                background-color:rgb(19, 4, 2); 
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); 
                animation: fadeInUp 0.8s ease-in-out; /* Hace que el cuadro "aparezca suavemente" */
            }

            .filtro-consultas:hover {
                transform: translateY(-5px); 
                box-shadow: 0px 10px 20px rgba(198, 167, 31, 0.5);
            }

            .form-control {
                transition: all 0.3s ease-in-out;
                border: 1px solid;
            }

            .form-control:focus {
                border: 2px solid rgb(160, 4, 4); /* Resalta con dorado */
                box-shadow: rgba(152, 10, 10, 0.81);
            }

            .btn-filtrar {
                transition: transform 0.3s ease-in-out;
            }

            .btn-filtrar:hover {
                transform: scale(1.1); /* Botón se agranda ligeramente */
            }
        </style>

        <div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm filtro-consultas"
            style="margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            <h5 class="mb-4"><strong>Filtrar Clientes</strong></h5>

            <!-- Formulario de filtro -->
            <form action="clientes.php" method="GET" onsubmit="scrollToTable()">
                <div class="row">
                    <div class="col-md-2">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento"
                            value="<?= htmlspecialchars($filtros['documento']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido"
                            value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            value="<?= htmlspecialchars($filtros['email']) ?>">
                    </div>
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
                </div><br>
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-black btn-filtrar">Filtrar</button>
                        <a href="clientes.php" class="btn btn-warning btn-filtrar">Limpiar Filtros</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sección de Listado Clientes -->
        <div id="tablaClientesContenedor" class="table-responsive p-4 mb-4 border border-secondary rounded bg-white shadow-sm"
            style="max-width: 97%; max-height: 700px; margin-left: 2%; margin-right: 2%; margin-top: 5%;">
            <h5 class="mb-4 text-secondary"><strong>Listado Clientes</strong></h5>
            <table class="table table-hover" id="tablaClientes">
                <thead>
                    <tr>
                        <th style='color: #bd399e;'>
                            <h3>#</h3>
                        </th>
                        <th>ID Cliente</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = "1";

                    for ($i = 0; $i < $CantidadClientes; $i++) {
                        echo "<tr class='cliente' data-id='" . $ListadoClientes[$i]['ID'] . "'>
                            <td><span style='color: #bd399e;'><h3>" . $contador . "</h3></span></td>
                            <td>" . $ListadoClientes[$i]['ID'] . "</td>
                            <td>" . $ListadoClientes[$i]['DOCUMENTO'] . "</td>
                            <td>" . $ListadoClientes[$i]['NOMBRE'] . "</td>
                            <td>" . $ListadoClientes[$i]['APELLIDO'] . "</td>
                            <td>" . $ListadoClientes[$i]['EMAIL'] . "</td>
                            <td>" . $ListadoClientes[$i]['TELEFONO'] . "</td>
                            <td>" . $ListadoClientes[$i]['DIRECCION'] . "</td>
                        </tr>";
                        $contador++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Recuadro con cantidad total de registros encontrados -->
        <style>
            .no-btn-effect {
                pointer-events: none; /* Evita que se comporte como un botón */
                box-shadow: none !important; 
                cursor: default !important; /* Hace que el cursor no cambie */
                border: none; 
            }
        </style>
        <p class="btn no-btn-effect" style="background-color: rgb(153, 6, 6); color: #ffffff; margin-left: 25px;">
            Total de registros encontrados: <?php echo $CantidadClientes; ?>
        </p>

        <br><br><br>

        <!-- Botones -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                <i class="fas fa-plus-circle"></i> Nuevo
            </button>
            <div>
                <button class="btn btn-warning" id="btnModificar" onclick="modificarCliente()" disabled>Modificar Cliente</button>
                <button class="btn btn-danger" id="btnEliminar" onclick="eliminarCliente()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>

        <!-- Modal para Nuevo Cliente -->
        <div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoClienteModalLabel">Agregar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="NuevoCliente.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
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

        // Desplazamiento vertical al listado luego de consulta
        function scrollToTable() {
            localStorage.setItem('scrollToTable', 'true'); // Guardar indicador antes de enviar
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('scrollToTable') === 'true') {
                setTimeout(() => {
                    document.getElementById('tablaClientesContenedor').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500); 
            }
        });

        let clienteSeleccionado = null;

        // Selección de cliente al hacer clic en una fila
        document.querySelectorAll('#tablaClientes .cliente').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.cliente').forEach(row => row.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');
                clienteSeleccionado = row.dataset.id;
                // Habilitar los botones
                document.getElementById('btnModificar').disabled = false;
                document.getElementById('btnEliminar').disabled = false;
            });
        });

        // Función para redirigir a ModificarCliente.php con el ID del cliente seleccionado
        function modificarCliente() {
            if (clienteSeleccionado) {
                window.location.href = 'ModificarCliente.php?id=' + clienteSeleccionado;
            }
        }

        // Función para redirigir a EliminarCliente.php con el ID del cliente seleccionado
        function eliminarCliente() {
            if (clienteSeleccionado) {
                if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                    window.location.href = 'EliminarCliente.php?id=' + clienteSeleccionado;
                }
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>