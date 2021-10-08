<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="">Fecha inicial</label>
                            <input type="text" id="start-date-report" name="start_date" class="form-control flatpickr-input" placeholder="" value="<?= (isset($start_date)) ? $start_date : date("Y-m-").'01' ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">Fecha final</label>
                            <input type="text" id="end-date-report" name="end_date" class="form-control flatpickr-input" placeholder="" value="<?= (isset($end_date)) ? $end_date : date("Y-m-d") ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for=""></label>
                            <a class="btn btn-orange btn-block" id="download-users-report">Descargar Excel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
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
                            <?php
                                if($roles && is_array($roles)){
                                    foreach ($roles as $rol) {
                                    ?>
                                    <a role-id="<?= $rol["id"] ?>" class="dropdown-item slt-role" href="#"><?= $rol["name"] ?></a>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
                <hr class="mb-4">
                <table id="table-users" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Identificaci&oacute;n</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tel&eacute;fono</th>
                            <th scope="col">Direcci&oacute;n</th>
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
                                    <a href="<?= base_url() ?>Usuarios/add_user/<?= $user["slug"] ?>" class="btn btn-primary btn-sm text-light">Modificar</a>
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
</div>