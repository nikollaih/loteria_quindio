<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Usuarios');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

    // Carga la vista de login con todos los parametros seleccionados
	public function login(){
        $user = $this->Mdl_Usuarios->obtenerUsuarios();

		$data["title"] = "Login | Lotería del Quindío";
		$this->load->view('Usuarios/Login', $data);
	}

	// Carga la vista de login con todos los parametros seleccionados
	public function registro(){
        $user = $this->Mdl_Usuarios->obtenerUsuarios();

		$data["title"] = "Registro | Lotería del Quindío";
		$this->load->view('Usuarios/Registro', $data);
	}
}
