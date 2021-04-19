<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <?php
                    if(true){
                ?>
                    <li>
                        <a href="javascript: void(0);">
                            <span> Saldo: $ <?= number_format(get_user_profile()["balance_total"], 0, ',', '.') ?> COP </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="#" id="btn-generate-withdraw">Solicitar retiro</a>
                            </li>
                            <li>
                                <a href="<?= base_url() . 'Withdraws'; ?>">Historial de retiros</a>
                            </li>
                        </ul>
                    </li>
                    
                <?php
                    }
                ?>
                <li class="menu-title">Menú</li>
                
                <?php
                    if(is_admin() || is_assistant()){
                        if(is_admin()){
                ?>
                    <li>
                        <a href="javascript: void(0);">
                            <em data-feather="users"></em>
                            <span> Usuarios </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="<?= base_url() . 'Usuarios/List'; ?>">Ver Todos</a>
                            </li>
                            <li>
                                <a href="<?= base_url() . 'Usuarios/add_user'; ?>">Agregar Nuevo</a>
                            </li>
                            <li>
                                <a href="<?= base_url() . 'Hobbies'; ?>">Hobbies</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);">
                            <em data-feather="tag"></em>
                            <span> Productos del juego </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="<?= base_url() ?>GameProducts">Ver Todos</a>
                            </li>
                            <li>
                                <a href="<?= base_url() ?>Games/Winners">Ganadores</a>
                            </li>
                        </ul>
                    </li>
                <?php
                        }
                ?>
                    <li>
                        <a href="<?= base_url() . 'Purchases/user_list'; ?>">
                            <em data-feather="dollar-sign"></em>
                            <span> Compras </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() . 'Withdraws'; ?>">
                            <em data-feather="credit-card"></em>
                            <span> Solicitudes de retiro </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() . 'Winners/manage_rewards'; ?>">
                            <em data-feather="dollar-sign"></em>
                            <span> Premios </span>
                        </a>
                    </li>
                    <li>
                    <a href="javascript: void(0);">
                        <em data-feather="trending-up"></em>
                        <span> Reportes </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="<?= base_url() . 'Reports/by_date'; ?>">Por Fecha</a>
                        </li>
                        <li>
                            <a href="<?= base_url() . 'Reports/by_state'; ?>">Por Departamento</a>
                        </li>
                    </ul>
                </li>
                    <li>
                        <a href="<?= base_url() . 'Draws'; ?>">
                            <em data-feather="star"></em>
                            <span> Sorteos </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <em data-feather="settings"></em>
                            <span> Mezclas </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a href="<?= base_url() . 'Blends'; ?>">Ver Todas</a>
                            </li>
                            <li>
                                <a href="<?= base_url() . 'Blends/import'; ?>">Importar</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url() . 'Products'; ?>">
                            <em data-feather="tag"></em>
                            <span> Productos </span>
                        </a>
                    </li>
                <?php
                    }
                ?>
                <?php
                    if(is_client()){
                ?>
                        <li>
                            <a href="javascript: void(0);">
                                <em data-feather="dollar-sign"></em>
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
                            <a href="<?= base_url() . 'games/my_rewards' ?>">
                                <em data-feather="award"></em>
                                <span> Premios fisicos </span>
                            </a>
                        </li>
                <?php
                    }
                ?>
                <li>
                    <a href="<?= base_url() . 'Purchases/user_subscriber'; ?>">
                        <em data-feather="refresh-cw"></em>
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