<?php

/**
 * Driver PostgreSQL
 */

require_once( SERVER_ROOT . '/librerias/' . 'database.php');

class PostgreSQLDriver extends DatabaseLibrary
{
  public $connection;
  public $query;
  public $result;

  // Conectar
  public function connect(){

   $host        = "host = quemas.geodatica.mx";
   $port        = "port = 5432";
   $dbname      = "dbname = quemas";
   $credentials = "user=postgres password=colage";

   $this->connection = pg_connect( "$host $port $dbname $credentials"  );
  }

  // desconectar
  public function disconnect(){
    pg_close($this->connection);
    return TRUE;
  }

  // preparar
  public function prepare($query){
      $this->query = $query;
  }

  // Query
  public function query(){
    if (isset($this->query)) {
      $this->result = pg_query($this->connection, $this->query);
    }
  }

  /// Fetch - Ir a buscar los datos del result
  public function fetch($type = 'object'){

      switch ($type) {
        case 'array':
          $row = pg_fetch_array($this->result);
          break;
        case 'object':
          $row = pg_fetch_object($this->result);
            break;
        default:
          $row = pg_fetch_object($this->result);
          break;
      }

      return $row;
      
  }
}
?>
