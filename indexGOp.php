<?php 

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Incluyo el script con la funcion que genera mi listado
require_once 'funciones/vehiculos listado.php';

$ListadoVehiculos = ListarVehiculos_OrderByFecha($conexion);
$CantidadVehiculos = count($ListadoVehiculos);

require_once 'funciones/Select_Tablas.php';
$ListadoUsuarios = Listar_Usuarios($conexion);
$CantidadUsuarios = count($ListadoUsuarios);


include('head.php');

?>

<body>
    <?php 
    if ($_SESSION['Cargo'] == "Administrador" || 
        $_SESSION['Cargo'] == "Gerente de Operaciones" ||
        $_SESSION['Cargo'] == "Gerente Comercial" || 
        $_SESSION['Cargo'] == "Gerente de Taller") { ?>    

        <div class="wrapper">

            <?php 
            include('sidebarGOp.php');
             $tituloPagina = "INICIO";
            include('topNavBar.php');  
            ?>
            
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3"> 
                            <a href="OpVehiculos.php">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-car"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Vehículos</p>
                                                <h4 class="card-title"> <?php echo $CantidadVehiculos; ?> </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            </a>
                        </div> 
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                                <i class="fas fa-tint"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Rutinas de Preparación</p>
                                                <h4 class="card-title">En construcción</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Repuestos</p>
                                                <h4 class="card-title">En construcción</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-cubes"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Productos</p>
                                                <h4 class="card-title">En construcción</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                <i class="far fa-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Reportes</p>
                                                <h4 class="card-title">3</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Historial de Uso</div>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                                <span class="btn-label">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                Exportar
                                            </a>
                                            <a href="#" class="btn btn-label-info btn-round btn-sm">
                                                <span class="btn-label">
                                                    <i class="fa fa-print"></i>
                                                </span>
                                                Imprimir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="min-height: 375px">
                                        <canvas id="statisticsChart"></canvas>
                                    </div>
                                    <div id="myChartLegend"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-primary card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Generación de Reportes</div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-label-light dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Reportes
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Operaciones</a>
                                                    <a class="dropdown-item" href="#">Repuestos según vehículo</a>
                                                    <a class="dropdown-item" href="#">Productos según vehículo</a>
                                                    <!-- <a class="dropdown-item" href="#">Something else here</a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-category">Seleccioná un tipo de reporte</div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-5">
                                        <a href="ReporteReservas.php"> <h2 style="color: white; font-weight: 100;" >Reservas de vehículos</h2> </a>
                                        <a href="ReporteContratos.php"> <h2 style="color: white; font-weight: 100;" >Contratos de alquiler</h2> </a>
                                        <a href="ReporteContratos_FrecMensuales.php"> <h4 style="color: white; font-weight: 100;"> Contratos por mes segmentados por estado </h4> </a>
                                    </div>
                                    <div class="pull-in">
                                        <canvas id="dailySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card card-round">
                                <div class="card-body pb-0">
                                    <div class="h1 fw-bold float-end text-primary">+5%</div>
                                    <h2 class="mb-2"> NA </h2>
                                    <p class="text-muted">Vehículos en preparación (En construcción) </p>
                                    <div class="pull-in sparkline-fix">
                                        <div id="lineChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row card-tools-still-right">
                                        <h4 class="card-title">Users Geolocation</h4>
                                        <div class="card-tools">
                                            <button class="btn btn-icon btn-link btn-primary btn-xs">
                                                <span class="fa fa-angle-down"></span>
                                            </button>
                                            <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
                                                <span class="fa fa-sync-alt"></span>
                                            </button>
                                            <button class="btn btn-icon btn-link btn-primary btn-xs">
                                                <span class="fa fa-times"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="card-category">
                                        Map of the distribution of users around the world
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive table-hover table-sales">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="flag">
                                                                    <img src="assets/img/flags/id.png" alt="indonesia" />
                                                                </div>
                                                            </td>
                                                            <td>Indonesia</td>
                                                            <td class="text-end">2.320</td>
                                                            <td class="text-end">42.18%</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="flag">
                                                                    <img src="assets/img/flags/us.png" alt="united states" />
                                                                </div>
                                                            </td>
                                                            <td>USA</td>
                                                            <td class="text-end">240</td>
                                                            <td class="text-end">4.36%</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="flag">
                                                                    <img src="assets/img/flags/au.png" alt="australia" />
                                                                </div>
                                                            </td>
                                                            <td>Australia</td>
                                                            <td class="text-end">119</td>
                                                            <td class="text-end">2.16%</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="flag">
                                                                    <img src="assets/img/flags/ru.png" alt="russia" />
                                                                </div>
                                                            </td>
                                                            <td>Russia</td>
                                                            <td class="text-end">1.081</td>
                                                            <td class="text-end">19.65%</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="flag">
                                                                    <img src="assets/img/flags/cn.png" alt="china" />
                                                                </div>
                                                            </td>
                                                            <td>China</td>
                                                            <td class="text-end">1.100</td>
                                                            <td class="text-end">20%</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="flag">
                                                                    <img src="assets/img/flags/br.png" alt="brazil" />
                                                                </div>
                                                            </td>
                                                            <td>Brasil</td>
                                                            <td class="text-end">640</td>
                                                            <td class="text-end">11.63%</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mapcontainer">
                                                <div id="world-map" class="w-100" style="height: 300px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Contactos</div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-list py-4">

                                        <?php 
                                        
                                        $decrementoUsuarios = 6;

                                        for ($i= ($CantidadUsuarios - 7); $i < $CantidadUsuarios; $i++) { 
                                                    
                                            $ultimosSieteUsuarios = $CantidadUsuarios - $decrementoUsuarios;
                                            
                                            ?>

                                            <div class="item-list">
                                                <div class="avatar">
                                                    <span class="avatar-title rounded-circle border border-white bg-primary"> 
                                                        <?php echo substr($ListadoUsuarios[$i]['NombreUsuario'], 0, 1); ?> 
                                                    </span>
                                                </div>

                                                <div class="info-user ms-3">
                                                    <div class="username"> <?php echo $ListadoUsuarios[$i]['NombreUsuario']; ?> </div>
                                                    <div class="status"> Username: <?php echo $ListadoUsuarios[$i]['Usuario']; ?> </div>
                                                    <div class="status"> <?php echo $ListadoUsuarios[$i]['NombreCargo']; ?> </div>
                                                </div>

                                                <button class="btn btn-icon btn-link op-8 me-1">
                                                    <i class="far fa-envelope"></i>
                                                </button>

                                                <button class="btn btn-icon btn-link btn-danger op-8">
                                                    <i class="fas fa-bolt"></i>
                                                </button>
                                            </div>

                                            <?php 
                                                $decrementoUsuarios = $decrementoUsuarios - 1;
                                            ?>

                                        <?php 
                                        } 
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Últimos vehículos registrados</div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">

                                        <!-- Tabla de vehículos -->

                                        <table class="table align-items-center mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Número de vehículo</th>
                                                    <th scope="col" class="text-end">Fecha de Compra</th>
                                                    <th scope="col" class="text-end">Matrícula</th>
                                                    <th scope="col" class="text-end">Incorporación a Flota</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php 

                                                $decremento = 8;

                                                for ($i= ($CantidadVehiculos - 9); $i < $CantidadVehiculos; $i++) { 
                                                    
                                                    $numerovehiculo = $CantidadVehiculos - $decremento;
                                                    
                                                    ?>

                                                    <tr>
                                                        <th scope="row">
                                                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            Vehículo #<?php echo $numerovehiculo; ?>
                                                        </th>

                                                        <td class="text-end"> <?php echo $ListadoVehiculos[$i]['vFechaCompra'];  ?> </td>

                                                        <td class="text-end"> <?php echo $ListadoVehiculos[$i]['vMatricula'];  ?> </td>

                                                        <td class="text-end">
                                                            <span class="badge badge-success">Completado</span>
                                                        </td>

                                                    </tr>

                                                    <?php 
                                                    $decremento = $decremento - 1;
                                                    ?>
                                                <?php 
                                                } 
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once "foot.php"?>

        </div>

    <?php 
    } 
    ?>

</body>

</html>