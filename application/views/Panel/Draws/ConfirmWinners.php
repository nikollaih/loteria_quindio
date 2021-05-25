<!-- Modal -->
<div class="modal fade" id="draw-winners" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ingresar mezcla</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Por favor verifique que los datos ingresados son correctos antes de continuar con la carga de los mezclas.
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span>
               </button>
            </div>
            <table id="table-winners" class="custom-datatable table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">mezcla</th>
                        <th scope="col">Serie</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" id="save-winners-btn">Guardar ganadores</button>
        </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Importar archivo de confirmación de winnersados</h4>
                <hr class="mb-4">
                <h6 class="text-center">CARGAR EL ARCHIVO DE GANADORES DEL SORTEO</h6>
                <h2 class="text-center" id="draw-info">#<?= $draw["draw_number"] ?> de <?= ucfirst(strftime('%B %d, %Y',strtotime($draw["date"]))); ?></h2>
                <div id="save-winners-txt" class="alert alert-warning alert-dismissible mt-4" role="alert" style="display:none;">
                    <span></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-left">
                        <p>A continuación por favor importe un archivo plano con formato .txt para confirmar la lista de ganadores e ingresarlos al sistema.</p>
                        <div class="form-group">
                            <p for="" class="mb-0 font-weight-bold">Subir archivo</p>
                            <input data-draw="<?= $draw["draw_slug"] ?>" accept=".txt" id="input_winners" required name="winners" type="file" class="form-control-file text-center">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success" id="save-winners-btn">Guardar ganadores</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>