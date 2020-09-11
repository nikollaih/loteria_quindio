<?php
Class Hobbie extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the hobbies rows
    public function get_hobbies() {
        $this->db->from('hobbies');
        $this->db->order_by("name", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function set_hobbie($data){
        return $this->db->insert('hobbies', $data);
    }
}
?>