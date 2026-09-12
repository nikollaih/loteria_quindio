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
                return "SECO DE 200 MILLONES";
                break;
            case '2':
                return "SECO DE 100 MILLONES";
                break;
            case ($line >= 3 && $line <= 7):
                return "SECO DE 50 MILLONES";
                break;
            case ($line >= 8 && $line <= 12):
                return "SECO DE 40 MILLONES";
                break;
            case ($line >= 13 && $line <= 17):
                return "SECO DE 30 MILLONES";
                break;
            case ($line >= 18 && $line <= 27):
                return "SECO DE 20 MILLONES";
                break;
            case ($line >= 28 && $line <= 37):
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
                return 3;
                break;
            case ($line >= 3 && $line <= 7):
                return 4;
                break;
            case ($line >= 8 && $line <= 12):
                return 5;
                break;
            case ($line >= 13 && $line <= 17):
                return 6;
                break;
            case ($line >= 18 && $line <= 27):
                return 7;
                break;
            case ($line >= 28 && $line <= 37):
                return 8;
                break;

            default:
                return false;
                break;
        }
    }

}
?>