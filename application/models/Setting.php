<?php
Class Setting extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the page settings
    public function get($key = null) {
        $this->db->from('settings');
        if($key){
            $this->db->where("key", $key);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($key) ? $query->row_array() : $query->result_array();
        } else {
            return false;
        }
    }

    public function set($setting){
        return $this->db->insert("setting");
    }   

    // Set a setting
    public function update($setting) {
        $this->db->where("key", $setting["key"]);
        return $this->db->update("settings", $setting);
    }
}
?>