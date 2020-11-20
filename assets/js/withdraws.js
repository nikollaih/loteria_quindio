// Add datatable options to custom tables
var table_users = jQuery("#table-withdraws").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    },
    "pageLength": 50,
    "order": []
});

// When the generate withdraw button is pressed
jQuery(document).on("click", "#btn-generate-withdraw", function () {
    $('#generate_withdraw_modal').modal('show');
});

// When the generate withdraw button is pressed
jQuery(document).on("click", ".edit-withdraw-button", function () {
    let withdraw = JSON.parse(jQuery(this).attr("data"));
    open_withdraw_update(withdraw);
});

function generate_withdraw(data) {
    $.ajax({
        url: base_url + "Withdraws/generate_withdraw",
        type: 'POST',
        data: {
            id_user: null,
            ...data
        },
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
                    window.location.href = base_url + "Withdraws";
                })
            }

            jQuery("#spinner-withdraw").css("display", "none");
            jQuery("#btn-save-generate-withdraw").css("display", "block");
        }
    });
}

function open_withdraw_update(withdraw){
    jQuery("#id_withdraw").val(withdraw.id_withdraw);
    jQuery("#withdraw-status").val(withdraw.status);
    jQuery("#notes").val(withdraw.notes);
    $('#withdraw_update').modal('show');
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
		var form = document.getElementById( "withdraw-form" );
		form.addEventListener( "submit", function( e ) {
            jQuery("#spinner-withdraw").css("display", "block");
            jQuery("#btn-save-generate-withdraw").css("display", "none");
			e.preventDefault();
            var json = toJSONString( this );
            generate_withdraw(json);
		}, false);

	});

})();