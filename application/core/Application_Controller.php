<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Application_Controller extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(['session']);
	}

	public function load_layout($view, $params = null)
	{
		if(!is_logged()){
			header("Location: " . base_url() . "usuarios/login");
		}

		$data = array();
		$data["view"] = $this->load->view($view, $params, true);
		$this->load->view("Layout", $data, false);
	}
}
