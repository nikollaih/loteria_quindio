<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blends extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Blend']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation']);
	}

	public function index()
	{
        // Check if it's a logged user
        //is_logged(true);

        if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('start_number', 'Desde', 'required|numeric|exact_length[4]');
			$this->form_validation->set_rules('end_number', 'Hasta', 'required|numeric|exact_length[4]');
			$this->form_validation->set_rules('serie', 'Serie', 'required|numeric|exact_length[3]');
			$this->form_validation->set_rules('blend_status', 'Estado', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, los datos ingresados presentan errores", "success" => false);
			}else{
                $params["message"] = $this->blend_register_proccess($this->input->post());
            }
            
            if(!$params["message"]["success"]){
                $params["data_form"] = $this->input->post();
            }
		}

		$params["title"] = "Mezclas";
        $params["subtitle"] = "Mezclas";
        $params["blends"] = $this->Blend->get_blends();
        $this->load_layout("Panel/Blends/Blends", $params);
    }

    private function blend_register_proccess($data){
        if(is_array($data)){
            if (!$this->Blend->validate_blend($data) && $data["id"] == "null"){
                $result_blend = $this->Blend->set_blend($data);
                // If the user was registered successfully
                if($result_blend != false){
                    return array("type" => "success", "success" => true, "message" => "Mezcla registrada exitosamente.");
                }
                else{
                    return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar la mezcla, por favor intente de nuevo más tarde.");
                }
            }
            else{
                if($data["id"] != null){
                    $result_blend = $this->Blend->update_blend($data);
                    // If the user was registered successfully
                    if($result_blend != false){
                        return array("type" => "success", "success" => true, "message" => "Mezcla modificada exitosamente.");
                    }
                    else{
                        return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar la mezcla, por favor intente de nuevo más tarde.");
                    }
                }
                else{
                    return array("type" => "danger", "message" => "Ya existe una mezcla con los datos que intenta ingresar.", "success" => false);
                }
            }
        }
        else{
            return array("type" => "danger", "success" => false, "message" => "Los datos recibidos son incorrectos.");
        }
    }

    public function delete_blend(){
        if(is_admin()){
            $id = $this->input->post("id");

            if($id){
                $blend = $this->Blend->get_blends(null, $id);
                if($blend != FALSE){

                    $result = $this->Blend->update_blend(array("id" => $id, "blend_status" => "2"));

                    if($result){
                        echo json_encode(array("error" => FALSE, "message" => "Mezcla eliminada correctamente."));
                    }
                    else{
                        echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                    }
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "La mezcla que intenta eliminar no se encuentra registrada."));
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
