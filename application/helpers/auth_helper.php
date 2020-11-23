<?php 

if(!function_exists('is_admin'))
{
    function is_admin(){
        $CI = &get_instance();
        $CI->load->library('session');

        return ($CI->session->userdata('logged_in')["roles_id"] == 1);
    }

}

if(!function_exists('is_client'))
{
    function is_client(){
        $CI = &get_instance();
        $CI->load->library('session');

        return ($CI->session->userdata('logged_in')["roles_id"] == 2);
    }

}

if(!function_exists('is_assistant'))
{
    function is_assistant(){
        $CI = &get_instance();
        $CI->load->library('session');

        return ($CI->session->userdata('logged_in')["roles_id"] == 3);
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

        if ($CI->session->has_userdata('logged_in')) {
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
        return random_string("alnum", $long);
    }

}

if(!function_exists('if_exists'))
{
    function if_exists($var){
        return isset($var) ? $var : '';
    }

}






if(!function_exists('create_unique_slug')){
    function create_unique_slug($table, $length=28, $field='slug', $key=NULL, $value=NULL)
    {
        $t =& get_instance();
        $slug = get_alnum_string($length);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;
    
        if($key)$params["$key !="] = $value; 
    
        while ($t->db->where($params)->get($table)->num_rows())
        {   
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
            
            $params [$field] = $slug;
        }   
        return $slug;   
    }
}
?>
