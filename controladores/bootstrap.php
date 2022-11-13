<?php

/***
 *   Controlador frontal
 *   
 *   Primer respondiente a las peticiones
 *
 *   http://quemas.geodatica.org/controladores/bootstrap.php?controlador=nombreControlador&var1=val1
 *
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

// URL para ejecutar el sistema
define('SITE_ROOT', 'http://quemas.geodatica.org');

// Raíz del sistema
define('SERVER_ROOT', '/var/www/html/quemas');

// Ruteador de controladores
require_once(SERVER_ROOT . '/controladores/' . 'router.php');

?>
