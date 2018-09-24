<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_registro extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function verificar_existencia($correo) {

        $data = array(
            'correo' => $correo
        );

        $query = $this->db->get_where('usuario', $data);

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return FALSE;
        }

    }

    public function registrar_usuario($correo, $contraseña) {

        $data = array(
            'correo' => $correo,
            'pass' => $contraseña
        );

        $query = $this->db->insert('usuario', $data);

        if ($this->db->affected_rows() == '1'){
            return $this->db->insert_id();
        }else{
            return FALSE;
        }

    }

}
