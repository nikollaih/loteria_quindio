<?php
// Get the current purchase status
if(!function_exists('get_purchase_status'))
{
    function get_purchase_status($purchase_id, $request_id){

        $jsonData = generate_payment_json($purchase_id);
        $ch = curl_init( get_setting("pse_api_url").$request_id );
        # Setup request to send json via POST.
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $jsonData ) );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result  = (array) json_decode(curl_exec($ch));
        curl_close($ch);

        return $result;
    }

}

if(!function_exists('generate_payment_json'))
{
    function generate_payment_json($id_purchase = null){
        $CI = &get_instance();
        $CI->load->model('Purchase');

        $secretKey =  get_setting("pse_api_secret_key");
        $seed = date("c");
        $purchase = $CI->Purchase->get_purchases($id_purchase);

        $tranKey = base64_encode(sha1($purchase["id_purchase"].$seed.$secretKey, true));

        $jsonData = array(
            'auth' => 
                array(
                    'login' => get_setting("pse_api_login"), 
                    "tranKey" => $tranKey,
                    "nonce" => base64_encode($purchase["id_purchase"]),
                    "seed" =>  $seed
                ), 
            "locale" => "en_CO",
            "buyer" =>
                array(
                    "name" => $purchase["first_name"],
                    "surname" => $purchase["last_name"],
                    "lastName" => $purchase["last_name"],
                    "email" => $purchase["email"],
                    "document" => $purchase["identification_number"],
                    "documentType" => "CC",
                    "mobile" => $purchase["phone"]
                ), 
            "payment" =>
                array(
                    "reference" => $purchase["slug"],
                    "description" => "Pago lotería del quindío",
                    "allowPartial" => false,
                    "notificationUrl" => base_url()."Purchases/notification",
                    "amount" => 
                        array(
                            "currency" => "COP",
                            "total" => $purchase["price"] - $purchase["discount"]
                        ),
                ), 
            "expiration" => date('c', strtotime("+15 minutes", strtotime($seed))),
            "returnUrl" => base_url()."Purchases/resume/".$purchase["slug"],
            "ipAddress" => $_SERVER['REMOTE_ADDR'],
            "userAgent" => $_SERVER['HTTP_USER_AGENT']
        );

        return $jsonData;
    }
}

// Generate tranKey
if(!function_exists('convert_purchase_status'))
{
    function convert_purchase_status($purchase_status){
        $status = array(
            'PENDING' => 'Pendiente', 
            'APPROVED' => 'Aprovado', 
            'REJECTED' => 'Rechazado', 
            'FAILED' => 'Falló', 
        );

        return (isset($status[$purchase_status])) ? $status[$purchase_status] : $purchase_status;
    }

}
?>