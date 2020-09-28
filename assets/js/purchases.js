// When the subscriber button is pressed
jQuery(document).on("click", ".btn-draw-cant", function() {
    if (jQuery(this).hasClass("btn-success")) {
        console.log("si")
        jQuery(".btn-draw-cant").removeClass("btn-success");
        jQuery(".btn-draw-cant").addClass("btn-outline-success");
        set_susbcriber(1);
    } else {
        console.log("no")
        jQuery(".btn-draw-cant").removeClass("btn-success");
        jQuery(".btn-draw-cant").addClass("btn-outline-success");
        jQuery(this).removeClass("btn-outline-success");
        jQuery(this).addClass("btn-success");
        set_susbcriber(jQuery(this).attr("data-value"));
    }
});

// Add datatable options to custom tables
var table_purchases = jQuery("#table-purchases").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    }
});

// Add datatable options to custom tables
var table_subscribers = jQuery("#table-subscribers").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    }
});

// When the select parts changes
jQuery(document).on("change", "#slt-parts-cant", function() {
    jQuery('#text-show-parts').html(jQuery(this).find(":selected").text());
    jQuery('#text-show-price').html("$ " + jQuery(this).val() * jQuery(this).attr("data-value") + " COP");
});

// When the select serie changes
jQuery(document).on("change", "#bill-serie", function() {
    set_show_bill_data();
});

jQuery(document).on("keyup", "#bill-number", function() {
    set_show_bill_data();
});

function set_susbcriber(value) {
    jQuery("#text-show-subscriber").html(value);
    jQuery("#text-value-subscriber").val(value);
}

// Set the visual number and serie in resume list
function set_show_bill_data() {
    var number = jQuery("#bill-number").val();
    var serie = jQuery("#bill-serie").val();
    jQuery("#text-show-number-serie").html(number + " - " + serie);
}