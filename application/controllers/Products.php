<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'product']);
		$this->load->library(['session', 'form_validation']);
		$this->load->model(['Product']);
	}

	public function index(){
	    if(is_admin() || is_assistant()){
            if($this->input->post()){
                // Set the inputs rules
                $this->form_validation->set_rules('product_name', 'Nombre', 'required');
                $this->form_validation->set_rules('fractions_count', 'Cantidad de Fracciones', 'required');
                $this->form_validation->set_rules('fraction_value', 'Valor de cada fracción (COP)', 'required');
                
                if ($this->form_validation->run() == TRUE) {
                    $params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde.");
                    // Get the post data
                    $data = $this->input->post();

                    if($data["id"] != "null"){
                        $product = $this->Product->get_products($data["id"]);
                        if($product != false){
                            $update = $this->Product->update_product($data);
                            if($update){
                                $params["message"] = array("type" => "success", "message" => "Producto modificado exitosamente.");
                            }
                        }
                    }
                    else
                    {
                        // Save the new product row in the DB
                        $data["slug"] = create_unique_slug('products');
                        $insert = $this->Product->set_product($data);
                        if($insert){
                            $params["message"] = array("type" => "success", "message" => "Producto registrado exitosamente.");
                        }
                    }
                }
        }
        $params["title"] = "Productos";
        $params["subtitle"] = "Productos";
        $params["products"] = $this->Product->get_products();
        $this->load_layout("Panel/Products/List", $params);
    }
    else {
        header("Location: " . base_url() . 'panel');
    }
  }
  
  public function delete_product(){
    if(is_admin()){
        $id = $this->input->post("id");

        if($id){
            $product = $this->Product->get_products($id);
            if($product != FALSE){
                $result = $this->Product->delete_product($id);

                if($result){
                    echo json_encode(array("error" => FALSE, "message" => "Producto eliminado correctamente."));
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                }
            }
            else{
                echo json_encode(array("error" => TRUE, "message" => "El producto que intenta eliminar no se encuentra registrado."));
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
