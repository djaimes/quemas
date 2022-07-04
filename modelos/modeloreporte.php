<?php

/***
*   Modelo Profesores
*/

// Incluir el driver de MySQL
require_once(SERVER_ROOT . '/librerias/drivers/' . 'mysqldriver.php');

class ModeloProfesores
{

  public $datosProfesoresConArreglo = array(
    "id"=>100,
    "nombre" => "Dennis",
    "paterno" => "MacAlistair",
    "materno" => "Ritchie"
  );

  // Ejemplo de datos con Mysql
  private $db;

  public function __construct()
  {
    // Crear el objeto de Base de Datos
    $this->db = new MySQLDriver;
  }

  // Método getProfesores para devolver los datos del Array
  public function getProfesoresConArreglo(){
    return $this->datosProfesoresConArreglo;
  }

  // Método profesores para devolver los datos de la base de datos
  public function getProfesoresConMysql($id){

    // Conectar
    $this->db->connect();

    // Preparar la Consulta
    $sql = "SELECT * FROM profesores WHERE id = " . $id;
    $this->db->prepare($sql);

    // Ejecutar la consulta
    $this->db->query();

    // Obtener profesor de la consulta
    $datosProfesoresConMysql = $this->db->fetch('array');

    return $datosProfesoresConMysql;

  }
}


?>
