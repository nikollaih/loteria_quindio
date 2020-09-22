<?php 

if(!function_exists('is_admin'))
{
    function is_admin(){
        $CI = &get_instance();
        $CI->load->library('session');

        return ($CI->session->userdata('logged_in')["roles_id"] == 1);
    }

}

if(!function_exists('logged_user'))
{
    function logged_user(){
        $CI = &get_instance();
        $CI->load->library('session');

        return $CI->session->userdata('logged_in');
    }

}

// Check if it's a logged user
if(!function_exists('is_logged'))
{
    function is_logged($redirect = false){
        $CI = &get_instance();
        $CI->load->library('session');

        if (!isset($CI->session->has_userdata('logged_in')["roles_id"])) {
            if($redirect){
                header("Location: " . base_url() . "panel");
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }

}

if(!function_exists('get_alnum_string'))
{
    function get_alnum_string($long = 28){
        return random_string("alnum", 28);
    }

}
?>
