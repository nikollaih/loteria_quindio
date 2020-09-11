<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(['session']);
	}

	public function index()
	{
		if(!$this->session->has_userdata('logged_in')){
			header("Location: " . base_url() . "usuarios/login");
		}
        $params["title"] = "Inicio";
        $params["subtitle"] = "Inicio";
        $this->load_layout("Panel/Home", $params);
	}
}
