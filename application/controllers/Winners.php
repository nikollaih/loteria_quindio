<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Winners extends Application_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'winners', 'file']);
        $this->load->model(["Purchase", "Subscriber", "Draw", "Booking", "Winner", "Reward", "Result", "Usuario"]);
		$this->load->library(['session']);
    }
    
    public function generate_winners(){
        $draw = ($this->input->post("id_draw")) ? $this->Draw->get_draws($this->input->post("id_draw")) : $this->Draw->get_previous_draw();
        
        if(is_array($draw) && isset($draw["draw_number"])){
            $purchases = $this->Purchase->get_purchase_by_param("d.draw_number", $draw["draw_number"], 0, "APPROVED");
            $results = $this->Result->get_results($draw["id"]);
            if(is_array($purchases)){
                foreach ($purchases as $purchase) {
                    for ($i=1; $i <= 26; $i++) { 
                        switch ($i) {
                            case '1':
                                if (check_premio_mayor($purchase, $draw, true)){
                                    $this->save_winner($purchase, 1);
                                    $i = 29;
                                }
                            break;
                            case ($i >= 2 && $i <= 6):
                                if (check_seco($purchase, $draw, $results, $i)){
                                    $this->save_winner($purchase, $i);
                                    $i = 29;
                                }
                            break;
                            case '7':
                                if (check_quindianito($purchase, $draw, $results, true)){
                                    $this->save_winner($purchase, 7);
                                    $i = 29;
                                }
                            break;
                            case '8':
                                if (check_mayor_invertido($purchase, $draw, true)){
                                    $this->save_winner($purchase, 8);
                                    $i = 29;
                                }
                            break;
                            case '9':
                                if (check_tres_primeras_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 9);
                                    $i = 29;
                                }
                            break;
                            case '10':
                                if (check_ultimas_tres_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 10);
                                    $i = 29;
                                }
                            break;
                            case '11':
                                if (check_combinado($purchase, $draw, true)){
                                    $this->save_winner($purchase, 11);
                                    $i = 29;
                                }
                            break;
                            case '12':
                                if (check_primera_ultima($purchase, $draw, true)){
                                    $this->save_winner($purchase, 12);
                                    $i = 29;
                                }
                            break;
                            case '13':
                                if (check_ultimas_dos_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 13);
                                    $i = 29;
                                }
                            break;
                            case '14':
                                if (check_primeras_dos_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 14);
                                    $i = 29;
                                }
                            break;
                            case '15':
                                if (check_dos_centro($purchase, $draw, true)){
                                    $this->save_winner($purchase, 15);
                                    $i = 29;
                                }
                            break;
                            case '16':
                                if (check_ultima($purchase, $draw, true)){
                                    $this->save_winner($purchase, 16);
                                    $i = 29;
                                }
                            break;
                            case '17':
                                if (check_serie($purchase, $draw, true)){
                                    $this->save_winner($purchase, 17);
                                    $i = 29;
                                }
                            break;
                            case '18':
                                if (check_premio_mayor($purchase, $draw, false)){
                                    $this->save_winner($purchase, 18);
                                    $i = 29;
                                }
                            break;
                            case '19':
                                if (check_mayor_invertido($purchase, $draw, false)){
                                    $this->save_winner($purchase, 19);
                                    $i = 29;
                                }
                            break;
                            case '20':
                                if (check_combinado($purchase, $draw, false)){
                                    $this->save_winner($purchase, 20);
                                    $i = 29;
                                }
                            break;
                            case '21':
                                if (check_tres_primeras_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 21);
                                    $i = 29;
                                }
                            break;
                            case '22':
                                if (check_ultimas_tres_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 22);
                                    $i = 29;
                                }
                            break;
                            case '23':
                                if (check_primera_ultima($purchase, $draw, false)){
                                    $this->save_winner($purchase, 23);
                                    $i = 29;
                                }
                            break;
                            case '24':
                                if (check_ultimas_dos_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 24);
                                    $i = 29;
                                }
                            break;
                            case '25':
                                if (check_primeras_dos_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 25);
                                    $i = 29;
                                }
                            break;
                            case '26':
                                if (check_dos_centro($purchase, $draw, false)){
                                    $this->save_winner($purchase, 26);
                                    $i = 29;
                                }
                            break;
                            case '27':
                                if (check_ultima($purchase, $draw, false)){
                                    $this->save_winner($purchase, 27);
                                    $i = 29;
                                }
                            break;
                            case '28':
                                if (check_seco_no_serie($purchase, $draw, $results, false)){
                                    $this->save_winner($purchase, 28);
                                    $i = 29;
                                }
                            break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                }
            }
        }
    }

    public function save_winner($purchase, $id_reward){
        $temp_winner = $this->Winner->get_winner($purchase["id_purchase"]);
        $reward = $this->Reward->get_rewards($id_reward);
        if(!$temp_winner){
            $set_winner = ($this->Winner->set_winner(array("id_reward" => $id_reward, "id_purchase" => $purchase["id_purchase"], "created_at" => date("Y-m-d H:i:s"), "total_without_discount" => $reward["bill_without_discount"], "total_with_discount" => $reward["bill_with_discount"]))) ? true : false;
            /*if($set_winner){
                $user = $this->Usuario->get_user_by_param("u.id", $purchase["id_user"]);
                if(is_array($user)){
                    $data["id"] = $user["id"];
                    $data["balance_total"] = doubleval($user["balance_total"]) + doubleval($reward["bill_with_discount"]);
                    $this->Usuario->update($data);
                }
            }*/
        }
        else{
            return true;
        }
    }

    public function manage_rewards(){
        $params["title"] = "Premios | Lotería del Quindío";
        $params["subtitle"] = "Premios";
        $params["rewards"] = $this->Reward->get_rewards();
        $this->load_layout("Panel/Rewards/Rewards", $params);
    }

    public function update_reward(){
        if(is_admin()){
            $data = $this->input->post("data");
    
            if($data){
                $reward = $this->Reward->get_rewards($data["id_reward"]);
                if($reward){
                    $result = $this->Reward->update_reward($data);
    
                    if($result){
                        echo json_encode(array("error" => FALSE, "message" => "Aproximación modificada exitosamente."));
                    }
                    else{
                        echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                    }
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "La aproximación que intenta modificar no se encuentra registrada."));
                }
            }
            else{
                echo json_encode(array("error" => TRUE, "message" => "Los datos de la aproximación son requeridos."));
            }
        }
        else{
            echo json_encode(array("error" => TRUE, "message" => "Usted no tiene permisos para realizar esta acción."));
        }
    }

    function import_confirm_winners($draw_slug = null){

        if(isset($_FILES["winners"])){
            if($_FILES["winners"]["type"] == "text/plain"){
                $string = read_file($_FILES["winners"]["tmp_name"]);
                $winner_rows = explode("\n", $string);
                $draw = $this->Draw->get_draws(null, null, $draw_slug);
                //array_pop($winner_rows);
                $tmp_array = [];

                if(is_array($draw)){
                    if($draw["confirmed_winners"] == 0){
                        for ($i=0; $i < count($winner_rows); $i++) { 
                            $winner = explode("|", $winner_rows[$i]);
                            
                            if(count($winner) == 7){
                                $data["id_purchase"] = $winner[5];
                                $data["confirmed"] = $winner[7];
                                $data["total_with_discount"] = $winner[1];
            
                                if($this->Winner->update_winner($data)){
                                    $purchase = $this->Purchase->get_purchases($winner[5]);
                                    if(!$this->Usuario->update(array("id" => $purchase["id"], "balance_total" => floatval($purchase["balance_total"]) + floatval($winner[1])))){
                                        $data["id_purchase"] = $winner[5];
                                        $data["confirmed"] = 0;
                                        $data["total_with_discount"] = 0;
                                        $this->Winner->update_winner($data);
                                        json_response(null, false, "Ha ocurrido un error inesperado.");
                                    }
                                    else{
                                        $this->Purchase->update_purchase(array("id_purchase" => $purchase["id_purchase"], "reward_name" => $winner[2]));
                                    }
                                }
                            }
                            else{
                                json_response(null, false, "La cantidad de items en la linea ".$i + 1 ." no es válida.");
                            }
                        }

                        $this->Draw->update_draw(array("id" => $draw["id"], "confirmed_winners" => 1));
                        json_response(null, true, "Ganadores cargados exitosamente.");
                    }
                    else{
                        json_response(null, false, "El sorteo ya cuenta con un archivo de confirmación de ganadores.");
                    }
                }
                else{
                    json_response(null, false, "El sorteo no existe.");
                }
            }
            else{
                json_response(null, false, "Archivo de texto no válido.");
            }
        }
        else{
            json_response(null, false, "No se ha recibido el archivo de texto.");
        }
    }

    function confirm_winners($draw_slug){
        if(is_admin()){
            $params["title"] = "Importar Ganadores";
            $params["subtitle"] = "Importar Ganadores";
            $params["draw"] = $this->Draw->get_draws(null, null, $draw_slug);
            $this->load_layout("Panel/Draws/ConfirmWinners", $params);
        }
    }
    
}
