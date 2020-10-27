

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Resultados del ultimo sorteo jugado el <?= ucfirst(strftime('%b %d, %Y',strtotime($draw["date"]))); ?></h4>
                <hr class="mb-4">
                <table id="table-results" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Resultado</th>
                            <th scope="col">Serie</th>
                            <th scope="col">Sorteo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($results) && is_array($results)){
                                $x = 1;
                                foreach ($results as $result) {
                        ?>
                            <tr>
                                <td><?= $result["award_name"] ?></td>
                                <td><?= $result["result_number"] ?></td>
                                <td><?= $result["result_serie"] ?></td>
                                <td><?= $draw["draw_number"] ?></td>
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