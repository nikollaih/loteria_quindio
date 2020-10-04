<?php 
  $this->load->view('Templates/Head');
?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<body>
    <div class="row total-height mg-0">
      <?php
        if(isset($unauthorized) && $unauthorized){
      ?>
         <?php $this->load->view('Templates/Not_authorized'); ?>
      <?php
        }else{
      ?>
        <div class="col-md-6 bg-white d-flex justify-content-center align-items-center">
          <div class="container width-70-percent">
            <form method="POST" action="<?= base_url().'passwords/change_password_process' ?>" class="form-signin"> 
            <div class="text-center mb-4">
                <img class="mb-4 text-center" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
              </div>
              <?php
                if(isset($success_message)){
              ?>
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Contraseña actualizada</h5>
                    <p class="card-text medium-text">Su contraseña ha sido modificada exitosamente.</p>
                  </div>
                </div>

              <?php
                }else{
              ?>
                <input type="hidden" name="user_slug" value="<?php echo $user_slug?>">  
                <input type="hidden" name="password_salt" value="<?php echo $password_salt?>">
                <div class="form-group">
                  <label for="inputPassword" class="sr-only">Contraseña</label>
                  <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Contraseña"  autofocus>
                  <label for="inputPasswordRepeated" class="sr-only">Repetir Contraseña</label>
                  <input name="password_repeated" type="password" id="inputPasswordRepeated" class="form-control" placeholder="Repetir contraseña">
                </div>
                <?php $this->load->view('Templates/Errors'); ?>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <button class="btn btn-lg btn-success btn-block" type="submit">Cambiar contraseña</button>
                  </div>
                </div>
              <?php
                }
              ?>
              <div class="row mt-4">
                  <div class="col-md-12 text-center">
                    <a href="<?= base_url() . 'usuarios/registro' ?>" class="btn btn-link" type="submit">Crear cuenta</a> | 
                    <a href="<?= base_url() . 'usuarios/login' ?>" class="btn btn-link" type="submit">Iniciar sesión</a>
                  </div>
                </div>
              </form>
          </div>
        </div>
        <div class="col-md-6 bg-green d-flex justify-content-center align-items-center flex-column">
          <div class="loteria-title">
            Lotería Del Quindío
          </div>
          <div class="loteria-subtitle">
            ¡La de todos!
          </div>
          <br>
          <div class="width-70-percent mt-4">
            <img class="mb-4 text-center img-100" src="<?= base_url().'assets/images/login-picture.svg' ?>">
          </div>
        </div>
      <?php
          }
        ?>
    </div>
  </body>
</html>
