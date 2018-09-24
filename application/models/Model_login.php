<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function is_logged() {
        if(isset($this->session->userdata['usr_correo'])){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function verificar_login($correo, $contraseña) {

        $data = array(
            'correo' => $correo,
            'pass' => $contraseña
        );

        $query = $this->db->get_where('usuario', $data);

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return FALSE;
        }

    }

}
