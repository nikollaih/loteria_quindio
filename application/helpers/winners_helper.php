<?php 
    if(!function_exists('check_premio_mayor')){
        function check_premio_mayor($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if($purchase["number"] == $draw["result"] && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_seco')){
        function check_seco($purchase, $draw, $results, $id_reward){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(is_array($results)){
                    for ($i=0; $i < count($results); $i++) { 
                        if($purchase["number"] == $results[$i]["result_number"] && $purchase["serie"] == $results[$i]["result_serie"] && $id_reward == $results[$i]["id_reward"]){
                            $i = count($results);
                            return true;
                        }
                    }

                    return false;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_seco_no_serie')){
        function check_seco_no_serie($purchase, $draw, $results, $id_reward){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(is_array($results)){
                    for ($i=1; $i < count($results); $i++) { 
                        if($purchase["number"] == $results[$i]["result_number"] && $purchase["serie"] != $results[$i]["result_serie"] && $id_reward == $results[$i]["id_reward"]){
                            $i = count($results);
                            return true;
                        }
                    }

                    return false;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_quindianito')){
        function check_quindianito($purchase, $draw, $results, $id_reward){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(is_array($results)){
                    if($purchase["number"] == $results[7]["result_number"] && $purchase["serie"] != $results[7]["result_serie"] && $id_reward == $results[7]["id_reward"]){
                        $i = count($results);
                        return true;
                    }
                    return false;
                }
                else{
                    return false;
                }
            }
        }
    }

    // Valida la compra con el número invertido del resultado al premio mayor
    if(!function_exists('check_mayor_invertido')){
        function check_mayor_invertido($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                /* writes number into string. */  
                $num = (string) $draw["result"];  
                /* Reverse the string. */  
                $revstr = strrev($num);  
                /* writes string into int. */  
                $reverse_result = (int) $revstr; 

                if($purchase["number"] == $reverse_result && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }
    
    if(!function_exists('check_tres_primeras_cifras')){
        function check_tres_primeras_cifras($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], 0, -1) == substr($draw["result"], 0, -1) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_ultimas_tres_cifras')){
        function check_ultimas_tres_cifras($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], -3) == substr($draw["result"], -3) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_combinado')){
        function check_combinado($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                $array_purchase = str_split($purchase["number"]);
                $array_result = str_split($draw["result"]);
                sort($array_purchase);
                sort($array_result);

                if(implode("", $array_purchase) == implode("", $array_result) && $purchase["number"] != $draw["result"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_primera_ultima')){
        function check_primera_ultima($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], -1) == substr($draw["result"], -1) && substr($purchase["number"], 0, 1) == substr($draw["result"], 0, 1) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_ultimas_dos_cifras')){
        function check_ultimas_dos_cifras($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], -2) == substr($draw["result"], -2) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_primeras_dos_cifras')){
        function check_primeras_dos_cifras($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], 0, 2) == substr($draw["result"], 0, 2) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_dos_centro')){
        function check_dos_centro($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], 1, 2) == substr($draw["result"], 1, 2) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_ultima')){
        function check_ultima($purchase, $draw, $check_serie = false){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if(substr($purchase["number"], -1) == substr($draw["result"], -1) && $purchase["draw_number"] == $draw["draw_number"] && (($check_serie && $purchase["serie"] == $draw["serie"]) || (!$check_serie && $purchase["serie"] != $draw["serie"]))){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    if(!function_exists('check_serie')){
        function check_serie($purchase, $draw, $check_serie = true){
            if(isset($purchase["number"]) && isset($purchase["serie"]) && isset($purchase["draw_number"]) && isset($draw["draw_number"]) && isset($draw["result"]) && isset($draw["serie"])){
                if($purchase["draw_number"] == $draw["draw_number"] && $check_serie && $purchase["serie"] == $draw["serie"]){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }
?>