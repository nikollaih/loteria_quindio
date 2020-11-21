<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Application_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'file', 'results']);
        $this->load->model(["Setting"]);
    }

    public function index(){
        if(is_admin()){

            if($this->input->post()){
                $settings = $this->input->post("data");
                foreach ($settings as $key => $value) {
                    $update["key"] = $key;
                    $update["value"] = $value;

                    $this->Setting->update($update);
                }

                $params["message"]["type"] = "success";
                $params["message"]["message"] = "Datos modificados exitosamente";
            }

            $params["settings"] = $this->Setting->get();
            
        }

        $params["title"] = "Configuración";
        $params["subtitle"] = "Configuración";
        $this->load_layout("Panel/Settings/Settings", $params);
    }
}