<?php

/***
*   Modelo Reporte
*/

require_once(SERVER_ROOT . '/librerias/drivers/' . 'postgresqldriver.php');

class ModeloReporte
{
  private $db;

  public function __construct(){
    $this->db = new PostgreSQLDriver;
  }

  public function getResultadoReporte(array $getVars){
    $this->db->connect();

    $sql = "INSERT INTO reporte(correo, latitud, longitud) VALUES('{$getVars['correo']}', {$getVars['latitud']}, {$getVars['longitud']}) returning id";
    $this->db->prepare($sql);
    $ret = $this->db->query();

    if(!$ret) {
       $folioReporte = $ret;
    } else {
       $folioReporte = $ret;
    }
    
    $this->db->disconnect();

    echo $folioReporte;
  }
}
?>
