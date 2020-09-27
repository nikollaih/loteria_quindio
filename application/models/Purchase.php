<?php
Class Purchase extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the purchases rows
    // $id -> If id is different of null it will return only a row with the purchase id information
    public function get_purchases($id = null) {
        $this->db->from('purchases');
        $this->db->order_by("id", "desc");
        if($id != null){
            $this->db->where("id", $id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($serie == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Add a new purchase
    // $data -> The purchase data with id as null and name
    public function set_purchase($data){
        return $this->db->insert('purchases', $data);
    }

    // Update an existing purchase
    // $data -> The new updated data with id and name
    public function update_purchase($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("purchases", $data);
    }

    // Validate if a same exists
    public function validate_purchase($data){
        $this->db->from('purchases');
        $this->db->where("id_draw", $data["id_draw"]);
        $this->db->where("number", $data["number"]);
        $this->db->where("serie", $data["serie"]);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // Get the cant of parts sold
    public function get_product_sold_parts($data){
        $this->db->select("SUM(parts) as parts", FALSE);
        $this->db->from('purchases');
        $this->db->where("id_draw", $data["id_draw"]);
        $this->db->where("number", $data["number"]);
        $this->db->where("serie", $data["serie"]);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_user_purchases($id_user){
        $this->db->select("d.id, d.draw_number, d.date, p.number, p.serie, p.parts, p.created_at, p.price");
        $this->db->from('purchases p');
        $this->db->join("draws d", "d.id = p.id_draw");
        $this->db->where("id_user", $id_user);
        $this->db->order_by("created_at", "desc");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
?>