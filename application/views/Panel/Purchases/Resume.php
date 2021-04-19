<?php
 //  print_r($request["status"]->status);
?>
<div class="row">
    <div class="offset-lg-2 offset-sm-0 col-lg-8 col-md-8 col-sm-12 purchase-resume">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 label-<?= $request["status"]->status ?>">COMPRA FINALIZADA</h4>
                <div class="main-icon text-center mt-5">
                    <img width="170px" src="<?= base_url() ?>assets/images/receipt.svg" alt="" srcset="">
                    <p class="mt-3">Su compra ha sido procesada de manera exitosa, aquí puede ver la información correspondiente:</p>
                    <h3 class="mb-0 mt-4">Estado de la transacción</h3>
                    <h2 class="mt-0 font-bolt text-<?= $request["status"]->status ?>"><?php echo ($request) ? (convert_purchase_status($request["status"]->status)) : "Pendiente" ?></h2>

                    <?php 
                        if($request["status"]->status == "PENDING"){
                    ?>
                        <p>En este momento su compra #<b><?= $purchase["slug"] ?></b>
                        presenta un proceso de pago cuya transacción se encuentra <b>PENDIENTE</b> de recibir
                        confirmación por parte de su entidad financiera, por favor espere unos minutos y
                        vuelva a consultar más tarde para verificar si su pago fue confirmado de forma
                        exitosa. Si desea mayor información sobre el estado actual de su operación puede
                        comunicarse a nuestras líneas de atención al cliente (57-6) 7448509 - (57-6) 7412441 o
                        enviar un correo electrónico a <b><?= get_setting("commerce_email")  ?></b> y preguntar por el estado de la
                        transacción<?= (!empty($request["payment"])) ? "<b> ".$request["payment"][0]->authorization."</b>" : "." ?></p>
                    <?php
                        }
                    ?>

                </div>
                <div class="purchase-info-container mt-5">
                    <table class="table">
                        <tbody>
                        <tr>
                                <td><strong>NIT</strong></td>
                                <td class="text-right"><?= get_setting("nit") ?></td>
                            </tr>
                            <tr>
                                <td><strong>Razon social</strong></td>
                                <td class="text-right"><?= get_setting("commerce_name") ?></td>
                            </tr>
                            <tr>
                                <td><strong>Referencia</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["slug"]) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Dirección IP</strong></td>
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Estado</strong></td>
                                <td class="text-right"><?= convert_purchase_status($request["status"]->status) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Motivo</strong></td>
                                <td class="text-right"><?= $request["status"]->message ?></td>
                            </tr>
                            
                            <?php
                                if (!empty($request["payment"])){
                            ?>
                                <tr>
                                    <td><strong>Autorización / CUS</strong></td>
                                    <td class="text-right"><?= $request["payment"][0]->authorization ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Banco</strong></td>
                                    <td class="text-right"><?= $request["payment"][0]->issuerName ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Franquicia</strong></td>
                                    <td class="text-right"><?= $request["payment"][0]->franchise ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Recibo</strong></td>
                                    <td class="text-right"><?= $request["payment"][0]->receipt ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td><strong>Descripción</strong></td>
                                <td class="text-right"><?= $request["request"]->payment->description ?></td>
                            </tr>
                            <tr>
                                <td><strong>Cliente</strong></td>
                                <td class="text-right"><?= $request["request"]->buyer->name ?></td>
                            </tr>
                            <tr>
                                <td><strong>Fecha y hora</strong></td>
                                <td class="text-right"><?= date("d/m/Y H:i:s", strtotime($request["status"]->date)) ?></td>
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
                                    <td class="text-right">COP <?= number_format($purchase["price"], 2 ,",",".") ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Descuento</strong></td>
                                    <td class="text-right">COP <?= number_format($purchase["discount"], 2 ,",",".") ?></td>
                                </tr>
                                <tr>
                                    <td class="total-text"><strong>Total</strong></td>
                                    <td class="text-right total-value"><strong>COP <?= number_format($purchase["price"] - $purchase["discount"], 2 ,",",".") ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4 ">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body purchase-info-container">
                                <p style="text-align: center;font-size: 12px;"><?= strtoupper(get_setting("commerce_name")) ?> 
                                    <br>LA DE TODOS!
                                    <br>Nit: <?= get_setting("nit") ?>.
                                    <br>Dirección: Carrera 16 No. 19 - 21, Armenia Quindío Colombia.
                                    <br>Teléfonos: (57-6) 7448509 - (57-6) 7412441 
                                        | Fax: (57-6) 7412441 
                                    <br>Correo Institucional: <a href="mailto:info@loteriaquindio.com.co">info@loteriaquindio.com.co</a>
                                    <br>Notificaciones Judiciales: <a href="mailto:juridica@loteriaquindio.com.co">juridica@loteriaquindio.com.co</a>
                                    <br>Horario de Atención: Lunes a Viernes: 08:00 AM - 12:00 M; 2:00 PM - 06:00 PM</p>
                            </div>
                        </div>    
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <?php
                            if($request["status"]->status == "APPROVED" || $request["status"]->status == "PENDING"){
                                ?>
                                <a href="<?= base_url() ?>panel" class="btn btn-success btn-lg printPageButton">Volver al inicio</a>
                                <?php
                            }
                            else {
                            ?>
                                <a href="<?= base_url() ?>Purchases/retry_payment/<?= $purchase["slug"] ?>" class="btn btn-success btn-lg printPageButton">Reintentar</a>
                            <?php
                            }
                        ?>
                        <button  onClick="window.print();" class="btn btn-success btn-lg printPageButton">Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .printPageButton {
            display: none;
        }
    }
</style>