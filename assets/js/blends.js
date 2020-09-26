// When the edit blend button is pressed
jQuery(document).on("click", ".edit-blend-button", function() {
    set_update_blend(jQuery(this).attr("data-columns"));
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
    }
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
            closeOnConfirm: false
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