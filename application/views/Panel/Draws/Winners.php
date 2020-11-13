<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de ganadores registrados para el sorteo #<?= $draw["draw_number"] ?></h4>
                <hr class="mb-4">
                <table id="table-winners" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Premio</th>
                            <th scope="col">Ganador</th>
                            <th scope="col">Resultado MAYOR</th>
                            <th scope="col">Serie MAYOR</th>
                            <th scope="col">Número Comprado</th>
                            <th scope="col">Serie Comprada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($winners) && is_array($winners)){
                                $x = 1;
                                foreach ($winners as $winner) {
                        ?>
                            <tr>
                                <td><?= $winner["reward_description"] ?></td>
                                <td><?= $winner["first_name"]." ".$winner["last_name"] ?></td>
                                <td><?= $winner["result"] ?></td>
                                <td><?= $winner["serie"] ?></td>
                                <td><?= $winner["number"] ?></td>
                                <td><?= $winner["purchase_serie"] ?></td>
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