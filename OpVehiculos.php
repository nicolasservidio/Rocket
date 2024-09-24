<?php
include "head.php";
include "topNavBar.php";
include "sidebarGop.php";

// Conexión a la base de datos
$servername = "localhost"; // Cambia según tu configuración
$username = "root";
$password = "";
$dbname = "rocket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Filtrado de vehículos
$matricula = isset($_POST['matricula']) ? $_POST['matricula'] : '';
$modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';

$sql = "SELECT * FROM vehiculos WHERE 
        (matricula LIKE '%$matricula%') AND 
        (modelo LIKE '%$modelo%') AND 
        (grupo LIKE '%$grupo%')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<main class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light bg-gradient p-4">
    <div class="card col-8 bg-white p-4 rounded shadow mb-4">
        <h4 class="text-center mb-4">Filtrar Vehículos</h4>
        <form method="post">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" name="matricula" id="matricula" value="<?= $matricula ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="grupo" class="form-label">Grupo</label>
                    <input type="text" class="form-control" name="grupo" id="grupo" value="<?= $grupo ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" name="modelo" id="modelo" value="<?= $modelo ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
    </div>

    <div class="card col-8 bg-white p-4 rounded shadow mb-4">
        <h4 class="text-center mb-3">Lista de Vehículos</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Matrícula</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Grupo</th>
                        <th scope="col">Disponible</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['matricula'] ?></td>
                        <td><?= $row['modelo'] ?></td>
                        <td><?= $row['grupo'] ?></td>
                        <td><?= $row['disponible'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between col-8">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoVehiculo">Nuevo</button>
        <button type="button" class="btn btn-primary" onclick="modificarVehiculo()">Modificar</button>
        <button type="button" class="btn btn-warning" onclick="renovarVehiculo()">Renovar</button>
    </div>
</main>

<!-- Modal para nuevo vehículo -->
<div class="modal fade" id="nuevoVehiculo" tabindex="-1" aria-labelledby="nuevoVehiculoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoVehiculoLabel">Agregar Nuevo Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="NuevoVehiculo.php" method="post">
                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" name="matricula" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" name="modelo" required>
                    </div>
                    <div class="mb-3">
                        <label for="grupo" class="form-label">Grupo</label>
                        <input type="text" class="form-control" name="grupo" required>
                    </div>
                    <div class="mb-3">
                        <label for="disponible" class="form-label">Disponible</label>
                        <select class="form-select" name="disponible">
                            <option value="Sí">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function modificarVehiculo() {
    alert("Funcionalidad de modificar vehículo aún no implementada.");
}

function renovarVehiculo() {
    alert("Funcionalidad de renovar vehículo aún no implementada.");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

