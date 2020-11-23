<!-- Modal -->
<div class="modal fade" id="withdraw_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="" method="post">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar solicitud</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id_withdraw" id="id_withdraw">
            <div class="form-group">
                <label for="">Estado</label>
                <select name="status" id="withdraw-status" class="form-control">
                    <?php
                        if(is_array($withdraw_status)){
                            foreach ($withdraw_status as $ws) {
                    ?>
                            <option value="<?= $ws["id_withdraw_status"] ?>"><?= $ws["description"] ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Notas</label>
                <textarea name="notes" id="notes" cols="30" rows="7" class="form-control"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row"> 
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Historial de retiros</h4>
                <hr class="mb-4">
                <table id="table-withdraws" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                        <th scope="col">Codigo del retiro</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Cantidad (COP)</th>
                            <th scope="col">Fecha de solicitud</th>
                            <th scope="col">Notas</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($withdraws) && is_array($withdraws)){
                                $x = 1;
                                foreach ($withdraws as $withdraw) {
                        ?>
                            <tr>
                                <td><strong><?= strtoupper($withdraw["slug_withdraw"]) ?></strong></td>
                                <td><div class="badge badge-<?= get_class_by_status($withdraw["description"]) ?> float-right"><?= $withdraw["description"] ?></div></td>
                                <td>$<?= number_format($withdraw["total"], 0, ',', '.') ?> COP</td>
                                <td><?= date("d M, Y H:i:s", strtotime($withdraw["created_at"])) ?></td>
                                <td>
                                <?php
                                        if($this->encryption->decrypt($withdraw["user_notes"]) != ""){
                                            echo '<p style="background: #e6e6e6;padding: 5px;border-radius: 6px;margin:0;line-height: 15px;font-size: 12px;margin-bottom:2px;">Cliente: '. $this->encryption->decrypt($withdraw["user_notes"]) .'</p>';
                                        }
                                    ?>
                                    
                                    <?php
                                        if($withdraw["notes"] != ""){
                                            echo '<p style="background: #b2dcd3;padding: 5px;border-radius: 6px;margin:0;line-height: 15px;font-size: 12px;">Admin: '. $withdraw["notes"] .'</p>';
                                        }
                                    ?>
                                </td>
                                <td class="text-center" style="width:160px;">
                                    <?php
                                        if(is_admin()){
                                    ?>
                                        <button data='<?= json_encode($withdraw) ?>'  type="button" class="btn btn-primary btn-sm edit-withdraw-button">Editar</button>
                                    <?php
                                        }
                                    ?>
                                    <div class="btn-group dropleft mt-2 mr-1">
                                        <button class="btn btn-warning dropdown-toggle btn-sm" type="button" id="dropdownMenutext" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Datos Bancarios <em class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></em>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg p-3" aria-labelledby="dropdownMenutext" x-placement="left-start">
                                            <div class="text-muted">
                                                <strong>Datos Bancarios</strong>
                                                <hr>
                                                <p style="margin:0;"><strong>Nombre:</strong> <?= $this->encryption->decrypt($withdraw["name"]) ?> </p>
                                                <p style="margin:0;"><strong>Tipo de documento:</strong> <?= $this->encryption->decrypt($withdraw["document_type"]) ?> </p>
                                                <p style="margin:0;"><strong>Número de documento:</strong> <?= $this->encryption->decrypt($withdraw["document_number"]) ?> </p>
                                                <p style="margin:0;"><strong>Banco:</strong> <?= $this->encryption->decrypt($withdraw["bank"]) ?> </p>
                                                <p style="margin:0;"><strong>Tipo de cuenta:</strong> <?= $this->encryption->decrypt($withdraw["account_type"]) ?> </p>
                                                <p style="margin:0;"><strong>Número de cuenta:</strong> <?= $this->encryption->decrypt($withdraw["account_number"]) ?> </p>
                                            </div>
                                        </div>
                                    </div>
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