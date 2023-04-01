<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Application_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'file', 'results']);
        $this->load->model(["Setting"]);
    }

    public function index(){
        if(is_admin()){

            if($this->input->post()){
                 //Comprobamos si el fichero es una imagen
                 if (isset($_FILES['data']['name']['main_background']) && ($_FILES['data']['type']['main_background']=='image/png' || $_FILES['data']['type']['main_background']=='image/jpeg')){

                    //Subimos el fichero al servidor
                    $img_type = str_replace('image/', '', $_FILES['data']['type']['main_background']);
                    $dir =  './uploads/background/';
                    $name = 'background.'.$img_type;

                    if(!file_exists($dir)){ //Si no existe el directorio lo crea
                        mkdir($dir, 0755);
                    }
                    if(move_uploaded_file($_FILES['data']["tmp_name"]['main_background'], $dir.$name)){
                        $update["key"] = "main_background";
                        $update["value"] = 'uploads/background/'.$name;
                        $this->Setting->update($update);
                    }
                }

                $settings = $this->input->post("data");
                foreach ($settings as $key => $value) {
                    $update["key"] = $key;
                    $update["value"] = $value;

                    $this->Setting->update($update);
                }

                $params["message"]["type"] = "success";
                $params["message"]["message"] = "Datos modificados exitosamente";
            }

            $params["settings"] = $this->Setting->get();
            
        }

        $params["title"] = "Configuración";
        $params["subtitle"] = "Configuración";
        $this->load_layout("Panel/Settings/Settings", $params);
    }
}