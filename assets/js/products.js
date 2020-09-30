// When the edit hobbie button is pressed
jQuery(document).on("click", ".edit-product-button", function() {
    set_update_product(jQuery(this).attr("data-id"), jQuery(this).attr("data-fractions-count"), jQuery(this).attr("data-fraction-value"), jQuery(this).attr("data-name"));
});


// When the delete hobbie button is pressed
jQuery(document).on("click", ".delete-product-button", function() {
    delete_product(jQuery(this).attr("data-id"));
});

var table_products = jQuery("#table-products").DataTable({
    "language": {
        "url": "assets/json/datatable_spanish.json"
    }
});


function set_update_product(id, fractions_count, fraction_value, product_name) {
    if (id != null) {
        jQuery("#input_id_product").val(id);
        jQuery("#input_fractions_count_product").val(fractions_count);
        jQuery("#input_fraction_value_product").val(fraction_value);
        jQuery("#input_name_product").val(product_name);
        jQuery(".add-product-title").html("Modificar Producto");
        jQuery(".cancel-edit-product-button").removeClass("invisible");
        jQuery(".result-product-action").remove();
        $('html, body').animate({ scrollTop: 0 }, "slow");
    }
}

//Deletes a producto with id as parameter
function delete_product(id) {
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
            jQuery.post(base_url + "products/delete_product", { id: id },
                function(data) {
                    if (data.error == false) {
                        table_products
                            .row($("#row-product-" + id).parents('tr'))
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