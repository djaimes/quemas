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

     // Debo usar echo en lugar de return para recibir valores desde curl
     echo json_encode($folio);

     //return $numFolio;
   }
 }
 ?>
