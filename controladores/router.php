<?php

/***
 *   Ruteador del sistema
 *    http://localhost/router.php?controlador=controladorprofesores&id=1&nombre=daniel
 *
*/

$request = urldecode($_SERVER['QUERY_STRING']);      // Todo lo que viene después del ?
$argumentos = explode('&',$request);      // Obtener arreglo de variable=valor
$controlador = array_shift($argumentos);  // Obtener el primer elemento
$controladorArray = explode('=',$controlador);
$nombreControlador = $controladorArray[1];

$getVars = array();

foreach ($argumentos as $argumento) {
  list($variable, $valor) = explode('=', $argumento);
  $getVars[$variable] = $valor;
}

$targetControlador = SERVER_ROOT . '/controladores/' . 'controlador' . strtolower($nombreControlador) . '.php';

// Incluir el controlador secundario
include_once($targetControlador);

// Crear el objeto controlador secundario
$nombreClase = 'Controlador' . ucfirst($nombreControlador);
$controlador = new $nombreClase;

// Pasar el control al controlador secundario
$controlador->main($getVars);

?>
