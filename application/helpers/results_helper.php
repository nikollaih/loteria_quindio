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
                    return "SECO DE 100 MILLONES";
                    break;
                case '2':
                case '3':
                    return "SUELDAZO CAFETERO";
                    break;
                case '4':
                    return "SECO DE 50 MILLONES";
                    break;
                case ($line >= 5 && $line <= 19):
                    return "SECO DE 10 MILLONES";
                break;
                case ($line > 19):
                    return "SECO DE 5 MILLONES";
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
                    return 4;
                    break;
                case ($line >= 5 && $line <= 19):
                    return 5;
                break;
                case ($line > 19):
                    return 6;
                break;
                
                default:
                    return false;
                    break;
            }
        }
    
    }
?>