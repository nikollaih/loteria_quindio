<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hobbies extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model("Hobbie");
	}

	public function index()
	{
        if(is_admin() || is_assistant()){
            if($this->input->post()){
                // Set the inputs rules
                $this->form_validation->set_rules('name', 'Name', 'required');
                
                if ($this->form_validation->run() == TRUE) {
                    $params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde.");
                    // Get the post data
                    $data = $this->input->post();

                    if($data["id"] != "null"){
                        $hobbie = $this->Hobbie->get_hobbies($data["id"]);
                        if($hobbie != false){
                            $update = $this->Hobbie->update_hobbie($data);
                            if($update){
                                $params["message"] = array("type" => "success", "message" => "Hobbie modificado exitosamente.");
                            }
                        }
                    }
                    else
                    {
                        // Save the new hobbie row in the DB
                        $insert = $this->Hobbie->set_hobbie($data);
                        if($insert){
                            $params["message"] = array("type" => "success", "message" => "Hobbie registrado exitosamente.");
                        }
                    }
                }
            }
            $params["title"] = "Hobbies";
            $params["subtitle"] = "Hobbies";
            $params["hobbies"] = $this->Hobbie->get_hobbies();
            $this->load_layout("Panel/Hobbies/Hobbies", $params);
        }
        else {
            header("Location: " . base_url() . 'panel');
        }
    }
    
    public function delete_hobbie(){
        if(is_admin() || is_assistant()){
            $id = $this->input->post("id");

            if($id){
                $hobbie = $this->Hobbie->get_hobbies($id);
                if($hobbie != FALSE){
                    $result = $this->Hobbie->delete_hobbie($id);

                    if($result){
                        echo json_encode(array("error" => FALSE, "message" => "Hobbie eliminado correctamente."));
                    }
                    else{
                        echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                    }
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "El hobbie que intenta eliminar no se encuentra registrado."));
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
