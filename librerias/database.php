<?php

/***
* Clase abstracta para derivar clases de conexión a MySQL, PostGreSQL, SQLServer
* La clase abstracta solo indica qué métodos son obligatorios para las
* clases derivadas y que deben ser implementados
*/

/**
 * Database Library
 */

abstract class DatabaseLibrary
{
  abstract protected function connect();
  abstract protected function disconnect();
  abstract protected function prepare($query);
  abstract protected function query();
  abstract protected function fetch($type ='object');
}

?>
