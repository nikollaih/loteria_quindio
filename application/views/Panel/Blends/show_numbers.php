<div class="row">
<!-- <?php if(is_admin()){ ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 add-blend-title">Agregar Mezcla</h4>
                <hr class="mb-4">
                <form action="" method="post" id="form-blend">
                    <input type="hidden" name="id" id="input_id_blend" value="null">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Desde (Número de 4 digitos)</label>
                                <input id="input_start_number" min="0000" max="" required name="start_number" type="number" minlength="4" maxlength="4" class="form-control max-length-check check-blend-start check-blend" placeholder="0000" value="<?= (isset($data_form)) ? $data_form["start_number"] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Hasta (Número de 4 digitos)</label>
                                <input id="input_end_number" min="" max="9999" required name="end_number" type="number" minlength="4" maxlength="4" class="form-control max-length-check check-blend-end check-blend" placeholder="0000" value="<?= (isset($data_form)) ? $data_form["end_number"] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Número de serie</label>
                                <input id="input_serie" required name="serie" type="number" minlength="3" maxlength="3" class="form-control max-length-check" placeholder="000" value="<?= (isset($data_form)) ? $data_form["serie"] : "" ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Estado</label>
                                <select name="blend_status" id="select_blend_status" class="form-control">
                                    <option <?php (isset($data_form) && $data_form["blend_status"] == 1) ? "selected" : "" ?> value="1">Activo</option>
                                    <option <?php (isset($data_form) && $data_form["blend_status"] == 0) ? "selected" : "" ?> value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($message)){
                    ?>
                        <p class="result-blend-action text-<?= $message["type"] ?>"><?= $message["message"] ?></p>
                    <?php
                        }
                    ?>
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <div class="form-group">    
                                <a class="btn btn-light btn-block cancel-edit-blend-button invisible" type="submit">Cancelar</a>
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
                    <?php } ?>   -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Lista de numeros de serie <?= $blend['serie']?></h4>
                <hr class="mb-4">
                <table id="table-blends" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Serie</th>
                            <th scope="col">Número</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($numbers) && is_array($numbers)){
                                foreach ($numbers as $number) {
                        ?>
                            <tr>
                            <td><?= $blend["serie"] ?></td>
                                <td><?= $number ?></td>
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