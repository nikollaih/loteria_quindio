<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario', 'Hobbie', 'Identification_Type', 'Location']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation']);
	}

    // Carga la vista de login con todos los parametros seleccionados
	public function login(){
		if(is_logged()){
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
				if($this->session->has_userdata("draw_number")){
					header("Location: " . base_url() . "Purchases");
				}
				else{
					header("Location: " . base_url() . "panel");
				}
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
			$this->form_validation->set_rules('user[identification_type_id]', 'Tipo de documento', 'required');
			$this->form_validation->set_rules('user[identification_number]', 'Número de documento', 'required');
			$this->form_validation->set_rules('user[first_name]', 'Nombre', 'required');
			$this->form_validation->set_rules('user[last_name]', 'Apellidos', 'required');
			$this->form_validation->set_rules('user[city_id]', 'Ciudad', 'required');
			$this->form_validation->set_rules('user[email]', 'Correo electrónico', 'required');
			$this->form_validation->set_rules('user[password]', 'Contraseña', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde", "success" => false);
			}else{
				$params["message"] = $this->user_signin_process($this->input->post("user"), $this->input->post("hobbies"));
			}

			if($params["message"]["success"] == true){
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
							header("Location: " . base_url() . "Purchases");
						}
						else{
							header("Location: " . base_url() . "panel");
						}
						exit();
					}
				}
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

	public function list(){
		$params["title"] = "Usuarios";
		$params["subtitle"] = "Usuarios";
		$params["users"] = $this->get_users_by_role(1, null);
        $this->load_layout("Usuarios/List", $params);
	}

	// Logout from admin page
	public function logout() {
		$this->session->unset_userdata('logged_in');
		$data['message_display'] = 'Successfully Logout';
		header("Location: " . base_url() . "usuarios/login");
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
                $user = $this->Usuario->get_user_by_param("id", $id);
                if($user != FALSE){

                    $result = $this->Usuario->update_user(array("id" => $id, "user_status" => "2"));

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
}
