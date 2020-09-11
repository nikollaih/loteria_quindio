<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hobbies extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url']);
        $this->load->library(['session']);
        $this->load->model("Hobbie");
	}

	public function index()
	{
        if(is_admin()){
            $params["title"] = "Hobbies";
            $params["subtitle"] = "Hobbies";
            $params["hobbies"] = $this->Hobbie->get_hobbies();
            $this->load_layout("Panel/Hobbies/Hobbies", $params);
        }
        else {
            header("Location: " . base_url() . 'panel');
        }
	}
}
