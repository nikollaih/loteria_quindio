<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends Application_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'file', 'results']);
        $this->load->model(["Draw", "Result"]);
    }
    
    // Get the cities list rows by an state id
	public function import_result($draw_slug = null){
        if(is_admin()){
            if($this->input->post()){
                $string = read_file($_FILES["result"]["tmp_name"]);
                $result_rows = explode("\n", $string);
                array_pop($result_rows);
                $draw = $this->Draw->get_draws(null, explode("|", $result_rows[0])[6]);

                $tmp_array = [];

                if(count($result_rows) == 38 && is_array($draw)){
                    for ($i=0; $i < 38; $i++) { 
                        $result = explode("|", $result_rows[$i]);

                        $data["id_draw"] = $draw["id"];
                        $data["id_reward"] = get_id_reward_by_line($i);
                        $data["award_name"] = get_result_name_by_line($i);
                        $data["nit"] = $result[0];
                        $data["dv"] = $result[1];
                        $data["lot_code"] = $result[2];
                        $data["fixed"] = $result[3];
                        $data["year"] = $result[4];
                        $data["file_type"] = $result[5];
                        $data["award_code"] = $result[7];
                        $data["result_number"] = $result[8];
                        $data["result_serie"] = $result[9];

                        array_push($tmp_array, $data);
                    }
                }

                if(count($tmp_array) == 38){
                    $result_insert = $this->Result->set_results($tmp_array);
                    if($result_insert){
                        $new_draw["id"] = $draw["id"];
                        $new_draw["result"] = $tmp_array[0]["result_number"];
                        $new_draw["serie"] = $tmp_array[0]["result_serie"];
                        $this->Draw->update_draw($new_draw);
                    }
                }
            }

            $params["title"] = "Importar Resultados";
            $params["subtitle"] = "Importar Resultados";
            $params["draw"] = $this->Draw->get_draws(null, null, $draw_slug);
            $this->load_layout("Panel/Results/Import", $params);
        }
    }

    // Save the draw results
    public function save_results(){
        // Check if the logged user is admin
        if(is_admin()){
            // Check is there is any post data
            if($this->input->post()){
                $data = $this->input->post("data");
                if(count($data) == 34){
                    $result_insert = $this->Result->set_results($data);

                    if($result_insert){
                        $draw = $this->Draw->get_draws($data[0]["id_draw"]);
                        $new_draw["id"] = $draw["id"];
                        $new_draw["result"] = $data[0]["result_number"];
                        $new_draw["serie"] = $data[0]["result_serie"];
                        $this->Draw->update_draw($new_draw);
                        json_response($draw, true, "Resultados cargados exitosamente");
                    }
                    else{
                        json_response(null, false, "Ha ocurrido un error al intentar guardar los resultados.");
                    }
                }
                else{
                    json_response($data, false, "Los valores recibidos no son validos, se esperaban 34 resultados y obtuvimos  ".count($data));
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
}
