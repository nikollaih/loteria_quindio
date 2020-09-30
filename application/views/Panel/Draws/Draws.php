<!-- Modal -->
<div class="modal fade" id="draw-result" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingresar Resultado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 class="text-center">INGRESAR RESULTADO Y SERIE DEL SORTEO</h6>
        <h2 class="text-center" id="draw-info">#2056 de 16 septiembre, 2020</h2>
        <form action="">
            <input type="hidden" name="id" id="result-id">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="" class="text-center mb-0 font-weight-bold">RESULTADO</p>
                        <input id="input_result" required name="result" type="number" minlength="4" maxlength="4" class="form-control text-center" placeholder="0000" value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <p for="" class="text-center mb-0 font-weight-bold">SERIE</p>
                        <input id="input_serie" required name="serie" type="number" minlength="3" maxlength="3" class="form-control text-center" placeholder="000" value="">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 add-draw-title">Agregar Sorteo</h4>
                <hr class="mb-4">
                <form action="" method="post" id="form-draw">
                    <input type="hidden" name="id" id="input_id_draw" value="null">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Número</label>
                                <input id="input_draw_number" required name="draw_number" type="number" minlength="4" maxlength="4" class="form-control" placeholder="0000" value="<?= (isset($data_form)) ? $data_form["draw_number"] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Fecha</label>
                                <input min="<?= date('Y-m-d') ?>" id="input_date" required name="date" type="text" class="form-control flatpickr-input active" value="<?= (isset($data_form)) ? $data_form["date"] : date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Producto (cantidad fracciones/valor por fracción)</label>
                                <select name="product_id" class="custom-select d-block w-100 bill-data" id="product-id" required="">
                                    <?php
                                    if(isset($products) && is_array($products)){
                                        $x = 1;
                                        foreach ($products as $product) {
                                    ?>
                                    <option value="<?= $product["id"] ?>"><?= $product["product_name"] ?> <?= $product["fractions_count"] ?>/$<?= $product["fraction_value"] ?>COP</option>
                                    <?php
                                    }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($message)){
                    ?>
                        <p class="result-draw-action text-<?= $message["type"] ?>"><?= $message["message"] ?></p>
                    <?php
                        }
                    ?>
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <div class="form-group">    
                                <a class="btn btn-light btn-block cancel-edit-draw-button invisible" type="submit">Cancelar</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-success btn-block" type="submit">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de sorteos</h4>
                <hr class="mb-4">
                <table id="table-draws" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Número de sorteo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Resultado</th>
                            <th scope="col">Serie</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($draws) && is_array($draws)){
                                $x = 1;
                                foreach ($draws as $draw) {
                        ?>
                            <tr>
                                <th scope="row"><?= $x++; ?></th>
                                <td><?= $draw["draw_number"] ?></td>
                                <td><?= $draw["date"] ?></td>
                                <td><?= $draw["product_name"] ?> <?= $draw["fractions_count"]?>/$<?= $draw["fraction_value"]?>COP</td>
                                <td><?php echo ($draw["result"] != null) ? $draw["result"] : '<span class="badge badge-danger">No disponible</span>' ?></td>
                                <td><?php echo ($draw["serie"] != null) ? $draw["serie"] : '<span class="badge badge-danger">No disponible</span>' ?></td>
                                <td class="text-center" style="width:160px;">
                                    <?php
                                        if($draw["date"] <= date("Y-m-d") && $draw["result"] == null){
                                    ?>
                                        <button data-columns='<?= json_encode($draw) ?>' data-toggle="modal" data-target="#draw-result" id="row-draw-<?= $draw['id'] ?>" data-id="<?= $draw['id'] ?>" type="button" class="btn btn-success btn-sm btn-add-result">Agregar Resultado</button>
                                    <?php
                                        }
                                    ?>
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