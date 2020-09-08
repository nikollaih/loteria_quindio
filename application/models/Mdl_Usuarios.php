<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Usuarios extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }

    // Obtiene la lista de todos los usuarios registrados en la BD
    function obtenerUsuarios(){
		$this->db->from('usuarios');
        $result = $this->db->get();
		return ($result->num_rows() > 0) ? $result->row_array() : false;
	}
}