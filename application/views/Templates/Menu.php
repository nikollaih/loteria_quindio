<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Menú</li>
                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="users"></i>
                        <span> Usuarios </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="email-inbox.html">Agregar</a>
                        </li>
                        <li>
                            <a href="email-read.html">Ver Todos</a>
                        </li>
                    </ul>
                </li>

                <?php
                    if(is_admin()){
                ?>
                    <li>
                        <a href="<?= base_url() . 'hobbies'; ?>">
                            <i data-feather="coffee"></i>
                            <span> Hobbies </span>
                        </a>
                    </li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->