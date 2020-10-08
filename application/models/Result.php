<?php
Class Result extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Save the result rows
    public function set_results($data) {
        return $this->db->insert_batch('results', $data); 
    }

    // Get the result by draw
    public function get_results($id_draw = null) {
        $this->db->from('results r');
        $this->db->join('draws d', 'd.id = r.id_draw', 'left outer');
        $this->db->order_by("r.id_result", "asc");
        $this->db->where("r.id_draw", $id_draw);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
?>