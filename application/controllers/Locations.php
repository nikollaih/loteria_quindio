<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends CI_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url']);
        $this->load->model("Location");
    }
    
    // Get the cities list rows by an state id
	public function get_cities_by_state(){
        $id = $this->input->post("id_state");
        if($id){
            $state = $this->Location->get_states($id);
            if($state != FALSE){
                $result = $this->Location->get_cities($id);

                if($result){
                    echo json_encode(array("error" => FALSE, "message" => "Lista de ciudades.", "cities" => $result));
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                }
            }
            else{
                echo json_encode(array("error" => TRUE, "message" => "El departamento que intenta consultar no se encuentra registrado."));
            }
        }
        else{
            echo json_encode(array("error" => TRUE, "message" => "El campo [id] es requerido."));
        }
    }
}
