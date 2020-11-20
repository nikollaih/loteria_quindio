<!-- Topbar Start -->
<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="<?= base_url() ?>panel" class="navbar-brand mr-0 mr-md-2 logo">
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logo.png" alt="Lotería del Quindío" height="40" />
            </span>
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/logo.png" alt="" height="24">
            </span>
        </a>

        <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
            <li class="d-none d-sm-block">
                <div class="app-search">
                    <p class="mb-0 mt-2 font-weight-bold" for="">Hola, <?php echo (isset($this->session->userdata("logged_in")["first_name"])) ? $this->session->userdata("logged_in")["first_name"] : "" ?></p>
                </div>
            </li>
            <li class="dropdown d-none d-lg-block" data-toggle="tooltip" data-placement="left">
                <a class="nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i data-feather="chevron-down"></i>
                </a>
                <div style="width:250px !important;" class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                    <a href="<?= base_url() . 'Usuarios/add_user/' . logged_user()['slug']; ?>" class="dropdown-item notify-item">
                        <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                        <span>Cuenta</span>
                    </a>
                    <a href="#" data-toggle="modal" data-target="#change_password_modal" class="dropdown-item notify-item">
                        <i data-feather="lock" class="icon-dual icon-xs mr-2"></i>
                        <span>Cambiar contraseña</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="<?= base_url() . 'usuarios/logout' ?>" class="dropdown-item notify-item">
                        <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                        <span>Cerrar Sesion</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>

</div>
<!-- end Topbar -->