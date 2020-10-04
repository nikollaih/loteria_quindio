<?php 
  $this->load->view('Templates/Head');
?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<body>
    <div class="row total-height mg-0">
      <div class="col-md-6 bg-white d-flex justify-content-center align-items-center">
        <div class="container width-70-percent">
          <form method="POST" action="<?= base_url().'usuarios/user_login_process' ?>" class="form-signin">

            <div class="text-center mb-4">
              <img class="mb-4 text-center" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
            </div>
            <label for="inputEmail" class="sr-only">Email</label>
            <input name="username" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
            <label for="inputPassword" class="sr-only">Contraseña</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
            <!-- <div class="checkbox mb-3">
              <label>
                <input type="checkbox" value="remember-me"> Recuerdame
              </label>
            </div> -->
            <?php
              if(isset($error_message)){
            ?>
              <div class="alert alert-danger" role="alert"><?= $error_message ?></div>
            <?php
              }
            ?>
            <div class="row mt-4">
              <div class="col-md-12">
                <button class="btn btn-lg btn-success btn-block" type="submit">Ingresar</button>
              </div>
            </div>
             <div class="row mt-4">
              <div class="col-md-12 text-center">
                <a href="<?= base_url() . 'usuarios/registro' ?>" class="btn btn-link" type="submit">Crear cuenta</a> | 
                <a href="<?= base_url() . 'passwords/send_instructions_form' ?>" class="btn btn-link" type="submit">Olvidé mi contraseña</a>
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
    </div>
  </body>
</html>
