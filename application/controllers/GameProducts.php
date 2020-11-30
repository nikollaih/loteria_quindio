<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameProducts extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['GameProduct']);
		$this->load->helper(["url", "form", "files"]);
		$this->load->library(['Form_validation']);
	}

	public function index()
	{
        // Check if it's a logged user
        //is_logged(true);

        if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('g_product_name', 'Nombre', 'required');
			$this->form_validation->set_rules('g_product_quantity', 'Cantidad', 'required|numeric');
			$this->form_validation->set_rules('g_product_status', 'Estado', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, los datos ingresados presentan errores", "success" => false);
			}else{
                $params["message"] = $this->game_product_register_proccess($this->input->post());

                /* Upload file */
                //Comprobamos si el fichero es una imagen
                if ($params["message"]["success"] && isset($_FILES['g_product_path']) && ($_FILES['g_product_path']['type']=='image/png' || $_FILES['g_product_path']['type']=='image/jpeg')){
                    //Subimos el fichero al servidor
                    $img_type = str_replace('image/', '', $_FILES['g_product_path']['type']);
                    $dir =  './uploads/game_products/'.$params["message"]["product"]["id_game_product"].'/';
                    if(!file_exists($dir)){ //Si no existe el directorio lo crea
                        mkdir($dir, 0755);
                    }
                    if(move_uploaded_file($_FILES['g_product_path']["tmp_name"], $dir.'product.'.$img_type)){
                        createThumb('product.'.$img_type, $img_type, $dir);
                        $params["message"]["product"]["g_product_path"] = substr($dir, 2).'sproduct.'.$img_type;
                        $this->GameProduct->update($params["message"]["product"]);
                    }
                }
            }
            
            if(!$params["message"]["success"]){
                $params["data_form"] = $this->input->post();
            }
		}

		$params["title"] = "Productos del juego";
        $params["subtitle"] = "Productos del juego";
        $params["game_products"] = $this->GameProduct->get();
        $this->load_layout("Panel/GameProducts/GameProducts", $params);
    }


    private function game_product_register_proccess($data){
        if(is_array($data)){
            if ($data["id_game_product"] == "null"){
                $result_gp = $this->GameProduct->set($data);
                // If the user was registered successfully
                if($result_gp){
                    return array("type" => "success", "success" => true, "message" => "Producto registrado exitosamente.", "product" => $result_gp);
                }
                else{
                    return array("type" => "danger", "success" => false, "message" => "No se ha podido registrar el producto, por favor intente de nuevo más tarde.");
                }
            }
            else{
                $result_gp = $this->GameProduct->update($data);

                // If the user was registered successfully
                if($result_gp){
                    return array("type" => "success", "success" => true, "message" => "Producto modificado exitosamente.", "product" => $result_gp);
                }
                else{
                    return array("type" => "danger", "success" => false, "message" => "No se ha podido modificar el producto, por favor intente de nuevo más tarde.");
                }
            }
        }
        else{
            return array("type" => "danger", "success" => false, "message" => "Los datos recibidos son incorrectos.");
        }
    }

    public function delete_game_product(){
        if(is_admin()){
            $id = $this->input->post("id");

            if($id){
                $game_product = $this->GameProduct->get($id);
                if($game_product){
                    $result = $this->GameProduct->delete($id);

                    if($result){
                        unlink("./".$game_product["g_product_path"]); 
                        rmdir("./uploads/game_products/".$game_product["id_game_product"]);
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

    function get_products(){
        $products = $this->GameProduct->get(null, 1);

        if(is_array($products)){
            for ($i=0; $i < count($products); $i++) { 
                $products[$i]["g_product_path"] = (@getimagesize(base_url().$products[$i]["g_product_path"])) ? base_url().$products[$i]["g_product_path"] : "https://dummyimage.com/600x400/bdbdbd/fff&text=Imagen no disponible";
            }

            echo json_encode($products);
        }
        else{
            echo json_encode([]);
        }
    }
    
}
