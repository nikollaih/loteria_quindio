<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronJobs extends Application_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(['url', 'winners']);
        $this->load->model(["Purchase", "Subscriber", "Draw", "Booking", "Winner"]);
		$this->load->library(['session']);
	}

    // Add the rows to purchase table with the subscriber information
	public function subscriber_to_purchase()
	{
        // Get the subscriber list
        $subscriber = $this->Subscriber->get_subscribers();
        // Get the current active draw
        $draw = $this->Draw->get_active_draw();

        // Validate if subscriber is an array and different than false
        if(is_array($subscriber) && $subscriber != false){
            foreach ($subscriber as $s) {
                // Create the new purchase array
                $data["id_user"] = $s["id_user"];
                $data["id_draw"] = $draw["id"];
                $data["number"] = $s["number"];
                $data["serie"] = $s["serie"];
                $data["parts"] = $draw["fractions_count"];
                $data["purchase_status"] = $s["purchase_status"];
                $data["created_at"] = date("Y-m-d h:m:s");

                // Validate if it exists any active purchase with the same data
                $validate_purchase = $this->Purchase->validate_purchase($data);
                if(!is_array($validate_purchase) && !$validate_purchase){
                    // Save the new purchase
                    $result_purchase = $this->Purchase->set_purchase($data);
                    // If purchase was created successfully then it will update the remaining subscriber amount
                    if(is_array($result_purchase)){
                        $result_subscriber = $this->Subscriber->update_subscriber(array("subscriber_remaining_amount" => $s["subscriber_remaining_amount"] - 1, "id_subscriber" => $s["id_subscriber"]));
                        // If there is any error while updating the subscriber then the purchase will be removed
                        if(!$result_subscriber){
                            $this->Purchase->delete_purchase($result_purchase["id_purchase"]);
                        }
                    }
                }
            }
        }
    }
    
    // Delete the old booking register, (more than 10 minutes since it was created)
    public function clear_booking(){
        $datetime_from = date("Y-m-d H:i:s", strtotime("-10 minutes", strtotime(date("Y-m-d H:i"))));
        $this->Booking->clear_booking($datetime_from);
    }

    public function generateWinners(){
        $draw = $this->Draw->get_previous_draw();
        print_r($draw);
        echo "====================================";
        if(is_array($draw) && isset($draw["draw_number"])){
            $purchases = $this->Purchase->get_purchase_by_param("d.draw_number", $draw["draw_number"], 0);
            print_r($purchases);
            if(is_array($purchases)){
                foreach ($purchases as $purchase) {
                    for ($i=1; $i <= 21; $i++) { 
                        switch ($i) {
                            case '1':
                                if (check_premio_mayor($purchase, $draw, true)){
                                    $this->save_winner($purchase, 1);
                                    $i = 22;
                                }
                            break;
                            case '2':
                                if (check_mayor_invertido($purchase, $draw, true)){
                                    $this->save_winner($purchase, 2);
                                    $i = 22;
                                }
                            break;
                            case '3':
                                if (check_tres_primeras_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 3);
                                    $i = 22;
                                }
                            break;
                            case '4':
                                if (check_ultimas_tres_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 4);
                                    $i = 22;
                                }
                            break;
                            case '5':
                                if (check_combinado($purchase, $draw, true)){
                                    $this->save_winner($purchase, 5);
                                    $i = 22;
                                }
                            break;
                            case '6':
                                if (check_primera_ultima($purchase, $draw, true)){
                                    $this->save_winner($purchase, 6);
                                    $i = 22;
                                }
                            break;
                            case '7':
                                if (check_ultimas_dos_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 7);
                                    $i = 22;
                                }
                            break;
                            case '8':
                                if (check_primeras_dos_cifras($purchase, $draw, true)){
                                    $this->save_winner($purchase, 8);
                                    $i = 22;
                                }
                            break;
                            case '9':
                                if (check_dos_centro($purchase, $draw, true)){
                                    $this->save_winner($purchase, 9);
                                    $i = 22;
                                }
                            break;
                            case '10':
                                if (check_ultima($purchase, $draw, true)){
                                    $this->save_winner($purchase, 10);
                                    $i = 22;
                                }
                            break;
                            case '11':
                                if (check_serie($purchase, $draw, true)){
                                    $this->save_winner($purchase, 11);
                                    $i = 22;
                                }
                            break;
                            case '12':
                                if (check_premio_mayor($purchase, $draw, false)){
                                    $this->save_winner($purchase, 12);
                                    $i = 22;
                                }
                            break;
                            case '13':
                                if (check_mayor_invertido($purchase, $draw, false)){
                                    $this->save_winner($purchase, 13);
                                    $i = 22;
                                }
                            break;
                            case '14':
                                if (check_tres_primeras_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 14);
                                    $i = 22;
                                }
                            break;
                            case '15':
                                if (check_ultimas_tres_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 15);
                                    $i = 22;
                                }
                            break;
                            case '16':
                                if (check_combinado($purchase, $draw, false)){
                                    $this->save_winner($purchase, 16);
                                    $i = 22;
                                }
                            break;
                            case '17':
                                if (check_primera_ultima($purchase, $draw, false)){
                                    $this->save_winner($purchase, 17);
                                    $i = 22;
                                }
                            break;
                            case '18':
                                if (check_ultimas_dos_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 18);
                                    $i = 22;
                                }
                            break;
                            case '19':
                                if (check_primeras_dos_cifras($purchase, $draw, false)){
                                    $this->save_winner($purchase, 19);
                                    $i = 22;
                                }
                            break;
                            case '20':
                                if (check_dos_centro($purchase, $draw, false)){
                                    $this->save_winner($purchase, 20);
                                    $i = 22;
                                }
                            break;
                            case '22':
                                if (check_ultima($purchase, $draw, false)){
                                    $this->save_winner($purchase, 22);
                                    $i = 22;
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

        if($temp_winner == false){
            if ($this->Winner->set_winner(array("id_reward" => $id_reward, "id_purchase" => $purchase["id_purchase"], "created_at" => date("Y-m-d H:i:s")))){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
    }
}
