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
    <!-- Formulario de filtrado -->
    <div class="card col-8 bg-white p-4 rounded shadow mb-4">
        <h4 class="text-center mb-4">Filtrar Vehículos</h4>
        <form>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" placeholder="Ingrese la matrícula">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="grupo" class="form-label">Grupo</label>
                    <input type="text" class="form-control" id="grupo" placeholder="Ingrese el grupo">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" id="modelo" placeholder="Ingrese el modelo">
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla con los resultados -->
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
                    <!-- Aquí puedes añadir dinámicamente filas con datos -->
                    <tr>
                        <td>ABC123</td>
                        <td>Ford Focus</td>
                        <td>A</td>
                        <td>Sí</td>
                    </tr>
                    <tr>
                        <td>XYZ987</td>
                        <td>Toyota Corolla</td>
                        <td>B</td>
                        <td>No</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between col-8">
        <button type="button" class="btn btn-success">Nuevo</button>
        <button type="button" class="btn btn-primary">Modificar</button>
        <button type="button" class="btn btn-warning">Renovar</button>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
