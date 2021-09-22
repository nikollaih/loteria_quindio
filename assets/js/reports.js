// When the cancel edit draw button is pressed
jQuery(document).on("click", "#download-states-report", function() {
    var start_date = jQuery("#start-date-report").val();
    var end_date = jQuery("#end-date-report").val();
    var report = jQuery(this).attr("data-report");
    window.open(base_url + "Files/"+report+"/" + start_date + "/" + end_date);
});

// When the cancel edit draw button is pressed
jQuery(document).on("click", "#download-withdraws-report", function() {
    var start_date = jQuery("#start-date-report").val();
    var end_date = jQuery("#end-date-report").val();
    window.open(base_url + "Files/generateWithdrawsReport/" + start_date + "/" + end_date);
});

// Add datatable options to custom tables
var table_reports_date = jQuery("#table-reports-date").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    },
    "pageLength": 50,
    "order": []
});

// Add datatable options to custom tables
var table_reports_state = jQuery("#table-reports-state").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    },
    "pageLength": 50,
    "order": [
        [0, "asc"]
    ]
});