let imported_winners;

// When the edit draw button is pressed
jQuery(document).on("click", ".edit-draw-button", function() {
    set_update_draw(jQuery(this).attr("data-id"), jQuery(this).attr("data-name"));
});

jQuery(document).on("click", ".modal-results-button", function() {
    set_modal_results(jQuery(this).attr("data-id"), jQuery(this).attr("data-number"));
});

jQuery(document).on("click", "#save-winners-btn", function () {
    jQuery("#save-winner-txt").hide();
    jQuery("#background-loading").show();
    load_winners(jQuery( "#input_winners").attr("data-draw"));
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

// Load the txt file and convert it into a winnerss table
function load_winners(draw_slug = null) {
    var formData = new FormData();
    formData.append('winners', jQuery('#input_winners')[0].files[0]);

    console.log(jQuery('#input_winners'));

    $.ajax({
        url: base_url + 'Winners/import_confirm_winners/' + draw_slug,
        type: 'POST',
        data: formData,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            data = (JSON.parse(data));
            imported_winners = data.object;

            if (data.status) {
                jQuery("#save-winners-txt > span").html(data.message);
                jQuery("#save-winners-txt").removeClass("alert-warning");
                jQuery("#save-winners-txt").addClass("alert-success");
                jQuery("#save-winners-txt").css("display", "block");
            } else {
                jQuery("#save-winners-txt > span").html(data.message);
                jQuery("#save-winners-txt").removeClass("alert-success");
                jQuery("#save-winners-txt").addClass("alert-warning");
                jQuery("#save-winners-txt").css("display", "block");
            }

            jQuery("#background-loading").hide();
        }
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

// When the cancel edit draw button is pressed
jQuery(document).on("click", "#download-winners-report", function() {
    var id_draw = jQuery(this).attr("data-id");
    window.open(base_url + "Files/generateWinnersReport/" + id_draw);
});