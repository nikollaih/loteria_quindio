<!-- Modal -->
<div class="modal fade" id="draw_result_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="draw_result_image_form" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="id" autocomplete="false" id="results-draw-id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar imagen de resultados para el sorteo #<span id="results-draw-number"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Seleccionar imagen</label>
                    <input autocomplete="off" type="file" name="result_image" id="result_image" class="form-control" required="required" value=""/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
                <div style="display: none;" id="spinner-change-password" class="spinner-border text-success m-2" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- Modal -->