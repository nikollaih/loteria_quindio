<?php
Class Reward extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get a purchase reward
    public function get_rewards($id_reward = null) {
        $this->db->from('rewards');
        if($id_reward){
            $this->db->where("id_reward", $id_reward);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id_reward) ? $query->row_array() : $query->result_array();
        } else {
            return false;
        }
    }

    // Set a new reward
    public function update_reward($data) {
        $this->db->where("id_reward", $data["id_reward"]);
        return $this->db->update("rewards", $data);
    }
}
?>