<?php
Class Withdraw extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the withdraws information
    public function get_withdraws($id_user = null, $id_withdraw = null) {
        $this->db->select('u.*, w.*, ws.*, it.name as identification_name');
        $this->db->from('withdraws w');
        $this->db->join('withdraw_status ws', 'w.status = ws.id_withdraw_status');
        $this->db->join('users u', 'w.id_user = u.id');
        $this->db->join('identification_types it', 'u.identification_type_id = it.id');
        $this->db->order_by('created_at', 'desc');

        if($id_withdraw != null){
            $this->db->where("w.id_withdraw", $id_withdraw);
        }

        if($id_user != null){
            $this->db->where("w.id_user", $id_user);
        }
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id_withdraw == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Get the withdraws information
    public function get_withdraws_by_dates($start_date, $end_date) {
        $this->db->select('u.*, w.*, ws.*, it.name as identification_name');
        $this->db->from('withdraws w');
        $this->db->join('withdraw_status ws', 'w.status = ws.id_withdraw_status');
        $this->db->join('users u', 'w.id_user = u.id');
        $this->db->join('identification_types it', 'u.identification_type_id = it.id');
        $this->db->order_by('created_at', 'desc');
        $this->db->where('w.created_at >=', $start_date." 00:00:00");
        $this->db->where('w.created_at <=', $end_date." 23:59:59");
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_withdraw_status($id = null){
        $this->db->from('withdraw_status');
        if($id != null){
            $this->db->where("id_withdraw_status", $id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    public function set($data){
        $this->db->insert("withdraws", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->get_withdraws(null, $this->db->insert_id());
        }
    }

    public function update($data){
        $this->db->where("id_withdraw", $data["id_withdraw"]);
        return $this->db->update("withdraws", $data);
    }
}
?>