<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Withdraws extends Application_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
        $this->load->model(["Withdraw", "Location", "Usuario"]);
		$this->load->library(['session', 'encryption', 'Mailer']);
	}
    
    // Delete the old booking register, (more than 10 minutes since it was created)
    public function index($id_user = null){
        $params["title"] = "Retiros solicitados";
        $params["subtitle"] = "Retiros solicitados";

        if($this->input->post()){
            $updated_withdraw = $this->input->post();
            $this->Withdraw->update($updated_withdraw);
        }

        if($id_user == null && is_client()){
            $id_user = logged_user()["id"];
        }

        $params["withdraws"] = $this->Withdraw->get_withdraws($id_user);
        $params["withdraw_status"] = $this->Withdraw->get_withdraw_status();
        $this->load_layout("Panel/Withdraws/Withdraws", $params);
    }

    // Method to generate a new withdraw, this method is called by ajax
    public function generate_withdraw(){
        if(isset($this->input->post()["id_user"])){
            $data = $this->input->post();

            if($data["id_user"] == null || $data["id_user"] == ""){
                $data["id_user"] = logged_user()["id"];
            }
            $user = $this->Usuario->get_user_by_param("u.id", $data["id_user"]);
            if($user["balance_total"] > 0){
                $new_withdraw["status"] = 1;
                $new_withdraw["slug_withdraw"] = create_unique_slug('withdraws', 8, 'slug_withdraw');
                $new_withdraw["id_user"] = $user["id"];
                $new_withdraw["created_at"] = date("Y-m-d h:i:s");
                $new_withdraw["total"] = $user["balance_total"];
                $new_withdraw["name"] = $this->encryption->encrypt($data["name"]);
                $new_withdraw["document_type"] = $this->encryption->encrypt($data["document_type"]);
                $new_withdraw["document_number"] = $this->encryption->encrypt($data["document_number"]);
                $new_withdraw["bank"] = $this->encryption->encrypt($data["bank"]);
                $new_withdraw["account_type"] = $this->encryption->encrypt($data["account_type"]);
                $new_withdraw["account_number"] = $this->encryption->encrypt($data["account_number"]);
                $new_withdraw["user_notes"] = $this->encryption->encrypt($data["user_notes"]);

                $result = $this->Withdraw->set($new_withdraw);

                if($result){
                    $new_user["id"] = $user["id"];
                    $new_user["balance_total"] = 0;
                    $this->Usuario->update($new_user);

                    $email_body = $this->load->view('emails/withdraw', $result, true);
				    $this->mailer->send($email_body, 'Solicitud de pago', get_setting("withdraw_email"));

                    echo json_encode(array("error" => FALSE, "message" => "Retiro solicitado exitosamente."));
                }
                else{
                    echo json_encode(array("error" => TRUE, "message" => "No se ha podido generar el retiro, por favor intente de nuevo más tarde."));
                }
            }
            else{
                echo json_encode(array("error" => TRUE, "message" => "No tiene fondos suficientes."));
            }
        }
        else{
            echo json_encode(array("error" => TRUE, "message" => "No se ha podido generar el retiro."));
        }
    }
}
