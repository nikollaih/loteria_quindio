<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Draws extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Draw', 'Product', 'Result']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation', 'GenerateReturn']);
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
        $params["products"] = $this->Product->get_products();
        $this->load_layout("Panel/Draws/Draws", $params);
    }

    // Do the draw register or update process
    private function draw_register_proccess($data){
        if(is_array($data)){
            if (!$this->Draw->get_draws($data["id"], $data["draw_number"]) && $data["id"] == "null"){
                $data["date"] = $data["date"] . " 21:30:00";
                $data["draw_slug"] = create_unique_slug("draws", 8, "draw_slug");
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
                    $data["date"] = $data["date"] . " 21:30:00";
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



    public function generate_return($draw){
        $draw = $this->Draw->get_draws(null, null, $draw);
        $this->generatereturn->perform($draw);
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

    public function results($slug){
        $params["title"] = "Resultados";
        $params["subtitle"] = "Resultados";
        $params["draw"] = $this->Draw->get_draws(null, null, $slug);
        $params["results"] = $this->Result->get_results($params["draw"]["id"]);
        $this->load_layout("Panel/Draws/Results", $params);
    }

    public function winners($slug){
        $params["title"] = "Ganadores";
        $params["subtitle"] = "Ganadores";
        $params["draw"] = $this->Draw->get_draws(null, null, $slug);
        $params["winners"] = $this->Draw->get_draws_winners($params["draw"]["id"]);
        $this->load_layout("Panel/Draws/Winners", $params);
    }
}