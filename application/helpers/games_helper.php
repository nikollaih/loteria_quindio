<?php
    if(!function_exists('add_loto_punto')){
        function add_loto_punto($action = "add"){
            $CI = &get_instance();
            $CI->load->model(['Usuario']);

            $CI->Usuario->substract_lotto_point(logged_user()["id"], $action);
        }
    }
    
?>