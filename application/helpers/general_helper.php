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
            //Get the sold number
            $sold_numbers = $CI->Purchase->get_sold_numbers($active_draw["id"], $blend["serie"]);
            // Get the booking numbers list
            $booking_number = $CI->Booking->get_bookings(array("serie" => $blend["serie"], "id_draw" => $active_draw["id"]));

            // Merge the sold and booked numbers to get a complete
            $exclude_array = array_merge($sold_numbers, $booking_number);

            do {   
                $rand_number = sprintf("%04s", rand($blend["start_number"], $blend["end_number"]));
            } while(in_array($rand_number, $exclude_array));
            
            return array("draw" => $active_draw, "number" => $rand_number, "serie" => $blend["serie"]);
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
?>