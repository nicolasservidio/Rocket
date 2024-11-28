<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('conn/conexion.php');
$MiConexion = ConexionBD();

include('ListadoClientes.php');
$ListadoClientes = Listar_Clientes($MiConexion);
$CantidadClientes = count($ListadoClientes);

include('head.php');

?>

<body class="bg-light">
    <div class="wrapper" style="margin-bottom: 100px;">

        <?php 

        include('sidebarGOp.php');
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }
        ?>
        
        <!-- Sección de Listado Clientes -->
        <div class="p-4 mb-4 border border-secondary rounded bg-white shadow-sm" style="margin-left: 2%; margin-right: 2%; margin-top: 8%;">
            <h5 class="mb-4 text-secondary"><strong>Listado Clientes</strong></h5>
            <table class="table table-hover" id="tablaClientes">
                <thead>
                    <tr>
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
                    for ($i = 0; $i < $CantidadClientes; $i++) {
                        echo "<tr class='cliente' data-id='" . $ListadoClientes[$i]['ID'] . "'>
                            <td>" . $ListadoClientes[$i]['ID'] . "</td>
                            <td>" . $ListadoClientes[$i]['DOCUMENTO'] . "</td>
                            <td>" . $ListadoClientes[$i]['NOMBRE'] . "</td>
                            <td>" . $ListadoClientes[$i]['APELLIDO'] . "</td>
                            <td>" . $ListadoClientes[$i]['EMAIL'] . "</td>
                            <td>" . $ListadoClientes[$i]['TELEFONO'] . "</td>
                            <td>" . $ListadoClientes[$i]['DIRECCION'] . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between" style="margin-left: 2%; margin-right: 2%; margin-top: 3%;">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                <i class="fas fa-plus-circle"></i> Nuevo
            </button>
            <div>
                <button class="btn btn-primary" id="btnModificar" onclick="modificarCliente()" disabled>Modificar Cliente</button>
                <button class="btn btn-danger" id="btnEliminar" onclick="eliminarCliente()" disabled>
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </div>
        </div>

        <div style="padding-top: 5%; padding-bottom: 20px;">
            <?php require_once "foot.php"; ?>
        </div>

    </div>

    <script>
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
</body>
</html>
