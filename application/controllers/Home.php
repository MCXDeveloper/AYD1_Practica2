<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('model_login');
    }

	public function index() {

		if($this->model_login->is_logged() == TRUE) {
			$this->load->view('log/principal');
		}else{
			$this->load->view('no-log/principal');
		}

	}

	public function obtener_laptops() {

		$code = 0;
		$message = "No se realizo ninguna acción.";
		$datos = array();

		if($this->model_login->is_logged() == TRUE) {

			$get_resp = $this->model_login->obtener_productos();

			if($get_resp != FALSE) {
				$code = 1;
				$message = "Productos obtenidos correctamente.";
				$datos = $get_resp;
			}

		}else{
			$code = 2;
			$message = "No se realizo ninguna acción.  Reinicia tu sesión.";
		}

		$respuesta = array(
			'code' => $code,
			'message' => $message,
			'datos' => $datos
		);

		echo json_encode($respuesta);

	}

}
