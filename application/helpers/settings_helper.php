<?php
    if(!function_exists('get_setting')){
        function get_setting($key = null){
            $CI = &get_instance();
            $CI->load->model(['Setting']);

            $setting = $CI->Setting->get($key);
            
            if(is_array($setting)){
                return $setting["value"];
            }
            else{
                return false;
            }
        }
    }
    
?>