<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends CI_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'file', 'results']);
        $this->load->model(["Draw", "Result"]);
    }
    
    // Get the cities list rows by an state id
	public function import_result(){
        if(is_admin()){
            if(isset($_FILES["result"]) && ($this->input->post("draw_number"))){
                if($_FILES["result"]["type"] == "text/plain"){
                    $string = read_file($_FILES["result"]["tmp_name"]);
                    $result_rows = explode("\n", $string);
                    array_pop($result_rows);

                    if(count($result_rows) == 38){
                        if(count(explode("|", $result_rows[0])) == 10){
                            $draw = $this->Draw->get_draws(null, explode("|", $result_rows[0])[6]);
                            if(is_array($draw)){
                                if($draw["draw_number"] == $this->input->post("draw_number")){
                                    $tmp_array = [];

                                    for ($i=0; $i < 38; $i++) { 
                                        $result = explode("|", $result_rows[$i]);

                                        if(count($result) == 10){
                                            if(strlen($result[8]) == 4 && strlen($result[9]) == 3){
                                                $data["id_draw"] = $draw["id"];
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
                                                $data["created_at"] = date("Y-m-d H:i:s");

                                                array_push($tmp_array, $data);
                                            }
                                            else{
                                                json_response(null, false, "El número de resultado o serie no cumple con la longitud requerida en la linea: ".($i + 1));
                                            }
                                        }
                                        else{
                                            json_response(null, false, "Una de las lineas del archivo tiene más o menos elementos de los requeridos por favor verifique la linea: ".($i + 1));
                                        }
                                    }

                                    if(count($tmp_array) == 38){
                                        json_response($tmp_array, true, "Result listing");
                                    }
                                    else{
                                        json_response(null, false, "Los valores recibidos no son validos, se esperaban 38 resultados y obtuvimos ".count($tmp_array));
                                    }
                                }
                                else{
                                    json_response(null, false, "Archivo de texto no válido para este sorteo, el número de sorteo no coincide.");
                                }
                            }
                            else{
                                json_response(null, false, "Sorteo #".explode("|", $result_rows[0])[6]." no encontrado.");
                            }
                        }
                        else{
                            json_response(null, false, "Una de las lineas del archivo tiene más o menos elementos de los requeridos por favor verifique la linea: 1");
                        }
                    }
                    else{
                        json_response(null, false, "Los valores recibidos no son validos, se esperaban 38 resultados y obtuvimos ".count($result_rows));
                    }
                }
                else{
                    json_response(null, false, "Archivo de texto no válido.");
                }
            }
            else{
                json_response(null, false, "No se ha recibido el archivo de texto.");
            }
        }
        else{
            json_response(null, false, "Usted no puede realizar esta acción.");
        }
    }
}
