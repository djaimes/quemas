<?php
/**
 * Controlador Reporte
 */
 class ControladorReporte
 {

   function main(array $getVars){
     
     $getVars['origen'] = 'Captura en sistema';
     $getVars['comentario'] = 'Recibido por telefonista';
     
     // obtener folio
     include_once(SERVER_ROOT . '/controladores/controladorfolio.php');
     $nombreClase = 'ControladorFolio';
     $controlador = new $nombreClase;
     $info = $controlador->main($getVars);
     
     // Agregar el folio obtenido al reporte de quemas
     $folioArray = json_decode($info);
     $folio = $folioArray->folio;
     $getVars['folio'] = $folio;

     // Ingresar el reporte de quemas
     require_once(SERVER_ROOT . '/modelos/' . 'modelo' . 'reporte.php');
     $modeloReporte = new ModeloReporte;
     $resultadoReporte = $modeloReporte->getResultadoReporte($getVars);
     
     return $resultadoReporte;
   }
 }
 ?>
