<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Draws extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Draw']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation']);
	}

    // Load the draws listing
	public function index()
	{
        // Check if it's a logged user
        //is_logged(true);

        if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('draw_number', 'Número de sorteo', 'required');
			$this->form_validation->set_rules('date', 'Fecha', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, los datos ingresados presentan errores", "success" => false);
			}else{
                $params["message"] = $this->draw_register_proccess($this->input->post());
            }
            
            if(!$params["message"]["success"]){
                $params["data_form"] = $this->input->post();
            }
		}

		$params["title"] = "Sorteos";
        $params["subtitle"] = "Sorteos";
        $params["draws"] = $this->Draw->get_draws();
        $this->load_layout("Panel/Draws/Draws", $params);
    }

    // Do the draw register or update process
    private function draw_register_proccess($data){
        if(is_array($data)){
            if (!$this->Draw->get_draws($data["id"], $data["draw_number"]) && $data["id"] == "null"){
                $result_draw = $this->Draw->set_draw($data);
                // If the user was registered successfully
                if($result_draw != false){
                    return array("type" => "success", "success" => true, "message" => "Sorteo registrado exitosamente.");
                }
                else{
                    return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar el sorteo, por favor intente de nuevo más tarde.");
                }
            }
            else{
                if($data["id"] != null && $data["id"] != "null"){
                    $result_draw = $this->Draw->update_draw($data);
                    // If the user was registered successfully
                    if($result_draw != false){
                        return array("type" => "success", "success" => true, "message" => "Sorteo modificado exitosamente.");
                    }
                    else{
                        return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar el sorteo, por favor intente de nuevo más tarde.");
                    }
                }
                else{
                    return array("type" => "danger", "success" => false, "message" => "El número de sorteo ".$data["draw_number"]." ya existe.");
                }
            }
        }
        else{
            return array("type" => "danger", "success" => false, "message" => "Los datos recibidos son incorrectos.");
        }
    }

    // Delete a draw
    public function delete_draw(){
        if(is_admin()){
            $id = $this->input->post("id");

            if($id){
                $draw = $this->Draw->get_draws($id);
                if($draw != FALSE){
                    $result = $this->Draw->delete_draw(array($id));

                    if($result){
                        echo json_encode(array("error" => FALSE, "message" => "Sorteo eliminado correctamente."));
                    }
                    else{
                        echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                    }
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "El sorteo que intenta eliminar no se encuentra registrada."));
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