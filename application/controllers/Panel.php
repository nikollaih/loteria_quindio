<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(['session']);
		$this->load->model(['Draw', 'Result']);
	}

	public function index()
	{
		$params["title"] = "Inicio";
		$params["subtitle"] = "Inicio";

		$active_draw = $this->Draw->get_previous_draw();
		$results = $this->Result->get_results($active_draw['id']);

		$params['draw'] = $active_draw;
		$params['results'] = $results;
		$this->load_layout("Panel/Home", $params);
	}
}
