<?php 
  $this->load->view('Templates/Head');
?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<script type="module" src="<?= base_url().'assets/js/main.js'; ?>"></script>
<body>
  <div class="row total-height mg-0">
    <div class="col-md-8 col-sm-12 bg-white d-flex justify-content-center align-items-center pt-4 pb-4">
      <div class="container width-90-percent">
      <form method="post" class="form-signin" action="<?= base_url().'Usuarios/registro' ?>">
        <div class="text-center mb-4">
          <img class="mb-4 text-center mb-5" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
        </div>
        <!-- <h1 class="h3 mb-3 font-weight-normal mb-0">Registrarse</h1>
        <hr class="mb-4"> -->
        <?php
          if(isset($message)){
        ?>
          <div class="alert alert-<?= $message["type"] ?>" role="alert"><?= $message["message"] ?></div>
        <?php
          }
        ?>
        <input type="hidden" name="user[roles_id]" value="2" readonly>
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="identification_type_id" >Tipo de documento</label>
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
            <label for="identification_number">Número de documento</label>
            <input type="number" id="identification_number" name="user[identification_number]" class="form-control" value="<?= (isset($data_form)) ? $data_form["user"]["identification_number"] : "" ?>" required>
          </div>
          <div class="col-md-6 form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="user[first_name]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["first_name"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="last_name">Apellidos</label>
            <input type="text" id="last_name" name="user[last_name]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["last_name"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="department" >Departamento</label>
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
            <label for="city" >Ciudad</label>
            <select class="form-control city-select" name="user[city_id]" id="city" required>
              <option value>--Seleccione una ciudad</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label for="phone">Teléfono</label>
            <input min="7" type="number" id="phone" name="user[phone]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["phone"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="phone">Dirección</label>
            <input type="text" id="address" name="user[address]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["address"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="birth_date">Fecha de nacimiento</label>
            <input type="text" id="birth_date" name="user[birth_date]" class="form-control flatpickr-input active" placeholder="" value="<?= (isset($data_form)) ? $data_form["user"]["birth_date"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="user[email]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["email"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="inputPassword">Contraseña</label>
            <input type="password" id="password" class="form-control check-password" name="user[password]" required value="<?= (isset($data_form)) ? $data_form["user"]["password"] : "" ?>">
          </div>
          <div class="col-md-6 form-group">
            <label for="inputPassword">Confirmar contraseña</label>
            <input type="password" id="cpassword" class="form-control check-password" required>
          </div>
          <div class="col-md-12">
            <p class="text-danger d-none password-match-text">Las contraseñas no coinciden.</p>
          </div>
          <div class="col-md-12 form-group">
            <label for="inputPassword">Hobbies</label>
              <select class="form-control wide custom-select2" name="hobbies[]" data-plugin="customselect" multiple="multiple" required>
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
        <div class="row mt-5 justify-content-md-end">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <a href="<?= base_url() . 'usuarios/login' ?>" class="btn btn-lg btn-light btn-block mb-3" type="submit">Iniciar Sesion</a>
              </div>
              <div class="col-md-6">
                <button class="btn btn-lg btn-success btn-block mb-3" type="submit">Registrarse</button>
              </div>
            </div>
          </div>
        </div>
      </form>
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






  <!-- <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-10 bg-white mb-5 pb-3 pt-2">
        <form method="post" class="form-signin" action="<?= base_url().'Usuarios/registro' ?>">
          <div class="text-center">
            <img class="mb-4 text-center" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
          </div>
          <h1 class="h3 mb-3 font-weight-normal mb-0">Registrarse</h1>
          <hr class="mb-4">
          <?php
            if(isset($message)){
          ?>
            <div class="alert alert-<?= $message["type"] ?>" role="alert"><?= $message["message"] ?></div>
          <?php
            }
          ?>
          <input type="hidden" name="user[roles_id]" value="2" readonly>
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="identification_type_id" >Tipo de documento</label>
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
              <label for="identification_number">Número de documento</label>
              <input type="number" id="identification_number" name="user[identification_number]" class="form-control" value="<?= (isset($data_form)) ? $data_form["user"]["identification_number"] : "" ?>" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="name">Nombre</label>
              <input type="text" id="name" name="user[first_name]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["first_name"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="last_name">Apellidos</label>
              <input type="text" id="last_name" name="user[last_name]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["last_name"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="department" >Departamento</label>
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
              <label for="city" >Ciudad</label>
              <select class="form-control city-select" name="user[city_id]" id="city" required>
                <option value>--Seleccione una ciudad</option>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label for="phone">Teléfono</label>
              <input min="7" type="number" id="phone" name="user[phone]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["phone"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="phone">Dirección</label>
              <input type="text" id="address" name="user[address]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["address"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="birth_date">Fecha de nacimiento</label>
              <input type="text" id="birth_date" name="user[birth_date]" class="form-control flatpickr-input active" placeholder="" value="<?= (isset($data_form)) ? $data_form["user"]["birth_date"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="email">Correo electrónico</label>
              <input type="email" id="email" name="user[email]" class="form-control" required value="<?= (isset($data_form)) ? $data_form["user"]["email"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="inputPassword">Contraseña</label>
              <input type="password" id="password" class="form-control" name="user[password]" required value="<?= (isset($data_form)) ? $data_form["user"]["password"] : "" ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="inputPassword">Confirmar contraseña</label>
              <input type="password" id="cpassword" class="form-control" required>
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
          <div class="row mt-5 justify-content-md-end">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <a href="<?= base_url() . 'usuarios/login' ?>" class="btn btn-lg btn-light btn-block" type="submit">Iniciar Sesion</a>
                </div>
                <div class="col-md-6">
                  <button class="btn btn-lg btn-success btn-block" type="submit">Registrarse</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> -->
  </body>
</html>
