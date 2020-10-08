<?php
Class Draw extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the draws rows
    // $id -> If id is different of null it will return only a row with the draw id information
    public function get_draws($id = null, $number = null, $slug = null) {
        $this->db->select('d.*, p.slug, p.fractions_count, p.fraction_value, p.product_name, r.nit');
        $this->db->from('draws d');
        $this->db->join('products p', 'p.id = d.product_id', 'left outer');
        $this->db->join('results r', 'd.id = r.id_draw', 'left outer');
        $this->db->order_by("date", "desc");
        $this->db->group_by("d.id");
        if($number != null && $number != "null"){
            $this->db->where("d.draw_number", $number);
        }
        if($id != null && $id != "null"){
            $this->db->where("d.id", $id);
        }
        if($slug != null && $slug != "null"){
            $this->db->where("d.draw_slug", $slug);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id == null && $number == null && $slug == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Add a new draw
    // $data -> The draw data with id as null and name
    public function set_draw($data){
        return $this->db->insert('draws', $data);
    }

    // Update an existing draw
    // $data -> The new updated data with id and name
    public function update_draw($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("draws", $data);
    }

    // Delete a new draw
    // $data -> The draw data with id as null and name
    public function delete_draw($id){
        $this->db->where("id", $id);
        return $this->db->delete('draws', $data);
    }

    // Get the current draw
    public function get_active_draw(){
        $this->db->select('d.*, p.slug, p.fractions_count, p.fraction_value, p.product_name');
        $this->db->from("draws d");
        $this->db->join("products p", "d.product_id = p.id");
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