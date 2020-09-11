<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario');
		$this->load->helper(["url", "form"]);
		$this->load->library(['form_validation', 'session']);
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

    // Carga la vista de login con todos los parametros seleccionados
	public function login(){
		if($this->session->has_userdata('logged_in')){
			header("Location: " . base_url() . "panel");
		}
		$data["title"] = "Login | Lotería del Quindío";
		$this->load->view('Usuarios/Login', $data);
	}

	// Check for user login process
	public function user_login_process() {
		// Set the inputs rules
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		// Check if input rules are ok
		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				header("Location: " . base_url() . "panel");
				exit();
			}else{
				$this->load->view('Usuarios/Login');
			}
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->Usuario->login($data);

			// If the user exists
			if ($result == TRUE) {
				$username = $this->input->post('username');
				$result = $this->Usuario->read_user_information($username);
				if ($result != false) {
				// Add user data in session
				$this->session->set_userdata('logged_in', $result[0]);
				header("Location: " . base_url() . "panel");
				exit();
			}
			} else {
				$data = array(
					'error_message' => 'Nombre de usuario o contraseña incorrecta.'
				);
				$this->load->view('Usuarios/Login', $data);
			}
		}
	}

	// Carga la vista de login con todos los parametros seleccionados
	public function registro(){
		$data["title"] = "Registro | Lotería del Quindío";
		$this->load->view('Usuarios/Registro', $data);
	}

	// Logout from admin page
	public function logout() {
		// Removing session data
		$sess_array = array(
			'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('usuarios/login', $data);
	}
	
}
