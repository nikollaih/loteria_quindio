<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . "/third_party/sendgrid-php/sendgrid-php.php");

class Mailer {
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
  }


  public function send($content, $subject, $to){
    $from = new SendGrid\Email(null, "loteriadelquindiosoporte@gmail.com");
    $subject = "Hello World from the SendGrid PHP Library!";
    $to = new SendGrid\Email(null, $to);
    $content = new SendGrid\Content("text/plain", "Hello, Email!");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);
    echo $response->statusCode();
    echo $response->headers();
    echo $response->body();
  }

  public function send1($content, $subject, $to){
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