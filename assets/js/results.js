var results = [];

jQuery(document).on("change", "#input_result", function () {
    jQuery("#save-result-txt").hide();
    jQuery("#background-loading").show();
    load_results(jQuery(this).attr("data-draw"));
});

jQuery(document).on("click", "#save-results-btn", function () {
    save_results();
});

// Load the txt file and convert it into a results table
function load_results(draw_number = null) {
    var formData = new FormData();
    formData.append('result', $('#input_result')[0].files[0]);
    formData.append('draw_number', draw_number);

    $.ajax({
        url: base_url + 'Files/import_result',
        type: 'POST',
        data: formData,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            data = (JSON.parse(data));
            results = data.object;
            console.log(data);
            var temp_rows = "";

            if (data.status) {
                for (let i = 0; i < data.object.length; i++) {
                    const e = data.object[i];

                    temp_rows += "<tr>" +
                        "<td>" + (i + 1) + "</td>" +
                        "<td><strong>" + e.award_name + "</strong></td>" +
                        "<td>" + e.result_number + "</td>" +
                        "<td>" + e.result_serie + "</td>" +
                        "</tr>";
                }

                jQuery("#table-results tbody").html(temp_rows);
                $('#draw-result').modal('show');
            } else {
                jQuery("#save-result-txt > span").html(data.message);
                jQuery("#save-result-txt").css("display", "block");
            }

            jQuery("#background-loading").hide();
        }
    });
}

function save_results() {
    jQuery("#background-loading").show();
    $('#draw-result').modal('hide');
    $.ajax({
        url: base_url + "Results/save_results",
        type: 'POST',
        data: { data: results },
        success: function (data) {
            data = (JSON.parse(data));
            if (data.status) {
                generate_winners(data.object.id);
                swal({
                    title: 'Exito!',
                    text: 'Resultados y ganadores registrados exitosamente!',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Volver a sorteos!',
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function() {
                    window.location = base_url + "Draws";
                });
            } else {
                jQuery("#save-result-txt > span").html(data.message);
                jQuery("#save-result-txt").css("display", "block");
            }
        }
    });
}

function generate_winners(id_draw){
    jQuery("#background-loading").show();
    $.ajax({
        url: base_url + "Winners/generate_winners",
        type: 'POST',
        data: { id_draw: id_draw},
        success: function () {
            jQuery("#background-loading").hide();
        }
    });
}