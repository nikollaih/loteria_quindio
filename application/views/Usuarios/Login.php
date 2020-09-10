<?php 
  $this->load->view('Templates/Head');
?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<body>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-5 bg-white pb-3">
      <form class="form-signin">
        <div class="text-center">
          <img class="mb-4 text-center" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
        </div>
        <h1 class="h4 mb-3 font-weight-normal mb-0">Iniciar Sesión</h1>
        <hr class="mb-4">
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Recuerdame
          </label>
        </div>
        <div class="row mt-5">
          <div class="col-md-6">
            <button class="btn btn-lg btn-light btn-block" type="submit">Registrarse</button>
          </div>
          <div class="col-md-6">
            <button class="btn btn-lg btn-success btn-block" type="submit">Entrar</button>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
  </body>
</html>
