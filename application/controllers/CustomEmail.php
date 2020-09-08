<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomEmail extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Usuarios');
        $this->load->library('email');
        
        //configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => '',
			'smtp_pass' => '',
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'smtp_debug' => true,
			'smtp_auth' => true
		);    
	
		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
	}

	public function index()
	{
		$this->email->from('nikollaihernandez@gmail.com', 'Lotería del Quindio');
		$this->email->to('nikollaihernandez@gmail.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();
	}
}
