<?php
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="">Fecha inicial</label>
                            <input type="text" id="start-date-report" name="start_date" class="form-control flatpickr-input" placeholder="" value="<?= (isset($start_date)) ? $start_date : date("Y-m-").'01' ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">Fecha final</label>
                            <input type="text" id="end-date-report" name="end_date" class="form-control flatpickr-input" placeholder="" value="<?= (isset($end_date)) ? $end_date : date("Y-m-d") ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="">Departamento</label>
                            <select name="state" id="" class="form-control">
                                <option value="0">Ver todos</option>
                                <?php
                                    if(isset($states) && is_array($states)){
                                        $x = 1;
                                        foreach ($states as $s) {
                                ?>
                                    <option <?= ($state == $s["id"]) ? "selected" : "" ?> value="<?= $s["id"] ?>"><?= $s["name"] ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for=""></label>
                            <button class="btn btn-success btn-block">Ver Reporte</button>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for=""></label>
                            <a data-report="generateStatesReport" class="btn btn-orange btn-block" id="download-states-report">Descargar Excel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-reports-state" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Departamento</th>
                            <th scope="col">Billetes Vendidos</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Descuento</th>
                            <th scope="col">Total</th>
                            <th scope="col">Método pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($purchases) && is_array($purchases)){
                                $x = 1;
                                foreach ($purchases as $purchase) {
                        ?>
                            <tr>
                                <td ><?= strtoupper($purchase["report_description"]) ?></td>
                                <td ><?= $purchase["bills"] ?></td>
                                <td class="text-right">$<?= number_format($purchase["price_sum"], 0, ',', '.') ?> COP</td>
                                <td class="text-right">$<?= number_format($purchase["discount_sum"], 0, ',', '.') ?> COP</td>
                                <td class="text-right">$<?= number_format($purchase["price_sum"] - $purchase["discount_sum"], 0, ',', '.') ?> COP</td>
                                <td class="text-center"><span class="badge badge-<?= ($purchase["payment_method"] == "1") ? 'primary' : 'warning' ?>"><?= ($purchase["payment_method"] == "1") ? "PSE" : "Plataforma" ?></span></td>
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