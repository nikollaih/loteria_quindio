<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Application_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->library("session");
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
        header("Location: " . base_url() . "Purchases");
    }
}
