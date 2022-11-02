<?php
/**
 * Controlador Folio
 * 
 * Ejemplo de uso:
 *
 * http://quemas.geodatica.org/controladores/bootstrap.php?controlador=folio&origen=correo&comentario=insertando
 *
 */
 class ControladorFolio
 {

   function main(array $getVars){

     require_once(SERVER_ROOT . '/modelos/' . 'modelo' . 'folio.php');

     $modeloFolio = new ModeloFolio;

     $numFolio = $modeloFolio->getResultadoFolio($getVars);

     $folio = array('folio' => $numFolio, 'obs' => 'comentario');
     
     $json = json_encode($folio);

     if ($getVars['origen'] == 'correo'){
	     echo $json;	// Si viene por correo
     }
     else{
     	     return $json;	// Si viene por sistema web
     }
   }
 }
 ?>
