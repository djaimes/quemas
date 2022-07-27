<?php
/**
 * Controlador Folio
 * 
 * Ejemplo de uso:
 *
 * http://quemas.geodatica.mx/controladores/indexmvc.php?controlador=folio&origen=correo&comentario=insertando
 *
 */
 class ControladorFolio
 {

   function main(array $getVars){

     require_once(SERVER_ROOT . '/modelos/' . 'modelo' . 'folio.php');

     $modeloFolio = new ModeloFolio;

     $numFolio = $modeloFolio->getResultadoFolio($getVars);

     header('Content-Type: application/text');
	
	   $folio = array('folio' => $numFolio, 'obs' => 'comentario');

     echo json_encode($folio);
   }
 }
 ?>
