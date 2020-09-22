<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(['session']);
		$this->load->model(['Location', 'Blend']);
	}

	public function index()
	{
        $params["title"] = "Compra";
		$params["subtitle"] = "Compra";
		$params["states"] = $this->Location->get_states();
		$params["blends"] = $this->Blend->get_blends();
        $this->load_layout("Purchases/Checkout", $params);
	}
}
