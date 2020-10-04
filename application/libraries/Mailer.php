<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer {
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
  }

  public function send($content, $subject, $to){
    $this->CI->load->library('email');


    $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'loteriadelquindiosoporte@gmail.com',
        'smtp_pass' => '@LoteriaQuindio',
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );

    $this->CI->email->initialize($config);
    $this->CI->email->set_mailtype("html");
    $this->CI->email->set_newline("rn");

    //Email content
    $htmlContent = '<h1>Sending email via SMTP server</h1>';
    $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

    $this->CI->email->to($to);
    $this->CI->email->from('loteriadelquindiosoporte@gmail.com','Loteria del quindio');
    $this->CI->email->subject($subject);
    $this->CI->email->message('hola');

    //Send email
    $this->CI->email->send();
  }
}