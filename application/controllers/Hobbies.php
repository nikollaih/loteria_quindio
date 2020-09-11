<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hobbies extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model("Hobbie");
	}

	public function index()
	{
        if(is_admin()){
            if($this->input->post()){
                // Set the inputs rules
                $this->form_validation->set_rules('name', 'Name', 'required');
                
                if ($this->form_validation->run() == TRUE) {
                    // Get the post data
                    $data = $this->input->post();
                    // Save the new hobbie row in the DB
                    $insert = $this->Hobbie->set_hobbie($data);
                    if($insert){
                        $params["message"] = array("type" => "success", "message" => "Hobbie registrado exitosamente.");
                    }
                    else{
                        $params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde.");
                    }
                }
            }
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
