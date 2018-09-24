<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UT_Registro extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
	      $this->load->library("unit_test");
        $this->load->model('model_registro');
    }
	  public function index(){
			$this->pruebaCorreoInexistente();
      $this->pruebaCorreoExistente();
      $this->pruebaRegistrarUsuarioExistente();
      $this->pruebaRegistrarUsuarioInexistente();

    }

    public function pruebaCorreoInexistente(){
      echo "Probando correo Inexistente";
      $correo = "javier@marvin.com ";
      $prueba = $this->model_registro->verificar_existencia($correo);
      $expected_result = FALSE;
      $test_name = "Prueba verificar_existencia (correo inexistente)";
      echo $this->unit->run($prueba, $expected_result, $test_name);
    }
    public function pruebaCorreoExistente(){
      echo "Probando correo Existente";
      $correo = "marvin@marvin.com ";
      $prueba = $this->model_registro->verificar_existencia($correo);
      $expected_result = 'is_object';
      $test_name = "Prueba verificar_existencia (correo existente)";
      echo $this->unit->run($prueba, $expected_result, $test_name);
    }
    public function pruebaRegistrarUsuarioExistente(){
      $correo = "marvin@marvin.com ";
      $password = "1234";
      echo "Registrar correo existente";
      $prueba = $this->model_registro->registrar_usuario($correo, $password);
      $expected_result = FALSE;
      $test_name = "Prueba registrar usuario existente";
      echo $this->unit->run($prueba, $expected_result, $test_name, "Si el correo está registrado no deberia guardar el usuario");
    }
    public function pruebaRegistrarUsuarioInexistente(){
      $correo = "rolf.hegdal@example.com";
      $password = "1234";
      echo "Registrar nuevo usuario";
      $prueba = $this->model_registro->registrar_usuario($correo, $password);
      $expected_result = 'is_numeric';
      $test_name = "Prueba registrar nuevo usuario";
      echo $this->unit->run($prueba, $expected_result, $test_name);
    }
}
