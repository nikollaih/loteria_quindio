<?php 
  $this->load->view('Templates/Head');
?>
<link rel="stylesheet" href="<?= base_url().'assets/css/login.css'; ?>">
<script type="module" src="<?= base_url().'assets/js/main.js'; ?>"></script>
<body>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-10 bg-white mb-5 pb-3 pt-2">
        <form class="form-signin">
          <div class="text-center">
            <img class="mb-4 text-center" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
          </div>
          <h1 class="h3 mb-3 font-weight-normal mb-0">Registrarse</h1>
          <hr class="mb-4">
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="inputEmail" >Tipo de documento</label>
              <select class="form-control" name="" id="">
                <option value="">Cedula de ciudadania</option>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputEmail">Número de documento</label>
              <input type="text" id="documento" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputEmail">Nombre</label>
              <input type="text" id="nombre" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputEmail">Apellidos</label>
              <input type="text" id="apellidos" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputEmail">Correo electrónico</label>
              <input type="email" id="inputEmail" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputPassword">Teléfono</label>
              <input type="number" id="telefono" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputPassword">Contraseña</label>
              <input type="password" id="password" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputPassword">Confirmar contraseña</label>
              <input type="password" id="cpassword" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="inputEmail">Fecha de nacimiento</label>
              <input type="email" id="inputEmail" class="form-control" required>
            </div>
            <div class="col-md-12 form-group">
              <label for="inputPassword">Hobbies</label>
                                                    <select class="form-control wide" data-plugin="customselect" multiple>
                                                        <option value="0" selected>Shreyu</option>
                                                        <option value="1">Greeva</option>
                                                        <option value="2">Dhyanu</option>
                                                        <option value="3" disabled>Disabled</option>
                                                        <option value="4">Mannat</option>
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
  </div>
  </body>
</html>
