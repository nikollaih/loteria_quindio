// Check the input max length
jQuery(document).on("keyup", ".max-length-check", function() {
    var value = jQuery(this).val();

    if (value.length > jQuery(this).attr("maxlength")) {
        jQuery(this).val(value.slice(0, this.maxLength));
    }
});

// When the state selector changes
jQuery(document).on("change", ".state-select", function() {
    if (jQuery(this).val() == "false") {
        set_cities();
    } else {
        get_cities_by_state(jQuery(this).val());
    }
});

// Check if password input values match
jQuery(document).on("keyup", ".check-password", function() {
    var password = jQuery("#password").val();
    var cpassword = jQuery("#cpassword").val();

    if (password == cpassword) {
        jQuery(".password-match-text").addClass("d-none");
    } else if (password.trim() != "" && cpassword.trim() != "") {
        jQuery(".password-match-text").removeClass("d-none");
    }
});


// Call a location function in order to get the state cities
function get_cities_by_state(id_state) {
    jQuery.post(base_url + "Locations/get_cities_by_state", { id_state: id_state },
        function(data) {
            if (data.error == false) {
                set_cities(data.cities);
            }
        }, 'json')
}

// Set the cities list into the select city element
function set_cities(cities = null) {
    var cities_dom = "<option value>--Seleccione una ciudad</option>";

    // If cities doesn't exists it will clear the city select and it will disabled
    if (cities == null) {
        jQuery(".city-select").html(cities_dom);
    } else {
        // Load the cities data into the city select
        var realArray = $.makeArray(cities)
        $.map(realArray, function(val, i) {
            cities_dom += "<option value='" + val.id + "'>" + val.name + "</option>";
        });
        jQuery(".city-select").html(cities_dom);
    }
}