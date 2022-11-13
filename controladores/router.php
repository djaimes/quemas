<?php

/***
 *
 *   Ruteador del sistema
 *
 */

/***
 * Parsear la URL
 */

$request = urldecode($_SERVER['QUERY_STRING']);       // Todo lo que viene después del ?
$argumentos = explode('&', $request);                  // Obtener arreglo de variable=valor
$controlador = array_shift($argumentos);              // Obtener el primer elemento
$controladorArray = explode('=', $controlador);
$nombreControlador = $controladorArray[1];

$getVars = array();

foreach ($argumentos as $argumento) {
  list($variable, $valor) = explode('=', $argumento);
  $getVars[$variable] = $valor;
}

/***
 * Construir la llamada al controlador secundaria
 */

$targetControlador = SERVER_ROOT . '/controladores/' . 'controlador' . strtolower($nombreControlador) . '.php';

include_once($targetControlador);

$nombreClase = 'Controlador' . ucfirst($nombreControlador); // Crear el objeto controlador secundario
$controlador = new $nombreClase;

$controlador->main($getVars);                               // Pasar el control al controlador secundario
