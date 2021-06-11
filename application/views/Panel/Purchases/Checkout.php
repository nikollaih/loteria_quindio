<div>
   <?php 
      $draw_number = null;

      if($this->session->has_userdata('draw_number')){
         $draw_number = $this->session->userdata()['draw_number'];
      }

      if($draw == false){
?>
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
           No hay ningún sorteo abierto en este momento.
            </div>
<?php
      }
      else if(get_setting("enable_purchases") == 0){
         ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Las ventas de los billetes están desactivadas temporalmente.
                     </div>
         <?php
               }
      else{
   ?>
   <div>
      <div class="py-3 text-center">
         <h2>Formulario de pago sorteo #<?= $draw["draw_number"] ?></h2>
         <h4>Este sorteo jugará en la fecha: <?= ucfirst(strftime('%B %d, %Y',strtotime($draw["date"]))); ?></h4>
         <p class="lead">A continuación encontrará una serie de secciones que le ayudaran a llevar a cano la compra de su billete y algunas opciones personalizables para el ahorro de  su dinero.</p>
         <?php
            if(isset($message)){
         ?>
            <div class="alert alert-<?= $message["type"] ?> alert-dismissible fade show" role="alert">
            <?= $message["message"] ?>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span>
               </button>
            </div>
         <?php
            }
         ?>
      </div>
      <form class="needs-validation" novalidate="" method="post">
         <input name="subscriber[amount]" type="hidden" id="text-value-subscriber" value="1">
         <input name="subscriber[discount]" type="hidden" id="text-value-subscriber-discount" value="0">
         <input name="purchase[id_draw]" type="hidden" id="" value="<?= $draw["id"] ?>">
         <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
               <h4 class="d-flex justify-content-between align-items-center mb-3">
                  <span>Resumen</span>
               </h4>
               <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                     <div>
                        <h6 class="my-0">Número y serie</h6>
                        <small class="text-muted fs-1-2 text-success font-weight-bold" id="text-show-number-serie"><?= (is_array($draw_number)) ? $draw_number["number"] : "0000" ?> - <?= (is_array($draw_number)) ? $draw_number["serie"] : "000" ?></small>
                     </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between bg-light">
                     <div class="text-success">
                        <h6 class="my-0">Cantidad de fracciones</h6>
                        <small class="text-muted" id="text-show-parts">Billete Completo</small>
                     </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                     <div>
                        <h6 class="my-0">Número de sorteo</h6>
                        <small class="text-muted"><?= $draw["draw_number"] ?></small>
                     </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between bg-light">
                     <div>
                        <h6 class="my-0">Fecha de juego</h6>
                        <small class="text-muted"><?= ucfirst(strftime('%B %d, %Y',strtotime($draw["date"]))); ?></small>
                     </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                     <div class="text-success">
                        <h6 class="my-0">Hora de juego</h6>
                        <small class="text-muted">10:30 pm</small>
                     </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between bg-light">
                     <div class="text-success">
                        <h6 class="my-0">Cantidad de sorteos (Sistema de Abonados)</h6>
                        <small style="vertical-align: inherit;" class="text-muted" id="text-show-subscriber">1</small>
                     </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                     <span>Valor (COP)</span>
                     <strong id="text-show-value">$ <?= $draw["fractions_count"] * $draw["fraction_value"] ?> COP</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                     <span>Descuento (COP)</span>
                     <strong id="text-show-discount" class="text-success">$ 0 COP</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                     <span>Total (COP)</span>
                     <strong id="text-show-price">$ <?= $draw["fractions_count"] * $draw["fraction_value"] ?> COP</strong>
                  </li>
               </ul>
               <hr class="mb-4">
               <button class="btn btn-success btn-lg btn-block" type="submit">Continuar</button>
            </div>
            <div class="col-md-8 order-md-1">
               <h4 class="mb-3">Datos personales</h4>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label for="firstName">Nombre</label>
                     <input readonly disabled type="text" class="form-control" id="firstName" placeholder="" value="<?= logged_user()["first_name"] ?>" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                     <div class="invalid-feedback">
                        Este campo es requerido.
                     </div>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="lastName">Apellido</label>
                     <input readonly disabled type="text" class="form-control" id="lastName" placeholder="" value="<?= logged_user()["last_name"] ?>" required="">
                     <div class="invalid-feedback">
                        Este campo es requerido.
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label for="email">Correo electrónico </label>
                     <input readonly disabled type="email" class="form-control" id="email" placeholder="nombre@example.com" value="<?= logged_user()["email"] ?>">
                     <div class="invalid-feedback">
                        Por favor ingrese un correo electrónico válido.
                     </div>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="email">Teléfono </label>
                     <input readonly disabled type="number" class="form-control" id="phone" placeholder="" value="<?= logged_user()["phone"] ?>">
                     <div class="invalid-feedback">
                        Este campo es requerido.
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label for="state">Departamento</label>
                     <select class="custom-select d-block w-100 state-select" id="department" required="">
                        <option value="">--Seleccione un departamento</option>
                        <?php
                           if($states != false && is_array($states)){
                             foreach ($states as $state) {
                           ?>
                        <option <?= (isset($cities[0]["state_id"]) && $state["id"] == $cities[0]["state_id"]) ? "selected" : "" ?> value='<?= $state["id"] ?>'><?= $state["name"] ?></option>
                        <?php
                           }
                           }
                           ?>                
                     </select>
                     <div class="invalid-feedback">
                        Este campo es requerido.
                     </div>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="state">Ciudad</label>
                     <select class="custom-select d-block w-100 city-select"  id="city" required="">
                        <option value="">--Seleccione una ciudad</option>
                        <?php
                           if($cities != false && is_array($cities)){
                             foreach ($cities as $city) {
                           ?>
                        <option <?= ($city["id"] == logged_user()["city_id"]) ? "selected" : "" ?> value='<?= $city["id"] ?>'><?= $city["name"] ?></option>
                        <?php
                           }
                           }
                           ?>            
                     </select>
                     <div class="invalid-feedback">
                        Este campo es requerido.
                     </div>
                  </div>
               </div>
               <hr class="mb-4">
               <h4 class="d-flex justify-content-between align-items-center mb-3">
                  <span>Datos del Billete</span>
               </h4>
               <p class="lead">Antes de realizar la compra asegurese de que todos los datos están bien, tenga en cuenta que estará comprando billetes completos.</p>
               <div class="row">
               <div class="col-md-4 mb-3">
                     <h5 for="state">Número del billete</h5>
                     <input value="<?= (is_array($draw_number)) ? $draw_number["number"] : "" ?>" onkeypress="if(this.value.length==4){ return false; }" maxlength="4" minlength="4" name="purchase[number]" type="number" class="form-control bill-data" id="bill-number" placeholder="0000" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                     <div class="invalid-feedback">
                        Ingrese un número válido.
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <h5 for="state">Número de serie</h5>
                     <select name="purchase[serie]" class="custom-select2 d-block w-100 bill-data" id="bill-serie" data-plugin="customselect" required="">
                           <?php
                              if(is_array($draw_number)){
                                 ?>
                                 
                                 <option selected value="<?= $draw_number["serie"] ?>"><?= $draw_number["serie"] ?></option>
                              <?php
                              }
                           ?>
                        <!--<?php
                           if(isset($blends) && is_array($blends)){
                               $x = 1;
                               foreach ($blends as $blend) {
                           ?>
                        <option data-min="<?= $blend["start_number"] ?>" data-max="<?= $blend["end_number"] ?>" <?= (is_array($draw_number) && $draw_number["serie"] == $blend["serie"]) ? "selected" : "" ?> value="<?= $blend["serie"] ?>"><?= $blend["serie"] ?></option>
                        <?php
                           }
                           }
                           ?>-->
                     </select>
                     <div class="invalid-feedback">
                        Ingrese una válida.
                     </div>
                  </div>
                  <!--<div class="col-md-4 mb-3">
                     <h5 for="state">Número del billete</h5>
                     <select class="form-control wide custom-select2 bill-data" name="purchase[number]" required="" data-plugin="customselect">
                        <?php
                           foreach (get_available_numbers((is_array($draw_number)) ? $draw_number["serie"] : $blends[0]["serie"])["numbers"] as $number) {
                        ?>
                           <option value="<?= $number ?>"><?= $number ?></option>
                        <?php
                           }
                           if(is_array($draw_number)){
                        ?>
                           <option selected value="<?= $draw_number["number"] ?>"><?= $draw_number["number"] ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <div class="invalid-feedback">
                        Ingrese un número válido.
                     </div>
                  </div>-->
                  <div class="col-md-4 mb-3">
                     <!-- <h5 for="state">Cantidad de fracciones</h5> -->
                     <input readonly id="slt-parts-cant" data-amount="<?= $draw['fractions_count'] ?>" data-value="<?= $draw['fraction_value'] ?>" value="<?= (is_array($draw)) ? $draw['fractions_count'] : "" ?>" name="purchase[parts]" type="hidden" class="form-control bill-data" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-8">
                     <p class="text-center mt-1 mb-1">Ó</p>
                     <p class="text-center mt-0"><a class="text-success" href="<?= base_url() ?>">Generar número mediante el juego</a></p>
                  </div>
               </div>
               <div id="container-subscriber">
                  <hr class="mb-4">
                  <h4 class="d-flex justify-content-between align-items-center mb-3">
                     <span>Sistema de abonados</span>
                  </h4>
                  <?php
                     if(get_remaining_draws() > 13){
                  ?>
                        <div>
                           <p class="lead">El plan club abonados le permite comprar su billete de lotería hasta por los 52 proximos sorteos, tenga en cuenta que entre más cantidad de sorteos compre con su mismo número, mayor será la cantidad de descuento que le ofreceremos por su compra.</p>
                           <p class="lead">Seleccione la cantidad de sorteos que desea comprar:</p>
                           
                                 <div class="row card-deck text-center">
                                 
                                    <div class="col-md-3">
                                       <div class="card mb-4 box-shadow">
                                             <div class="card-header bg-white">
                                                <h5 class="my-0 font-weight-normal mt-2">1 Sorteo</h5>
                                                <hr class="mb-0">
                                             </div>
                                             <div class="card-body">
                                                <h1 class="card-title pricing-card-title mb-0">0%</h1>
                                                <ul class="list-unstyled mt-0 mb-4">
                                                <li>Descuento</li>
                                                </ul>
                                                <button data-percent="0" data-value="0" type="button" class="btn btn-outline-success btn-block btn-draw-cant">Seleccionar</button>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                       if(get_remaining_draws() > 13){
                                    ?>
                                       <div class="col-md-3">
                                          <div class="card mb-4 box-shadow">
                                             <div class="card-header bg-white">
                                                <h5 class="my-0 font-weight-normal mt-2">13 Sorteos</h5>
                                                <hr class="mb-0">
                                             </div>
                                             <div class="card-body">
                                                <h1 class="card-title pricing-card-title mb-0">5%</h1>
                                                <ul class="list-unstyled mt-0 mb-4">
                                                <li>Descuento</li>
                                                </ul>
                                                <button data-percent="5" data-value="13" type="button" class="btn btn-outline-success btn-block btn-draw-cant">Seleccionar</button>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                       }
                                    ?>
                                     <?php
                                       if(get_remaining_draws() > 26){
                                    ?>
                                       <div class="col-md-3">
                                       <div class="card mb-4 box-shadow">
                                             <div class="card-header bg-white">
                                                <h5 class="my-0 font-weight-normal mt-2">26 Sorteos</h5>
                                                <hr class="mb-0">
                                             </div>
                                             <div class="card-body">
                                                <h1 class="card-title pricing-card-title mb-0">8%</h1>
                                                <ul class="list-unstyled mt-0 mb-4">
                                                <li>Descuento</li>
                                                </ul>
                                                <button data-percent="8" data-value="26" type="button" class="btn btn-outline-success btn-block btn-draw-cant">Seleccionar</button>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                       }
                                    ?>
                                     <?php
                                       if(get_remaining_draws() > 52){
                                    ?>
                                       <div class="col-md-3">
                                       <div class="card mb-4 box-shadow">
                                             <div class="card-header bg-white">
                                                <h5 class="my-0 font-weight-normal mt-2">52 Sorteos</h5>
                                                <hr class="mb-0">
                                             </div>
                                             <div class="card-body">
                                                <h1 class="card-title pricing-card-title mb-0">15%</h1>
                                                <ul class="list-unstyled mt-0 mb-4">
                                                <li>Descuento</li>
                                                </ul>
                                                <button data-percent="15" data-value="52" type="button" class="btn btn-outline-success btn-block btn-draw-cant">Seleccionar</button>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                       }
                                    ?>
                                 </div>
                              
                        </div>
                  <?php
                     }
                     else{
                  ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                           El sistema de abonados ya no se encuentra disponible para el año en curso.
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">×</span>
                           </button>
                        </div>
                  <?php
                     }
                  ?> 
               </div>
               <hr class="mb-4">
               <h4 class="mb-3">Pago</h4>
               <div class="d-block my-3">
                  <div class="custom-control custom-radio">
                     <input id="bank-purchase" name="purchase[payment_method]" type="radio" class="custom-control-input" required="" value="1" checked>
                     <label class="custom-control-label" for="bank-purchase"> <img class="mb-4" src="<?= base_url() ?>assets/images/pagos-pse.png"  alt="" srcset="" width="60px"></label>
                    
                  </div>
                  <div class="custom-control custom-radio">
                     <input id="balance" name="purchase[payment_method]" type="radio" class="custom-control-input" required="" value="2">
                     <label class="custom-control-label" for="balance">Saldo en plataforma: $<?= number_format($user["balance_total"], 0, ',', '.') ?> COP</label>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<?php
      }
?>