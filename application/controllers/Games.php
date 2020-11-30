<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(['url']);
		$this->load->model(['ProductWinner']);
  }

	public function slot_machine()
	{
		if(!is_logged()){
			header("Location: " . base_url() . "usuarios/login");
		}

		$this->load->view('games/slot_machine');
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
}
