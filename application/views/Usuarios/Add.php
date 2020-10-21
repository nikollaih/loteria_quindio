
<div class="col-md-12">
   <div class="card">
      <div class="card-body">
         <h4 class="header-title mt-0 add-draw-title"><?= ($user) ? "Modificar" : "Agregar" ?> Usuario</h4>
         <hr class="mb-4">
         <form action="" method="post" autocomplete="off">
            <?php 
               if(isset($user["id"])){
            ?>
                  <input type="hidden" name="user[id]" value="<?= $user["id"] ?>" readonly>
            <?php
               }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <p>Los campos marcados con <small class="text-danger fs-1">*</small> son campos obligatorios.</p>
                    <hr>
                    <?php
                        if(isset($message)){
                    ?>
                        <p class="result-blend-action text-<?= $message["type"] ?>"><?= $message["message"] ?></p>
                    <?php
                        }
                    ?>
                </div>
               <div class="col-md-12">
                  <div class="row mt-3">
                     <div class="col-md-4 form-group">
                        <label for="roles_id" >Rol <small class="text-danger fs-1">*</small></label>
                        <select class="form-control" name="user[roles_id]" id="roles_id" required>
                           <option value>--Seleccione el rol</option>
                           <?php
                              if($roles && is_array($roles)){
                                 foreach ($roles as $rol) {
                                 ?>
                                    <option <?= (isset($user["roles_id"]) && $user["roles_id"] == $rol["id"]) ? "selected" : "" ?> value='<?= $rol["id"] ?>'><?= $rol["name"] ?></option>
                                 <?php
                                 }
                              }
                           ?>
                        </select>
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="identification_type_id" >Tipo de documento <small class="text-danger fs-1">*</small></label>
                        <select class="form-control" name="user[identification_type_id]" id="identification_type_id" required>
                           <option value>--Seleccione el tipo de documento</option>
                           <?php
                              if($identification_types && is_array($identification_types)){
                              foreach ($identification_types as $it) {
                              ?>
                           <option <?= (isset($user["identification_type_id"]) && $user["identification_type_id"] == $it["id"]) ? "selected" : "" ?> value='<?= $it["id"] ?>'><?= $it["name"] ?></option>
                           <?php
                              }
                              }
                              ?>
                        </select>
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="identification_number">Número de documento <small class="text-danger fs-1">*</small></label>
                        <input placeholder="Ej: 123456789" type="number" id="identification_number" name="user[identification_number]" class="form-control" value="<?= (isset($user["identification_number"])) ? $user["identification_number"] : "" ?>" required>
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="name">Nombre <small class="text-danger fs-1">*</small></label>
                        <input placeholder="Ejemplo" type="text" id="name" name="user[first_name]" class="form-control" required value="<?= (isset($user["first_name"])) ? $user["first_name"] : "" ?>">
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="last_name">Apellidos <small class="text-danger fs-1">*</small></label>
                        <input placeholder="Ejemplo" type="text" id="last_name" name="user[last_name]" class="form-control" required value="<?= (isset($user["last_name"])) ? $user["last_name"] : "" ?>">
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="email">Correo electrónico <small class="text-danger fs-1">*</small></label>
                        <input autocomplete="off" placeholder="ejemplo@correo.com" type="email" id="email" name="user[email]" class="form-control" required value="<?= (isset($user["email"])) ? $user["email"] : "" ?>">
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="department" >Departamento <small class="text-danger fs-1">*</small></label>
                        <select class="form-control state-select" name="department" id="department" required>
                           <option value>--Seleccione un departamento</option>
                           <?php
                              if($states && is_array($states)){
                              foreach ($states as $state) {
                              ?>
                           <option <?= (isset($user["state_id"]) && $user["state_id"] == $state["id"]) ? "selected" : "" ?> value='<?= $state["id"] ?>'><?= $state["name"] ?></option>
                           <?php
                              }
                              }
                              ?>
                        </select>
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="city" >Ciudad <small class="text-danger fs-1">*</small></label>
                        <select class="form-control city-select" name="user[city_id]" id="city" required>
                           <option value>--Seleccione una ciudad</option>
                           <?php
                              if($cities && is_array($cities)){
                              foreach ($cities as $city) {
                              ?>
                           <option <?= (isset($cities) && isset($user["city_id"]) && $user["city_id"] == $city["id"]) ? "selected" : "" ?> value='<?= $city["id"] ?>'><?= $city["name"] ?></option>
                           <?php
                              }
                              }
                              ?>
                        </select>
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="phone">Teléfono</label>
                        <input placeholder="3212233444" min="7" type="number" id="phone" name="user[phone]" class="form-control" value="<?= (isset($user["phone"])) ? $user["phone"] : "" ?>">
                     </div>
                     <div class="col-md-4 form-group">
                        <label for="birth_date">Fecha de nacimiento</label>
                        <input type="text" id="birth_date" name="user[birth_date]" class="form-control flatpickr-input active" placeholder="" value="<?= (isset($user["birth_date"])) ? $user["birth_date"] : "" ?>">
                     </div>
                     <div class="col-md-8 form-group">
                        <label for="phone">Dirección</label>
                        <input placeholder="Ej: Calle 2 # 3 - 45" type="text" id="address" name="user[address]" class="form-control" value="<?= (isset($user["address"])) ? $user["address"] : "" ?>">
                     </div>
                     <?php 
                        if(!isset($user["id"])){
                     ?>
                        <div class="col-md-4 form-group">
                           <label for="last_name">Contraseña <small class="text-danger fs-1">*</small></label>
                           <input autocomplete="off" type="password" minlength="4" id="new-password" name="user[password]" class="form-control" value="" required>
                        </div>
                        <div class="col-md-4 form-group">
                           <label for="name">Repetir Contraseña <small class="text-danger fs-1">*</small></label>
                           <input autocomplete="off" type="password" minlength="4" id="r-new-password" name="r_new_password" class="form-control" value="" required>
                        </div>
                     <?php
                        }
                     ?>
                  </div>
               </div>
               <div class="col-md-12">
                  <hr class="mb-3">
                  <button class="btn btn-success float-right">Guardar</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>