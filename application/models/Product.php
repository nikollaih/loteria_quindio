<?php
Class Product extends CI_Model {
  function __construct(){        
      parent::__construct();
      $this->load->database();
  }

  // Get the products rows
  // $id -> If id is different of null it will return only a row with the product id information
  public function get_products($id = null) {
    $this->db->from('products');
    $this->db->order_by("id", "desc");
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

  // Add a new product
  // $data -> The product data with id as null
  public function set_product($data){
      return $this->db->insert('products', $data);
  }

  // Update an existing product
  // $data -> The new updated data with id
  public function update_product($data){
      $this->db->where("id", $data["id"]);
      return $this->db->update("products", $data);
  }

  // Delete a product
  // $id -> Product id the user wants to delete
  public function delete_product($id){
    $this->db->where("id", $id);
    return $this->db->delete("products");
  }

  // Validate if a same exists
  public function validate_product($data){
      $this->db->from('products');
      $this->db->where("fractions_count", $data["fractions_count"]);
      $this->db->where("faction_value", $data["faction_value"]);

      $query = $this->db->get();

      if ($query->num_rows() > 0) {
          return $query->row_array();
      } else {
          return false;
      }
  }
}
?>