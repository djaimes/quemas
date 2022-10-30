<?php
/**
 * Controlador Login
 */
 class ControladorLogin
 {

   function main(array $getVars){

     require_once(SERVER_ROOT . '/modelos/' . 'modelo' . 'login.php');

     $modeloLogin = new ModeloLogin;

     $resultadoLogin1 = $modeloLogin->getResultadoLogin($getVars);

     header('Content-Type: application/text');
     
     echo $resultadoLogin1;
   }
 }
 ?>
