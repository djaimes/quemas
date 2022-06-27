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
    $host = 'localhost';
    $database = 'mvc';
    $user = 'mvc';
    $password = 'Mvc_2103';

    $this->connection = new mysqli($host, $user, $password, $database);

  }

  // desconectar
  public function disconnect(){
    $this->connection->close();
    return TRUE;
  }

  // preparar
  public function prepare($query){
      $this->query = $query;
  }

  // Query
  public function query(){
    if (isset($this->query)) {
      $this->result = $this->connection->query($this->query);
    }
  }

  /// Fetch - Ir a buscar los datos del resulta
  public function fetch($type = 'object'){

      switch ($type) {
        case 'array':
          $row = $this->result->fetch_array();
          break;
        case 'object':
          $row = $this->result->fetch_object();
            break;
        default:
          $row = $this->result->fetch_object();
          break;
      }

      return $row;
      
  }
}
?>
