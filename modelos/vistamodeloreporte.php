<?php

  /**
   * Clase Vista-Modelo Profesores
   */
  class VistaModeloProfesores
  {

    private $data = array();
    private $render;

    public function __construct($template)
    {
      //Cargar un template para la vista
      $file = SERVER_ROOT . '/vistas/' . strtolower($template) . '.php';

      $this->render = $file;
    }

    // Asignar dato del modelo a la vista del template
    public function asignar($variable, $valor){
      $this->data[$variable] = $valor;
    }

    public function __destruct(){
      $data = $this->data;
      include($this->render);
    }
  }

?>
