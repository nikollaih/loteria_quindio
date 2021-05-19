<?php
Class Draw extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->helper(["settings"]);
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

    // Get the draws rows
    // $id -> If id is different of null it will return only a row with the draw id information
    public function get_draws_winners($id = null) {
        $this->db->select('u.*, p.*, p.serie as purchase_serie, w.*, r.*, d.*');
        $this->db->from('draws d');
        $this->db->join('purchases p', 'p.id_draw = d.id');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->join('winners w', 'w.id_purchase = p.id_purchase');
        $this->db->join('rewards r', 'w.id_reward = r.id_reward');

        if($id != null && $id != "null"){
            $this->db->where("d.id", $id);
        }
        $this->db->order_by("w.id_reward");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
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
        $close_time = get_setting("close_draw_time");
        if(count(explode(":", $close_time)) == 2){
            $close_time = $close_time.":00";
        }

        $this->db->select('d.*, p.slug, p.fractions_count, p.fraction_value, p.product_name');
        $this->db->from("draws d");
        $this->db->join("products p", "d.product_id = p.id");
        $this->db->where("date >=", date("Y-m-d")." ".$close_time);
        $this->db->order_by("date", "asc");
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

     // Get the last played draw
     public function get_previous_draw(){
        $close_time = get_setting("close_draw_time");
        if(count(explode(":", $close_time)) == 2){
            $close_time = $close_time.":00";
        }

        $this->db->select('d.*, p.slug, p.fractions_count, p.fraction_value, p.product_name');
        $this->db->from("draws d");
        $this->db->join("products p", "d.product_id = p.id");
        $this->db->where("date <=", date("Y-m-d")." ".$close_time);
        $this->db->order_by("date", "desc");
        $this->db->limit(1);

        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }


    // returns cant of sold fractions in a draw
    public function get_sold_fractions($id) {
        $this->db->select("SUM(parts) as parts", FALSE);
        $this->db->from('purchases');
        $this->db->where("id_draw", $id);
      
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_sold_grouped_by_serie($id){
        $this->db->select("*");
        $this->db->from('purchases');
        $this->db->where("id_draw", $id);
        $this->db->group_by("serie");
      
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
?>