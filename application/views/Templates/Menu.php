<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Menú</li>
                
                <?php
                    if(is_admin()){
                ?>
                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="users"></i>
                            <span> Usuarios </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="<?= base_url() . 'Usuarios/List'; ?>">Ver Todos</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url() . 'Draws'; ?>">
                            <i data-feather="star"></i>
                            <span> Sorteos </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() . 'Blends'; ?>">
                            <i data-feather="settings"></i>
                            <span> Mezclas </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() . 'Hobbies'; ?>">
                            <i data-feather="coffee"></i>
                            <span> Hobbies </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url() . 'Products'; ?>">
                            <i data-feather="tag"></i>
                            <span> Productos </span>
                        </a>
                    </li>
                <?php
                    }
                ?>
                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="dollar-sign"></i>
                        <span> Compras </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="<?= base_url() . 'Purchases'; ?>">Nueva Compra</a>
                        </li>
                        <li>
                            <a href="<?= base_url() . 'Purchases'; ?>/user_list">Mis Compras</a>
                        </li>
                    </ul>
                </li>
                <li>
                        <a href="<?= base_url() . 'Purchases/user_subscriber'; ?>">
                            <i data-feather="refresh-cw"></i>
                            <span> Abonados </span>
                        </a>
                    </li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->