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

	public function cerrar_sesion() {

		$this->session->sess_destroy();

		$respuesta = array(
			'code' => 1
		);

		echo json_encode($respuesta);

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

	public function registrar_pedido() {

		$code = 0;
		$message = "No se realizo ninguna acción.";

		if($this->model_login->is_logged() == TRUE) {

			$datos = $this->input->post('datos');
			$datos_obtenidos = json_decode($datos);

			//Obtengo el id del usuario que esta haciendo la compra
			$correo_usuario = $this->session->userdata['usr_correo'];

			$usr_resp = $this->model_login->obtener_usuario($correo_usuario);

			if($usr_resp != FALSE) {

				//Hago el registro del pedido con la fecha actual
				date_default_timezone_set('America/Guatemala');
	        	$fecha_actual_mysql = date("Y-m-d");

				$datos = array(
					'fecha' => $fecha_actual_mysql,
					'usuario_id_usuario' => $usr_resp->id_usuario
				);

				$ins_resp = $this->model_login->registrar_pedido($datos);

				if($ins_resp != FALSE) {

					//Ahora procedo a registrar los productos relacionados a este pedido.
					foreach ($datos_obtenidos as $k => $v) {

						$pedido_data = array(
							'cantidad' => $v->cantidad,
							'producto_id_producto' => $v->id,
							'pedido_id_pedido' => $ins_resp,
							'pedido_usuario_id_usuario' => $usr_resp->id_usuario
						);

						$new_ins_resp = $this->model_login->registrar_productos_pedido($pedido_data);

					}

					$code = 1;
					$message = "Pedido registrado correctamente.";

				}else{
					$message = "No se pudo registrar el pedido.  Intente de nuevo mas tarde.";
				}

			}else{
				$message = "No se pudo obtener al usuario.  Intente de nuevo mas tarde.";
			}

		}else{
			$code = 2;
			$message = "No se realizo ninguna acción.  Reinicia tu sesión.";
		}

		$respuesta = array(
			'code' => $code,
			'message' => $message
		);

		echo json_encode($respuesta);

	}

	public function obtener_datos_extra() {

		$code = 0;
		$message = "No se realizo ninguna acción.";

		if($this->model_login->is_logged() == TRUE) {

			//Obtengo la informacion del usuario
			$correo_usuario = $this->session->userdata['usr_correo'];

			$usr_resp = $this->model_login->obtener_usuario($correo_usuario);

			$code = 1;
			$message = $usr_resp;

		}else{
			$code = 2;
			$message = "No se realizo ninguna acción.  Reinicia tu sesión.";
		}

		$respuesta = array(
			'code' => $code,
			'message' => $message
		);

		echo json_encode($respuesta);

	}

	public function actualizar_data_usuario() {

		$code = 0;
		$message = "No se realizo ninguna acción.";

		if($this->model_login->is_logged() == TRUE) {

			//Obtengo la informacion del usuario
			$correo_usuario = $this->session->userdata['usr_correo'];

			$direccion = $this->input->post('direccion');
			$tarjeta_credito = $this->input->post('tarjeta_credito');

			$datos = array(
				'direccion' => $direccion,
				'tarjeta_credito' => $tarjeta_credito
			);

			$condicion = array('correo' => $correo_usuario);

			$up_resp = $this->model_login->actualizar_datos_usuario($datos, $condicion);

			if($up_resp != FALSE) {
				$code = 1;
				$message = "Información actualizada correctamente.";
			}else{
				$message = "No se pudo actualizar la información o la información es la misma y no hay que actualizar nuevamente.";
			}

		}else{
			$code = 2;
			$message = "No se realizo ninguna acción.  Reinicia tu sesión.";
		}

		$respuesta = array(
			'code' => $code,
			'message' => $message
		);

		echo json_encode($respuesta);

	}

	/*FUNCION PARA RESETEAR PASSWORD DE USUARIO*/
	public function reset_password()
	{
		$code = 0; // CODIGO DE RESPUESTA
		$message = "no se reseteo el password";

		if($this->model_login->is_logged() == TRUE)
		{
			$correo_usuario = $this->session->userdata['usr_correo'];

			$nuevo = $this->input->post('password');

			$datos = array(
				'pass' => $nuevo
			);

			$condicion = array('correo' => $correo_usuario);
			
			$resp = $this->model_login->actualiza_password($datos, $condicion);

			if($resp == TRUE)
			{
				$code = 1;
				$message = "Cambio de Password realizado exitosamente!";
			}
			else
			{
				$message = "Error, no se pudo cambiar el Password!";
			}
		}
		else
		{
			$code = 2;
			$message = "Para realizar esta accion debes iniciar sesion!";
		}

		$respuesta = array(
			'code' => $code,
			'message' => $message
		);

		echo json_encode($respuesta);

	}

}
