<?php
// Check the available product parts cant
    if(!function_exists('get_product_available_parts'))
    {
        function get_product_available_parts($id_product, $purchase_data){
            $CI = &get_instance();
            $CI->load->model('Purchase');
            
            $sold_parts = $CI->Purchase->get_product_sold_parts($purchase_data);
            $available_cant = intval(4) - intval($sold_parts["parts"]);
            return $available_cant;
        }
    
    }
?>