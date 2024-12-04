
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->

        <div class="logo-header" data-background-color="dark">
            <a href="#" class="logo">
                <img src="assets/img/logo-red.png" alt="navbar brand" class="navbar-brand" height="45" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            <ul class="nav nav-secondary" >
                <li class="nav-item" id="inicio" onclick="activarItem(this, 'inicio')">
                    <a aria-expanded="false" href="indexGOp.php" > <!-- atributos: data-bs-toggle="collapse" class="collapsed"  -->
                        <i class="fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <li class="nav-item" id="vehiculos" onclick="activarItem(this, 'vehiculos')" >
                    <a aria-expanded="false" href="OpVehiculos.php" >
                        <i class="fas fa-car-side" ></i>
                        <p> Vehiculos </p>
                    </a>
                </li>

                <li class="nav-item" id="reservas" onclick="activarItem(this, 'reservas')" >
                    <a aria-expanded="false" href="reservas.php" >
                        <i class="fas fa-clipboard-list" ></i>
                        <p> Reservas </p>
                    </a>
                </li>

                <li class="nav-item" id="clientes" onclick="activarItem(this, 'clientes')" >
                    <a aria-expanded="false" href="clientes.php" >
                        <i class="fas fa-address-card" ></i>
                        <p> Clientes </p>
                    </a>
                </li>


                <?php  
                /* Dejo el registro de que utilizábamos este algoritmo, pero ya no lo necesitamos. No utilizar porque se rompe el script de JS */
                /*
                $listaNavBar = [
                    ["OpVehiculos.php", "fas fa-car-side", "Vehiculos"],  
                    ["reservas.php", "fas fa-clipboard-list", "Reservas"],
                    ["clientes.php", "fas fa-address-card", "Clientes"]
                ];


                foreach ($listaNavBar as $entry) {  ?>
                     
                    <li class="nav-item" id="activar" onclick="activarItem()" >
                        <a href=" <?php echo $entry[0]; ?> " >
                            <i class=" <?php echo $entry[1]; ?> " ></i>
                            <p> <?php echo $entry[2]; ?> </p>
                        </a>
                    </li>
                    
                <?php
                } 
                */
                ?>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

<script>

function activarItem(element, id) {

    // Remover la clase "active" de todos los elementos
    const items = document.querySelectorAll('.nav-item');
    items.forEach(item => item.classList.remove('active'));

    // Agregar la clase "active" al elemento cliqueado
    element.classList.add('active');

    // Guardar el estado activo en localStorage 
    localStorage.setItem('activeItem', id);
}

// Restaurar el estado activo al cargar la página a la cual fuimos redirigidos (ie, vehiculos, reservas o clientes):
document.addEventListener('DOMContentLoaded', () => {
    const activeItem = localStorage.getItem('activeItem');

    if (activeItem) { 
        const element = document.getElementById(activeItem);
        if (element) {
            element.classList.add('active');
        }
    }
});

</script>

