
<?php
// CalculatorTest.php
require('vendor/autoload.php');
use GuzzleHttp\Client;
class FinalTest extends \PHPUnit_Framework_TestCase {

    protected $client;

    protected function setUp()
    {
        
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost'
        ]);
    }

 

    public function testStatusRoute(){

        $response = $this->client->post('/AYD1_Practica2/home/reset_password', [
            'json' => [
                'password'    => '123'
            ]
        ]); 
        //Prueba Exitosa Prueba
        $this->assertEquals(200, $response->getStatusCode());
    }


    public function testStatus2(){

        $response = $this->client->post('/AYD1_Practica2/home/actualizar_data_usuario'); 
        //Prueba
        $this->assertEquals(500, $response->getStatusCode());
    }

    //Prueba de Correo Inexistente
    public function testCorreoInexistente()
    {
        $response = $this->client->post('/AYD1_Practica2/login',[
            'json' => [
                'correo'    => 'marvin@marvin.com',
                'password'  => '123456'
            ]
        ]);
    }
 
}
