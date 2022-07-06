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

    $sql = "INSERT INTO folio (origen, comentario) VALUES('{$getVars['origen']}', '{$getVars['comentario']}') returning id";
    $this->db->prepare($sql);

    $ret = $this->db->query();

    if (pg_num_rows($this->db->result) > 0) {     
 	$folios = $this->db->fetch('array');
 	$folio = $folios['id'];
    }else {
 	$folio = "No-Folio";
    }

    $this->db->disconnect();

    return $folio;
  }
}
?>
