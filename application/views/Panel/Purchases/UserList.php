<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de compras</h4>
                <hr class="mb-4">
                <table id="table-purchases" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Estado</th>
                            <th scope="col">Sorteo #</th>
                            <th scope="col">Fecha del sorteo</th>
                            <th scope="col">Número</th>
                            <th scope="col">Serie</th>
                            <th scope="col">Fracciones</th>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($purchases) && is_array($purchases)){
                                $x = 1;
                                foreach ($purchases as $purchase) {
                        ?>
                            <tr>
                                <th scope="row"><span class="badge badge-primary">Pendiente</span></th>
                                <td class="text-center"><?= $purchase["draw_number"] ?></td>
                                <td><?= ucfirst(strftime('%B %d, %Y',strtotime($purchase["date"]))) ?></td>
                                <td class="text-center"><?= $purchase["number"] ?></td>
                                <td class="text-center"><?= $purchase["serie"] ?></td>
                                <td class="text-center"><?= $purchase["parts"] ?></td>
                                <td><?= ucfirst(strftime('%B %d, %Y',strtotime($purchase["created_at"]))) ?></td>
                                <td class="text-center">$<?= number_format($purchase["price"], 0, ',', '.') ?> COP</td>
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