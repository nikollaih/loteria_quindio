<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Application_Controller extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function load_layout($view, $params = null)
	{
		$data = array();
		$data["view"] = $this->load->view($view, $params, true);
		$this->load->view("Layout", $data, false);
	}
}
