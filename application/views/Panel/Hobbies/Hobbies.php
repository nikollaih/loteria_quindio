<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Agregar hobbie</h4>
                <hr class="mb-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de hobbies</h4>
                <hr class="mb-4">
                <table id="table-hobbies" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($hobbies) && is_array($hobbies)){
                                $x = 1;
                                foreach ($hobbies as $hobbie) {
                        ?>
                            <tr>
                                <th scope="row"><?= $x++; ?></th>
                                <td><?= $hobbie["name"] ?></td>
                                <td></td>
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