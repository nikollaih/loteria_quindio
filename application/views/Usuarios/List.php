<div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <div class="row">
                <div class="col-md-6"><h4 class="header-title mt-0">Lista de usuarios</h4></div>
                <div class="col-md-6 text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" id="slt-role-text">Seleccionar rol (Administradores)</button>
                        <button type="button"
                            class="btn btn-success dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon"><span data-feather="chevron-down"></span></i>
                        </button>
                        <div class="dropdown-menu">
                            <a role-id="1" class="dropdown-item slt-role" href="#">Administradores</a>
                            <a role-id="2" class="dropdown-item slt-role" href="#">Clientes</a>
                        </div>
                    </div>
                </div>
            </div>
                <hr class="mb-4">
                <table id="table-users" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Identificación</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Dirección</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($users) && is_array($users)){
                                $x = 1;
                                foreach ($users as $user) {
                        ?>
                            <tr>
                                <td><?= $user["identification_number"] ?></td>
                                <td><?= $user["first_name"] . ' ' . $user["last_name"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["phone"] ?></td>
                                <td><?= $user["address"] ?></td>
                                <td class="text-center" style="width:160px;">
                                        <button id="row-user-<?= $user['id'] ?>" data-id="<?= $user['id'] ?>" type="button" class="btn btn-danger btn-sm delete-user-button">Eliminar</button>
                                </td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>