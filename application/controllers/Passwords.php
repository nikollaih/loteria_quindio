<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Passwords extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario']);
		$this->load->helper(["url", "form", 'user']);
		$this->load->library(['Form_validation', 'Mailer']);
	}

  function send_instructions_form() {
		$this->load->view('Usuarios/password/send_instructions_form');
	}
	
	function send_instructions_process() {
		$validation = validate_send_instructions_form($this);
		$email = $this->input->post('email');

		$data = [];

		if ($validation == true) {
			$result = $this->Usuario->get_user_by_param("email", $email);
			if($result != false){
				$salt = get_alnum_string(10);

				$updating = $this->Usuario->update(array("change_password_salt" => $salt, "id" => $result["id"]));
				if($updating) {
					$data['success_message'] = true;
					$data['change_password_url'] = generate_change_password_url($result);
					$email_body = $this->load->view('emails/change_password', $data, true);
					$this->mailer->send($email_body, 'Solicitud de cambio de contraseña', $result['email']);
				}
			}else {
				$data['error_message'] = 'Este correo electronico no esta registrado.';
			}
		}


		$this->load->view('Usuarios/password/send_instructions_form', $data);
	}

	function change_password_form($user_slug, $password_salt) {
		$data['unauthorized'] = true;

		if($user_slug != '' && $password_salt != '') {
			$user = $this->Usuario->get_user_by_param("slug", $user_slug);
			if($user != false) {
				if($user['change_password_salt'] == $password_salt){
					$data['user_slug'] = $user_slug;
					$data['password_salt'] = $password_salt;
					$data['unauthorized'] = false;
				}
			}
		} 
		$this->load->view('Usuarios/password/change_password_form', $data);
	}

	function change_password_process() {
		$validation = validate_passsword_form($this);

		$user_slug = $this->input->post("user_slug");
		$password_salt = $this->input->post("password_salt");

		$data = Array(
			'user_slug' => $user_slug,
			'password_salt' => $password_salt
		);

		if($validation == true) {
			$data['unauthorized'] = true;

			if($user_slug != '' && $password_salt != '') {
				$user = $this->Usuario->get_user_by_param("slug", $user_slug);
				if($user != false) {
					if($user['change_password_salt'] == $password_salt){
						$data['unauthorized'] = false;

						$new_password = $this->input->post("password");
						$new_data = Array(
							'id' => $user['id'],
							'password' => md5($new_password),
							'change_password_salt' => ''
						);
						$updating = $this->Usuario->update($new_data);
						if($updating) {
							$data['success_message'] = true;
						}else {
							$data['error_message'] = "Hubo un error al intentar cambiar la contraseña.";
						}
					}
				}
			} 
		}
		$this->load->view('Usuarios/password/change_password_form', $data);
	}
}