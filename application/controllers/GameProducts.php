<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameProducts extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['GameProduct', 'ProductWinner', 'Usuario']);
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
                        createThumb('product.'.$img_type, $img_type, $dir, true);
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

  function get_products_for_game(){
    $products = $this->GameProduct->get(null, 1, 8);
    if(is_array($products)){
      $result = array(
        'products' => $products,
        'current_user' => logged_user()["id"]  
      );
      echo json_encode($result);
    }
    else{
      echo json_encode([]);
    }
  }

  function get_result_for_game(){
    $products = $this->input->post("products");
    $user_id = $this->input->post("user");
    $result = [];
    for ($i = 0; $i < 3; $i++) {
      $random_result = array_rand($products, 1);
      array_push($result, $products[$random_result]['id_game_product']);
    }
    
    $won = false;
    $salt = '55ca4060468c976905aa4c4c48a83842-2e53c5d186c6366a3cd908986db85df9';
    if($result[0] == $result[1] && $result[0] == $result[2]){
      $salt = $this->GameProduct->winner_salt();
      $won = true;
    }

    
    $lotto_points = $this->Usuario->get_loto_points($user_id);
    $this->Usuario->substract_lotto_point($user_id);
    $products = $this->GameProduct->get(null, 1, 8);

    $result =  array(
      "won"  =>  $won,
      "ids"  => $result,
      "salt"  =>  $salt,
      "lotto_points" => $lotto_points,
      "products" => $products
    );

    //sleep(4);

    echo json_encode($result);
  }

  function validate_result_for_game(){
    $salt = $this->input->post("salt");
    $product = $this->input->post("product");
    $user = $this->input->post("user");
    $winner_salt = $this->GameProduct->winner_salt();
    if($salt == $winner_salt){
      $slug = create_unique_slug('product_winners', 6);
      $data = array(
        'product_id' =>  $product,
        'user_id' => $user,
        'slug' => $slug
      );
      $this->ProductWinner->set_product_winners($data);
      echo json_encode(array('result' => true));
    }else{
      echo json_encode(array('result' => false));
    }
  }
}
