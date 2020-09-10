<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
        $params["title"] = "Inicio";
        $params["subtitle"] = "Inicio";
        $this->load_layout("Panel/Home", $params);
	}
}
