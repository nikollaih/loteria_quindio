<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class GenerateReturn {
  protected $draw;
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
    $this->CI->load->model(['Draw', 'Purchase', 'ToReturn']);
  }

  public function perform($draw){
    $this->draw = $draw;

    $to_return = $this->get_return($draw['id']);

    $returned = [];
    $returned_count = 0;

    $returned = [];
    $returned_count = 0;

    $series = unserialize($to_return['to_return']);
    
    foreach ($series as $serie) {
      $returned_count += count($serie[0]);
    }

    $returned_count = $returned_count * $this->frantions_count();

    $data = Array(
      'returned' => $series,
      'count' => $returned_count
    );
   
    $this->write_file($draw, $data);
  }
  
  function write_file($draw, $data) {
    
    $agency_id = 'LDQ';

    $filePathAndName = $agency_id . $draw['draw_number'] . ".19.txt";
    // print_r($data);
    // die();
    $the_file = fopen($filePathAndName, "w") or die("Unable to open file!");

    fwrite($the_file, '19' . PHP_EOL);
    fwrite($the_file, 'CCCCC' . PHP_EOL);
    fwrite($the_file, $draw['draw_number'] . PHP_EOL);
    fwrite($the_file, $data['count'] . PHP_EOL);

    $returned = $data['returned'];
    
    foreach($returned as $serie => $numbers){
      foreach($numbers[0] as $returned_number) {
        fwrite($the_file, $returned_number);
        fwrite($the_file, $serie . '00');
        fwrite($the_file, $this->frantions_count() . '0');
        fwrite($the_file, $this->frantions_count() . '00000');
        fwrite($the_file, PHP_EOL);
      } 
    }

    fclose($the_file);

    $this->download_file($filePathAndName);
  }

  function download_file($filePathAndName){
    header('Content-Description: File Transfer');
    header('Content-Type: file/txt');
    header('Content-Disposition: attachment; filename='.basename($filePathAndName));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePathAndName));
    ob_clean();
    flush();
    readfile($filePathAndName);
  }

  function frantions_count(){
    return $this->draw['fractions_count'];
  }
  
  function get_sold_numbers($serie) {
    return $this->CI->Purchase->get_sold_numbers_array($this->draw['id'], $serie);
  }

  function get_return($id_draw) {
    return $this->CI->ToReturn->get_return($id_draw);
  }
}