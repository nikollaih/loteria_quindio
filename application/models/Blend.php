<?php
Class Blend extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the blends rows
    // $id -> If id is different of null it will return only a row with the blend id information
    public function get_blends($serie = null, $id = null) {
        $this->get_all();
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

    // Get the blends rows by number
    public function get_blends_by_number($number) {
        $this->db->select("serie");
        $this->db->from('blends');
        $this->db->order_by("serie", "asc");
        $this->db->like('blend_numbers', $number, 'both');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return$query->result_array();
        } else {
            return [];
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
        $this->db->where("blend_status", 1);

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? true : false;
    }

    // Save the blends rows
    public function set_blends($data) {
        return $this->db->insert_batch('blends', $data); 
    }

    public function get_all(){
        $this->db->select("SUM(numbers_quantity) as sum");
        $this->db->from('blends');
        $query = $this->db->get();
    }

    public function delete_blends(){
        $this->db->where("id >", 0);
        $this->db->delete("blends");
    }
}
?>