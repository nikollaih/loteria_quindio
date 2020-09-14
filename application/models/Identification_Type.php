<?php
Class Identification_Type extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the identification types rows
    public function get_identification_types() {
        $this->db->from('identification_types');
        $this->db->order_by("name", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
?>