<?php
Class Usuario extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Insert registration data in database
    public function signin_insert($data) {
        // Query to insert data in database
        $this->db->insert('users', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->get_user_by_param("email", $data["email"]);;
        }
        else{
            return false;
        }
    }

    // Update the user information
    public function update_user($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("users", $data);
    }

    // Read data using username and password
    public function login($data) {
        $this->db->from('users');
        $this->db->where("email", $data['username']);
        $this->db->where("password", $data['password']);
        $this->db->where("user_status !=", 2);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Get the user's roles
    public function get_roles() {
        $this->db->from('roles');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // Read data from database to show data in admin page
    public function get_user_by_param($param, $value, $limit = 1){
        $this->db->select("c.name as city_name, s.id as state_id, s.name as state_name, u.*");
        $this->db->from('users u');
        $this->db->join('cities c', 'u.city_id = c.id', 'left outer');
        $this->db->join('states s', 'c.state_id = s.id', 'left outer');
        $this->db->order_by('first_name', 'asc');
        $this->db->where($param, $value);
        $this->db->where('user_status !=', '2');
        if($limit > 0){
            $this->db->limit(1);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($limit == 0) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    public function update($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("users", $data);
    }
}
?>