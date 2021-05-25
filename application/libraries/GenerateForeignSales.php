<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class GenerateForeignSales {
  protected $draw;
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
    $this->CI->load->model(['Draw', 'Purchase']);
  }

  public function perform($draw){
    $this->draw = $draw;

    $solds = $this->get_solds();

    $this->write_file($draw, $solds);
  }
  
  function write_file($draw, $solds) {
    
    $agency_id = 'LDQ';

    $filePathAndName = 'foraneas-' . $agency_id . '-' . $draw['draw_number'] . ".19.txt";
   
    $the_file = fopen($filePathAndName, "w") or die("Unable to open file!");

    $solds_count = count($solds) * $this->frantions_count();

    fwrite($the_file, '19' . PHP_EOL);
    fwrite($the_file, 'CCCCC' . PHP_EOL);
    fwrite($the_file, $draw['draw_number'] . PHP_EOL);
    fwrite($the_file, $solds_count . PHP_EOL);

    foreach($solds as $sold){
      fwrite($the_file, $sold['number']);
      fwrite($the_file, $sold['serie'] . '0000');
      //fwrite($the_file, $this->frantions_count() . '0');
      //fwrite($the_file, $this->frantions_count() . '00000');
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

  function frantions_count(){
    return $this->draw['fractions_count'];
  }

  function get_solds(){
    return $this->CI->Purchase->get_sold_numbers_with_serie($this->draw['id']);
  }
}