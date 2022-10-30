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

    $sql = "INSERT INTO reporte(ubicacion, correo,latitud,longitud,folio) 
            VALUES(ST_SetSrid(ST_MakePoint({$getVars['longitud']},{$getVars['latitud']}),4326),
            '{$getVars['correo']}', {$getVars['latitud']}, {$getVars['longitud']}, 
            {$getVars['folio']}) returning id";
    
    $this->db->prepare($sql);
    
    $ret = $this->db->query();

    //Here: 31.07.21, no retorna el id correcto!!!

    if(!$ret) {
       $folioReporte = -1;
    } else {
       $folioReporte = $ret;
    }
    
    $this->db->disconnect();
    
    return $folioReporte;
  }
}
?>
