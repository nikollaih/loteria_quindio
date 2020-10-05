<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require(APPPATH . "/third_party/sendgrid-php/sendgrid-php.php");

class Mailer {
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
  }

  
  public function send($content, $subject, $to){
    $this->CI->load->library('email');


    $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'loteriadelquindiosoporte@gmail.com',
        'smtp_pass' => '@LoteriaQuindio',
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'wordwrap' => TRUE,
    );

    $this->CI->email->initialize($config);
    $this->CI->email->set_mailtype("html");
    $this->CI->email->set_newline("\r\n");

    $this->CI->email->to($to);
    $this->CI->email->from('loteriadelquindiosoporte@gmail.com','Lotería del Quindio');
    $this->CI->email->subject($subject);
    $this->CI->email->message($content);

    //Send email
    if ($this->CI->email->send()) {
      return true;
    } else {
        //Do whatever you want if failed 
        log_message('error', 'Unable to Send Email to Customer.' . print_r($this->CI->email->print_debugger(array('headers', 'subject')), TRUE));
        return false;
    }
  }
}