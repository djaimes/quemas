<?php

/***
*   Modelo Login
*/

require_once(SERVER_ROOT . '/librerias/drivers/' . 'postgresqldriver.php');

class ModeloLogin
{

  private $db;

  public function __construct(){
    $this->db = new PostgreSQLDriver;
  }

  public function getResultadoLogin(array $getVars){

    $this->db->connect();

    $sql = "SELECT * FROM usuario WHERE login = '{$getVars['usuario']}' AND contrasena = '{$getVars['contrasena']}'";

    //print_r($sql);
    
    $this->db->prepare($sql);

    $this->db->query();

    if (pg_num_rows($this->db->result) > 0) {
      // El login si existe
      $resultadoLogin = $this->db->fetch('array');
      $nombreDeUsuario = $resultadoLogin['nombre'];
    }else {
      $nombreDeUsuario = "Acceso denegado";
    }

    $this->db->disconnect();

    return $nombreDeUsuario;
  }
}
?>
