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
       return $this->db->insert("winners", $data);
    }
}
?>