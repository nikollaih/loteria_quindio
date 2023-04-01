<!-- Modal -->
<div class="modal fade" id="winner_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="winner-form" action="" method="post">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="">Estado</label>
                <select name="status" id="winner-status" class="form-control">
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Enviado">Enviado</option>
                    <option value="Entregado">Entregado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Comentarios</label>
                <textarea name="comments" id="comments" cols="30" rows="7" class="form-control"></textarea>
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
                <h4 class="header-title mt-0">Lsita de premios</h4>
                <hr class="mb-4">
                <table id="table-winners" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Codigo del premio</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Comentarios</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($winners) && is_array($winners)){
                                $x = 1;
                                foreach ($winners as $winner) {
                        ?>
                            <tr>
                                <th scope="row">
                                    <img height="80px" src="<?= (@getimagesize(base_url().$winner["g_product_path"])) ? base_url().$winner["g_product_path"] : "https://dummyimage.com/600x400/bdbdbd/fff&text=Imagen no disponible" ?>" alt="<?= $winner["g_product_name"] ?>" srcset="">
                                </th>
                                <td><strong><?= strtoupper($winner["slug"]) ?></strong></td>
                                
                                <td><?= "P-".$winner["product_id"]. " " . $winner["g_product_name"] ?></td>
                                <td><div class="badge badge-<?= get_class_by_status($winner["status"]) ?> "><?= $winner["status"] ?></div></td>
                                <td>
                                <?php
                                        if($winner["comments"] != ""){
                                            echo '<p style="background: #e6e6e6;padding: 5px;border-radius: 6px;margin:0;line-height: 15px;font-size: 12px;margin-bottom:2px;">'. $winner["comments"] .'</p>';
                                        }
                                    ?>
                                </td>
                                <td class="text-center" style="width:160px;">
                                    <?php
                                        if(is_admin()){
                                    ?>
                                        <button data='<?= json_encode($winner) ?>'  type="button" class="btn btn-primary btn-sm edit-winner-button">Editar</button>
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