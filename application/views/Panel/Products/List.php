<div class="row">
<?php if(is_admin()){ ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 add-product-title">Agregar producto</h4>
                <hr class="mb-4">
                <form action="" method="post">
                    <input type="hidden" name="id" id="input_id_product" value="null">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="">Nombre del producto</label>
                            <input id="input_name_product" required name="product_name" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="">Cantidad de Fracciones</label>
                            <input id="input_fractions_count_product" required name="fractions_count" type="number" min="1"   class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="">Valor de cada fracción (COP)</label>
                            <input id="input_fraction_value_product" required name="fraction_value" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                   
                    
                    <?php
                        if(isset($message)){
                    ?>
                        <p class="result-product-action text-<?= $message["type"] ?>"><?= $message["message"] ?></p>
                    <?php
                        }
                    ?>
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <div class="form-group">    
                                <a class="btn btn-light btn-block cancel-edit-product-button invisible" type="submit">Cancelar</a>
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
                <h4 class="header-title mt-0">Lista de Productos</h4>
                <hr class="mb-4">
                <table id="table-products" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad de fracciones</th>
                            <th scope="col">Valor de cada fracción (COP)</th>
                            <?php if(is_admin()){ ?>
                            <th scope="col"></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($products) && is_array($products)){
                                $x = 1;
                                foreach ($products as $product) {
                        ?>
                            <tr>
                                <th scope="row"><?= $x++; ?></th>
                                <td><?= $product["product_name"] ?></td>
                                <td><?= $product["fractions_count"] ?></td>
                                <td>$<?= number_format($product["fraction_value"], 0, ',', '.') ?> COP</td>
                                <?php if(is_admin()){ ?>
                                <td class="text-center" style="width:160px;">
                                    <button data-name="<?= $product['product_name'] ?>" data-id="<?= $product['id'] ?>" data-fractions-count="<?= $product['fractions_count']?>" data-fraction-value="<?= $product['fraction_value']?>" type="button" class="btn btn-primary btn-sm edit-product-button">Editar</button>
                                    <button id="row-product-<?= $product['id'] ?>" data-id="<?= $product['id'] ?>" type="button" class="btn btn-danger btn-sm delete-product-button">Eliminar</button>
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