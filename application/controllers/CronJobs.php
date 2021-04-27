<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronJobs extends Application_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper(['url', 'winners', 'games']);
        $this->load->model(["Purchase", "Subscriber", "Draw", "Booking", "Winner", "Usuario"]);
		$this->load->library(['session']);
	}

    // Add the rows to purchase table with the subscriber information
    // Run every friday at 00:00
	public function subscriber_to_purchase()
	{
        if(date("N") == 5){
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
                            add_loto_punto();
                            $result_subscriber = $this->Subscriber->update_subscriber(array("subscriber_remaining_amount" => $s["subscriber_remaining_amount"] - 1, "id_subscriber" => $s["id_subscriber"]));
                            // If there is any error while updating the subscriber then the purchase will be removed
                            if(!$result_subscriber){
                                add_loto_punto("substract");
                                $this->Purchase->delete_purchase($result_purchase["id_purchase"]);
                            }
                        }
                    }
                }
            }
        }
    }
    
    // Delete the old booking register, (more than 10 minutes since it was created)
    // Run every 10 minutes
    public function clear_booking(){
        $datetime_from = date("Y-m-d H:i:s", strtotime("-20 minutes", strtotime(date("Y-m-d H:i"))));
        $this->Booking->clear_booking($datetime_from);
    }

    // Set the lotto points to 0
    // Run after finished the current draw
    function clear_lotto_points(){
        if(date("N") == 4){
            $this->Usuario->clear_lotto_points();
        }
    }

    
    function update_purchases_status(){
        $purchases = $this->Purchase->get_purchase_by_param("p.purchase_status", "PENDING", 0);

        if($purchases){
            foreach ($purchases as $purchase) {
                if($purchase["request_id"]){
                    $status = get_purchase_status($purchase["id_purchase"], $purchase["request_id"]);
                    $this->Purchase->update_purchase(array('id_purchase' => $purchase["id_purchase"], 'purchase_status' => $status["status"]->status ));
                }
            }
        }
    }
}
