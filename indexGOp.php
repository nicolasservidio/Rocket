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

<body style="margin: 0 auto;">

    <div class="wrapper">

        <?php 
        include('sidebarGOp.php');
         $tituloPagina = "INICIO";
        include('topNavBar.php');  
        ?>
        
        <div class="container">

            <!-- Estilo para el mensaje de bienvenida -->
            <style>
                .text-title {
                    color: rgba(136, 4, 4, 0.91) !important; 
                    font-family: 'CameoAppearanceNF', cursive !important;
                    font-weight: 100;
                }
                .text-subtitle {
                    color:rgb(53, 21, 11) !important; 
                    font-family: 'Raleway', sans-serif;
                }

                .lead {
                    font-size: 1.3rem;
                    font-weight: 400;
                }
            </style>

            <div class="text-center mt-5 page-inner">
                <h1 class="display-4 text-title">Bienvenido a Rocket</h1> <br>
                <p class="lead text-muted text-subtitle">
                    Optimiza la gestión del alquiler de vehículos con herramientas inteligentes destinadas a administrar flotas, clientes, reservas y más. <br>
                    Usa los accesos rápidos a cada módulo y mejora la gestión de tu negocio.
                </p>
                <hr class="my-4">
            </div>

            
            <!-- Estilo para las tarjetas -->
            <style>
                .card-flip {
                    perspective: 1000px;
                    text-decoration: none;
                }

                .card {
                    width: 100%;
                    height: 250px;
                    position: relative;
                    transform-style: preserve-3d;
                    transition: transform 0.5s ease;
                }

                .card-front, .card-back {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    backface-visibility: hidden;
                }

                .card-front img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 10px;
                }

                .card-back {
                    background: rgba(136, 4, 4, 0.91);
                    color: white;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border-radius: 10px;
                    transform: rotateY(180deg);
                }

                .card-flip:hover .card {
                    transform: rotateY(180deg);
                }

                .card-back h3 {
                    font-family: 'Montserrat', sans-serif; 
                }
            </style>

            <div class="container">
                <div class="row justify-content-center page-inner">
                    <!-- Tarjeta VEHÍCULOS -->
                    <div class="col-md-4">
                        <a href="OpVehiculos.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/vehiculos.png" class="img-fluid" alt="Vehiculos">
                                </div>
                                <div class="card-back">
                                    <h3>Vehículos</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Tarjeta CLIENTES -->
                    <div class="col-md-4">
                        <a href="clientes.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/clientes.png" class="img-fluid" alt="Clientes">
                                </div>
                                <div class="card-back">
                                    <h3>Clientes</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Tarjeta RESERVAS -->
                    <div class="col-md-4">
                        <a href="reservas.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/reserva.png" class="img-fluid" alt="Reservas">
                                </div>
                                <div class="card-back">
                                    <h3>Reservas</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center page-inner">
                    <!-- Tarjeta CONTRATOS -->
                    <div class="col-md-4">
                        <a href="contratosAlquiler.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/contratos.png" class="img-fluid" alt="Contratos">
                                </div>
                                <div class="card-back">
                                    <h3>Contratos</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Tarjeta ENTREGAS -->
                    <div class="col-md-4">
                        <a href="entregaVehiculo.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/entregas.png" class="img-fluid" alt="Entregas">
                                </div>
                                <div class="card-back">
                                    <h3>Entregas</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Tarjeta DEVOLUCIONES -->
                    <div class="col-md-4">
                        <a href="devolucionVehiculo.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/devoluciones.png" class="img-fluid" alt="Devoluciones">
                                </div>
                                <div class="card-back">
                                    <h3>Devoluciones</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center page-inner">
                    <!-- Tarjeta PROVEEDORES -->
                    <div class="col-md-4">
                        <a href="proveedores.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/proveedores.png" class="img-fluid" alt="Proveedores">
                                </div>
                                <div class="card-back">
                                    <h3>Proveedores</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Tarjeta PEDIDOS A PROVEEDORES -->
                    <div class="col-md-4">
                        <a href="pedidosProveedores.php" class="card-flip">
                            <div class="card">
                                <div class="card-front">
                                    <img src="assets/img/pedidosproveedores.png" class="img-fluid" alt="PedidosProveedores">
                                </div>
                                <div class="card-back">
                                    <h3>Pedidos a Proveedores</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="page-inner">
                <?php 
                if ($_SESSION['Cargo'] == "Administrador" || 
                    $_SESSION['Cargo'] == "Gerente de Operaciones" ||
                    $_SESSION['Cargo'] == "Gerente Comercial" || 
                    $_SESSION['Cargo'] == "Gerente de Taller") { ?> 

                <div class="row">
                    <div class="col-md-4">
                        <div class="card-round">
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
                                                <a class="dropdown-item" href="#">Acción</a>
                                                <a class="dropdown-item" href="#">Otra acción</a>
                                                <a class="dropdown-item" href="#">Algo más aquí</a>
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
                                                <a class="dropdown-item" href="#">Acción</a>
                                                <a class="dropdown-item" href="#">Otra acción</a>
                                                <a class="dropdown-item" href="#">Algo más aquí</a>
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

                <?php 
                } 
                ?>
                
            </div>
        </div>

        <?php require_once "foot.php"?>

    </div>

</body>

</html>