var purchase_price = 0;
var purchase_discount = 0;
var purchase_total = 0;

jQuery(document).ready(function(){
    jQuery("#bill-number").trigger("change");
})

// When the subscriber button is pressed
jQuery(document).on("click", ".btn-draw-cant", function () {
    var fractions_count = jQuery("#slt-parts-cant").attr("data-amount");
    var fraction_price = jQuery("#slt-parts-cant").attr("data-value");

    if (jQuery(this).hasClass("btn-success")) {
        purchase_price = jQuery("#slt-parts-cant").val() * fraction_price;
        purchase_discount = 0;
        jQuery(".btn-draw-cant").removeClass("btn-success");
        jQuery(".btn-draw-cant").addClass("btn-outline-success");
        set_susbcriber(1);
        set_total();
    } else {
        var subscriber_percent = jQuery(this).attr("data-percent");
        var subscriber_amount = jQuery(this).attr("data-value");

        var bill_price = (fractions_count * fraction_price);
        purchase_price = (fractions_count * fraction_price * subscriber_amount) + bill_price;
        purchase_discount = (purchase_price - bill_price) * (subscriber_percent / 100);

        jQuery(".btn-draw-cant").removeClass("btn-success");
        jQuery(".btn-draw-cant").addClass("btn-outline-success");
        jQuery(this).removeClass("btn-outline-success");
        jQuery(this).addClass("btn-success");
        jQuery("#text-value-subscriber-discount").val(subscriber_percent);
        set_total();
        set_susbcriber(subscriber_amount);
    }
});

// Add datatable options to custom tables
var table_purchases = jQuery("#table-purchases").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json",
    },
    "order": [],
});

// Add datatable options to custom tables
var table_subscribers = jQuery("#table-subscribers").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json",
    },
    "order": [],
});

// When the select parts changes
jQuery(document).on("change", "#slt-parts-cant", function () {
    purchase_discount = 0;
    purchase_price = jQuery(this).val() * jQuery(this).attr("data-value");
    var fractions_count = jQuery("#slt-parts-cant").attr("data-amount");

    if (jQuery(this).val() == fractions_count) {
        jQuery("#container-subscriber").slideDown();
    } else {
        jQuery("#container-subscriber").slideUp();
    }

    jQuery('#text-show-parts').html(jQuery(this).find(":selected").text());
    jQuery(".btn-draw-cant").removeClass("btn-success");
    jQuery(".btn-draw-cant").addClass("btn-outline-success");
    jQuery("#text-value-subscriber").val(1);
    set_total();
});

// When the select serie changes
jQuery(document).on("change", "#bill-serie", function () {
    var min_value = jQuery(this).find(":selected").attr("data-min");
    var max_value = jQuery(this).find(":selected").attr("data-max");

    // jQuery("#bill-number").attr("min", min_value);
    // jQuery("#bill-number").attr("max", max_value);
    jQuery("#show-min-value").html(min_value);
    jQuery("#show-max-value").html(max_value);
    get_available_numbers(jQuery("#bill-serie").val());
    set_show_bill_data();
});

jQuery(document).on("change", "#bill-number", function () {
    set_show_bill_data();
});

function set_total() {
    jQuery('#text-show-value').html("$ " + purchase_price + " COP");
    jQuery('#text-show-discount').html("$ " + purchase_discount + " COP");
    jQuery('#text-show-price').html("$ " + ((purchase_price) - (purchase_discount)) + " COP");
}

function set_susbcriber(value) {
    jQuery("#text-show-subscriber").html(value);
    jQuery("#text-value-subscriber").val(value);
}

// Set the visual number and serie in resume list
function set_show_bill_data() {
    var number = jQuery("#bill-number").val();
    var serie = jQuery("#bill-serie").val();
    jQuery("#text-show-number-serie").html(((number == null) ? "0000" : number) + " - " + serie);
}

function get_available_numbers(serie_id) {
    jQuery("#bill-number").html("");
    jQuery.get(base_url + "Blends/available_number/" + serie_id, {},
        function (data) {
            let numbers = data.object.numbers;

            for (let i = 0; i < numbers.length; i++) {
                let new_option = new Option(numbers[i], numbers[i], false, false);
                jQuery("#bill-number").append(new_option);
            }
            jQuery("#bill-number").trigger("change");
        }, 'json')
}