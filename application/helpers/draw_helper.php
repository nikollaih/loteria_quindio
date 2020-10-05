<?php
    // Get the remaining draws in the current year
    if(!function_exists('get_remaining_draws'))
    {
        function get_remaining_draws(){
            $datetime1 = date_create(date("Y-m-d"));
            $datetime2 = date_create(date("Y")."-12-31");
            $interval = date_diff($datetime1, $datetime2);
            return floor($interval->format('%a') / 7);
        }
    
    }
?>