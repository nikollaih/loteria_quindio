<?php 
  $this->load->view('Templates/Head');
?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<body>
    <div class="row total-height mg-0">
      <div class="col-md-6 bg-white d-flex justify-content-center align-items-center">
        <div class="container width-70-percent">
          <form method="POST" action="<?= base_url().'passwords/send_instructions_process' ?>" class="form-signin">

            <div class="text-center mb-4">
              <img class="mb-4 text-center" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
            </div>
            <?php
              if(isset($success_message)){
            ?>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Instrucciones enviadas</h5>
                  <p class="card-text medium-text">Un email con las instrucciones para modificar su contraseña ha sido enviado a su buzón de correo. Es posible que el email llegue a su bandeja de spam.</p>
                </div>
              </div>

            <?php
              }else{
            ?>

              <label for="inputEmail" class="sr-only">Email</label>
              <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
              
              <?php $this->load->view('Templates/Errors'); ?>
              
              <div class="row mt-4">
                <div class="col-md-12">
                  <button class="btn btn-lg btn-success btn-block" type="submit">Enviar instrucciones</button>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12 text-center">
                  <a href="<?= base_url() . 'usuarios/registro' ?>" class="btn btn-link" type="submit">Crear cuenta</a> | 
                  <a href="<?= base_url() . 'usuarios/login' ?>" class="btn btn-link" type="submit">Iniciar sesión</a>
                </div>
              </div>
            <?php
              }
            ?>
             
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
    </div>
  </body>
</html>
