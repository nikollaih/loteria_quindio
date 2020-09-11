<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Usuarios extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Usuarios');
		$this->load->helper('url');
	}

    // Carga la vista de login con todos los parametros seleccionados
	public function login(){
        $data["code"] = 200;
		$data["user"] = ["name" => "niko"];
		$data = array('response' => array('type' => false,'code' => 400,'msg' => 'Email format Invalid.' ));
		echo json_encode($data);
	}
}
