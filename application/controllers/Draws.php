<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Draws extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['Draw', 'Product', 'Result', 'Purchase']);
		$this->load->helper(["url", "form"]);
		$this->load->library(['Form_validation', 'GenerateReturn', 'GenerateForeignSales']);
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
                $data["date"] = date("Y-m-d H:i:s",strtotime ( '-1 minute' , strtotime ( $data["date"]. " ".get_setting("close_draw_time")) ));
                $data["draw_slug"] = create_unique_slug("draws", 8, "draw_slug");

                //Convert the date string into a unix timestamp.
                $unixTimestamp = strtotime( $data["date"]);

                //Get the day of the week using PHP's date function.
                $dayOfWeek = date("N", $unixTimestamp);
                if($dayOfWeek != get_setting("draw_day")){
                    return array("type" => "danger", "success" => false, "message" => "La fecha seleccionada no es válida.");
                }

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
                    $purchases = $this->Purchase->get_purchase_by_param("p.id_draw", $data["id"]);

                    if(!is_array($purchases)){
                        $data["date"] = $data["date"]. " ".get_setting("close_draw_time");
                        //Convert the date string into a unix timestamp.
                        $unixTimestamp = strtotime( $data["date"]);

                        //Get the day of the week using PHP's date function.
                        $dayOfWeek = date("N", $unixTimestamp);
                        if($dayOfWeek != get_setting("draw_day")){
                            return array("type" => "danger", "success" => false, "message" => "La fecha seleccionada no es válida.");
                        }

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
                        return array("type" => "danger", "success" => false, "message" => "El sorteo ya tiene compras activas y no puede ser modificado.");
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

    public function generate_foreign_sales($draw){
        $draw = $this->Draw->get_draws(null, null, $draw);
        $this->generateforeignsales->perform($draw);
    }

    public function save_numbers_to_return(){
        get_numbers_to_return();
       
    }

    // Delete a draw
    public function delete_draw(){
        if(is_admin()){
            $id = $this->input->post("id");
            $purchases = $this->Purchase->get_purchase_by_param("p.id_draw", $id);

            if($id){
                $draw = $this->Draw->get_draws($id);
                if($draw != FALSE){
                    if(!is_array($purchases)){
                        $result = $this->Draw->delete_draw(array($id));

                        if($result){
                            echo json_encode(array("error" => FALSE, "message" => "Sorteo eliminado correctamente."));
                        }
                        else{
                            echo json_encode(array("error" => TRUE, "message" => "Ha ocurrido un error, por favor intente de nuevo más tarde."));
                        }
                    }
                    else{
                        echo json_encode(array("error" => TRUE, "message" => "El sorteo ya tiene compras activas y no puede ser eliminado."));
                    }
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "El sorteo que intenta eliminar no se encuentra registrado."));
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

    public function image_results(){
        if(is_admin()){
            if($this->input->post()){
                $id = $this->input->post("id");
                $draw = $this->Draw->get_draws($id);

                //Comprobamos si el fichero es una imagen
                if (isset($_FILES['result_image']['name']) && ($_FILES['result_image']['type']=='image/png' || $_FILES['result_image']['type']=='image/jpeg')){

                   //Subimos el fichero al servidor
                   $img_type = str_replace('image/', '', $_FILES['result_image']['type']);
                   $dir =  './uploads/results/';
                   $name = $draw["draw_number"] . '_result.'.$img_type;

                   if(!file_exists($dir)){ //Si no existe el directorio lo crea
                       mkdir($dir, 0755);
                   }
                   if(move_uploaded_file($_FILES['result_image']["tmp_name"], $dir.$name)){
                        $this->Draw->update_draw(array('id' => $draw["id"], 'image_result' => $name));
                        echo json_encode(array("error" => FALSE, "message" => "Imagen cargada exitosamente."));
                   }
               }
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