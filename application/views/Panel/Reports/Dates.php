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
                            <label for=""></label>
                            <button class="btn btn-success btn-block">Ver Reporte</button>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for=""></label>
                            <a data-report="generateDatesReport" class="btn btn-orange btn-block" id="download-states-report">Descargar Excel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <div id="chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-reports-date" class="custom-datatable table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Número</th>
                            <th scope="col">Serie</th>
                            <th scope="col">Sorteo</th>
                            <th scope="col">Abonados</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($purchases) && is_array($purchases)){
                                $x = 1;
                                foreach ($purchases as $purchase) {
                        ?>
                            <tr>
                            <td><?= ucfirst(strftime('%B %d, %Y',strtotime($purchase["purchase_date"]))) ?></td>
                                <td class=""><?= $purchase["first_name"]." ".$purchase["last_name"] ?></td>
                                <td class="text-center"><?= $purchase["number"] ?></td>
                                <td class="text-center"><?= $purchase["serie"] ?></td>
                                <td class="text-center"><?= $purchase["draw_number"] ?></td>
                                <td class="text-center"><?= ($purchase["subscriber_amount"] > 0) ? "x".$purchase["subscriber_amount"] : "N/A" ?></td>
                                <td class="text-right">$<?= number_format($purchase["price"] - $purchase["discount"], 0, ',', '.') ?> COP</td>
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

<script>
    setTimeout(() => {
        var options = {
          series: [{
          name: 'Valor',
          data: [6900, 481000, 112000, 0, 481000, 112000]
        },
        {
          name: 'Descuento',
          data: [0, 61500, 12450, 0, 61500, 12450]
        }],
          chart: {
          type: 'bar',
          height: 400
        },
        plotOptions: {
          bar: {
            columnWidth: '10%',
          }
        },
        dataLabels: {
          enabled: false,
        },
        yaxis: {
          title: {
            text: 'Ventas por fecha',
          },
          labels: {
            formatter: function (y) {
              return "$" + y + " COP";
            }
          }
        },
        xaxis: {
          type: 'datetime',
          categories: [
            '2020-10-01', '2020-10-01', '2020-10-01', '2020-10-02', '2020-10-03'
          ],
          labels: {
            rotate: -90
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    }, 1000);
     
</script>