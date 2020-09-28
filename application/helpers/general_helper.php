<?php 
    // Get a random number and serie 
    if(!function_exists('get_random_draw_number'))
    {
        function get_random_draw_number(){
            $CI = &get_instance();
            $CI->load->model(['Blend', 'Draw', 'Purchase']);
            
            // Get current active draw
            $active_draw = $CI->Draw->get_active_draw();
            // Get the blends list
            $blends_list = $CI->Blend->get_blends();
            // Get a random blend
            $blend = $blends_list[rand(0, count($blends_list) - 1)];
            //Get the sold number
            $sold_numbers = $CI->Purchase->get_sold_numbers($active_draw["id"], $blend["serie"]);

            do {   
                $rand_number = sprintf("%04s", rand($blend["start_number"], $blend["end_number"]));
            } while(in_array($rand_number, $sold_numbers));
            
            return array("draw" => $active_draw, "number" => $rand_number, "serie" => $blend["serie"]);
        }
    
    }
?>