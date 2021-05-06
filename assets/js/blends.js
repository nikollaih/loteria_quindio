var imported_blends = [];
// When the edit blend button is pressed
jQuery(document).on("click", ".edit-blend-button", function() {
    set_update_blend(jQuery(this).attr("data-columns"));
});

jQuery(document).on("change", "#input_blends", function () {
    jQuery("#save-result-txt").hide();
    jQuery("#background-loading").show();
    load_blends(jQuery(this).attr("data-draw"));
});

/*jQuery(document).on("change", "#input_result", function () {
    jQuery("#save-result-txt").hide();
    jQuery("#background-loading").show();
    load_results(jQuery(this).attr("data-draw"));
});*/

jQuery(document).on("click", "#save-blends-btn", function () {
    save_blends();
});

// When the cancel edit blend button is pressed
jQuery(document).on("click", ".cancel-edit-blend-button", function() {
    stop_editing_blend();
});

// When the cancel edit blend button is pressed
jQuery(document).on("keyup", ".check-blend", function() {
    check_blend_start_end();
});

// When the delete blend button is pressed
jQuery(document).on("click", ".delete-blend-button", function() {
    delete_blend(jQuery(this).attr("data-id"));
});

// Add datatable options to custom tables
var table_blends = jQuery("#table-blends").DataTable({
    "language": {
        "url": "assets/json/datatable_spanish.json"
    },
    "pageLength": 50,
});

function check_blend_start_end() {
    jQuery(".check-blend-start").attr("max", jQuery(".check-blend-end").val());
    jQuery(".check-blend-end").attr("min", jQuery(".check-blend-start").val());
}

function set_update_blend(columns) {
    var data = JSON.parse(columns);

    jQuery("#input_id_blend").val(data.id);
    jQuery("#input_start_number").val(data.start_number);
    jQuery("#input_end_number").val(data.end_number);
    jQuery("#input_serie").val(data.serie);
    jQuery("#select_blend_status").val(data.blend_status);
    jQuery(".add-blend-title").html("Modificar Hobbie");
    jQuery(".cancel-edit-blend-button").removeClass("invisible");
    jQuery(".result-blend-action").remove();
    $('html, body').animate({ scrollTop: 0 }, "slow");
}

function stop_editing_blend() {
    jQuery('#form-blend').trigger("reset");
    jQuery(".add-blend-title").html("Agregar Mezcla");
    jQuery(".cancel-edit-blend-button").addClass("invisible");
}

function delete_blend(id) {
    swal({
            title: '¿Estás seguro?',
            text: 'La mezcla será eliminada!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            jQuery.post(base_url + "Blends/delete_blend", { id: id },
                function(data) {
                    console.log(data)
                    if (data.error == false) {
                        table_blends
                            .row($("#row-blend-" + id).parents('tr'))
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

// Load the txt file and convert it into a results table
function load_blends(draw_number = null) {
    var formData = new FormData();
    formData.append('result', $('#input_blends')[0].files[0]);

    $.ajax({
        url: base_url + 'Files/import_blends',
        type: 'POST',
        data: formData,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            data = (JSON.parse(data));
            imported_blends = data.object;
            console.log(data)

            if (data.status) {
                jQuery("#save-result-txt > span").html(data.message);
                jQuery("#save-result-txt").removeClass("alert-warning");
                jQuery("#save-result-txt").addClass("alert-success");
                jQuery("#save-result-txt").css("display", "block");
                jQuery(".success-import").css("display", "block");
            } else {
                jQuery("#save-result-txt > span").html(data.message);
                jQuery("#save-result-txt").removeClass("alert-success");
                jQuery("#save-result-txt").addClass("alert-warning");
                jQuery("#save-result-txt").css("display", "block");
                jQuery(".success-import").css("display", "none");
            }

            jQuery("#background-loading").hide();
        }
    });
}

function save_blends() {
    jQuery("#background-loading").show();
    $.ajax({
        url: base_url + "Blends/save_blends",
        type: 'POST',
        data: { data: JSON.stringify(imported_blends) },
        success: function (data) {
            data = (JSON.parse(data));
            if (data.status) {
                swal({
                    title: 'Exito!',
                    text: data.message,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Ir a mezclas!',
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function() {
                    window.location = base_url + "Blends";
                });
            } else {
                jQuery("#save-result-txt > span").html(data.message);
                jQuery("#save-result-txt").css("display", "block");
            }
        }
    });
}