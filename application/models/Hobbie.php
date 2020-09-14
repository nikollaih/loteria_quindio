<?php
Class Hobbie extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the hobbies rows
    // $id -> If id is different of null it will return only a row eith the hobbie id information
    public function get_hobbies($id = null) {
        $this->db->from('hobbies');
        $this->db->order_by("name", "asc");
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

    // Add a new hobbie
    // $data -> The hobbie data with id as null and name
    public function set_hobbie($data){
        return $this->db->insert('hobbies', $data);
    }

    // Update an existing hobbie
    // $data -> The new updated data with id and name
    public function update_hobbie($data){
        $this->db->where("id", $data["id"]);
        return $this->db->update("hobbies", $data);
    }

    // Delete a hobbie
    // $id -> Hobbie id the user wants to delete
    public function delete_hobbie($id){
        $this->db->where("id", $id);
        return $this->db->delete("hobbies");
    }

    public function set_user_hobbies($user_id, $hobbies){
        if(is_array($hobbies)){
            for ($i=0; $i < count($hobbies); $i++) { 
                $this->db->insert('users_hobbies',array("user_id" => $user_id, "hobby_id" => $hobbies[$i]));
            }
            return true;
        }
        else{
            return false;
        }
    }
}
?>