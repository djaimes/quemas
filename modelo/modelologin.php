<?php

/***
*   Modelo Login
*/

require_once(SERVER_ROOT . '/librerias/drivers/' . 'mysqldriver.php');

class ModeloLogin
{

  private $db;

  public function __construct(){
    $this->db = new MySQLDriver;
  }

  public function getResultadoLogin(array $getVars){

    $this->db->connect();

    $sql = "SELECT * FROM usuario WHERE login = '{$getVars['usuario']}' AND contrasena = '{$getVars['contrasena']}'";
    $this->db->prepare($sql);

    $this->db->query();

    if ($this->db->result->num_rows > 0) {
      // El login si existe
      $resultadoLogin = $this->db->fetch('array');
      $nombreDeUsuario = $resultadoLogin['nombre'];
    }else {
      // El login no existe
      $nombreDeUsuario = "denegado";
    }

    $this->db->disconnect();

    return $nombreDeUsuario;
  }
}
?>
