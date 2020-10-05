
<?php $this->load->view("Templates/Head") ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/app.min.css">
<body>
<div id="invoice" class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
     <div class="card">
         <div class="card-header p-4">
            <img height="50" class="pt-2 d-inline-block" src="<?= base_url() ?>assets/images/logo.png" alt="Lotería del Quindío" srcset="">
             <div class="float-right text-right">
                 <h5 class="mb-0">Factura: <?= strtoupper($purchase["slug"]); ?></h5>
                 <label for=""><strong>Fecha:</strong> <?= ucfirst(strftime('%B %d, %Y',strtotime($purchase["purchase_date"]))) ?></label>
             </div>
         </div>
         <div class="card-body">
             <div class="row mb-4">
                 <div class="col-sm-6">
                     <h6 class="mb-3"></h6>
                     <h4 class="text-dark mb-1"><?= $purchase["first_name"].' '.$purchase["last_name"]; ?></h4>
                     <div><?= $purchase["address"] ?></div>
                     <div><?= strtoupper($purchase["city"]).', '. strtoupper($purchase["state"]); ?></div>
                     <div><strong>Email:</strong> <?= $purchase["email"] ?></div>
                     <?php
                        if(trim($purchase["phone"]) != ""){
                            echo "<strong>Teléfono: </strong>".$purchase["phone"];
                        }
                     ?>
                 </div>
                 <div class="col-sm-6 text-right">
                     <h6 class="mb-3"></h6>
                     <h4 class="text-dark mb-1">Lotería del Quíndio</h4>
                     <div>Nit: 365467363254-4</div>
                     <div><strong>Número de sorteo:</strong> <?= $purchase["draw_number"] ?></div>
                     <div><strong>Fecha del sorteo:</strong> <?= ucfirst(strftime('%B %d, %Y',strtotime($purchase["date"]))); ?></div>
                 </div>
             </div>
             <div class="table-responsive-sm">
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th class="center">#</th>
                             <th>Description</th>
                             <th class="text-right">Precio</th>
                             <th class="text-center">Qty</th>
                             <th class="text-right">Total</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td class="center">1</td>
                             <td class="left">
                                <?php 
                                    if($purchase["parts"] == $purchase["fractions_count"]){
                                        echo "Billete de lotería <br><strong>Número:</strong> ".$purchase["number"]. " <br><strong>Serie:</strong> ".$purchase["serie"];
                                    }
                                    else{
                                        echo $purchase["parts"] . " fracciones de un total de ".$purchase["fractions_count"]." <br><strong>Número:</strong> ".$purchase["number"]. " <br><strong>Serie:</strong> ".$purchase["serie"];
                                    }
                                ?>
                             </td>
                             <td class="text-right">$
                                <?php 
                                    if($purchase["parts"] == $purchase["fractions_count"]){
                                        echo number_format($purchase["parts"] * $purchase["fraction_value"], 0, ',', '.');
                                    }
                                    else{
                                        echo number_format($purchase["fraction_value"], 0, ',', '.');
                                    }
                                ?>
                                COP
                             </td>
                             <td class="text-center">
                                <?php 
                                    if($purchase["parts"] == $purchase["fractions_count"]){
                                        echo "1";
                                    }
                                    else{
                                        echo $purchase["parts"];
                                    }
                                ?>
                             </td>
                             <td class="text-right">$
                                <?php 
                                    if($purchase["parts"] == $purchase["fractions_count"]){
                                        echo number_format($purchase["fractions_count"] * $purchase["fraction_value"], 0, ',', '.');
                                    }
                                    else{
                                        echo number_format($purchase["fraction_value"] * $purchase["parts"], 0, ',', '.');
                                    }
                                ?>
                                COP
                             </td>
                         </tr>
                         <?php
                            if($purchase["subscriber_amount"] > 0){
                        ?>
                            <tr>
                                <td class="center">2</td>
                                <td class="left">
                                    <?php 
                                        echo "Sistema de abonados x".$purchase["subscriber_amount"]." sorteos";
                                    ?>
                                </td>
                                <td class="text-right">$
                                    <?php 
                                        echo number_format(($purchase["fractions_count"] * $purchase["fraction_value"]) * $purchase["subscriber_amount"], 0, ',', '.');
                                    ?>
                                    COP
                                </td>
                                <td class="text-center">1</td>
                                <td class="text-right">$
                                    <?php 
                                        echo number_format(($purchase["fractions_count"] * $purchase["fraction_value"]) * $purchase["subscriber_amount"], 0, ',', '.');
                                    ?>
                                    COP
                                </td>
                            </tr>
                        <?php
                            }
                         ?>
                     </tbody>
                 </table>
             </div>
             <div class="row">
                 <div class="col-lg-4 col-sm-5">
                 </div>
                 <div class="col-lg-4 col-sm-5 ml-auto">
                     <table class="table table-clear">
                         <tbody>
                             <tr>
                                 <td class="text-left">
                                     <strong class="text-dark">Subtotal</strong>
                                 </td>
                                 <td class="text-right">$ <?= number_format($purchase["price"], 0, ',', '.'); ?> COP</td>
                             </tr>
                             <tr>
                                 <td class="text-left">
                                     <strong class="text-dark">Descuento</strong>
                                 </td>
                                 <td class="text-right">$ <?= number_format($purchase["discount"], 0, ',', '.'); ?> COP</td>
                             </tr>
                             <tr>
                                 <td class="text-left">
                                     <strong class="text-dark">Total</strong> </td>
                                 <td class="text-right">
                                     <strong class="text-dark">$ <?= number_format($purchase["price"] - $purchase["discount"], 0, ',', '.'); ?> COP</strong>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
         <div class="card-footer bg-white">
             
         </div>
     </div>
 </div>
 <button id="printPageButton" class="btn btn-success" style="position:fixed;bottom:40px;right:40px;" onclick="window.print()">Imprimir</button>
</body>
</html>

<style>
    @media print {
        #printPageButton {
            display: none;
        }
    }
</style>