<?php
// DEvoluciones
Class ToReturn extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    
    // Add a new to_return: Devoluciones
    // $data -> The purchase data with id as null and name
    public function set_return($data){
        return $this->db->insert('to_return', $data);
    }

    public function get_return($id_draw = null) {
      $this->db->select('*');
      $this->db->from('to_return');
      if($id_draw != null){
          $this->db->where("id_draw", $id_draw);
      }
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
          return ($id_draw == null) ? $query->result_array() : $query->row_array();
      } else {
          return false;
      }
  }

}
?>