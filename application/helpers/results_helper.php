<?php
    // Get the remaining draws in the current year
    if(!function_exists('get_result_name_by_line'))
    {
        function get_result_name_by_line($line = null){
            switch ($line) {
                case '0':
                    return "PREMIO MAYOR";
                    break;
                case '1':
                    return "SECO DE 150 MILLONES";
                    break;
                case '2':
                case '3':
                    return "SUELDAZO CAFETERO";
                    break;
                case '4':
                case '5':
                case '6':
                    return "SECO DE 50 MILLONES";
                    break;
                case ($line >= 7 && $line <= 17):
                    return "SECO DE 25 MILLONES";
                break;
                case ($line > 17 && $line <= 32):
                    return "SECO DE 10 MILLONES";
                break;
                case '33':
                    return "QUINDIANITO SIN SERIE";
                break;
                
                default:
                    return false;
                    break;
            }
        }
    
    }

    // Get the reward id by line
    if(!function_exists('get_id_reward_by_line'))
    {
        function get_id_reward_by_line($line = null){
            switch ($line) {
                case '0':
                    return 1;
                break;
                case '1':
                    return 2;
                    break;
                case '2':
                case '3':
                    return 3;
                    break;
                case '4':
                case '5':
                case '6':
                    return 4;
                    break;
                case ($line >= 7 && $line <= 17):
                    return 5;
                break;
                case ($line > 17 && $line <= 32):
                    return 6;
                break;
                case '33':
                    return 7;
                break;
                
                default:
                    return false;
                    break;
            }
        }
    
    }
?>