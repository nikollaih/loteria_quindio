<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Application_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
        $this->load->model(["Purchase", "Location"]);
		$this->load->library(['session']);
	}
    
    // Delete the old booking register, (more than 10 minutes since it was created)
    public function by_date(){
        $params["start_date"] = $this->input->post("start_date");
        $params["end_date"] = $this->input->post("end_date");
        $params["title"] = "Reporte por fecha";
        $params["subtitle"] = "Reporte por fechas";
        $params["purchases"] = $this->Purchase->get_purchases_by_dates($params["start_date"], $params["end_date"]);
        $this->load_layout("Panel/Reports/Dates", $params);
    }

    public function by_state(){
        $params["start_date"] = $this->input->post("start_date");
        $params["end_date"] = $this->input->post("end_date");
        $params["state"] = $this->input->post("state");
        $params["title"] = "Reporte por departamento";
        $params["subtitle"] = "Reporte por departamento";
        $params["states"] = $this->Location->get_states();
        $params["purchases"] = $this->Purchase->get_purchases_by_dates($params["start_date"], $params["end_date"], $params["state"]);

        $this->load_layout("Panel/Reports/States", $params);
    }
}
