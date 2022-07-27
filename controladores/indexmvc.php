<?php

/***
*   Controlador frontal
*/

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

// URL para ejecutar el sistema
define('SITE_ROOT','http://quemas.geodatica.mx');

// Raíz del sistema
define('SERVER_ROOT', '/var/www/quemas');

// Ruteador de controladores

require_once(SERVER_ROOT . '/controladores/' . 'router.php');

?>
