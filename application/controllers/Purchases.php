<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'product']);
		$this->load->library(['session', 'form_validation']);
		$this->load->model(['Location', 'Blend', 'Draw', 'Purchase', 'Subscriber']);
	}

	public function index()
	{
		$params["draw"] = $this->Draw->get_active_draw();

		if($this->input->post()){
			// Set the inputs rules
			$this->form_validation->set_rules('purchase[number]', 'Número del billete', 'required|numeric|exact_length[4]');
			$this->form_validation->set_rules('purchase[serie]', 'Serie', 'required|numeric|exact_length[3]');
			$this->form_validation->set_rules('purchase[parts]', 'Fracciones', 'required');
			$this->form_validation->set_rules('purchase[id_draw]', 'Sorteo', 'required');

			// Check if input rules are ok
			if ($this->form_validation->run() == false) {
				$params["message"] = array("type" => "danger", "message" => "Ha ocurrido un error, los datos ingresados presentan errores", "success" => false);
			}else{
				$temp_data = $this->input->post();
				$temp_data["current_draw"] = $params["draw"];
                $params["message"] = $this->register_purchase_proccess($temp_data);
            }
            
            if(!$params["message"]["success"]){
                $params["data_form"] = $this->input->post();
			}
			else{
				$this->session->unset_userdata('draw_number');
			}
		}

        $params["title"] = "Compra";
		$params["subtitle"] = "Compra";
		$params["states"] = $this->Location->get_states();
		$params["blends"] = $this->Blend->get_blends();
		$params["cities"] = $this->Location->get_cities_by_city(logged_user()["city_id"]);

        $this->load_layout("Panel/Purchases/Checkout", $params);
	}

	// Purchase register process
	function register_purchase_proccess($info_data){
		$data = $info_data["purchase"];
		$subscriber_amount = $info_data["subscriber"]["amount"];
		$subcriber_discount = $info_data["subscriber"]["discount"];

		$data["created_at"] = date("Y-m-d H:i:s");
		$data["id_user"] = logged_user()["id"];
		$data["price"] = $info_data["current_draw"]["fraction_value"] * $data["parts"];
		$draw = $this->Draw->get_active_draw();

		if($subscriber_amount > 1){
			$data["price"] = $info_data["current_draw"]["fraction_value"] * $data["parts"] * $subscriber_amount;
			$data["discount"] = $data["price"] * ($subcriber_discount / 100);
		}

		// Validate if current active draw is the same for the purchase process
		if($data["id_draw"] == $draw["id"]){
			$temp_purchase = $this->Purchase->validate_purchase($data);

			// Check if exists a previus purchase with the same number, serie and draw
			if(!$temp_purchase){
				$result_purchase = $this->Purchase->set_purchase($data);
				if($result_purchase != false){
					if($subscriber_amount > 1){
						$this->set_subscriber($subscriber_amount, $result_purchase);
					}
					return array("type" => "success", "success" => true, "message" => "Compra realizada exitosamente.");
				}
			}
			else{
				// Check is there is any available part for the number purchase
				if(intval(get_product_available_parts(1, $data)) > intval(0)){
					$result_purchase = $this->Purchase->set_purchase($data);
					if($result_purchase != false){
						if($subscriber_amount > 1){
							$this->set_subscriber($subscriber_amount, $result_purchase);
						}
						return array("type" => "success", "success" => true, "message" => "Compra realizada exitosamente.");
					}
				}
				else{
					return array("type" => "danger", "success" => false, "message" => "El número o cantidad de fracciones que desea comprar no se encuentra disponible.");
				}
			}
		}
		else{
			return array("type" => "danger", "success" => false, "message" => "El sorteo #".$draw["draw_number"]." ya no se encuentra disponible.");
		}
	}

	// Set the subscriber rows
	function set_subscriber($amount, $purchase){
		$data["id_user"] = $purchase["id_user"];
		$data["id_purchase"] = $purchase["id_purchase"];
		$data["subscriber_amount"] = $amount;
		$data["subscriber_remaining_amount"] = $amount;
		$data["created_at"] = $purchase["created_at"];

		$this->Subscriber->set_subscriber($data);
	}
	
	function user_list(){
		$params["title"] = "Mis Compras";
		$params["subtitle"] = "Mis Compras";
		$params["purchases"] = $this->Purchase->get_user_purchases(logged_user()["id"]);

        $this->load_layout("Panel/Purchases/UserList", $params);
	}

	function user_subscriber(){
		$params["title"] = "Mis Abonados";
		$params["subtitle"] = "Mis Abonados";
		$params["subscribers"] = $this->Subscriber->get_user_subscribers(logged_user()["id"]);

        $this->load_layout("Panel/Purchases/UserSubscriber", $params);
	}
}
