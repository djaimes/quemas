<?php

/***
*   Controlador Profesores
*/

  class ControladorProfesores
  {

    public $template = 'vistaprofesoresajax';  // Para almacenar la vista

    function __construct()
    {
      // code...
    }

    function main(array $getVars){

      require_once(SERVER_ROOT . '/modelos/' . 'modeloprofesores.php');

      // Crear el modelo
      $modeloProfesores = new ModeloProfesores;

      // Consultamos
      $datosProfesores = $modeloProfesores->getProfesoresConMySQL($getVars['id']);

      // Este módulo combina datos + html para la vista final
      require_once(SERVER_ROOT . '/modelos/' . 'vistamodeloprofesores.php');

      // Crear la vista final
      $vista = new VistaModeloProfesores($this->template);

      // Verificar si hubo resultado de la consulta con el id proporcionado
      if (isset($datosProfesores)){
        $vista->asignar('id',$datosProfesores['id']);
        $vista->asignar('nombre',$datosProfesores['nombre']);
        $vista->asignar('paterno',$datosProfesores['paterno']);
        $vista->asignar('materno',$datosProfesores['materno']);
      }else {
        $vista->asignar('id',"no encontrado");
        $vista->asignar('nombre',"No encontrado");
        $vista->asignar('materno',"No encontrado");
        $vista->asignar('paterno',"No encontrado");
      }
    }
  }
?>
