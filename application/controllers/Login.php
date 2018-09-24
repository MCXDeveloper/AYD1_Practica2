<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_login');
    }

	public function index(){

        $code_resp = 0;
        $mesg_resp = "No se realizó ninguna acción";

        $correo = $this->input->post('correo');
        $contraseña = $this->input->post('password');

        if($correo && $contraseña) {

            // Verifico si el usuario con las credenciales existe
            $get_resp = $this->model_login->verificar_login($correo, $contraseña);

            if($get_resp != FALSE) {

                $code_resp = 1;
                $mesg_resp = "Usuario correcto.";

                // Guardo su correo en las variables de sesión
                $this->session->set_userdata(array('usr_correo' => $correo));

            }else{
                $mesg_resp = "El usuario proporcionado no se encuentra registrado.";
            }

        }else{
            $mesg_resp = "Ocurrió un error al obtener los datos para iniciar sesión.  Intente de nuevo más tarde.";
        }

        $respuesta = array(
            'code' => $code_resp,
            'message' => $mesg_resp
        );

        echo json_encode($respuesta);

	}

}
