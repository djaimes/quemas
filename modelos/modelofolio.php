<?php

/***
*   Modelo Folio
*/

require_once(SERVER_ROOT . '/librerias/drivers/' . 'postgresqldriver.php');

class ModeloFolio
{

  private $db;

  public function __construct(){
    $this->db = new PostgreSQLDriver;
  }

  public function getResultadoFolio(array $getVars){

    $this->db->connect();

    $sql = "INSERT INTO folio (origen, comentario) VALUES('{$getVars['origen']}', '{$getVars['comentario']}')";
    $this->db->prepare($sql);

    $ret = $this->db->query();
    if(!$ret) {
      $folio = "foo" . $ret;
    } else {
      $folio = "foo" . $ret;
    } 

    $this->db->disconnect();

    return $folio;
  }
}
?>
