<?php
Class Blend extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the blends rows
    // $id -> If id is different of null it will return only a row with the blend id information
    public function get_blends($serie = null, $id = null) {
        $this->db->from('blends');
        $this->db->order_by("serie", "asc");
        if($serie != null){
            $this->db->where("serie", $serie);
        }
        if($id != null){
            $this->db->where("id", $id);
        }
        $this->db->where("blend_status !=", "2");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($serie == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Add a new blend
    // $data -> The blend data with id as null and name
    public function set_blend($data){
        return $this->db->insert('blends', $data);
    }

    // Update an existing blend
    // $data -> The new updated data with id and name
    public function update_blend($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("blends", $data);
    }

    // Validate if a same exists
    public function validate_blend($data){
        $this->db->from('blends');
        $this->db->where("start_number", $data["start_number"]);
        $this->db->where("end_number", $data["end_number"]);
        $this->db->where("serie", $data["serie"]);

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? true : false;
    }
}
?>