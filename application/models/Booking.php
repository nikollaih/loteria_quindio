<?php
Class Booking extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the bookings rows
    // $data -> Array that contains the booking information (number, draw, serie)
    public function get_bookings($data) {
        $this->db->from('booking');
        if(isset($data["serie"])){
            $this->db->select("number");
            $this->db->where("serie", $data["serie"]);
        }
        if(isset($data["number"])){
            $this->db->select("serie");
            $this->db->where("number", $data["number"]);
        }
        $this->db->where("id_draw", $data["id_draw"]);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function get_old_booking($date){
        $this->db->from("booking");
        $this->db->where("created_at <=", $date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // Add a new booking
    // $data -> The booking data with id as null and name
    public function set_booking($data){
        return $this->db->insert('booking', $data);
    }

    public function clear_booking($date){
        $this->db->where("created_at <=", $date);
        return $this->db->delete("booking"); 
    }
}
?>