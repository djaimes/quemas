<?php
/**
 * Controlador Folio
 */
 class ControladorFolio
 {

   function main(array $getVars){

     require_once(SERVER_ROOT . '/modelos/' . 'modelo' . 'folio.php');

     $modeloFolio = new ModeloFolio;

     $resultadoFolio1 = $modeloFolio->getResultadoFolio($getVars);

     header('Content-Type: application/text');
   }
 }
 ?>
