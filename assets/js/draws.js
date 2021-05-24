// When the edit draw button is pressed
jQuery(document).on("click", ".edit-draw-button", function() {
    set_update_draw(jQuery(this).attr("data-id"), jQuery(this).attr("data-name"));
});

jQuery(document).on("click", ".modal-results-button", function() {
    set_modal_results(jQuery(this).attr("data-id"), jQuery(this).attr("data-number"));
});

jQuery(document).on("click", ".delete-draw-button", function() {
    delete_draw(jQuery(this).attr("data-id"), jQuery(this).attr("data-name"));
});

// When the cancel edit draw button is pressed
jQuery(document).on("click", ".cancel-edit-draw-button", function() {
    stop_editing_draw();
});

// When the delete draw button is pressed
jQuery(document).on("click", ".btn-add-result", function() {
    set_dom_result(jQuery(this).attr("data-columns"), jQuery(this).attr("data-formated-date"));
});

// Add datatable options to custom tables
var table_draws = jQuery("#table-draws").DataTable({
    "language": {
        "url": "assets/json/datatable_spanish.json"
    }
});

function set_update_draw(id, name) {
    if (id != null) {
        jQuery("#input_id_draw").val(id);
        jQuery("#input_draw_number").val(name);
        jQuery(".add-draw-title").html("Modificar Sorteo");
        jQuery(".cancel-edit-draw-button").removeClass("invisible");
        jQuery(".result-draw-action").remove();
        $('html, body').animate({ scrollTop: 0 }, "slow");
    }
}

function stop_editing_draw() {
    jQuery("#input_id_draw").val(null);
    jQuery("#input_draw_number").val("");
    jQuery(".add-draw-title").html("Agregar Sorteo");
    jQuery(".cancel-edit-draw-button").addClass("invisible");
}

function delete_draw(id) {
    swal({
            title: '¿Estás seguro?',
            text: 'El sorteo será eliminado!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            jQuery.post(base_url + "draws/delete_draw", { id: id },
                function(data) {
                    if (data.error == false) {
                        table_draws
                            .row($("#row-draw-" + id).parents('tr'))
                            .remove()
                            .draw();

                            swal(
                                'Eliminado!',
                                data.message,
                                'success'
                            );
                    } else {
                        swal({
                            title: 'Error!',
                            text: data.message,
                            type: 'warning',
                            confirmButtonText: 'Continuar',
                        });
                    }
                }, 'json')
        });
}

function set_dom_result(columns, date) {
    let data = JSON.parse(columns);

    jQuery("#input_result").val("");
    jQuery("#draw-info").html("#" + data.draw_number + " de " + date);
    jQuery("#result-id").val(data.id);
}

function set_modal_results(id, number){
    jQuery("#results-draw-number").html(number);
    jQuery("#results-draw-id").val(id);
}

function upload_draw_results(data){
    $.ajax({
        url: base_url + "Draws/image_results",
        type: "POST",
        data: data,
        success: function (result) {
            result = (JSON.parse(result));
           if (result.error == false) {
            $('#draw_result_image').modal('toggle');
                swal(
                    'Exito!',
                    result.message,
                    'success'
                );
            } else {
                swal({
                    title: 'Error!',
                    text: result.message,
                    type: 'warning',
                    confirmButtonText: 'Continuar',
                });
            }
            jQuery("#spinner-change-password").css("display", "none");
            jQuery("#btn-save-change-password").css("display", "block");
        },
        cache: false,
        contentType: false,
        processData: false
      });
}

document.addEventListener( "DOMContentLoaded", function() {
    var form = document.getElementById( "draw_result_image_form" );
    form.addEventListener( "submit", function( e ) {
        jQuery("#spinner-change-password").css("display", "block");
        jQuery("#btn-save-change-password").css("display", "none");
        e.preventDefault();
        var formData = new FormData(this);
        upload_draw_results(formData);
    }, false);

});