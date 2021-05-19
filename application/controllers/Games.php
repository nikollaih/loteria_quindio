<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends Application_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(['url']);
		$this->load->model(['ProductWinner', 'GameProduct']);
  }


	public function slot_game(){
		if(!is_logged()){
			header("Location: " . base_url() . "usuarios/login");
		}
		if(get_setting('enable_loto_game')){
			$this->load->view('games/slot_game');
		}
		else{
			header("Location: " . base_url() . "Panel");
		}
	}

	public function my_rewards(){
		if(!is_logged()){
			header("Location: " . base_url() . "usuarios/login");
		}

		$params['winners'] = $this->ProductWinner->get_product_winners_by_user(logged_user()["id"]);
		$params['title'] = 'Mis premios fisicos';
		$params['subtitle'] = 'Mis premios fisicos';
		
		$this->load_layout('Panel/GameProducts/MyRewards', $params);
	}

	public function validate_slot_machine_result(){
		$slots = $this->input->post("slots");
		$product_id = $this->input->post("product_id");
		if ($slots == 1 &&  $product_id != '') {
			$slug = create_unique_slug('product_winners', 6);
			$data["slug"] = $slug;
			$data["user_id"] = logged_user()['id'];
			$data["product_id"] = $product_id;
			$data["status"] = 'pending';
			$result = $this->ProductWinner->set_product_winners($data);
			if($result != false){
				echo json_encode(array("success" => TRUE, "slug" => $slug));
			}
		}else {
			echo json_encode(array("success" => FALSE));
		}
	}

	function winners(){
		$params["winners"] = $this->ProductWinner->get_product_winners();
		$params["title"] = "Lista de ganadores";
        $params["subtitle"] = "Lista de ganadores";
        $this->load_layout("Panel/GameProducts/Winners", $params);
	}
	
	function update_winner(){
		if(isset($this->input->post()["id"])){
			$data = $this->input->post();

			if ($this->ProductWinner->update_product_winners($data)){
				echo json_encode(array("error" => FALSE, "message" => "Registro modificado exitosamente."));
			}else{
				echo json_encode(array("error" => TRUE, "message" => "No se ha podido modificar el registro."));
			}
					
		}else{
      echo json_encode(array("error" => TRUE, "message" => "No se ha podido generar el retiro."));
    }
	}
}
