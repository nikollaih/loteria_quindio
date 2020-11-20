// Add datatable options to custom tables
var table_users = jQuery("#table-users").DataTable({
    "language": {
        "url": base_url + "assets/json/datatable_spanish.json"
    },
    "pageLength": 50,
    "order": [
        [1, "asc"]
    ]
});

// When the load button is pressed
jQuery(document).on("click", ".slt-role", function () {
    jQuery("#background-loading").show();
    load_users(jQuery(this).attr("role-id"));
});

// When the delete user button is pressed
jQuery(document).on("click", ".delete-user-button", function () {
    delete_user(jQuery(this).attr("data-id"));
});

function load_users(role = 1) {
    var text_role = "Admiistradores";
    jQuery.post(base_url + "Usuarios/get_users_by_role/" + role, {},
        function (data) {
            table_users
                .clear()

            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                table_users
                    .row.add([e.identification_number, e.first_name + " " + e.last_name, e.email, e.phone, e.address, '<a href="'+base_url+'Usuarios/add_user/' + e.slug + '" class="btn btn-primary btn-sm text-light">Modificar</a><button id="row-user-' + e.id + '" data-id="' + e.id + '" type="button" class="btn btn-danger btn-sm delete-user-button">Eliminar</button>'])
            }
            table_users
                .draw();

            switch (role) {
                case "1":
                    text_role = "Administradores";
                    break;
                case "2":
                    text_role = "Clientes";
                    break;
                case "3":
                    text_role = "Asistentes";
                    break;
                default:
                    text_role = "Administradores";
                    break;
            }
            jQuery("#background-loading").hide();
            jQuery("#slt-role-text").html("Seleccionar rol (" + text_role + ")");
        }, 'json')
}

function delete_user(id) {
    swal({
        title: '¿Estás seguro?',
        text: 'El usuario será eliminado!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    },
        function () {
            jQuery.post(base_url + "Usuarios/delete_user", { id: id },
                function (data) {
                    if (data.error == false) {
                        table_users
                            .row($("#row-user-" + id).parents('tr'))
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

function change_password(data) {
    $.ajax({
        url: base_url + "Usuarios/change_password",
        type: 'POST',
        data: data,
        success: function (result) {
            result = (JSON.parse(result));
            console.log(result);
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
                    jQuery("#change_password_modal").modal("hide");
                })
            }

            jQuery("#spinner-change-password").css("display", "none");
            jQuery("#btn-save-change-password").css("display", "block");
        }
    });
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
		var form = document.getElementById( "change-password-form" );
		form.addEventListener( "submit", function( e ) {
            jQuery("#spinner-change-password").css("display", "block");
            jQuery("#btn-save-change-password").css("display", "none");
			e.preventDefault();
            var json = toJSONString( this );
            change_password(json);
		}, false);

	});

})();