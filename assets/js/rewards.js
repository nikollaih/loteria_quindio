jQuery(document).on("click", ".edit-reward", function () {
    let data = JSON.parse(jQuery(this).attr("data-reward"));
    jQuery("#reward_description").html(data.reward_description);
    jQuery("#reward_description_input").html(data.reward_description);
    jQuery("#bill_without_discount").val(data.bill_without_discount);
    jQuery("#bill_with_discount").val(data.bill_with_discount);
    jQuery("#total_plan").val(data.total_plan);
    jQuery("#id_reward").val(data.id_reward);
    $('#edit-reward-modal').modal('show');
});

jQuery(document).on("click", "#edit-reward-btn", function () {
    update_reward();
});

function update_reward() {
    swal({
        title: '¿Estás seguro?',
        text: 'Deseas modificar la aproximación!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Actualizar!',
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    },
        function () {
            console.log({
                id_reward: jQuery("#id_reward").val(),
                bill_without_discount: jQuery("#bill_without_discount").val(),
                bill_with_discount: jQuery("#bill_with_discount").val(),
                total_plan: jQuery("#total_plan").val()
            });
            jQuery.post(base_url + "Winners/update_reward",
                {
                    data: {
                        id_reward: jQuery("#id_reward").val(),
                        bill_without_discount: jQuery("#bill_without_discount").val(),
                        bill_with_discount: jQuery("#bill_with_discount").val(),
                        total_plan: jQuery("#total_plan").val()
                    }
                },
                function (data) {
                    console.log(data)
                    if(data.error){
                        swal(
                            {
                                text: data.message,
                                type: 'error',
                                confirmButtonText: 'Aceptar',
                            }
                        );
                    }
                    else{
                        location.reload();
                    }
                    
                }, 'json')
        });
}