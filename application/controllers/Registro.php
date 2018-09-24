<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('model_registro');
    }

	public function index(){

        $code_resp = 0;
        $mesg_resp = "No se realizó ninguna acción";

        $correo = $this->input->post('correo');
        $contraseña = $this->input->post('password');

        if($correo && $contraseña) {

            // Primero verifico si el usario no existe
            $get_resp = $this->model_registro->verificar_existencia($correo);

            if($get_resp == FALSE) {

                // Como el usuario no existe, procedo a registrarlo
                $ins_resp = $this->model_registro->registrar_usuario($correo, $contraseña);

                if($ins_resp != FALSE) {

                    $code_resp = 1;
                    $mesg_resp = "Usuario registrado correctamente.";

                    // Guardo su correo en las variables de sesión
                    $this->session->set_userdata(array('usr_correo' => $correo));

                }else{
                    $mesg_resp = "No se pudo registrar el usuario, intente de nuevo más tarde.";
                }

            }else{
                $mesg_resp = "El usuario proporcionado ya se encuentra registrado.";
            }

        }else{
            $mesg_resp = "Ocurrió un error al obtener los datos para registrarlos.  Intente de nuevo más tarde.";
        }

        $respuesta = array(
            'code' => $code_resp,
            'message' => $mesg_resp
        );

        echo json_encode($respuesta);

	}

}
