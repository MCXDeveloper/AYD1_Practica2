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

    public function obtener_usuario($correo) {

        $query = $this->db->get_where('usuario', array('correo' => $correo));

        if($query->num_rows() > 0){
            return $query->row();
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

    public function obtener_productos() {

        $query = $this->db->get_where('producto');

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }

    }

    public function registrar_pedido($datos) {

        $query = $this->db->insert('pedido', $datos);

        if ($this->db->affected_rows() == '1'){
            return $this->db->insert_id();
        }else{
            return FALSE;
        }

    }

    public function registrar_productos_pedido($datos) {

        $query = $this->db->insert('detalle_pedido', $datos);

        if ($this->db->affected_rows() == '1'){
            return $this->db->insert_id();
        }else{
            return FALSE;
        }

    }

    public function actualizar_datos_usuario($datos, $condicion) {

        $query = $this->db->update('usuario', $datos, $condicion);

        if ($this->db->affected_rows() == '1'){
            return TRUE;
        }else{
            return FALSE;
        }

    }

}
