<?php
  Class GameProduct extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the game products or just a product by id
    function get($id = null, $status = null, $limit = null){
        $this->db->from("game_products");
        if($id != null){
            $this->db->where("id_game_product", $id);
        }
        if($status != null){
            $this->db->where("g_product_status", $status);
        }
        if($limit != null){
            $this->db->limit($limit);
        }

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return ($id != null) ? $result->row_array() : $result->result_array();
        }
        else{
            return false;
        }
    }


    function get_availables($id = null, $status = null, $limit = null){
        $this->db->from("game_products");
        if($id != null){
            $this->db->where("id_game_product", $id);
        }
        if($status != null){
            $this->db->where("g_product_status", $status);
        }
        if($limit != null){
            $this->db->limit($limit);
        }

        $this->db->where("g_product_quantity > 0");

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return ($id != null) ? $result->row_array() : $result->result_array();
        }
        else{
            return false;
        }
    }

    // Insert a new game product
    function set($product){
        $this->db->insert("game_products", $product);
        return $this->get($this->db->insert_id());
    }

    // Update a game product
    function update($product){
        $this->db->where("id_game_product", $product["id_game_product"]);
        $this->db->update("game_products", $product);
        return $this->get($product["id_game_product"]);
    }

    // Delete a game product
    function delete($id){
        $this->db->where("id_game_product", $id);
        return $this->db->delete("game_products");
    }


    function winner_salt(){
      return 'fb33052424200cdf15078337d2334490-b4976f78d42ce18b5628bf23571de217';
    }
  }
?>