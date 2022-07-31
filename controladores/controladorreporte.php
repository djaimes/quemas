<?php
/**
 * Controlador Reporte
 */
 class ControladorReporte
 {

   function main(array $getVars){

     require_once(SERVER_ROOT . '/modelos/' . 'modelo' . 'reporte.php');

     $modeloReporte = new ModeloReporte;

     $resultadoReporte = $modeloReporte->getResultadoReporte($getVars);

     //header('Content-Type: application/text');
     
     return $resultadoReporte;
   }
 }
 ?>
