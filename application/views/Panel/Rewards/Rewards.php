<!-- Modal -->
<div class="modal fade" id="edit-reward-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar Aproximación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h4 id="reward_description" class="text-center"></h4>
            <input type="hidden" name="id_reward" id="id_reward">
            <div class="form-group">
                <p for="" class="mb-0 font-weight-bold">Billete Sin Descuento</p>
                <input id="bill_without_discount" required name="bill_without_discount" type="number" class="form-control">
            </div>
            <div class="form-group">
                <p for="" class="mb-0 font-weight-bold">Neto Billete</p>
                <input id="bill_with_discount" required name="bill_with_discount" type="number" class="form-control">
            </div>
            <div class="form-group">
                <p for="" class="mb-0 font-weight-bold">Total Plan</p>
                <input id="total_plan" required name="total_plan" type="number" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <a id="edit-reward-btn" class="btn btn-success text-white">Actualizar</a>
        </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-rewards" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Descripción</th>
                            <th scope="col">Valor sin descuento</th>
                            <th scope="col">Valor con descuento</th>
                            <th scope="col">Total</th>
                            <?php
                                if(is_admin()){
                            ?>
                                <th scope="col"></th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($rewards) && is_array($rewards)){
                                $x = 1;
                                foreach ($rewards as $reward) {
                        ?>
                            <tr>
                                <td ><strong><?= $reward["reward_description"] ?></strong></td>
                                <td class="text-right">$<?= number_format($reward["bill_without_discount"], 2, ',', '.') ?></td>
                                <td class="text-right">$<?= number_format($reward["bill_with_discount"], 2, ',', '.') ?></td>
                                <td class="text-right">$<?= number_format($reward["total_plan"], 2, ',', '.') ?></td>
                                <?php
                                    if(is_admin()){
                                ?>
                                    <td><button data-reward='<?= json_encode($reward) ?>' class="btn btn-sm btn-primary edit-reward">Editar</button></td>
                                <?php
                                    }
                                ?>
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