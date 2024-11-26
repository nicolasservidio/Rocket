
 <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->




          <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
              <img
                src="assets/img/logo-red.png"
                alt="navbar brand"
                class="navbar-brand"
                height="45"
              />
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
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="index.php"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Inicio</p>
                </a>
                
              </li>

<?php
    $listaNavBar = [
        ["stock.php", "fas fa-archive", "Stock"],
        ["insumos.php", "fas fa-car", "Insumos a vehiculos"],
        ["ordenCompra.php", "fas fa-file-invoice-dollar", "Ordenes de compra"],
        ["proovedores.php", "fas fa-handshake", "Proveedores"]
    ];

    foreach ($listaNavBar as $entry) { 
        echo 
        "<li class=\"nav-item\">
            <a href=\"$entry[0]\">
                <i class=\"$entry[1]\"></i>
                <p>$entry[2]</p>
            </a>
        </li>";
        
    };
?>



              

            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->