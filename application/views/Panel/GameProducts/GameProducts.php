<div class="row">
<?php if(is_admin()){ ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 add-game_product-title">Agregar Producto</h4>
                <hr class="mb-4">
                <p><strong>Nota: </strong>Asegurese de que la imagen que desea subir para el producto sea de dimensiones cuadradas, esto para que no pierda la proporción a la hora de ser cargada al sistema.</p>
                <form action="" method="post" id="form-game_product" enctype="multipart/form-data">
                    <input type="hidden" name="id_game_product" id="input_id_game_product" value="<?= (isset($data_form)) ? $data_form["id_game_product"] : "null" ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Imagen</label>
                                <input id="g_product_path" name="g_product_path" type="file" class="form-control "  value="" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input id="g_product_name" required name="g_product_name" type="text" class="form-control  " placeholder="Nombre del producto (Plancha, Licuadora, etc.)" value="<?= (isset($data_form)) ? $data_form["g_product_name"] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Cantidad</label>
                                <input id="g_product_quantity" required name="g_product_quantity" type="number" class="form-control " placeholder="10" value="<?= (isset($data_form)) ? $data_form["g_product_quantity"] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Estado</label>
                                <select name="g_product_status" id="g_product_status" class="form-control">
                                    <option <?php (isset($data_form) && $data_form["g_product_status"] == 1) ? "selected" : "" ?> value="1">Activo</option>
                                    <option <?php (isset($data_form) && $data_form["g_product_status"] == 0) ? "selected" : "" ?> value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($message)){
                    ?>
                        <p class="result-game_product-action text-<?= $message["type"] ?>"><?= $message["message"] ?></p>
                    <?php
                        }
                    ?>
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <div class="form-group">    
                                <a class="btn btn-light btn-block cancel-edit-game_product-button invisible" type="submit">Cancelar</a>
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
                    <?php } ?>  
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de productos</h4>
                <hr class="mb-4">
                <table id="table-game_products" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Ref</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Estado</th>
                            <?php if(is_admin()){ ?>
                            <th scope="col"></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($game_products) && is_array($game_products)){
                                $x = 1;
                                foreach ($game_products as $game_product) {
                        ?>
                            <tr>
                                <th scope="row">
                                    <img height="80px" src="<?= (@getimagesize(base_url().$game_product["g_product_path"])) ? base_url().$game_product["g_product_path"] : "https://dummyimage.com/600x400/bdbdbd/fff&text=Imagen no disponible" ?>" alt="<?= $game_product["g_product_name"] ?>" srcset="">
                                </th>
                                <td><?= "P-". $game_product["id_game_product"] ?></td>
                                <td><?= $game_product["g_product_name"] ?></td>
                                <td><?= $game_product["g_product_quantity"] ?></td>
                                <td><?php echo ($game_product["g_product_status"] == 1) ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>' ?></td>
                                <?php if(is_admin()){ ?>
                                    <td class="text-center" style="width:160px;">
                                        <button data-columns='<?= json_encode($game_product) ?>' type="button" class="btn btn-primary btn-sm edit-game_product-button">Editar</button>
                                        <button id="row-game_product-<?= $game_product['id_game_product'] ?>" data-id="<?= $game_product['id_game_product'] ?>" type="button" class="btn btn-danger btn-sm delete-game_product-button">Eliminar</button>
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