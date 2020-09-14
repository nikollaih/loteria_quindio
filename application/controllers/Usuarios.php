<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario', 'Hobbie', 'Identification_Type', 'Location']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation', 'encryption']);
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
				'password' => md5($this->input->post('password')),
			);

			$result = $this->Usuario->login($data);

			// If the user exists
			if ($result == TRUE) {
				$username = $this->input->post('username');
				$result = $this->Usuario->get_user_by_param("email", $username);
				if ($result != false) {
				// Add user data in session
				$this->session->set_userdata('logged_in', $result);
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
		if($this->session->has_userdata('logged_in')){
			header("Location: " . base_url() . "panel");
		}

		if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('user[identification_type_id]', 'Tipo de documento', 'required|numeric');
			$this->form_validation->set_rules('user[identification_number]', 'Número de documento', 'required|numeric');
			$this->form_validation->set_rules('user[first_name]', 'Nombre', 'required|alpha');
			$this->form_validation->set_rules('user[last_name]', 'Apellidos', 'required|alpha');
			$this->form_validation->set_rules('user[city_id]', 'Ciudad', 'required|numeric');
			$this->form_validation->set_rules('user[phone]', 'Teléfono', 'required|numeric|min_length[7]');
			$this->form_validation->set_rules('user[address]', 'Dirección', 'required');
			$this->form_validation->set_rules('user[birth_date]', 'Fecha de nacimiento', 'required');
			$this->form_validation->set_rules('user[email]', 'Correo electrónico', 'required|valid_email');
			$this->form_validation->set_rules('user[password]', 'Contraseña', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde", "success" => false);
			}else{
				$params["message"] = $this->user_signin_process($this->input->post("user"), $this->input->post("hobbies"));
			}

			$params["data_form"] = $this->input->post();
		}

		$params["title"] = "Registro | Lotería del Quindío";
		$params["hobbies"] = $this->Hobbie->get_hobbies();
		$params["identification_types"] = $this->Identification_Type->get_identification_types();
		$params["states"] = $this->Location->get_states();
		$this->load->view('Usuarios/Registro', $params);
	}

	public function user_signin_process($user_data, $user_hobbies){
		// Check if received params are arrays
		if(is_array($user_data) && is_array($user_hobbies)){
			// Serach an account with the signin email
			$user = $this->Usuario->get_user_by_param("email", $user_data["email"]);

			// In case it doesn't exists an account with the same email
			if($user == false){
				$user = $this->Usuario->get_user_by_param("identification_number", $user_data["identification_number"]);

				// In case it doesn't exists an account with the same idetification number
				if($user == false){
					$user_data["slug"] = get_alnum_string();
					$user_data["password"] = md5($user_data["password"]);
					$result_user = $this->Usuario->signin_insert($user_data);
					// If the user was registered successfully
					if($result_user != false){
						$result_hobbies = $this->Hobbie->set_user_hobbies($result_user["id"], $user_hobbies);

						if($result_hobbies){
							return array("type" => "success", "success" => true, "message" => "Usuario registrado exitosamente.");
						} 
						else{
							return array("type" => "success", "success" => true, "message" => "El usuario ha sido registrado pero ha ocurrido un error con los hobbies.");
						}
					}
					else{
						return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar el usuario, por favor intente de nuevo más tarde.");
					}
				}
				else{
					return array("type" => "danger", "success" => false, "message" => "El número de documento que intenta registrar ya está en uso.");
				}
			}
			else{
				return array("type" => "danger", "success" => false, "message" => "El correo electrónico " . $user_data["email"] . " ya se encuentra en uso.");
			}
		}
		else{
			return array("type" => "danger", "success" => false, "message" => "Los datos recibidos son incorrectos.");
		}
	}

	// Logout from admin page
	public function logout() {
		$this->session->unset_userdata('logged_in');
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('usuarios/login', $data);
	}
	
}
