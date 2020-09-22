// When the edit draw button is pressed
jQuery(document).on("click", ".edit-draw-button", function() {
    set_update_draw(jQuery(this).attr("data-id"), jQuery(this).attr("data-name"));
});

// When the cancel edit draw button is pressed
jQuery(document).on("click", ".cancel-edit-draw-button", function() {
    stop_editing_draw();
});

// When the delete draw button is pressed
jQuery(document).on("click", ".btn-add-result", function() {
    set_dom_result(jQuery(this).attr("data-columns"));
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
        jQuery("#input_name_draw").val(name);
        jQuery(".add-draw-title").html("Modificar Sorteo");
        jQuery(".cancel-edit-draw-button").removeClass("invisible");
        jQuery(".result-draw-action").remove();
        $('html, body').animate({ scrollTop: 0 }, "slow");
    }
}

function stop_editing_draw() {
    jQuery("#input_id_draw").val(null);
    jQuery("#input_name_draw").val("");
    jQuery(".add-draw-title").html("Agregar Sorteo");
    jQuery(".cancel-edit-draw-button").addClass("invisible");
}

function delete_draw(id) {
    swal({
            title: '¿Estás seguro?',
            text: 'El draw será eliminado!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            closeOnConfirm: false
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
                        swal(
                            'Error!',
                            data.message,
                            'danger'
                        );
                    }
                }, 'json')
        });
}

function set_dom_result(columns) {
    let data = JSON.parse(columns);
    console.log(data)
    jQuery("#draw-info").html("#" + data.draw_number + " de " + data.date);
    jQuery("#result-id").val(data.id);
}