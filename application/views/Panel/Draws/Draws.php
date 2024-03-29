<!-- Modal -->
<div class="modal fade" id="draw-result" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="<?= base_url() ?>Files/import_result" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ingresar Resultado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h6 class="text-center">CARGAR EL ARCHIVO DE RESULTADOS DEL SORTEO</h6>
            <h2 class="text-center" id="draw-info">#2056 de 16 septiembre, 2020</h2>
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p for="" class="mb-0 font-weight-bold">Subir archivo</p>
                            <input id="input_result" required name="result" type="file" class="form-control-file text-center">
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar Resultados</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
    <?php 
        if(is_admin()){
    ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 add-draw-title">Agregar Sorteo</h4>
                    <hr class="mb-4">
                    <form action="" method="post" id="form-draw">
                        <input type="hidden" name="id" id="input_id_draw" value="<?= (isset($data_form)) ? $data_form["id"] : "null" ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">N&uacute;mero</label>
                                    <input id="input_draw_number" required name="draw_number" type="number" minlength="4" maxlength="4" class="form-control" placeholder="0000" value="<?= (isset($data_form)) ? $data_form["draw_number"] : "" ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha de juego</label>
                                    <input min="<?= date('Y-m-d') ?>" id="input_date" required name="date" type="text" class="form-control flatpickr-input active" value="<?= (isset($data_form)) ? $data_form["date"] : date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Producto (cantidad fracciones/valor por fracci&oacute;n)</label>
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
                            <div class="alert alert-<?= $message["type"] ?> alert-dismissible fade show" role="alert">
                                <?= $message["message"] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php
                            }
                        ?>
                        <div class="row justify-content-end">
                            <div class="col-md-3">
                                <div class="form-group">    
                                    <a class="btn btn-light btn-block cancel-edit-draw-button <?= (isset($data_form)) ? "" : "invisible" ?>" type="submit">Cancelar</a>
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
    <?php
        }
    ?>    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de sorteos</h4>
                <hr class="mb-4">
                <table id="table-draws" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">N&uacute;mero de sorteo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Resultado</th>
                            <th scope="col">Serie</th>
                            <?php 
        if(is_admin()){
    ?>
                            <th scope="col"></th>
        <?php } ?>
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
                                <td><?= ucfirst(strftime('%B %d, %Y',strtotime($draw["date"]))); ?></td>
                                <td><?= $draw["product_name"] ?> <?= $draw["fractions_count"]?>/$<?= $draw["fraction_value"]?>COP</td>
                                <td><?php echo ($draw["result"] != null) ? $draw["result"] : '<span class="badge badge-danger">No disponible</span>' ?></td>
                                <td><?php echo ($draw["serie"] != null) ? $draw["serie"] : '<span class="badge badge-danger">No disponible</span>' ?></td>
                                <?php 
        if(is_admin()){
    ?>
                                <td class="text-center" style="width:160px;">
                                    <?php
                                        if($draw["date"] <= date("Y-m-d"). " ".get_setting("close_draw_time")){
                                    ?>
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle gray-color" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                 <?php
                                                    if($draw["date"] <= date("Y-m-d"). " ".get_setting("close_draw_time") && $draw["result"] == null && $draw["nit"] == null){
                                                ?>
                                                    <a href="<?= base_url() ?>Results/import_result/<?= $draw["draw_slug"] ?>" data-formated-date="<?= ucfirst(strftime('%B %d, %Y',strtotime($draw["date"]))); ?>" data-columns='<?= json_encode($draw) ?>'  id="row-draw-<?= $draw['id'] ?>" data-id="<?= $draw['id'] ?>" type="button" class="dropdown-item">Agregar Resultado</a>
                                                <?php
                                                    }
                                                ?>

                                                <a href="<?= base_url() ?>Draws/generate_return/<?= $draw["draw_slug"] ?>" type="button" class="dropdown-item">Generar devoluci&oacute;n</a>
                                                <a href="<?= base_url() ?>Draws/generate_foreign_sales/<?= $draw["draw_slug"] ?>" type="button" class="dropdown-item">Generar foraneas</a>
                                            
                                                <?php
                                                    if($draw["nit"] != null){
                                                ?>
                                                    <a href="<?= base_url() ?>Draws/results/<?= $draw["draw_slug"] ?>" type="button" class="dropdown-item">Ver Resultados</a>
                                                <?php
                                                    }
                                                ?>
                                                <?php
                                                    if($draw["result"] != null && $draw["serie"] != null){
                                                ?>
                                                    <a href="<?= base_url() ?>Draws/winners/<?= $draw["draw_slug"] ?>" type="button" class="dropdown-item">Ver Ganadores</a>
                                                <?php
                                                    }
                                                ?>
                                                 <?php
                                                    if($draw["result"] != null && $draw["serie"] != null && $draw["confirmed_winners"] == 0){
                                                ?>
                                                    <a href="<?= base_url() ?>Winners/confirm_winners/<?= $draw["draw_slug"] ?>" type="button" class="dropdown-item">Confirmar Ganadores</a>
                                                <?php
                                                    }
                                                ?>
                                                <a href="" data-id='<?= $draw["id"] ?>'  data-number='<?= $draw["draw_number"] ?>' data-toggle="modal" data-target="#draw_result_image" type="button" class="dropdown-item modal-results-button">Imagen de resultados</a>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                        else{
                                            ?>
                                             <button data-name="<?= $draw["draw_number"] ?>" data-id="<?= $draw["id"] ?>" type="button" class="btn btn-primary btn-sm edit-draw-button">Editar</button>
                                <button data-name="<?= $draw["draw_number"] ?>" data-id="<?= $draw["id"] ?>" type="button" class="btn btn-danger btn-sm delete-draw-button">Eliminar</button>
                                            <?php
                                                }
                                    ?>
                                </td>
                                    <?php } ?>
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