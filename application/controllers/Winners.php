<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Winners extends Application_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'winners']);
        $this->load->model(["Purchase", "Subscriber", "Draw", "Booking", "Winner", "Reward", "Result", "Usuario"]);
		$this->load->library(['session']);
    }
    
    public function generate_winners(){
        $draw = ($this->input->post("id_draw")) ? $this->Draw->get_draws($this->input->post("id_draw")) : $this->Draw->get_previous_draw();
        
        if(is_array($draw) && isset($draw["draw_number"])){
            $purchases = $this->Purchase->get_purchase_by_param("d.draw_number", $draw["draw_number"], 0);
            $results = $this->Result->get_results($draw["id"]);
            if(is_array($purchases)){
                foreach ($purchases as $purchase) {
                    for ($i=1; $i <= 26; $i++) { 
                        switch ($i) {
                            case '1':
                                if (check_premio_mayor($purchase, $draw, true)){
                                    $this->save_winner($purchase, 1);
                                    $i = 27;
                                }
                            break;
                            case ($i >= 2 && $i <= 6):
                                if (check_seco($purchase, $draw, $results, $i)){
                                    $this->save_winner($purchase, $i);
                                    $i = 27;
                                }
                            break;
                            case '7':
                                if (check_mayor_invertido($purchase, $draw, true)){
                                    $this->save_winner($purchase, 7);
                                    $i = 27;
                                }
                            break;
                            case '8':
                                if (check_tres_primeras_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 8);
                                    $i = 27;
                                }
                            break;
                            case '9':
                                if (check_ultimas_tres_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 9);
                                    $i = 27;
                                }
                            break;
                            case '10':
                                if (check_combinado($purchase, $draw, true)){
                                    $this->save_winner($purchase, 10);
                                    $i = 27;
                                }
                            break;
                            case '11':
                                if (check_primera_ultima($purchase, $draw, true)){
                                    $this->save_winner($purchase, 12);
                                    $i = 27;
                                }
                            break;
                            case '12':
                                if (check_ultimas_dos_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 12);
                                    $i = 27;
                                }
                            break;
                            case '13':
                                if (check_primeras_dos_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 13);
                                    $i = 27;
                                }
                            break;
                            case '14':
                                if (check_dos_centro($purchase, $draw, true)){
                                    $this->save_winner($purchase, 14);
                                    $i = 27;
                                }
                            break;
                            case '15':
                                if (check_ultima($purchase, $draw, true)){
                                    $this->save_winner($purchase, 15);
                                    $i = 27;
                                }
                            break;
                            case '16':
                                if (check_serie($purchase, $draw, true)){
                                    $this->save_winner($purchase, 16);
                                    $i = 27;
                                }
                            break;
                            case '17':
                                if (check_premio_mayor($purchase, $draw, false)){
                                    $this->save_winner($purchase, 17);
                                    $i = 27;
                                }
                            break;
                            case '18':
                                if (check_mayor_invertido($purchase, $draw, false)){
                                    $this->save_winner($purchase, 18);
                                    $i = 27;
                                }
                            break;
                            case '19':
                                if (check_combinado($purchase, $draw, false)){
                                    $this->save_winner($purchase, 19);
                                    $i = 27;
                                }
                            break;
                            case '20':
                                if (check_tres_primeras_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 20);
                                    $i = 27;
                                }
                            break;
                            case '21':
                                if (check_ultimas_tres_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 21);
                                    $i = 27;
                                }
                            break;
                            case '22':
                                if (check_primera_ultima($purchase, $draw, false)){
                                    $this->save_winner($purchase, 22);
                                    $i = 27;
                                }
                            break;
                            case '23':
                                if (check_ultimas_dos_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 23);
                                    $i = 27;
                                }
                            break;
                            case '24':
                                if (check_primeras_dos_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 24);
                                    $i = 27;
                                }
                            break;
                            case '25':
                                if (check_dos_centro($purchase, $draw, false)){
                                    $this->save_winner($purchase, 25);
                                    $i = 27;
                                }
                            break;
                            case '26':
                                if (check_ultima($purchase, $draw, false)){
                                    $this->save_winner($purchase, 26);
                                    $i = 27;
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
            $set_winner = ($this->Winner->set_winner(array("id_reward" => $id_reward, "id_purchase" => $purchase["id_purchase"], "created_at" => date("Y-m-d H:i:s")))) ? true : false;
            if($set_winner){
                $user = $this->Usuario->get_user_by_param("u.id", $purchase["id_user"]);
                if(is_array($user)){
                    $data["id"] = $user["id"];
                    $data["balance_total"] = doubleval($user["balance_total"]) + doubleval($reward["bill_with_discount"]);
                    $this->Usuario->update($data);
                }
            }
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
    
}
