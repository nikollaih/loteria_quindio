// When the edit hobbie button is pressed
jQuery(document).on("click", ".edit-hobbie-button", function() {
    set_update_hobbie(jQuery(this).attr("data-id"), jQuery(this).attr("data-name"));
});

// When the cancel edit hobbie button is pressed
jQuery(document).on("click", ".cancel-edit-hobbie-button", function() {
    stop_editing_hobbie();
});

// When the delete hobbie button is pressed
jQuery(document).on("click", ".delete-hobbie-button", function() {
    delete_hobbie(jQuery(this).attr("data-id"));
});

// Add datatable options to custom tables
var table_hobbies = jQuery("#table-hobbies").DataTable({
    "language": {
        "url": "assets/json/datatable_spanish.json"
    }
});

function set_update_hobbie(id, name) {
    if (id != null) {
        jQuery("#input_id_hobbie").val(id);
        jQuery("#input_name_hobbie").val(name);
        jQuery(".add-hobbie-title").html("Modificar Hobbie");
        jQuery(".cancel-edit-hobbie-button").removeClass("invisible");
        jQuery(".result-hobbie-action").remove();
        $('html, body').animate({ scrollTop: 0 }, "slow");
    }
}

function stop_editing_hobbie() {
    jQuery("#input_id_hobbie").val(null);
    jQuery("#input_name_hobbie").val("");
    jQuery(".add-hobbie-title").html("Agregar Hobbie");
    jQuery(".cancel-edit-hobbie-button").addClass("invisible");
}

function delete_hobbie(id) {
    swal({
            title: '¿Estás seguro?',
            text: 'El hobbie será eliminado!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            jQuery.post(base_url + "hobbies/delete_hobbie", { id: id },
                function(data) {
                    if (data.error == false) {
                        table_hobbies
                            .row($("#row-hobbie-" + id).parents('tr'))
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