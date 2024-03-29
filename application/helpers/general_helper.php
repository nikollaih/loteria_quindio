<?php 
    // Get a random number and serie 
    if(!function_exists('get_random_draw_number'))
    {
        function get_random_draw_number(){
            $CI = &get_instance();
            $CI->load->model(['Blend', 'Draw', 'Purchase', 'Booking']);
            
            // Get current active draw
            $active_draw = $CI->Draw->get_active_draw();
            // Get the blends list
            $blends_list = $CI->Blend->get_blends();
            // Get a random blend
            $blend = $blends_list[rand(0, count($blends_list) - 1)];
            $blend_numbers = unserialize($blend["blend_numbers"]);

            //Get the sold number
            $sold_numbers = $CI->Purchase->get_sold_numbers($active_draw["id"], $blend["serie"]);
            // Get the booking numbers list
            $booking_number = $CI->Booking->get_bookings(array("serie" => $blend["serie"], "id_draw" => $active_draw["id"]));

            // Merge the sold and booked numbers to get a complete
            $exclude_array = array_merge($sold_numbers, $booking_number);
            $temp_exclude = [];
            for ($i=0; $i < count($exclude_array); $i++) { 
                array_push($temp_exclude, array_values($exclude_array[$i])[0]) ;
            }

            do {
                $rand_number = sprintf("%04s",  $blend_numbers[rand(0, count($blend_numbers))]);
            } while(in_array(intval($rand_number), $temp_exclude));
            
            return array("draw" => $active_draw, "number" => $rand_number, "serie" => $blend["serie"]);
        }
    
    }


    if(!function_exists('get_numbers_to_return'))
    {
        function get_numbers_to_return(){
            $CI = &get_instance();
            $CI->load->model(['Blend', 'Draw', 'Purchase', 'ToReturn']);
            
            // Get current active draw
            $draw = $CI->Draw->get_previous_draw();
            // Get the blends list
            $blends_list = $CI->Blend->get_blends();

            $sold_numbers_for_blend = $CI->Purchase->get_sold_numbers_with_serie($draw["id"]);

            $grouped_by_serie = array();
            foreach($sold_numbers_for_blend as $val) {
                $grouped_by_serie[$val['serie']][] = $val['number'];
            }
        
            $not_sold_numbers = Array();
            $sold_numbers = [];
            foreach ($blends_list as $key => $blend) {
              $blend_numbers = unserialize($blend["blend_numbers"]);

              $diff = $blend_numbers;
              if(array_key_exists($blend['serie'], $grouped_by_serie)){
                $sold_numbers = $grouped_by_serie[$blend['serie']];
                $diff = array_diff($blend_numbers, $sold_numbers);
              
              }
              $not_sold_numbers[$blend['serie']][] = $diff;
            }

            $data = Array(
                'id_draw' => $draw['id'],
                'to_return' => serialize($not_sold_numbers)
            );

            $result = $CI->ToReturn->set_return($data);
        }
    
    }


    // Get a random number and serie 
    if(!function_exists('get_available_numbers'))
    {
        function get_available_numbers($serie_id){
            $CI = &get_instance();
            $CI->load->model(['Blend', 'Draw', 'Purchase', 'Booking']);
            
            // Get current active draw
            $active_draw = $CI->Draw->get_active_draw();
            // Get the blends list
            $blend = $CI->Blend->get_blends($serie_id);
            $blend_numbers = unserialize($blend["blend_numbers"]);

            //Get the sold number
            $sold_numbers = $CI->Purchase->get_sold_numbers($active_draw["id"], $blend["serie"]);
            // Get the booking numbers list
            $booking_number = $CI->Booking->get_bookings(array("serie" => $blend["serie"], "id_draw" => $active_draw["id"]));

            // Merge the sold and booked numbers to get a complete
            $exclude_array = array_merge($sold_numbers, $booking_number);
            $temp_exclude = [];
            for ($i=0; $i < count($exclude_array); $i++) { 
                array_push($temp_exclude, array_values($exclude_array[$i])[0]) ;
            }

            $available_numbers = array_diff($blend_numbers, $temp_exclude);
            
            return array("draw" => $active_draw, "numbers" => array_values($available_numbers), "serie" => $blend["serie"]);
        }
    
    }

    // Get a random number and serie 
    if(!function_exists('get_available_blends'))
    {
        function get_available_blends($number){
            $CI = &get_instance();
            $CI->load->model(['Blend', 'Draw', 'Purchase', 'Booking']);
            
            // Get current active draw
            $active_draw = $CI->Draw->get_active_draw();
            // Get the blends list
            $temp_blends = ($CI->Blend->get_blends_by_number($number));
            $blends = [];

            for ($i=0; $i < count($temp_blends) ; $i++) { 
                array_push($blends, $temp_blends[$i]["serie"]);
            }

            //Get the sold number
            $sold_numbers = $CI->Purchase->get_sold_blends($active_draw["id"], $number);

            // Get the booking numbers list
            $booking_number = $CI->Booking->get_bookings(array("number" => $number, "id_draw" => $active_draw["id"]));

            // Merge the sold and booked numbers to get a complete
            $exclude_array = array_merge($sold_numbers, $booking_number);
            $temp_exclude = [];
            for ($i=0; $i < count($exclude_array); $i++) { 
                array_push($temp_exclude, ($exclude_array[$i]["serie"])) ;
            }
            
            $available_blends = array_diff($blends, $temp_exclude);
            
            return array("draw" => $active_draw, "series" => array_values($available_blends), "number" => $number);
        }
    
    }

    // Print a json response for ajax calls
    if(!function_exists('json_response'))
    {
        function json_response($obj = null, $status = false, $text = ""){
            echo json_encode(array("object" => $obj, "status" => $status, "message" => $text));
            die();
        }
    
    }

    // Get the banls listing
    if(!function_exists('get_array_banks'))
    {
        function get_array_banks(){
            $banks = "BANCAMIA S.A.,BANCO AGRARIO,BANCO AV VILLAS,BANCO BBVA COLOMBIA S.A.,BANCO CAJA SOCIAL,BANCO COOPERATIVO COOPCENTRAL,BANCO DAVIVIENDA,BANCO DE BOGOTA,BANCO DE OCCIDENTE,BANCO FALABELLA,BANCO GNB SUDAMERIS,BANCO ITAU,BANCO PICHINCHA S.A.,BANCO POPULAR,BANCO PROCREDIT,BANCO SANTANDER COLOMBIA,BANCO SERFINANZA,BANCOLOMBIA,BANCOOMEVA S.A.,CFA COOPERATIVA FINANCIERA,CITIBANK,COLTEFINANCIERA,CONFIAR COOPERATIVA FINANCIERA,COTRAFA,DAVIPLATA,NEQUI,RAPPIPAY,SCOTIABANK COLPATRIA";
            return explode(",", $banks);
        }
    
    }

    // Get an array with the identification types
    if(!function_exists('get_identification_types'))
    {
        function get_identification_types(){
            $CI = &get_instance();
            $CI->load->model(['Identification_Type']);

            return $CI->Identification_Type->get_identification_types();
        }
    
    }

    // Get the class name given the status name
    if(!function_exists('get_class_by_status'))
    {
        function get_class_by_status($status){
            switch (strtolower($status)) {
                case 'pendiente':
                    return "secondary";
                    break;
                case 'cancelado':
                    return "danger";
                    break;
                case 'denegado': case 'en proceso':
                    return "warning";
                    break;
                case 'confirmado': case 'enviado':
                    return "primary";
                    break;
                case 'completado': case 'entregado':
                    return "success";
                    break;
                
                default:
                    return "primary";
                    break;
            }
        }
    
    }

     // Get the banls listing
     if(!function_exists('check_number_blend'))
     {
         function check_number_blend($blend, $number){
            $CI = &get_instance();
            $CI->load->model(['Blend']);
        
            // Get the blends list
            $blend = $CI->Blend->get_blends($blend);
            $blend_numbers = unserialize($blend["blend_numbers"]);

            return (in_array($number, $blend_numbers)) ? true : false;
         }
     
     }
?>