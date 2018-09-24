<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TST_R extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('model_login');
  }


  public function index()
  {
    $this->load->library('unit_test');
    // INICIA EL TEST DEL LOG IN DONDE ESPERO UN FALSO
    $this->testing_login_method();
    // INICIA EL TEST DE PRODUTOS Y ESPERO UN ARREGLO
    $this->testing_product_method();
    // INICIA EL TEST DE OBTENER UN USUARIO
    $this->testing_get_user_method();
    // METODO DE registro
    $this->testing_retgistrarp_method();
    //METODO DE REGISTRO PEDIOD
    $this->testing_registrar_p_method();
  }


  public function testing_login_method()
  {
    $resultado = FALSE;
    $nombre = "Prueba al llamado de metodo: verificar_login";
    echo "<center><h1> Test de Llamado al metodo: verificar_login</h1></center><br>";
    echo $this->unit->run($this->model_login->verificar_login("NAN", "NAN"), $resultado, $nombre, 'Verificacion de que devuelva un Booleano');
    echo "<br>";
  }

  public function testing_product_method()
  {
    $resultado = 'is_array';
    $nombre = "Prueba de llamado al metodo: obtener_productos";
    echo "<center><h1> Test de Llamado al metodo: obtener_productos</h1></center><br>";
    echo $this->unit->run($this->model_login->obtener_productos(), $resultado, "Verificacion de que devuelva un Arreglo");
    echo "<br>";
  }

  public function testing_get_user_method()
  {
    $resultado = FALSE;
    $nombre = "Prueba de llamado al metodo: obtener_usuario";
    echo "<center><h1> Test de Llamado al metodo: obtener_usuario</h1></center><br>";
    echo $this->unit->run($this->model_login->obtener_usuario("NAN"), $resultado, "Verificacion de que devuelva UN Booelano ya que el usuario no existe!");
    echo "<br>";
  }

  public function testing_retgistrarp_method()
  {
    $datos = array(
      'cantidad' => 1,
      'usuario_Id_usuario' => 1,
      'producto_Id_producto' => 1
    );

    $resultado = 'is_int';
    $nombre = "Prueba de registro de pedido";
    echo "<center><h1> Test de Llamado al metodo: registro_producto</h1></center><br>";
    echo $this->unit->run($this->model_login->registrar_pedido($datos), $resultado, "Verficcacion de registro de pedidos");
    echo "<br>";
  }

  public function testing_registrar_p_method()
  {
    $datos = array(
      'cantidad' => 1,
      'pedido_Id_pedido' => 1,
      'producto_Id_producto' => 1,
      'pedido_usuario_id_usuario' => 1
    );
    $resultado = 'is_int';
    echo "<center><h1> Test de Llamado al metodo: registro_producto_pedido</h1></center><br>";
    echo $this->unit->run($this->model_login->registrar_productos_pedido($datos), $resultado, "Verficcacion de registro de pedidos");
    echo "<br>";
  }

}
