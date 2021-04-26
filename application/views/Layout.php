
<?php $this->load->view("Templates/Head") ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/app.min.css">
<body>
    <!-- Modal -->
    <div class="modal fade" id="generate_withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="withdraw-form">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Solicitud de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nombre completo</label>
                    <input type="text" name="name" id="name" class="form-control" required="required" value="<?= logged_user()["first_name"].' '.logged_user()["last_name"] ?>"/>
                </div>
                <div class="form-group">
                    <label for="">Tipo de documento</label>
                    <select name="document_type" id="document_type" class="form-control">
                        <?php
                            $it = get_identification_types();
                            if(is_array($it)){
                                for ($i=0; $i < count($it); $i++) { 
                        ?>
                                <option value="<?= $it[$i]["name"] ?>"><?= $it[$i]["name"] ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Número de documento</label>
                    <input readonly type="number" name="document_number" id="document_number" class="form-control" required="required" value="<?= logged_user()["identification_number"] ?>"/>
                </div>
                <div class="form-group">
                    <label for="">Banco</label>
                    <select name="bank" id="bank" class="form-control">
                        <?php
                        $banks = get_array_banks();
                            if(is_array($banks)){
                                for ($i=0; $i < count($banks); $i++) { 
                        ?>
                                <option value="<?= $banks[$i] ?>"><?= $banks[$i] ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Tipo de cuenta</label>
                    <select name="account_type" id="account_type" class="form-control">
                        <option value="Ahorros">Ahorros</option>
                        <option value="Corriente">Corriente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Número de cuenta</label>
                    <input type="number" name="account_number" id="account_number" class="form-control" required="required"/>
                </div>
                <div class="form-group">
                    <label for="">Notas</label>
                    <textarea name="user_notes" id="user_notes" cols="30" rows="7" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button href="#" type="submit" id="btn-save-generate-withdraw" class="btn btn-success">Enviar</button>
                <div style="display: none;" id="spinner-withdraw" class="spinner-border text-success m-2" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post" id="change-password-form" autocomplete="off">
                    <input type="hidden" name="" autocomplete="false">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Contraseña actual *</label>
                        <input autocomplete="off" type="password" name="current_password" id="current_password" class="form-control" required="required" value="<?= logged_user()["first_name"].' '.logged_user()["last_name"] ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="">Nueva contraseña *</label>
                        <input autocomplete="off" min-length="6" type="password" name="new_password" id="new_password" class="form-control" required="required" value="<?= logged_user()["identification_number"] ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="">Repetir nueva contraseña *</label>
                        <input autocomplete="off" min-length="6" type="password" name="r_new_password" id="r_new_password" class="form-control" required="required" value="<?= logged_user()["identification_number"] ?>"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button href="#" type="submit" id="btn-save-change-password" class="btn btn-success">Enviar</button>
                    <div style="display: none;" id="spinner-change-password" class="spinner-border text-success m-2" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="frequent_questions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Preguntas Frecuentes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="accordionExample">
                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading1">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                        <label style="cursor:pointer;">1. ¿Qué es Placetopay? </label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionExample">
                            <div class="card-body">
                                Placetopay es la plataforma de pagos electrónicos que usa <?= get_setting("commerce_name") ?> para procesar en línea las transacciones generadas en la tienda virtual con las formas de pago habilitadas para tal fin.  
                            </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading2">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                        <label style="cursor:pointer;">2. ¿Cómo puedo pagar? </label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample">
                            <div class="card-body">
                            En la tienda virtual de <?= get_setting("commerce_name") ?> usted podrá realizar su pago con los medios habilitados para tal fin. Usted, de acuerdo a las opciones de pago escogidas por el comercio, podrá pagar a través de Cuentas debito ahorro y corriente PSE.
                            </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading3">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                        <label style="cursor:pointer;">3. ¿Es seguro ingresar mis datos bancarios en este sitio web? </label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
                            <div class="card-body">
                            Para proteger tus datos <?= get_setting("commerce_name") ?> delega en Placetopay la captura de la información sensible. Nuestra plataforma de pagos cumple con los más altos estándares exigidos por la norma internacional PCI DSS de seguridad en transacciones con tarjeta de crédito. Además tiene certificado de seguridad SSL expedido por GeoTrust una compañía Verisign, el cual garantiza comunicaciones seguras mediante la encriptación de todos los datos hacia y desde el sitio; de esta manera te podrás sentir seguro a la hora de ingresar la información de su tarjeta.<br>Durante el proceso de pago, en el navegador se muestra el nombre de la organización autenticada, la autoridad que lo certifica y la barra de dirección cambia a color verde. Estas características son visibles de inmediato y dan garantía y confianza para completar la transacción en Placetopay. 
                            </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading4">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        <label style="cursor:pointer;">4. ¿Puedo realizar el pago cualquier día y a cualquier hora? </label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
                            <div class="card-body">
                            Sí, en <?= get_setting("commerce_name") ?> podrás realizar tus compras en línea los 7 días de la semana, las 24 horas del día a sólo un clic de distancia. 
                            </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading5">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                        <label style="cursor:pointer;">5. ¿Puedo cambiar la forma de pago?</label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionExample">
                            <div class="card-body">
                            Si aún no has finalizado tu pago, podrás volver al paso inicial y elegir la forma de pago que prefieras. Una vez finalizada la compra no es posible cambiar la forma de pago. 
                            </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading6">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                        <label style="cursor:pointer;">6. ¿Pagar electrónicamente tiene algún valor para mí como comprador? </label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
                            <div class="card-body">
                            No, los pagos electrónicos realizados a través de Placetopay no generan costos adicionales para el comprador.                             </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading7">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                        <label style="cursor:pointer;">7. ¿Qué debo hacer si mi transacción no concluyó?</label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionExample">
                            <div class="card-body">
                            En primera instancia, revisar si llegó un email de confirmación de la transacción a la cuenta de correo electrónico inscrita en el momento de realizar el pago, en caso de no haberlo recibido, deberás contactar a <?= get_setting("commerce_email") ?> para confirmar el estado de la transacción.                             </div>
                            </div>
                        </div>

                        <div class="card z-depth-0 bordered mb-2">
                            <div class="card-header" id="heading8">
                            <h5 class="mb-0 mt-0">
                                <button class="btn collapsed text-secondary" type="button" data-toggle="collapse"
                                data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                        <label style="cursor:pointer;">8. ¿Qué debo hacer si no recibí el comprobante de pago?</label>
                                </button>
                            </h5>
                            </div>
                            <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordionExample">
                            <div class="card-body">
                            Por cada transacción aprobada a través de Placetopay, recibirás un comprobante del
pago con la referencia de compra en la dirección de correo electrónico que indicaste al
momento de pagar. <br>
Si no lo recibes, podrás contactar a <?= get_setting("commerce_name") ?> o a las líneas (57-6) 7448509 - (57-6) 7412441 o al correo electrónico
<?= get_setting("commerce_email") ?>, para solicitar el reenvío del comprobante a la misma
dirección de correo electrónico registrada al momento de pagar.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" id="background-loading">
        <div class="text-center d-inline-flex justify-content-center background-loading">
            <div class="row align-middle justify-middle">
                <div class="col-md-12 align-self-center ">
                    <div class="spinner-border text-light m-2 " role="status">
                    </div>
                    <p class="text-light font-weight-bold fs-1">Cargando</p>
                </div>
            </div>
        </div>
    </div>
    <div id="wrapper">
        <?php $this->load->view("Templates/Header") ?>
        <?php $this->load->view("Templates/Menu") ?>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row page-title align-items-center">
                        <div class="col-sm-4 col-xl-6">
                            <h4 class="mb-1 mt-0"><?= $subtitle; ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $view; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Content -->
            <!-- Footer Start -->
            <?php $this->load->view("Templates/Footer") ?>
        </div>
        <!-- End Content Page -->
    </div>
    <!-- End Wrapper -->
</body>
</html>