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
                return "SECO DE 300 MILLONES";
                break;
            case '2':
            case '3':
                return "SECO DE 200 MILLONES";
                break;
            case '4':
            case '5':
            case '6':
                return "SECO DE 100 MILLONES";
                break;
            case ($line >= 7 && $line <= 14):
                return "SECO DE 50 MILLONES";
                break;
            case ($line >= 15 && $line <= 24):
                return "SECO DE 20 MILLONES";
                break;
            case ($line > 24 && $line <= 44):
                return "SECO DE 10 MILLONES";
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
            case ($line >= 7 && $line <= 14):
                return 5;
                break;
            case ($line >= 15 && $line <= 24):
                return 6;
                break;
            case ($line > 24 && $line <= 44):
                return 7;

            default:
                return false;
                break;
        }
    }

}
?>