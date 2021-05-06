<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario', 'Hobbie', 'Identification_Type', 'Location']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation', 'Mailer']);
		$this->HEADER_LOCATION = "Location: ";
	}

    // Carga la vista de login con todos los parametros seleccionados
	public function login(){
		if(is_logged()){
			header($this->HEADER_LOCATION . base_url() . "panel");
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
				header($this->HEADER_LOCATION. base_url() . "panel");
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
				if($result['confirmed_email'] == TRUE) {
					// Add user data in session
					$this->session->set_userdata('logged_in', $result);
					if($this->session->has_userdata("draw_number")){
						header($this->HEADER_LOCATION. base_url() . "Purchases");
					}
					else{
						header($this->HEADER_LOCATION. base_url() . "panel");
					}
					exit();
				}else {
					$data = array(
						'error_message' => 'Su direccion de correo no ha sido verificada. <a href=' . base_url() . 'usuarios/send_verification_email/' . $result['slug'] . '>Enviar email de verificación </a>'
					);
					$this->load->view('Usuarios/Login', $data);
				}
			} else {
				$data = array(
					'error_message' => 'Nombre de usuario o contraseña incorrecta.'
				);
				$this->load->view('Usuarios/Login', $data);
			}
		}
	}

	public function verify_email($user_slug = '') {
		if($user_slug != ''){
			$user = $this->Usuario->get_user_by_param("slug", $user_slug);
			if($user != false) {
				$updating = $this->Usuario->update(array("confirmed_email" => true, "id" => $user["id"]));

				if($updating) {
					$data['success_message'] = true;
				}else {
					$data['error_message'] = "Hubo un error al intentar verificar su correo electronico.";
				}
				$this->load->view('Usuarios/verified_email', $data);
			}else {
				$this->load->view('Templates/Not_authorized');
			}
		}else {
			$this->load->view('Templates/Not_authorized');
		}
	}

	// Carga la vista de login con todos los parametros seleccionados
	public function registro(){
		if($this->session->has_userdata('logged_in')){
			header($this->HEADER_LOCATION. base_url() . "panel");
		}

		if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('user[identification_type_id]', 'Tipo de documento', 'required');
			$this->form_validation->set_rules('user[identification_number]', 'Número de documento', 'required|integer');
			$this->form_validation->set_rules('user[first_name]', 'Nombre', 'required', array(
				'required'      => 'El campo Nombre es requerido.',
        	));
			$this->form_validation->set_rules('user[last_name]', 'Apellidos', 'required', array(
				'required'      => 'El campo Apellidos es requerido.',
        	));
			$this->form_validation->set_rules('user[city_id]', 'Ciudad', 'required');
			$this->form_validation->set_rules('user[email]', 'Correo electrónico', 'required|valid_email', array(
                'valid_email'      => 'El campo Correo electrónico no es válido.',
        	));
			$this->form_validation->set_rules('user[password]', 'Contraseña', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde", "success" => false);
			}else{
				$params["message"] = $this->user_signin_process($this->input->post("user"), $this->input->post("hobbies"));
			}

			/* if($params["message"]["success"] == true){
				$data = array(
					'username' => $this->input->post("user")['email'],
					'password' => md5($this->input->post("user")["password"]),
				);
	
				$result = $this->Usuario->login($data);
	
				// If the user exists
				if ($result == TRUE) {
					$result = $this->Usuario->get_user_by_param("email", $data["username"]);
					if ($result != false) {
						// Add user data in session
						$this->session->set_userdata('logged_in', $result);
						$this->session->set_userdata('register', true);
						if($this->session->has_userdata("draw_number")){
							header($this->HEADER_LOCATION. base_url() . "Purchases");
						}
						else{
							header($this->HEADER_LOCATION. base_url() . "panel");
						}
						exit();
					}
				}
			} */

			$params["data_form"] = $this->input->post();
		}

		$params["title"] = "Registro | Lotería del Quindío";
		$params["hobbies"] = $this->Hobbie->get_hobbies();
		$params["identification_types"] = $this->Identification_Type->get_identification_types();
		$params["states"] = $this->Location->get_states();
		$this->load->view('Usuarios/Registro', $params);
	}

	public function user_signin_process($user_data, $user_hobbies){

		if(!is_array($user_hobbies)){
			$user_hobbies = [];
		}

		// Check if received params are arrays
		if(is_array($user_data) && is_array($user_hobbies)){
			// Serach an account with the signin email
			$user = $this->Usuario->get_user_by_param("email", $user_data["email"]);

			// In case it doesn't exists an account with the same email
			if($user == false){
				$user = $this->Usuario->get_user_by_param("identification_number", $user_data["identification_number"]);

				// In case it doesn't exists an account with the same idetification number
				if($user == false){
					$user_data["slug"] = create_unique_slug('users');
					$user_data["password"] = md5($user_data["password"]);
					$result_user = $this->Usuario->signin_insert($user_data);
					// If the user was registered successfully
					if($result_user != false){
						$result_hobbies = $this->Hobbie->set_user_hobbies($result_user["id"], $user_hobbies);

						$email_body = $this->load->view('emails/confirm_email', $result_user, true);
						$this->mailer->send($email_body, 'Verifica tu correo electronico', $result_user['email']);

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

	public function add_user($slug_user = null){
		$params["title"] = "Usuarios";
		$params["subtitle"] = "Usuarios";
		$params["identification_types"] = $this->Identification_Type->get_identification_types();
		$params["states"] = $this->Location->get_states();
		$params["user"] = $this->Usuario->get_user_by_param("slug", $slug_user);
		$params["roles"] = $this->Usuario->get_roles();

		if(is_array($params["user"])){
			$params["cities"] = $this->Location->get_cities($params["user"]["state_id"]);
		}

		if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('user[identification_type_id]', 'Tipo de documento', 'required');
			$this->form_validation->set_rules('user[identification_number]', 'Número de documento', 'required|integer');
			$this->form_validation->set_rules('user[first_name]', 'Nombre', 'required', array(
				'required'      => 'El campo Nombre es requerido.',
        	));
			$this->form_validation->set_rules('user[last_name]', 'Apellidos', 'required', array(
				'required'      => 'El campo Apellidos es requerido.',
        	));
			$this->form_validation->set_rules('user[city_id]', 'Ciudad', 'required');
			$this->form_validation->set_rules('user[email]', 'Correo electrónico', 'required|valid_email', array(
                'valid_email'      => 'El campo Correo electrónico no es válido.',
        	));

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde", "success" => false);
			}else{
				if($this->input->post("user")["id"]){
					// Get the user by password
					if ($this->Usuario->update($this->input->post("user"))){
						$params["message"] = array("type" => "success", "message" => "Usuario modificado exitosamente", "success" => true, "updated" => TRUE);
					}
					else{
						$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error intentando modificar el usuario", "success" => false);
					}
				}
				else{
					if($this->input->post("user")["password"] == $this->input->post("r_new_password")){
						$params["message"] = $this->user_signin_process($this->input->post("user"), false);
					}
					else{
						$params["message"] = array("type" => "danger", "message" => "Las contraseñas no coinciden", "success" => false);
					}
				}
			}

			if(!$params["message"]["success"] || isset($params["message"]["updated"])){
				$params["user"] = $this->input->post("user");
			}
		}

        $this->load_layout("Usuarios/Add", $params);
	}

	// Users listing
	public function list(){
		$params["title"] = "Usuarios";
		$params["subtitle"] = "Usuarios";
		$params["roles"] = $this->Usuario->get_roles();
		$params["users"] = $this->get_users_by_role(1, null);
        $this->load_layout("Usuarios/List", $params);
	}

	// Send a verification mail
	public function send_verification_email($slug = ''){
		if($slug != ''){
			$user = $this->Usuario->get_user_by_param("slug", $slug);
			if($user != false) {
				$email_body = $this->load->view('emails/confirm_email', $user, true);
				$this->mailer->send($email_body, 'Verifica tu correo electronico', $user['email']);

				$data['message']['success'] = true;
				$this->load->view('Usuarios/Registro', $data);

			}else{
				$this->load->view('Templates/Not_authorized');
			}
		}
	}	

	// Logout from admin page
	public function logout() {
		$this->session->unset_userdata('logged_in');
		$data['message_display'] = 'Successfully Logout';
		header($this->HEADER_LOCATION. base_url() . "usuarios/login");
	}

	// Get the users list by role id
	public function get_users_by_role($role = 1, $response_type = "json"){
		$users = $this->Usuario->get_user_by_param("roles_id", $role, null);
		if($response_type == "json"){
			echo json_encode($users);
		}
		else{
			return $users;
		}
	}

	// Change the user status to set it as deleted
	public function delete_user(){
        if(is_admin()){
            $id = $this->input->post("id");

            if($id){
                $user = $this->Usuario->get_user_by_param("u.id", $id);
                if($user != FALSE){

                    $result = $this->Usuario->update(array("id" => $id, "user_status" => "2"));

                    if($result){
                        echo json_encode(array("error" => FALSE, "message" => "Usuario eliminado correctamente."));
                    }
                    else{
                        echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                    }
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "El usuario que intenta eliminar no se encuentra registrado."));
                }
            }
            else{
                echo json_encode(array("error" => TRUE, "message" => "El campo [id] es requerido."));
            }
        }
        else{
            echo json_encode(array("error" => TRUE, "message" => "Usted no tiene permisos para realizar esta acción."));
        }
	}
	
	// Change the user password
	public function change_password(){
            $data = $this->input->post();

            if(isset($data["current_password"]) && isset($data["new_password"]) && isset($data["r_new_password"])){
                $user = $this->Usuario->get_user_by_param("u.id", logged_user()["id"]);
                if($user != FALSE){
					if(md5($data["current_password"]) == $user["password"]){
						if($data["new_password"] == $data["r_new_password"] && strlen($data["new_password"]) > 5){
							$new_user["password"] = md5($data["new_password"]);
							$new_user["id"] = $user["id"];

							if ($this->Usuario->update($new_user)){
								echo json_encode(array("error" => FALSE, "message" => "Contraseña modificada exitosamente."));
							}
							else{
								echo json_encode(array("error" => TRUE, "message" => "Ha ocurrio un error, por favor intente de nuevo más tarde."));
							}
						}
						else{
							echo json_encode(array("error" => TRUE, "message" => "Las contraseñas nuevas no coinciden o no cumplen con la longitud minima requerida (6)."));
						}
					}
					else{
						echo json_encode(array("error" => TRUE, "message" => "La contraseña actual es incorrecta, por favor intente nuevamente."));
					}
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "El usuario que intenta modificar no se encuentra registrado."));
                }
            }
            else{
                echo json_encode(array("error" => TRUE, "message" => "Todos los campos son requeridos."));
            }
        
    }
}
