<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de abonados</h4>
                <hr class="mb-4">
                <table id="table-subscribers" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Número</th>
                            <th scope="col">Serie</th>
                            <th scope="col">Cantidad sorteos</th>
                            <th scope="col">Cantidad restante</th>
                            <th scope="col">Fecha de compra</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($subscribers) && is_array($subscribers)){
                                $x = 1;
                                foreach ($subscribers as $subscriber) {
                        ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $x++; ?></th>
                                <td class="text-center"><?= $subscriber["number"] ?></td>
                                <td class="text-center"><?= $subscriber["serie"] ?></td>
                                <td class="text-center"><?= $subscriber["subscriber_amount"] ?></td>
                                <td class="text-center"><?= $subscriber["subscriber_remaining_amount"] ?></td>
                                <td><?= ucfirst(strftime('%B %d, %Y',strtotime($subscriber["created_at"]))) ?></td>
                                <td class="text-center">
                                    <a target="_blank" href="<?= base_url().'Main/invoice/'.$subscriber["user_slug"].'/'.$subscriber["slug"] ?>" class="btn btn-sm btn-success">Tiquete de compra</a>
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