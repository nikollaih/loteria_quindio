<?php
    if(!function_exists('generate_invoice_url')){
        function generate_invoice_url($user_slug = null, $purchase_slug = null){
            if($user_slug != null && $purchase_slug != null){
                return base_url() . 'Main/invoice/' . $user_slug . '/' . $purchase_slug;
            }
            else{
                return base_url();
            }
        }
    }
    
?>