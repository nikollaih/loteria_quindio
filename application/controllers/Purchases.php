<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends Application_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper(['url', 'product', 'games']);
		$this->load->library(['session', 'form_validation', 'Mailer']);
		$this->load->model(['Location', 'Blend', 'Draw', 'Purchase', 'Subscriber', 'Usuario']);
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
		}

        $params["title"] = "Compra";
		$params["subtitle"] = "Compra";
		$params["user"] = $this->Usuario->get_user_by_param("u.id", logged_user()["id"]);
		$params["states"] = $this->Location->get_states();
		$params["blends"] = $this->Blend->get_blends();
		$params["cities"] = $this->Location->get_cities_by_city(logged_user()["city_id"]);

        $this->load_layout("Panel/Purchases/Checkout", $params);
	}

	// Purchase register process
	function register_purchase_proccess($info_data){
		$data = $info_data["purchase"];
		$blend = $this->Blend->get_blends($data["serie"]);
		$user = $this->Usuario->get_user_by_param("u.id", logged_user()["id"]);
		$subscriber_amount = $info_data["subscriber"]["amount"];

		switch ($subscriber_amount) {
			case '52':
				$subcriber_discount = 15;
				break;
			
			case '26':
				$subcriber_discount = 8;
				break;

			case '13':
				$subcriber_discount = 5;
				break;
			
			default:
			$subcriber_discount = 0;
				break;
		}

		$data["bills"] = ($subscriber_amount > 1) ? $subscriber_amount + 1 : 1;
		$data["parts"] = $info_data["current_draw"]["fractions_count"];
		$data["created_at"] = date("Y-m-d H:i:s");
		$data["id_user"] = logged_user()["id"];
		$data["price"] = $info_data["current_draw"]["fraction_value"] * $data["parts"];
		$data["slug"] = create_unique_slug("Purchases", 8);
		$data["discount"] = 0;
		$data["purchase_status"] = "PENDING";
		$draw = $this->Draw->get_active_draw();

		if($subscriber_amount > 1){
			$data["price"] = ($info_data["current_draw"]["fraction_value"] * $data["parts"] * $subscriber_amount) + ($info_data["current_draw"]["fraction_value"] * $info_data["current_draw"]["fractions_count"]);
			$data["discount"] = ($data["price"] - ($info_data["current_draw"]["fraction_value"] * $info_data["current_draw"]["fractions_count"])) * ($subcriber_discount / 100);
		}

		

		// Validate if current active draw is the same for the purchase process
		if($data["id_draw"] == $draw["id"]){

			// if($data["number"] >= $blend["start_number"] && $data["number"] <= $blend["end_number"]){
			if(check_number_blend($data["serie"], $data["number"])){
				$temp_purchase = $this->Purchase->validate_purchase($data);

				// Check if exists a previus purchase with the same number, serie and draw
				if(!$temp_purchase){
					$result_purchase = $this->Purchase->set_purchase($data);
					if($result_purchase != false){
						$this->session->unset_userdata('draw_number');
						if($subscriber_amount > 1){
							$this->set_subscriber($subscriber_amount, $result_purchase);
						}
						// Add a new loto point
						add_loto_punto();

						$payment_result = $this->do_payment($result_purchase, $user["balance_total"]);
						if(is_array($payment_result)){
							return $payment_result;
						}
						//return array("type" => "success", "success" => true, "message" => "Compra realizada exitosamente.", "data" => $result_purchase);
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
							// Add a new loto point
							add_loto_punto();
							return array("type" => "success", "success" => true, "message" => "Compra realizada exitosamente.", "data" => $result_purchase);
						}
					}
					else{
						return array("type" => "danger", "success" => false, "message" => "El número y serie que desea comprar no se encuentra disponible.");
					}
				}
			}
			return array("type" => "danger", "success" => false, "message" => "El número que desea comprar no se encuentra disponible con la serie ".$data["serie"].".");
		}
		else{
			return array("type" => "danger", "success" => false, "message" => "El sorteo #".$draw["draw_number"]." ya no se encuentra disponible.");
		}
	}

	function do_payment($purchase, $user_balance){
		$purchase_total = $purchase["price"] - $purchase["discount"];
		if($purchase["payment_method"] == 2){
			if(($purchase_total) <= $user_balance){
				$new_balance = $user_balance - ($purchase_total);
				update_balance($new_balance, $purchase["id_user"]);
			}
			else{
				return array("type" => "danger", "success" => false, "message" => "Saldo insuficiente.");
			}
		}
		else{
			$jsonData = generate_payment_json($purchase["id_purchase"]);

			$ch = curl_init( get_setting("pse_api_url") );
			# Setup request to send json via POST.
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $jsonData ) );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			# Return response instead of printing.
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			# Send request.
			$result = json_decode(curl_exec($ch));
			curl_close($ch);

			$this->Purchase->update_purchase(array('id_purchase' => $purchase["id_purchase"], 'request_id' => $result->requestId ));
			# Print response.
			header("Location:".$result->processUrl);
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
		if(is_admin() || is_assistant()){
			$params["purchases"] = $this->Purchase->get_purchases();
		}
		else{
			$params["purchases"] = $this->Purchase->get_user_purchases(logged_user()["id"]);
		}

        $this->load_layout("Panel/Purchases/UserList", $params);
	}

	function user_subscriber(){
		$params["title"] = "Mis Abonados";
		$params["subtitle"] = "Mis Abonados";

		if(is_admin() || is_assistant()){
			$params["subscribers"] = $this->Subscriber->get_subscribers(null, false);
		}
		else{
			$params["subscribers"] = $this->Subscriber->get_user_subscribers(logged_user()["id"]);
		}

        $this->load_layout("Panel/Purchases/UserSubscriber", $params);
	}

	// Show the purchase resume, purchase status
	function resume($purchase_slug = null){
		$params["title"] = "Resumen";
		$params["subtitle"] = "";
		$params["request"] = [];
		$params["purchase"] = $this->Purchase->get_purchase_by_param("p.slug", $purchase_slug);

		if($params["purchase"]["request_id"] != null && $params["purchase"]){
			$jsonData = generate_payment_json($params["purchase"]["id_purchase"]);
			$ch = curl_init( get_setting("pse_api_url").$params["purchase"]["request_id"] );
			# Setup request to send json via POST.
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $jsonData ) );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			# Return response instead of printing.
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			# Send request.
			$params["request"]  = (array) json_decode(curl_exec($ch));
			curl_close($ch);
		}

		$this->Purchase->update_purchase(array('id_purchase' => $params["purchase"]["id_purchase"], 'purchase_status' => $params["request"]["status"]->status, 'payment_response' =>  serialize($params["request"]), 'authorization' => ($params["request"]["status"]->status == "APPROVED") ? $params["request"]["payment"][0]->authorization : ""));

        $this->load_layout("Panel/Purchases/Resume", $params);
	}

	// Update a purchase status
	function notification(){
		$response = json_decode(file_get_contents('php://input'));
		$signature = sha1($response->requestId.$response->status->status.$response->status->date.get_setting("pse_api_secret_key"));
		$purchase = $this->Purchase->get_purchase_by_param("p.request_id", $response->requestId);

		if($signature == $response->signature && $purchase && $purchase["purchase_status"] == "PENDING"){
			$this->Purchase->update_purchase(array('id_purchase' => $purchase["id_purchase"], 'purchase_status' => $response->status->status ));
		}
	}

	// Retry the payment
	function retry_payment($purchase_slug){
		if(is_logged()){
			$purchase = $this->Purchase->get_purchase_by_param("p.slug", $purchase_slug);
			if($purchase){
				$this->do_payment($purchase, 0);
			}
		}
	}
}
