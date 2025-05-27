<div class="main-panel ">
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="index.html" class="logo">
                    <img src="assets/img/kaiadmin/logo_light.png" alt="navbar brand" class="navbar-brand" height="20" />
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



        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">


                <!-- Aparece titulo de pagina segun la pagina en la que este -->
                <?php if (isset($tituloPagina)): ?>
                <div class="navbar-center-title text-center w-100">
                    <h3 style="margin: 0;"><?php echo $tituloPagina; ?></h3>
                </div>
                <?php endif; ?>


                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm">
                                <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
                            </div>
                            <span class="profile-username">
                                <span class="op-7">Hola,</span>
                                <span class="fw-bold"> <?php echo $_SESSION["Nombre"]; ?> </span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg">
                                            <img src="assets/img/profile.jpg" alt="image profile"
                                                class="avatar-img rounded" />
                                        </div>
                                        <div class="u-text">
                                            <h4> <?php echo strtoupper($_SESSION["Nombre"]); ?> </h4>
                                            <p class="text-muted"> <?php echo $_SESSION["Cargo"]; ?> </p>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="cerrarsesion.php">Cerrar Sesión</a>

                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
        <!-- End Navbar -->


    </div>