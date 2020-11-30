<?php
Class ProductWinner extends CI_Model {
  function __construct(){        
      parent::__construct();
      $this->load->database();
  }

  public function get_product_winners($id = null) {
    $this->db->select('u.first_name, u.last_name, gp.g_product_name, pw.*');
    $this->db->from('product_winners pw');
    $this->db->join('users u', 'pw.user_id = u.id');
    $this->db->join('game_products gp', 'gp.id_game_product = pw.product_id');
    $this->db->order_by("pw.id", "desc");
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return ($id == null) ? $query->result_array() : $query->row_array();
    } else {
        return false;
    }
  }

  public function get_product_winners_by_status($status) {
    $this->db->from('product_winners');
    $this->db->order_by("id", "desc");
    $this->db->where("status", $status);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return ($id == null) ? $query->result_array() : $query->row_array();
    } else {
        return false;
    }
  }

  public function get_product_winners_by_slug($slug) {
    $this->db->from('product_winners');
    $this->db->order_by("id", "desc");
    $this->db->where("slug", $slug);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return ($id == null) ? $query->result_array() : $query->row_array();
    } else {
        return false;
    }
  }


  public function set_product_winners($data){
      return $this->db->insert('product_winners', $data);
  }


  public function update_product_winners($data){
      $this->db->where("id", $data["id"]);
      return $this->db->update("product_winners", $data);
  }

  public function get_points_for_play($user_id){

  }
}
?>