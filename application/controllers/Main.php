<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Application_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->helper(["date"]);
        $this->load->library("session");
        $this->load->model(["Booking", "Draw", "Purchase", "Usuario"]);
	}

    // Return a random number and serie for current draw
	public function get_random_draw_number($type = "json")
	{
        if($type == "json"){
            echo json_encode(get_random_draw_number());
        }
        else{
            return get_random_draw_number();
        }
    }
    
    // Set a draw number and serie in a session array
    public function set_session_draw_number($number = null, $serie = null){
        $this->session->set_userdata('draw_number', array("number" => $number, "serie" => $serie));
        // Get the active draw
        $draw = $this->Draw->get_active_draw();
        $created_at = date("Y-m-d H:i:s");

        // Add the booking row to save the number for this sale
        $this->Booking->set_booking(array("created_at" => $created_at, "id_draw" => $draw["id"], "number" => $number, "serie" => $serie));

        header("Location: " . base_url() . "Purchases");
    }

    public function invoice($user_slug = null, $purchase_slug = null){
        $params["title"] = "Tiquete de compra";
        $params["purchase"] = $this->Purchase->get_purchase_by_param("p.slug", $purchase_slug);

        if($params["purchase"] != false && $params["purchase"]["user_slug"] == $user_slug){
            $this->load->view("Invoice", $params);
        }
    }
}
