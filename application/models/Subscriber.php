<?php
Class Subscriber extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the subscribers rows
    // $id -> If id is different of null it will return only a row with the subscriber id information
    public function get_subscribers($id = null, $validate = true) {
        $this->db->select('p.*, u.slug as user_slug, s.*');
        $this->db->from('subscribers s');
        $this->db->join('purchases p', 'p.id_purchase = s.id_purchase');
        $this->db->join('users u', 'u.id = p.id_user');
        if($id != null && $id != "null"){
            $this->db->where("id_subscriber", $id);
        }

        if($validate){
            $this->db->where("s.subscriber_remaining_amount >", 0);
            $this->db->where("p.purchase_status", 1);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Get the subscribers rows by user
    // $id -> If id is different of null it will return only a row with the subscriber id information
    public function get_user_subscribers($id_user) {
        $this->db->select('p.*, u.slug as user_slug, s.*');
        $this->db->from('subscribers s');
        $this->db->join('purchases p', 's.id_purchase = p.id_purchase');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->order_by("id_subscriber", "desc");
        $this->db->where("s.id_user", $id_user);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_purchase_subscriber($id_purchase) {
        $this->db->select('p.*, u.slug as user_slug, s.*');
        $this->db->from('subscribers s');
        $this->db->join('purchases p', 's.id_purchase = p.id_purchase');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->order_by("id_subscriber", "desc");
        $this->db->where("s.id_purchase", $id_purchase);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // Add a new subscriber
    // $data -> The subscriber data with id as null and name
    public function set_subscriber($data){
        return $this->db->insert('subscribers', $data);
    }

    // Update an existing subscriber
    // $data -> The new updated data with id and name
    public function update_subscriber($data){
        $this->db->where("id_subscriber", $data["id_subscriber"]);
        return $this->db->update("subscribers", $data);
    }

    // Get the current subscriber
    public function get_active_subscriber(){
        $this->db->from("subscribers");
        $this->db->where("date >=", date("Y-m-d"));
        $this->db->order_by("date", "asc");
        $this->db->limit(1);

        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
?>