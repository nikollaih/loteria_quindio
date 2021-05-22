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

    public function import(){
        $params["title"] = "Importar Mezclas";
        $params["subtitle"] = "Importar Mezclas";
        $params["blends"] = $this->Blend->get_blends();
        $this->load_layout("Panel/Blends/Import", $params);
    }

    public function show_numbers($serie) {
        $params["title"] = "Números de mezcla";
        $params["subtitle"] = "Números de mezcla";
        $params["blend"] = $this->Blend->get_blends($serie);
        $params["numbers"] = unserialize($params["blend"]["blend_numbers"]);
        $this->load_layout("Panel/Blends/show_numbers", $params);
    }

    private function blend_register_proccess($data){
        if(is_array($data)){
            if (!$this->Blend->validate_blend($data) && $data["id"] == "null"){
                $blend_blend = $this->Blend->set_blend($data);
                // If the user was registered successfully
                if($blend_blend != false){
                    return array("type" => "success", "success" => true, "message" => "Mezcla registrada exitosamente.");
                }
                else{
                    return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar la mezcla, por favor intente de nuevo más tarde.");
                }
            }
            else{
                if($data["id"] != null){
                    $blend_blend = $this->Blend->update_blend($data);
                    // If the user was registered successfully
                    if($blend_blend != false){
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

                    $blend = $this->Blend->update_blend(array("id" => $id, "blend_status" => "2"));

                    if($blend){
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

    // Save the draw blends
    public function save_blends(){
        // Check if the logged user is admin
        if(is_admin()){
            // Check is there is any post data
            if($this->input->post()){
                $blends = json_decode($this->input->post("data"));
                $tmp_array = [];

                foreach ($blends as $key => $blend) {
                    $data["start_number"] = 0;
                    $data["end_number"] = 0;
                    $data["blend_status"] = 1;
                    $data["serie"] = $key;
                    $data["blend_numbers"] = serialize($blend);
                    $data["numbers_quantity"] = count($blend);

                    array_push($tmp_array, $data);
                }

                $this->Blend->delete_blends();
                $blend_insert = $this->Blend->set_blends($tmp_array);

                if($blend_insert){
                    json_response(null, true, "Mezclas guardadas exitosamente");
                }
                else{
                    json_response(null, false, "Ha ocurrido un error al intentar guardar las mezclas.");
                }
            }
            else{
                json_response(null, false, "No se ha recibido ningún dato.");
            }
        }
        else{
            json_response(null, false, "No tiene permisos para realizar esta acción.");
        }
    }

    function available_number($serie_id){
        json_response(get_available_numbers($serie_id), true, "Lista de números disponibles");
    }

    function available_series($number){
        json_response(get_available_blends($number), true, "Lista de series disponibles");
    }
    
}
