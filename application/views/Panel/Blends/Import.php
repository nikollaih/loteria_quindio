<!-- Modal -->
<div class="modal fade" id="draw-result" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
            <table id="table-results" class="custom-datatable table table-bordered table-striped mb-0">
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
            <button type="submit" class="btn btn-success" id="save-results-btn">Guardar mezclas</button>
        </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0">Importar archivo de mezclas</h4>
                <hr class="mb-4">
                <h6 class="text-center">CARGAR EL ARCHIVO DE MEZCLAS</h6>
                <div id="save-result-txt" class="alert alert-dismissible mt-4" role="alert" style="display:none;">
                    <span></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-left">
                        <p>A continuación por favor importe un archivo plano con formato .txt para realizar la válidación de las mezclas antes de ingresarlas al sistema.</p>
                        <div class="form-group">
                            <p for="" class="mb-0 font-weight-bold">Subir archivo</p>
                            <input accept=".txt" id="input_blends" required name="result" type="file" class="form-control-file text-center">
                        </div>
                        <p class="success-import" style="margin-bottom:0;display:none;font-weight:700">Presione el botón "Guardar mezclas" para continuar con el proceso</p>
                        <button style="display:none;" type="submit" class="btn btn-success success-import" id="save-blends-btn">Guardar mezclas</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>