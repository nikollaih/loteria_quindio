<?php 
   $this->load->view('Templates/Head');
   ?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<script type="module" src="<?= base_url().'assets/js/main.js'; ?>"></script>
<body>
   <div class="row total-height mg-0">
      <div class="col-md-8 col-sm-12 bg-white d-flex justify-content-center align-items-center pt-4 pb-4">
         <div class="container width-90-percent">
           <!-- end col -->
           <div class="text-center mt-4">
                  <img class="text-center mb-5" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
               </div>
            <?php
              if(isset($message) && $message['success'] == true){
            ?>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">!Proceso exitoso!</h5>
                  <p class="card-text medium-text">Se ha enviado un email de confirmación al buzón de su correo electronico para la verificación de su dirección de correo. Es posible que el email haya llegado a su bandeja de Spam.</p>
                </div>
              </div>

            <?php
              }else{
            ?>
               <form class="needs-validation" novalidate="" method="post" class="form-signin" action="<?= base_url().'Usuarios/registro' ?>">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-body">
                        <?php
                     if(isset($message)){
                     ?>
                  <div class="alert alert-<?= $message["type"] ?>" role="alert"><?= $message["message"] ?></div>
                  <?php
                     }
                     ?>
                        <p class="text-right m-0 mb-1 fs-1">¿Ya tienes una cuenta? - <a class="text-success" href="<?= base_url() . 'usuarios/login' ?>">Inicia sesion</a></p>
                           <div id="smartwizard-arrows">
                              <ul>
                                 <li><a href="#sw-arrows-step-1">Cuenta<small class="d-block">Datos de la cuenta</small></a></li>
                                 <li><a href="#sw-arrows-step-2">Perfil<small class="d-block">Datos personales</small></a></li>
                                 <li><a href="#sw-arrows-step-3">Final<small class="d-block">Finalizar</small></a></li>
                              </ul>
                              <div class="p-3">
                                 <div id="sw-arrows-step-1">
                                    <input type="hidden" name="user[roles_id]" value="2" readonly>
                                    <p>Los campos marcados con <small class="text-danger fs-1">*</small> son campos obligatorios.</p>
                                    <hr>
                                    <div class="row mt-3">
                                       <div class="col-md-6 form-group">
                                          <label for="identification_type_id" >Tipo de documento <small class="text-danger fs-1">*</small></label>
                                          <select class="form-control" name="user[identification_type_id]" id="identification_type_id" required>
                                             <option value>--Seleccione el tipo de documento</option>
                                             <?php
                                                if($identification_types != false && is_array($identification_types)){
                                                foreach ($identification_types as $it) {
                                                ?>
                                             <option <?= (isset($data_form) && $data_form["user"]["identification_type_id"] == $it["id"]) ? "selected" : "" ?> value='<?= $it["id"] ?>'><?= $it["name"] ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="identification_number">Número de documento <small class="text-danger fs-1">*</small></label>
                                          <input placeholder="Ej: 123456789" type="number" id="identification_number" name="user[identification_number]" class="form-control" value="<?= (isset($data_form)) ? $data_form["user"]["identification_number"] : "" ?>" required>
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="name">Nombre <small class="text-danger fs-1">*</small></label>
                                          <input placeholder="Ejemplo" type="text" id="name" name="user[first_name]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["first_name"] : "" ?>">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="last_name">Apellidos <small class="text-danger fs-1">*</small></label>
                                          <input placeholder="Ejemplo" type="text" id="last_name" name="user[last_name]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["last_name"] : "" ?>">
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <label for="email">Correo electrónico <small class="text-danger fs-1">*</small></label>
                                          <input placeholder="ejemplo@correo.com" type="email" id="email" name="user[email]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["email"] : "" ?>">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="inputPassword">Contraseña <small class="text-danger fs-1">*</small></label>
                                          <input type="password" id="password" class="form-control check-password" name="user[password]" required value="<?= (isset($data_form)) ? $data_form["user"]["password"] : "" ?>">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="inputPassword">Confirmar contraseña <small class="text-danger fs-1">*</small></label>
                                          <input type="password" id="cpassword" class="form-control check-password" required>
                                       </div>
                                       <div class="col-md-12">
                                          <p class="text-danger d-none password-match-text">Las contraseñas no coinciden.</p>
                                       </div>
                                    </div>
                                 </div>
                                 <div id="sw-arrows-step-2">
                                 <p>Los campos marcados con <small class="text-danger fs-1">*</small> son campos obligatorios.</p>
                                 <hr>
                                    <div class="row">
                                    <div class="col-md-6 form-group">
                                          <label for="department" >Departamento <small class="text-danger fs-1">*</small></label>
                                          <select class="form-control state-select" name="department" id="department" required>
                                             <option value>--Seleccione un departamento</option>
                                             <?php
                                                if($states != false && is_array($states)){
                                                foreach ($states as $state) {
                                                ?>
                                             <option value='<?= $state["id"] ?>'><?= $state["name"] ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="city" >Ciudad <small class="text-danger fs-1">*</small></label>
                                          <select class="form-control city-select" name="user[city_id]" id="city" required>
                                             <option value>--Seleccione una ciudad</option>
                                          </select>
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="phone">Teléfono</label>
                                          <input placeholder="3212233444" min="7" type="number" id="phone" name="user[phone]" class="form-control" value="<?= (isset($data_form)) ? $data_form["user"]["phone"] : "" ?>">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label for="birth_date">Fecha de nacimiento</label>
                                          <input type="text" id="birth_date" name="user[birth_date]" class="form-control flatpickr-input active" placeholder="" value="<?= (isset($data_form)) ? $data_form["user"]["birth_date"] : "" ?>">
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <label for="phone">Dirección</label>
                                          <input placeholder="Ej: Calle 2 # 3 - 45" type="text" id="address" name="user[address]" class="form-control" value="<?= (isset($data_form)) ? $data_form["user"]["address"] : "" ?>">
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <label for="inputPassword">Hobbies</label>
                                          <select class="form-control wide custom-select2" name="hobbies[]" data-plugin="customselect" multiple="multiple">
                                             <?php
                                                if($hobbies != false && is_array($hobbies)){
                                                foreach ($hobbies as $hobbie) {
                                                ?>
                                             <option <?= (isset($data_form) && in_array($hobbie["id"], $data_form["hobbies"])) ? "selected" : "" ?> value='<?= $hobbie["id"] ?>'><?= $hobbie["name"] ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <!-- end row -->
                                 </div>
                                 <div id="sw-arrows-step-3">
                                    <div class="row">
                                       <div class="col-12">
                                          <div class="text-center">
                                             <div class="mb-3">
                                                <i class="uil uil-check-square text-success h2"></i>
                                             </div>
                                             <h3>Finalizar!</h3>
                                             <p class="w-75 mb-2 mx-auto text-muted">Para completar el registro por favot acepte los términos y condiciones y presione el botón "Terminar"</p>
                                             <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                   <input required type="checkbox" class="custom-control-input" id="sm-arrows-customCheck">
                                                   <label class="custom-control-label" for="sm-arrows-customCheck">Acepto los términos y condiciones</label>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       
                                       <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                    <div class="row mt-5 justify-content-md-end">
                     <div class="col-md-12">
                        <div class="row justify-content-center align-items-center">
                           <div class="col-md-4 justify-content-center align-items-center">
                              <button class="btn btn-lg btn-success btn-block mb-3" type="submit">Terminar</button>
                           </div>
                        </div>
                     </div>
                  </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end card -->
                  </div>
                  
               </form>
            <?php
              }
            ?>
             
         </div>
      </div>
      <div class="col-md-4 col-sm-12 d-none d-xs-none d-sm-none d-md-block bg-green justify-content-center align-items-center flex-column register-fixed">
         <div class="d-flex justify-content-center align-items-center flex-column h-100">
            <div class="loteria-title">
               Lotería Del Quindío
            </div>
            <div class="loteria-subtitle">
               ¡La de todos!
            </div>
            <br>
            <div class="width-70-percent mt-4">
               <img class="mb-4 text-center img-100" src="<?= base_url() ?>assets/images/signin-picture.svg">
            </div>
         </div>
      </div>
   </div>
</body>
</html>