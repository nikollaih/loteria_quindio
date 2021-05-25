<?php
Class Winner extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get a purchase winner
    public function get_winner($id_purchase) {
        $this->db->from('winners');
        $this->db->where("id_purchase", $id_purchase);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // Set a new winner
    public function set_winner($data) {
       $this->db->insert("winners", $data);
       return $this->get_winner($data["id_purchase"]);
    }

    // Set a new winner
    public function update_winner($data) {
        $this->db->where("id_purchase", $data["id_purchase"]);
        return $this->db->update('winners', $data); 
     }
}
?>