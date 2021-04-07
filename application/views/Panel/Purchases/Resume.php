<?php
 //  print_r($request["status"]->status);
?>
<div class="row">
    <div class="offset-lg-4 offset-sm-2 col-lg-4 col-md-8 col-sm-12 purchase-resume">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">COMPRA FINALIZADA</h4>
                <div class="main-icon text-center mt-5">
                    <img width="170px" src="<?= base_url() ?>assets/images/receipt.svg" alt="" srcset="">
                    <p class="mt-3">Su compra ha sido procesada de manera exitosa, aquí puede ver la información correspondiente:</p>
                    <h3 class="mb-0 mt-4">Estado de la transacción</h3>
                    <h2 class="mt-0 font-bolt" style="color:#e9782c;"><?php echo ($request) ? $request["status"]->status : "Pendiente" ?></h2>
                </div>
                <div class="purchase-info-container mt-5">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Código de factura</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["slug"]) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Fecha</strong></td>
                                <td class="text-right"><?= date("d M, Y", strtotime($purchase["created_at"])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Número del billete</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["number"]) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Serie del billete</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["serie"]) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              
                <div class="row mt-4">
                    <div class="offset-lg-6 col-lg-6">
                        <table class="table total-table">
                            <tbody>
                                <tr>
                                    <td><strong>Valor</strong></td>
                                    <td class="text-right">$<?= number_format($purchase["price"], 0 ,",",".") ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Descuento</strong></td>
                                    <td class="text-right">$<?= number_format($purchase["discount"], 0 ,",",".") ?></td>
                                </tr>
                                <tr>
                                    <td class="total-text"><strong>Total</strong></td>
                                    <td class="text-right total-value"><strong>$<?= number_format($purchase["price"] - $purchase["discount"], 0 ,",",".") ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>