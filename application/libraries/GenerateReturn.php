<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class GenerateReturn {
  protected $draw;
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
    $this->CI->load->model(['Draw', 'Purchase', 'Blend']);
  }

  public function perform($draw){
    $this->draw = $draw;

    $blends = $this->get_blends();

    $returned = [];
    $returned_count = 0;

    die();
    foreach ($blends as $blend) {
      $serie = $blend['serie'];
      $solds = $this->get_sold_numbers($serie);
      
      $start_number = $blend['start_number'];
      $end_number = $blend['end_number'];

      $rango = array_map( function( $day ) {
        return str_pad( $day, 4, '000', STR_PAD_LEFT );
      }, range($start_number, $end_number) );

      $result = array_diff($rango, $solds);

      $returned_count += count($result);
      $returned[$serie] = $result;
    }

    $returned_count = $returned_count * $this->frantions_count();

    $data = Array(
      'returned' => $returned,
      'count' => $returned_count
    );
   
    $this->write_file($draw, $data);
  }
  
  function write_file($draw, $data) {
    
    $agency_id = 'LDQ';

    $filePathAndName = $agency_id . $draw['draw_number'] . ".19.txt";
    $the_file = fopen($filePathAndName, "w") or die("Unable to open file!");

    fwrite($the_file, '19' . PHP_EOL);
    fwrite($the_file, 'CCCCC' . PHP_EOL);
    fwrite($the_file, $draw['draw_number'] . PHP_EOL);
    fwrite($the_file, $data['count'] . PHP_EOL);

    $returned = $data['returned'];

    foreach($returned as $serie => $numbers){
      foreach($numbers as $returned_number) {
        $fractions_count = $this->frantions_count();
        for ($i=1; $i <= $fractions_count; $i++) { 
          fwrite($the_file, $returned_number . '|');
          fwrite($the_file, $serie . '|');
          fwrite($the_file, $i . '|');
          fwrite($the_file, $fractions_count . '|');
          fwrite($the_file, PHP_EOL);
        }
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

  function get_blends() {
    return $this->CI->Blend->get_blends();
  }
}