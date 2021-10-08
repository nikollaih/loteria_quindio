<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Files extends CI_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'file', 'results']);
        $this->load->model(["Draw", "Result", "Purchase","Withdraw", "Usuario"]);
    }
    
    // Get the cities list rows by an state id
	public function import_result(){
        if(is_admin() || is_assistant()){
            if(isset($_FILES["result"]) && ($this->input->post("draw_number"))){
                if($_FILES["result"]["type"] == "text/plain"){
                    $string = read_file($_FILES["result"]["tmp_name"]);
                    $result_rows = explode("\n", $string);
                   // array_pop($result_rows);

                    if(count($result_rows) == 38){
                        if(count(explode("|", $result_rows[0])) == 10){
                            $draw = $this->Draw->get_draws(null, explode("|", $result_rows[0])[6]);
                            if(is_array($draw)){
                                if($draw["draw_number"] == $this->input->post("draw_number")){
                                    $tmp_array = [];

                                    for ($i=0; $i < 38; $i++) { 
                                        $result = explode("|", $result_rows[$i]);

                                        if(count($result) == 10){
                                            if(strlen($result[8]) == 4 && (strlen($result[9]) == 3) || $i == 37){
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
                                        json_response($tmp_array, false, "Los valores recibidos no son validos, se esperaban 38 resultados y obtuvimos ".count($tmp_array));
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
                            json_response(null, false, "Una de las lineas del archivo tiene más o menos elementos de los requeridos, por favor verifique la linea: 1");
                        }
                    }
                    else{
                        json_response($result_rows, false, "Los valores recibidos no son validos, se esperaban 38 resultados y obtuvimos ".count($result_rows));
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

    // Import the blends listing
	public function import_blends(){
        if(is_admin() || is_assistant()){
            if(isset($_FILES["result"])){
                if($_FILES["result"]["type"] == "text/plain"){
                    $string = read_file($_FILES["result"]["tmp_name"]);
                    $result_rows = explode("\n", $string);
                    //array_pop($result_rows);
                    $tmp_array = [];

                    for ($i=0; $i < count($result_rows); $i++) { 
                        if(trim($result_rows[$i]) != ""){
                            $result = explode(",", $result_rows[$i]);

                            if(count($result) > 4 && count($result) < 7){
                                if(!isset($tmp_array[$result[2]])){
                                    $tmp_array[$result[2]] = [];
                                }
                                        array_push($tmp_array[$result[2]], $result[1]);
                            }
                            else{
                                json_response(null, false, "Una de las lineas del archivo tiene más o menos elementos de los requeridos, por favor verifique la linea: ".($i + 1));
                            }
                        }   
                    }

                    json_response($tmp_array, true, "Mezclas cargadas correctamente");
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

    // Generate the purchases excel report by dates
    public function generateDatesReport($start_date = null, $end_date = null){
        if($start_date == null){
            $start_date = date("Y-m-d");
        }
        if($end_date == null){
            $end_date = date("Y-m-d");
        }
        if(is_admin() || is_assistant()){

            $purchases = $this->Purchase->get_purchases_by_dates($start_date, $end_date);

            if(is_array($purchases)){
                $line = 1;
                $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

                // manually set title value
                $sheet->mergeCells("A".$line.":J".$line);
                $sheet->setCellValue('A'.$line, 'LOTERIA DEL QUINDIO'); 
                $sheet->getStyle("A".$line.":J".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":J".$line)->getFont()->setSize(14);
                $line++;
                $sheet->mergeCells("A".$line.":J".$line);
                $sheet->setCellValue('A'.$line, 'REPORTE DE VENTAS DESDE '.strtoupper(strftime('%B %d, %Y',strtotime($start_date))).' HASTA '.strtoupper(strftime('%B %d, %Y',strtotime($end_date)))); 
                $sheet->getStyle("A".$line.":J".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":J".$line)->getFont()->setSize(12);
                $line += 6;

                $sheet->getStyle('A'.$line.':J'.$line)->applyFromArray($this->getItemTitleStyle());

                // Set the cells dimensions
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(12);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(12);
                $sheet->getColumnDimension('G')->setWidth(12);
                $sheet->getColumnDimension('H')->setWidth(12);
                $sheet->getColumnDimension('I')->setWidth(12);
                $sheet->getColumnDimension('J')->setWidth(12);

                // Set the table titles
                $sheet->setCellValue('A'.$line, 'FECHA DE COMPRA'); 
                $sheet->setCellValue('B'.$line, 'DOCUMENTO CLIENTE'); 
                $sheet->setCellValue('C'.$line, 'NOMBRE CLIENTE'); 
                $sheet->setCellValue('D'.$line, 'NUMERO'); 
                $sheet->setCellValue('E'.$line, 'SERIE'); 
                $sheet->setCellValue('F'.$line, 'SORTEO'); 
                $sheet->setCellValue('G'.$line, 'ABONADOS'); 
                $sheet->setCellValue('H'.$line, 'SUBTOTAL'); 
                $sheet->setCellValue('I'.$line, 'DESCUENTO'); 
                $sheet->setCellValue('J'.$line, 'TOTAL'); 

                $line++;

                $price = 0;
                $discount = 0;
                foreach ($purchases as $purchase) {
                    $price += $purchase["price"];
                    $discount += $purchase["discount"];
                    // Set the purchases data
                    $sheet->setCellValue('A'.$line, ucfirst(strftime('%B %d, %Y',strtotime($purchase["purchase_date"])))); 
                    $sheet->setCellValue('B'.$line, $purchase["identification_number"]); 
                    $sheet->setCellValue('C'.$line, $purchase["first_name"]." ".$purchase["last_name"]); 
                    $sheet->setCellValue('D'.$line, $purchase["number"]); 
                    $sheet->setCellValue('E'.$line, $purchase["serie"]); 
                    $sheet->setCellValue('F'.$line, $purchase["draw_number"]); 
                    $sheet->setCellValue('G'.$line, ($purchase["subscriber_amount"] > 0) ? $purchase["subscriber_amount"] : "N/A"); 
                    $sheet->setCellValue('H'.$line, $purchase["price"]); 
                    $sheet->setCellValue('I'.$line, $purchase["discount"]); 
                    $sheet->setCellValue('J'.$line, $purchase["price"] - $purchase["discount"]); 
                    $sheet->getStyle('A'.$line.':J'.$line)->applyFromArray($this->getItemListStyle());
                    $sheet->getStyle('D'.$line.':J'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT ] ]);
                    $sheet->getStyle('B'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $line++;
                }

                // Set the prices summary
                $sheet->mergeCells("A4:B4");
                $sheet->setCellValue('A4', 'SUBTOTAL'); 
                $sheet->getStyle("A4:B4")->applyFromArray($this->getItemTitleStyle());
                $sheet->mergeCells("C4:D4");
                $sheet->setCellValue('C4', $price); 
                $sheet->getStyle("C4:D4")->applyFromArray($this->getItemListStyle());
                $sheet->getStyle("A4:D4")->getFont()->setSize(12);

                $sheet->mergeCells("A5:B5");
                $sheet->setCellValue('A5', 'DESCUENTO'); 
                $sheet->getStyle("A5:B5")->applyFromArray($this->getItemTitleStyle());
                $sheet->mergeCells("C5:D5");
                $sheet->setCellValue('C5', $discount); 
                $sheet->getStyle("C5:D5")->applyFromArray($this->getItemListStyle());
                $sheet->getStyle("A5:D5")->getFont()->setSize(12);

                $sheet->mergeCells("A6:B6");
                $sheet->setCellValue('A6', 'TOTAL'); 
                $sheet->getStyle("A6:B6")->applyFromArray($this->getItemTitleStyle());
                $sheet->mergeCells("C6:D6");
                $sheet->setCellValue('C6', $price - $discount); 
                $sheet->getStyle("C6:D6")->applyFromArray($this->getItemListStyle());
                $sheet->getStyle("A6:D6")->getFont()->setSize(12);


                $writer = new Xlsx($spreadsheet); // instantiate Xlsx
        
                $filename = 'Reporte de compras '.$start_date.' to '.$end_date; // set filename for excel file to be exported
        
                header('Content-Type: application/vnd.ms-excel'); // generate excel file
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
                
                $writer->save('php://output');	// download file 
            }
            else{
                json_response(null, false, "No se encontraron ventas para las fechas.");
            }
        }
        else{
            json_response(null, false, "Usted no puede realizar esta acción.");
        }
    }

    // Generate the purchases excel report by dates
    public function generateWinnersReport($id_draw){
        if(is_admin() || is_assistant()){

            $draw = $this->Draw->get_draws($id_draw);
            $winners = $this->Draw->get_draws_winners($id_draw);

            
            if(is_array($winners)){
                $line = 1;
                $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

                // manually set title value
                $sheet->mergeCells("A".$line.":M".$line);
                $sheet->setCellValue('A'.$line, 'LOTERIA DEL QUINDIO'); 
                $sheet->getStyle("A".$line.":M".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":M".$line)->getFont()->setSize(14);
                $line++;
                $sheet->mergeCells("A".$line.":M".$line);
                $sheet->setCellValue('A'.$line, 'REPORTE DE GANADORES PARA EL SORTEO #'.$draw["draw_number"]); 
                $sheet->getStyle("A".$line.":M".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":M".$line)->getFont()->setSize(12);
                $line += 3;

                $sheet->getStyle('A'.$line.':M'.$line)->applyFromArray($this->getItemTitleStyle());

                // Set the cells dimensions
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(40);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(40);
                $sheet->getColumnDimension('G')->setWidth(40);
                $sheet->getColumnDimension('H')->setWidth(20);
                $sheet->getColumnDimension('I')->setWidth(25);
                $sheet->getColumnDimension('J')->setWidth(25);
                $sheet->getColumnDimension('K')->setWidth(12);
                $sheet->getColumnDimension('L')->setWidth(12);
                $sheet->getColumnDimension('M')->setWidth(12);

                // Set the table titles
                $sheet->setCellValue('A'.$line, 'FECHA DE COMPRA'); 
                $sheet->setCellValue('B'.$line, 'REFERENCIA DE COMPRA');
                $sheet->setCellValue('C'.$line, 'PREMIO');
                $sheet->setCellValue('D'.$line, 'VALOR PREMIO'); 
                $sheet->setCellValue('E'.$line, 'DOCUMENTO CLIENTE'); 
                $sheet->setCellValue('F'.$line, 'NOMBRE CLIENTE'); 
                $sheet->setCellValue('G'.$line, 'CORREO'); 
                $sheet->setCellValue('H'.$line, 'TELEFONO'); 
                $sheet->setCellValue('I'.$line, 'DEPARTAMENTO'); 
                $sheet->setCellValue('J'.$line, 'CIUDAD'); 
                $sheet->setCellValue('K'.$line, 'NUMERO');
                $sheet->setCellValue('L'.$line, 'SERIE');
                $sheet->setCellValue('M'.$line, 'ESTADO');

                $line++;

                $price = 0;
                $discount = 0;
                foreach ($winners as $winner) {
                    // Set the winners data
                    $sheet->setCellValue('A'.$line, ucfirst(strftime('%B %d, %Y',strtotime($winner["purchase_date"])))); 
                    $sheet->setCellValue('B'.$line, $winner["purchase_slug"]); 
                    $sheet->setCellValue('C'.$line, $winner["reward_description"]); 
                    $sheet->setCellValue('D'.$line, $winner["total_with_discount"]); 
                    $sheet->setCellValue('E'.$line, $winner["identification_number"]); 
                    $sheet->setCellValue('F'.$line, $winner["first_name"]." ".$winner["last_name"]);
                    $sheet->setCellValue('G'.$line, $winner["email"]); 
                    $sheet->setCellValue('H'.$line, $winner["phone"]);
                    $sheet->setCellValue('I'.$line, $winner["state"]);
                    $sheet->setCellValue('J'.$line, $winner["city"]);
                    $sheet->setCellValue('K'.$line, $winner["number"]);
                    $sheet->setCellValue('L'.$line, $winner["purchase_serie"]);
                    $sheet->setCellValue('M'.$line, ($winner["confirmed"] == 0) ? "Sin Confirmar" : "Confirmado");
                    $sheet->getStyle('A'.$line.':M'.$line)->applyFromArray($this->getItemListStyle());
                    $sheet->getStyle('E'.$line.':M'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT ] ]);
                    $sheet->getStyle('F'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $sheet->getStyle('G'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $sheet->getStyle('I'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $sheet->getStyle('J'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $sheet->getStyle('M'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $line++;
                }


                $writer = new Xlsx($spreadsheet); // instantiate Xlsx
        
                $filename = 'Reporte de ganadores para el sorteo #'.$draw["draw_number"]; // set filename for excel file to be exported
             
                header('Content-Type: application/vnd.ms-excel'); // generate excel file
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
                
                $writer->save('php://output');	// download file
            }
            else{
                json_response(null, false, "No se encontraron ventas para las fechas.");
            }
        }
        else{
            json_response(null, false, "Usted no puede realizar esta acción.");
        }
    }

    // Generate the purchases excel report by dates
    public function generateStatesReport($start_date = null, $end_date = null){
        if($start_date == null){
            $start_date = date("Y-m-d");
        }
        if($end_date == null){
            $end_date = date("Y-m-d");
        }
        if(is_admin() || is_assistant()){

            $purchases = $this->Purchase->get_purchases_by_dates($start_date, $end_date, 0);

            if(is_array($purchases)){
                $line = 1;
                $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

                // manually set title value
                $sheet->mergeCells("A".$line.":J".$line);
                $sheet->setCellValue('A'.$line, 'LOTERIA DEL QUINDIO'); 
                $sheet->getStyle("A".$line.":J".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":J".$line)->getFont()->setSize(14);
                $line++;
                $sheet->mergeCells("A".$line.":J".$line);
                $sheet->setCellValue('A'.$line, 'REPORTE DE VENTAS POR DEPARTAMENTO DESDE '.strtoupper(strftime('%B %d, %Y',strtotime($start_date))).' HASTA '.strtoupper(strftime('%B %d, %Y',strtotime($end_date)))); 
                $sheet->getStyle("A".$line.":J".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":J".$line)->getFont()->setSize(12);
                $line += 6;

                $sheet->getStyle('A'.$line.':E'.$line)->applyFromArray($this->getItemTitleStyle());

                // Set the cells dimensions
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(12);
                $sheet->getColumnDimension('E')->setWidth(12);

                // Set the table titles
                $sheet->setCellValue('A'.$line, 'DEPARTAMENTO'); 
                $sheet->setCellValue('B'.$line, 'BILLETES VENDIDOS'); 
                $sheet->setCellValue('C'.$line, 'SUBTOTAL'); 
                $sheet->setCellValue('D'.$line, 'DESCUENTO'); 
                $sheet->setCellValue('E'.$line, 'TOTAL'); 

                $line++;

                $price = 0;
                $discount = 0;
                foreach ($purchases as $purchase) {
                    $price += $purchase["price_sum"];
                    $discount += $purchase["discount_sum"];
                    // Set the purchases data
                    $sheet->setCellValue('A'.$line, $purchase["report_description"]); 
                    $sheet->setCellValue('B'.$line, $purchase["bills"]); 
                    $sheet->setCellValue('C'.$line, $purchase["price_sum"]); 
                    $sheet->setCellValue('D'.$line, $purchase["discount_sum"]); 
                    $sheet->setCellValue('E'.$line, $purchase["price_sum"] - $purchase["discount_sum"]); 
                    
                    $sheet->getStyle('A'.$line.':E'.$line)->applyFromArray($this->getItemListStyle());
                    $line++;
                }

                // Set the prices summary
                $sheet->mergeCells("A4:B4");
                $sheet->setCellValue('A4', 'SUBTOTAL'); 
                $sheet->getStyle("A4:B4")->applyFromArray($this->getItemTitleStyle());
                $sheet->mergeCells("C4:D4");
                $sheet->setCellValue('C4', $price); 
                $sheet->getStyle("C4:D4")->applyFromArray($this->getItemListStyle());
                $sheet->getStyle("A4:D4")->getFont()->setSize(12);

                $sheet->mergeCells("A5:B5");
                $sheet->setCellValue('A5', 'DESCUENTO'); 
                $sheet->getStyle("A5:B5")->applyFromArray($this->getItemTitleStyle());
                $sheet->mergeCells("C5:D5");
                $sheet->setCellValue('C5', $discount); 
                $sheet->getStyle("C5:D5")->applyFromArray($this->getItemListStyle());
                $sheet->getStyle("A5:D5")->getFont()->setSize(12);

                $sheet->mergeCells("A6:B6");
                $sheet->setCellValue('A6', 'TOTAL'); 
                $sheet->getStyle("A6:B6")->applyFromArray($this->getItemTitleStyle());
                $sheet->mergeCells("C6:D6");
                $sheet->setCellValue('C6', $price - $discount); 
                $sheet->getStyle("C6:D6")->applyFromArray($this->getItemListStyle());
                $sheet->getStyle("A6:D6")->getFont()->setSize(12);


                $writer = new Xlsx($spreadsheet); // instantiate Xlsx
        
                $filename = 'Reporte de compras por departamento '.$start_date.' to '.$end_date; // set filename for excel file to be exported
        
                header('Content-Type: application/vnd.ms-excel'); // generate excel file
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
                
                $writer->save('php://output');	// download file 
            }
            else{
                json_response(null, false, "No se encontraron ventas para las fechas.");
            }
        }
        else{
            json_response(null, false, "Usted no puede realizar esta acción.");
        }
    }

    // Generate the purchases excel report by dates
    public function generateWithdrawsReport($start_date, $end_date){
        if(is_admin() || is_assistant()){

            $withdraws = $this->Withdraw->get_withdraws_by_dates($start_date, $end_date);

            if(is_array($withdraws)){
                $line = 1;
                $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

                // manually set title value
                $sheet->mergeCells("A".$line.":K".$line);
                $sheet->setCellValue('A'.$line, 'LOTERIA DEL QUINDIO'); 
                $sheet->getStyle("A".$line.":K".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":K".$line)->getFont()->setSize(14);
                $line++;
                $sheet->mergeCells("A".$line.":K".$line);
                $sheet->setCellValue('A'.$line, 'REPORTE SOLICITUDES DE RETIRO ('.ucfirst(strftime('%B %d, %Y',strtotime($start_date))).' - '.ucfirst(strftime('%B %d, %Y',strtotime($end_date))).')'); 
                $sheet->getStyle("A".$line.":K".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":K".$line)->getFont()->setSize(12);
                $line += 3;

                $sheet->getStyle('A'.$line.':K'.$line)->applyFromArray($this->getItemTitleStyle());

                // Set the cells dimensions
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(23);
                $sheet->getColumnDimension('F')->setWidth(23);
                $sheet->getColumnDimension('G')->setWidth(23);
                $sheet->getColumnDimension('H')->setWidth(20);
                $sheet->getColumnDimension('I')->setWidth(20);
                $sheet->getColumnDimension('J')->setWidth(20);
                $sheet->getColumnDimension('K')->setWidth(40);

                // Set the table titles
                $sheet->setCellValue('A'.$line, 'CODIGO DEL RETIRO'); 
                $sheet->setCellValue('B'.$line, 'ESTADO'); 
                $sheet->setCellValue('C'.$line, 'VALOR'); 
                $sheet->setCellValue('D'.$line, 'TIPO DOCUMENTO'); 
                $sheet->setCellValue('E'.$line, 'NÚMERO DOCUMENTO'); 
                $sheet->setCellValue('F'.$line, 'CLIENTE'); 
                $sheet->setCellValue('G'.$line, 'FECHA DE SOLICITUD'); 
                $sheet->setCellValue('H'.$line, 'BANCO'); 
                $sheet->setCellValue('I'.$line, 'TIPO DE CUENTA'); 
                $sheet->setCellValue('J'.$line, 'NÚMERO DE CUENTA'); 
                $sheet->setCellValue('K'.$line, 'NOTAS CLIENTE'); 

                $line++;

                $price = 0;
                $discount = 0;
                foreach ($withdraws as $w) {
                    // Set the winners data
                    $sheet->setCellValue('A'.$line, strtoupper($w["slug_withdraw"])); 
                    $sheet->setCellValue('B'.$line, $w["description"]); 
                    $sheet->setCellValue('C'.$line, $w["total"]); 
                    $sheet->setCellValue('D'.$line, $this->encryption->decrypt($w["document_type"])); 
                    $sheet->setCellValue('E'.$line, $this->encryption->decrypt($w["document_number"])); 
                    $sheet->setCellValue('F'.$line, $w["first_name"]." ".$w["last_name"]); 
                    $sheet->setCellValue('G'.$line, ucfirst(strftime('%B %d, %Y',strtotime($w["created_at"])))); 
                    $sheet->setCellValue('H'.$line, $this->encryption->decrypt($w["bank"])); 
                    $sheet->setCellValue('I'.$line, $this->encryption->decrypt($w["account_type"])); 
                    $sheet->setCellValue('J'.$line, $this->encryption->decrypt($w["account_number"])); 
                    $sheet->setCellValue('K'.$line, $this->encryption->decrypt($w["user_notes"])); 
                    $sheet->getStyle('A'.$line.':K'.$line)->applyFromArray($this->getItemListStyle());
                    $sheet->getStyle('A'.$line.':K'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $sheet->getStyle('C'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT ] ]);
                    $line++;
                }


                $writer = new Xlsx($spreadsheet); // instantiate Xlsx
        
                $filename = 'Reporte de solicitudes de retiro'; // set filename for excel file to be exported
             
                header('Content-Type: application/vnd.ms-excel'); // generate excel file
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
                
                $writer->save('php://output');	// download file 
            }
            else{
                json_response(null, false, "No se encontraron solicitudes para las fechas.");
            }
        }
        else{
            json_response(null, false, "Usted no puede realizar esta acción.");
        }
    }


    // Generate the purchases excel report by dates
    public function generateUsersReport($start_date, $end_date){
        if(is_admin() || is_assistant()){
            $users = $this->Usuario->get_user_by_dates($start_date, $end_date);

            if(is_array($users)){
                $line = 1;
                $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

                // manually set title value
                $sheet->mergeCells("A".$line.":H".$line);
                $sheet->setCellValue('A'.$line, 'LOTERIA DEL QUINDIO'); 
                $sheet->getStyle("A".$line.":H".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":H".$line)->getFont()->setSize(14);
                $line++;
                $sheet->mergeCells("A".$line.":H".$line);
                $sheet->setCellValue('A'.$line, 'REPORTE USUARIOS ('.ucfirst(strftime('%B %d, %Y',strtotime($start_date))).' - '.ucfirst(strftime('%B %d, %Y',strtotime($end_date))).')'); 
                $sheet->getStyle("A".$line.":H".$line)->applyFromArray($this->getDocumentTitleStyle());
                $sheet->getStyle("A".$line.":H".$line)->getFont()->setSize(12);
                $line += 3;

                $sheet->getStyle('A'.$line.':H'.$line)->applyFromArray($this->getItemTitleStyle());

                // Set the cells dimensions
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(23);
                $sheet->getColumnDimension('C')->setWidth(45);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(60);
                $sheet->getColumnDimension('F')->setWidth(23);
                $sheet->getColumnDimension('G')->setWidth(23);
                $sheet->getColumnDimension('H')->setWidth(25);

                // Set the table titles
                $sheet->setCellValue('A'.$line, 'TIPO DOCUMENTO'); 
                $sheet->setCellValue('B'.$line, 'NÚMERO DOCUMENTO'); 
                $sheet->setCellValue('C'.$line, 'NOMBRE'); 
                $sheet->setCellValue('D'.$line, 'TELÉFONO'); 
                $sheet->setCellValue('E'.$line, 'DIRECCIÓN'); 
                $sheet->setCellValue('F'.$line, 'CIUDAD'); 
                $sheet->setCellValue('G'.$line, 'DEPARTAMENTO'); 
                $sheet->setCellValue('H'.$line, 'FECHA DE NACIMIENTO'); 

                $line++;

                foreach ($users as $u) {
                    // Set the winners data
                    $sheet->setCellValue('A'.$line, $u["document_type"]); 
                    $sheet->setCellValue('B'.$line, $u["identification_number"]); 
                    $sheet->setCellValue('C'.$line, strtoupper($u["first_name"] . " " .$u["last_name"])); 
                    $sheet->setCellValue('D'.$line, $u["phone"]); 
                    $sheet->setCellValue('E'.$line, $u["address"]); 
                    $sheet->setCellValue('F'.$line, $u["city_name"]); 
                    $sheet->setCellValue('G'.$line, $u["state_name"]); 
                    $sheet->setCellValue('H'.$line, $u["birth_date"]); 
                    $sheet->getStyle('A'.$line.':H'.$line)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT ] ]);
                    $line++;
                }


                $writer = new Xlsx($spreadsheet); // instantiate Xlsx
        
                $filename = 'Reporte de usuarios'; // set filename for excel file to be exported
             
                header('Content-Type: application/vnd.ms-excel'); // generate excel file
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                header('Cache-Control: max-age=0');
                
                $writer->save('php://output');	// download file 
            }
            else{
                json_response(null, false, "No se encontraron usuarios para las fechas.");
            }
        }
        else{
            json_response(null, false, "Usted no puede realizar esta acción.");
        }
    }

    // Define the table headers style
    public function getItemTitleStyle(){
        return [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ],
            ],
        ];
    }

    // Define the table items style
    function getItemListStyle(){
        return [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ],
            ],
        ];
    }

    function getDocumentTitleStyle(){
        return [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ],
            ],
        ];
    }
}
