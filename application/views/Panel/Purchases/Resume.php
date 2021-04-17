<?php
 //  print_r($request["status"]->status);
?>
<div class="row">
    <div class="offset-lg-4 offset-sm-0 col-lg-4 col-md-8 col-sm-12 purchase-resume">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 label-<?= $request["status"]->status ?>">COMPRA FINALIZADA</h4>
                <div class="main-icon text-center mt-5">
                    <img width="170px" src="<?= base_url() ?>assets/images/receipt.svg" alt="" srcset="">
                    <p class="mt-3">Su compra ha sido procesada de manera exitosa, aquí puede ver la información correspondiente:</p>
                    <h3 class="mb-0 mt-4">Estado de la transacción</h3>
                    <h2 class="mt-0 font-bolt text-<?= $request["status"]->status ?>"><?php echo ($request) ? (convert_purchase_status($request["status"]->status)) : "Pendiente" ?></h2>
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
                                <td><strong>Descripción</strong></td>
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
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Franquicia</strong></td>
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Banco</strong></td>
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Autorización / CUS</strong></td>
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recibo</strong></td>
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Descripción</strong></td>
                                <td class="text-right"><?= $_SERVER["REMOTE_ADDR"] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Cliente</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["first_name"]. " ".$purchase["last_name"]) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Mensaje</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["slug"]) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Referencia</strong></td>
                                <td class="text-right"><?= strtoupper($purchase["slug"]) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Fecha y hora</strong></td>
                                <td class="text-right"><?= date("d/m/Y H:i:s", strtotime($purchase["created_at"])) ?></td>
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

                <div class="row mt-4 purchase-info-container">
                    <div class="col-md-12">
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

                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <a href="<?= base_url() ?>panel" class="btn btn-success btn-lg printPageButton">Volver al inicio</a>
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