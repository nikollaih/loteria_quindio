<?php
Class Purchase extends CI_Model {
    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Get the purchases rows
    // $id -> If id is different of null it will return only a row with the purchase id information
    public function get_purchases($id = null) {
        $this->db->select('pro.*, u.*, u.slug as user_slug, c.name as city, s.name as state, sub.*, sub.created_at, d.draw_number, d.date, p.*, p.created_at as purchase_date, it.it_code');
        $this->db->from('purchases p');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->join('identification_types it', 'u.identification_type_id = it.id');
        $this->db->join('cities c', 'u.city_id = c.id', 'left outer');
        $this->db->join('states s', 'c.state_id = s.id', 'left outer');
        $this->db->join('draws d', 'p.id_draw = d.id', 'left outer');
        $this->db->join('products pro', 'pro.id = d.product_id', 'left outer');
        $this->db->join('subscribers sub', 'p.id_purchase = sub.id_purchase', 'left outer');
        $this->db->order_by("p.id_purchase", "desc");
        if($id != null){
            $this->db->where("p.id_purchase", $id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($id == null) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    public function get_sold_numbers($id_draw, $serie = null) {
        $this->db->select("number");
        $this->db->from('purchases');
        $this->db->where("id_draw", $id_draw);
        if($serie != null){
            $this->db->where("serie", $serie);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_sold_blends($id_draw, $number = null) {
        $this->db->select("serie");
        $this->db->from('purchases');
        $this->db->where("id_draw", $id_draw);
        if($number != null){
            $this->db->where("number", $number);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_sold_numbers_with_serie($id_draw, $serie = null) {
        $this->db->select("number, serie, cities.dane_id as city_dane_id");
        $this->db->from('purchases');
        $this->db->join('users', 'users.id = purchases.id_user');
        $this->db->join('cities', 'cities.id = users.city_id');
        $this->db->where("id_draw", $id_draw); 
        $this->db->where("purchase_status", 'APPROVED'); 
        if($serie != null){
            $this->db->where("serie", $serie);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_sold_numbers_array($id_draw, $serie = null) {
        $this->db->select("number");
        $this->db->from('purchases');
        $this->db->where("id_draw", $id_draw);
        if($serie != null){
            $this->db->where("serie", $serie);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $return = array();

            foreach ($query->result_array() as $row) {
                array_push($return, $row['number']);
            }
            return $return;
        } else {
            return array();
        }
    }

    // Add a new purchase
    // $data -> The purchase data with id as null and name
    public function set_purchase($data){
        $this->db->insert('purchases', $data);
        return $this->get_purchases($this->db->insert_id());
    }

    // Update an existing purchase
    // $data -> The new updated data with id and name
    public function update_purchase($data){
        $this->db->where("id_purchase", $data["id_purchase"]);
        return $this->db->update("purchases", $data);
    }

    // Validate if a same exists
    public function validate_purchase($data){
        $this->db->from('purchases');
        $this->db->where("id_draw", $data["id_draw"]);
        $this->db->where("number", $data["number"]);
        $this->db->where("serie", $data["serie"]);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // Get the cant of parts sold
    public function get_product_sold_parts($data){
        $this->db->select("SUM(parts) as parts", FALSE);
        $this->db->from('purchases');
        $this->db->where("id_draw", $data["id_draw"]);
        $this->db->where("number", $data["number"]);
        $this->db->where("serie", $data["serie"]);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // Get the user's purchases list
    // id_user -> The user identification to get his/her purchases list
    public function get_user_purchases($id_user){
        $this->db->select('pro.*, u.*, u.slug as user_slug, c.name as city, s.name as state, sub.*, sub.created_at, d.draw_number, d.date, p.*, p.created_at as purchase_date');
        $this->db->from('purchases p');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->join('cities c', 'u.city_id = c.id', 'left outer');
        $this->db->join('states s', 'c.state_id = s.id', 'left outer');
        $this->db->join('draws d', 'p.id_draw = d.id', 'left outer');
        $this->db->join('products pro', 'pro.id = d.product_id', 'left outer');
        $this->db->join('subscribers sub', 'p.id_purchase = sub.id_purchase', 'left outer');
        $this->db->where("p.id_user", $id_user);
        $this->db->order_by("p.created_at", "desc");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // Read data from database to show data in admin page
    public function get_purchase_by_param($param, $value, $limit = 1, $status = null){
        $this->db->select('pro.*, u.*, u.slug as user_slug, c.name as city, s.name as state, sub.*, sub.created_at, d.draw_number, d.date, p.*, p.created_at as purchase_date');
        $this->db->from('purchases p');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->join('cities c', 'u.city_id = c.id', 'left outer');
        $this->db->join('states s', 'c.state_id = s.id', 'left outer');
        $this->db->join('draws d', 'p.id_draw = d.id', 'left outer');
        $this->db->join('products pro', 'pro.id = d.product_id', 'left outer');
        $this->db->join('subscribers sub', 'p.id_purchase = sub.id_purchase', 'left outer');
        $this->db->order_by('p.created_at', 'desc');
        $this->db->where($param, $value);
        if($limit > 0){
            $this->db->limit(1);
        }
        if($status != null){
            $this->db->where("purchase_status", $status);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return ($limit == 0) ? $query->result_array() : $query->row_array();
        } else {
            return false;
        }
    }

    // Delete a product
    // $id -> Purchase id the user wants to delete
    public function delete_purchase($id){
        $this->db->where("id_purchase", $id);
        return $this->db->delete("purchases");
    }

    // Get the purchases rows by dates
    // $id -> If id is different of null it will return only a row with the purchase id information
    public function get_purchases_by_dates($start_date = null, $end_date = null, $state = -1, $dates = false, $price = false, $discount = false) {
        // Define the initial and end date
        if($start_date == null){
            $start_date = date("Y-m-").'01';
        }
        if($end_date == null){
            $end_date = date("Y-m-d");
        }

        // Check if any state was seected
        if($state > 0){
            $this->db->select('pro.*, u.*, u.slug as user_slug, c.name as report_description, s.name as state, sub.*, sub.created_at, d.draw_number, d.date, p.*, p.created_at as purchase_date, SUM(p.price) as price_sum, SUM(p.discount) as discount_sum, , SUM(p.bills) as bills');
            $this->db->where("s.id", $state);
            $this->db->group_by("c.id");
        }

        if($state == 0){
            $this->db->select('pro.*, u.*, u.slug as user_slug, c.name as city, s.name as report_description, sub.*, sub.created_at, d.draw_number, d.date, p.*, p.created_at as purchase_date, SUM(p.price) as price_sum, SUM(p.discount) as discount_sum, SUM(p.bills) as bills');
            $this->db->group_by("s.id");
        }

        if($state == -1){
            $this->db->select('pro.*, u.*, u.slug as user_slug, c.name as city, s.name as state, sub.*, sub.created_at, d.draw_number, d.date, p.*, p.created_at as purchase_date');
        }
       
        $this->db->from('purchases p');
        $this->db->join('users u', 'u.id = p.id_user');
        $this->db->join('cities c', 'u.city_id = c.id', 'left outer');
        $this->db->join('states s', 'c.state_id = s.id', 'left outer');
        $this->db->join('draws d', 'p.id_draw = d.id', 'left outer');
        $this->db->join('products pro', 'pro.id = d.product_id', 'left outer');
        $this->db->join('subscribers sub', 'p.id_purchase = sub.id_purchase', 'left outer');
        $this->db->order_by("p.id_purchase", "desc");
        $this->db->where('p.created_at >=', $start_date." 00:00:00");
        $this->db->where('p.created_at <=', $end_date." 23:59:59");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
?>