// Add datatable options to custom tables
var table_winners = jQuery("#table-winners").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    },
    "pageLength": 50,
    "order": []
});

// When the generate winner button is pressed
jQuery(document).on("click", "#btn-generate-winner", function () {
    $('#generate_winner_modal').modal('show');
});

// When the generate winner button is pressed
jQuery(document).on("click", ".edit-winner-button", function () {
    let winner = JSON.parse(jQuery(this).attr("data"));
    open_winner_update(winner);
});

function generate_winner(data) {
    console.log(data)
    $.ajax({
        url: base_url + "games/update_winner",
        type: 'POST',
        data: data,
        success: function (result) {
            result = (JSON.parse(result));
            if (result.error) {
                swal({
                    title: 'Error!',
                    text: result.message,
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'Continuar',
                    closeOnConfirm: true,
                    showLoaderOnConfirm: false
                })
            }
            else {
                swal({
                    title: 'Exito!',
                    text: result.message,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Continuar',
                    closeOnConfirm: true,
                    showLoaderOnConfirm: false
                },
                function(){
                    window.location.reload();
                })
            }

            jQuery("#spinner-winner").css("display", "none");
            jQuery("#btn-save-generate-winner").css("display", "block");
        }
    });
}

function open_winner_update(winner){
    console.log(winner)
    jQuery("#id").val(winner.id);
    jQuery("#winner-status").val(winner.status);
    jQuery("#comments").val(winner.comments);
    $('#winner_update').modal('show');
}

(function() {
	function toJSONString( form ) {
		var obj = {};
		var elements = form.querySelectorAll( "input, select, textarea" );
		for( var i = 0; i < elements.length; ++i ) {
			var element = elements[i];
			var name = element.name;
			var value = element.value;

			if( name ) {
				obj[ name ] = value;
			}
		}

		return  obj ;
	}

	document.addEventListener( "DOMContentLoaded", function() {
		var form = document.getElementById( "winner-form" );
		form.addEventListener( "submit", function( e ) {
            jQuery("#spinner-winner").css("display", "block");
            jQuery("#btn-save-generate-winner").css("display", "none");
			e.preventDefault();
            var json = toJSONString( this );
            generate_winner(json);
		}, false);

	});

})();