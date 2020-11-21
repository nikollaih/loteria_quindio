
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