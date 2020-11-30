// When the edit game_product button is pressed
jQuery(document).on("click", ".edit-game_product-button", function() {
    set_update_game_product(jQuery(this).attr("data-columns"));
});

// When the cancel edit game_product button is pressed
jQuery(document).on("click", ".cancel-edit-game_product-button", function() {
    stop_editing_game_product();
});

// When the cancel edit game_product button is pressed
jQuery(document).on("keyup", ".check-game_product", function() {
    check_game_product_start_end();
});

// When the delete game_product button is pressed
jQuery(document).on("click", ".delete-game_product-button", function() {
    delete_game_product(jQuery(this).attr("data-id"));
});

// Add datatable options to custom tables
var table_game_products = jQuery("#table-game_products").DataTable({
    "language": {
        "url": "assets/json/datatable_spanish.json"
    }
});

function check_game_product_start_end() {
    jQuery(".check-game_product-start").attr("max", jQuery(".check-game_product-end").val());
    jQuery(".check-game_product-end").attr("min", jQuery(".check-game_product-start").val());
}

function set_update_game_product(columns) {
    var data = JSON.parse(columns);

    jQuery("#input_id_game_product").val(data.id_game_product);
    jQuery("#g_product_name").val(data.g_product_name);
    jQuery("#g_product_quantity").val(data.g_product_quantity);
    jQuery("#g_product_status").val(data.g_product_status);
    jQuery(".add-game_product-title").html("Modificar Producto");
    jQuery(".cancel-edit-game_product-button").removeClass("invisible");
    jQuery(".result-game_product-action").remove();
    $('html, body').animate({ scrollTop: 0 }, "slow");
}

function stop_editing_game_product() {
    jQuery('#form-game_product').trigger("reset");
    jQuery(".add-game_product-title").html("Agregar Producto");
    jQuery(".cancel-edit-game_product-button").addClass("invisible");
}

function delete_game_product(id) {
    swal({
            title: '¿Estás seguro?',
            text: 'El producto será eliminado!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            jQuery.post(base_url + "GameProducts/delete_game_product", { id: id },
                function(data) {
                    console.log(data)
                    if (data.error == false) {
                        table_game_products
                            .row($("#row-game_product-" + id).parents('tr'))
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