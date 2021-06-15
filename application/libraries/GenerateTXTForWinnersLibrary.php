<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class GenerateTXTForWinnersLibrary {
  protected $draw;
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
    $this->CI->load->model(['Draw', 'Purchase', 'ToReturn']);
  }

  public function perform($draw, $winners){
    $this->draw = $draw;
    $this->winners = $winners;
   
  
   
    $this->write_file($draw, $winners);
  }
  
  function write_file($draw, $winners) {
    
    $agency_id = 'LDQ';

    $filePathAndName = $agency_id . '.'. $draw['draw_number'] . ".winners.txt";
    // print_r($data);
    // die();
    $the_file = fopen($filePathAndName, "w") or die("Unable to open file!");
    
    foreach($winners as $winner){
      fwrite($the_file, $winner['identification_number'] . '|');
      fwrite($the_file, $winner['total_with_discount'] . '|');
      fwrite($the_file, $winner['reward_description'] . '|');
      fwrite($the_file, $winner['number'] . '|');
      fwrite($the_file, $winner['purchase_serie'] . '|');
      fwrite($the_file, $winner['id_purchase'] . '|');
      fwrite($the_file, $winner['draw_number'] . '|');
      fwrite($the_file, $winner['confirmed']);
      fwrite($the_file, PHP_EOL);
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
}