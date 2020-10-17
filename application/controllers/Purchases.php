<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'product']);
		$this->load->library(['session', 'form_validation', 'Mailer']);
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
				$data["purchase"] = $params["message"]["data"];
				$data["subscriber"] = $this->input->post("subscriber");
				$data['success_message'] = true;
				$data['button_url'] = generate_invoice_url($data["purchase"]["user_slug"], $data["purchase"]["slug"]);
				$email_body = $this->load->view('emails/purchase_invoice', $data, true);
				$this->mailer->send($email_body, 'Compra exitosa', $data["purchase"]["email"]);
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
		$blend = $this->Blend->get_blends($data["serie"]);
		$subscriber_amount = $info_data["subscriber"]["amount"];
		$subcriber_discount = $info_data["subscriber"]["discount"];

		$data["bills"] = ($subscriber_amount > 1) ? $subscriber_amount + 1 : 1;
		$data["parts"] = $info_data["current_draw"]["fractions_count"];
		$data["created_at"] = date("Y-m-d H:i:s");
		$data["id_user"] = logged_user()["id"];
		$data["price"] = $info_data["current_draw"]["fraction_value"] * $data["parts"];
		$data["slug"] = create_unique_slug("Purchases", 8);
		$draw = $this->Draw->get_active_draw();

		if($subscriber_amount > 1){
			$data["price"] = ($info_data["current_draw"]["fraction_value"] * $data["parts"] * $subscriber_amount) + ($info_data["current_draw"]["fraction_value"] * $info_data["current_draw"]["fractions_count"]);
			$data["discount"] = ($data["price"] - ($info_data["current_draw"]["fraction_value"] * $info_data["current_draw"]["fractions_count"])) * ($subcriber_discount / 100);
		}

		// Validate if current active draw is the same for the purchase process
		if($data["id_draw"] == $draw["id"]){
			if($data["number"] >= $blend["start_number"] && $data["number"] <= $blend["end_number"]){
				$temp_purchase = $this->Purchase->validate_purchase($data);

				// Check if exists a previus purchase with the same number, serie and draw
				if(!$temp_purchase){
					$result_purchase = $this->Purchase->set_purchase($data);
					if($result_purchase != false){
						if($subscriber_amount > 1){
							$this->set_subscriber($subscriber_amount, $result_purchase);
						}
						return array("type" => "success", "success" => true, "message" => "Compra realizada exitosamente.", "data" => $result_purchase);
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
							return array("type" => "success", "success" => true, "message" => "Compra realizada exitosamente.", "data" => $result_purchase);
						}
					}
					else{
						return array("type" => "danger", "success" => false, "message" => "El número o cantidad de fracciones que desea comprar no se encuentra disponible.");
					}
				}
			}
			return array("type" => "danger", "success" => false, "message" => "El número que desea comprar debe ser mayor que ".$blend["start_number"]." y menor que ".$blend["end_number"].".");
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
