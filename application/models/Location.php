<?php
Class Location extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the states list rows
    public function get_states($id = null) {
        $this->db->from('states');
        $this->db->order_by("name", "asc");
        if($id != null){
            $this->db->where("id", $id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Get the cities list rows
    public function get_cities($state_id) {
        $this->db->from('cities');
        $this->db->order_by("name", "asc");
        $this->db->where("state_id", $state_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
?>