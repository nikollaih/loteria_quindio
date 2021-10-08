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
            return $this->get_user_by_param("email", $data["email"]);
        }
        else{
            return false;
        }
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

    // Read data from database to show data in admin page
    public function get_user_by_dates($start_date, $end_date, $role = 2){
        $this->db->select("c.name as city_name, s.name as state_name, it.name as document_type, u.first_name, u.last_name, u.phone, u.address, u.birth_date, u.identification_number");
        $this->db->from('users u');
        $this->db->join('identification_types it', 'u.identification_type_id = it.id');
        $this->db->join('cities c', 'u.city_id = c.id');
        $this->db->join('states s', 'c.state_id = s.id');
        $this->db->order_by('first_name', 'asc');
        $this->db->where("u.created_at >=", $start_date);
        $this->db->where("u.created_at <=", $end_date);
        $this->db->where('user_status !=', '2');
        $this->db->where('u.roles_id', $role);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // Update the user information
    public function update($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("users", $data);
    }


    public function get_loto_points($id){
      $this->db->from('users');
      $this->db->order_by("id", "desc");
      if($id != null){
          $this->db->where("id", $id);
      }
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
          return ($id == null) ? $query->result_array() : $query->row_array()['lotto_points'];
      } else {
          return false;
      }
    }

    public function get_loto_points_by_slug($slug){
        $this->db->from('users');
        $this->db->order_by("id", "desc");
        if($slug != null){
            $this->db->where("slug", $slug);
        }
        $query = $this->db->get();
  
        if ($query->num_rows() > 0) {
            return ($slug == null) ? $query->result_array() : $query->row_array()['lotto_points'];
        } else {
            return false;
        }
      }

    public function substract_lotto_point($id, $action = "substract"){
      $this->db->set('lotto_points', (($action == "substract") ? $this->get_loto_points($id) - 1 : $this->get_loto_points($id) + 1));
      $this->db->where('id', $id);
      $this->db->update('users');
    }

    public function substract_lotto_point_by_slug($slug, $action = "substract"){
        $this->db->set('lotto_points', (($action == "substract") ? $this->get_loto_points_by_slug($slug) - 1 : $this->get_loto_points_by_slug($slug) + 1));
        $this->db->where('slug', $slug);
        $this->db->update('users');
      }

    // Set the lotto points to 0
    public function clear_lotto_points($id = null){
        $this->db->set('lotto_points', 0);
        if($id != null){
            $this->db->where('id', $id);
        }
        $this->db->update('users');
    }
}
?>