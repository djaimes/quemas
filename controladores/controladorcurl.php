#!/usr/bin/php
<?php

/**
 * Obtener un número de folio
 */
$url = 'http://quemas.geodatica.mx/controladores/indexmvc.php';

$curl = curl_init();
 
$fields = array(
	'controlador' => 'folio',
	'origen' => 'correo',
	'comentario' => 'procmail'
);
 
$fields_string = http_build_query($fields);

$url1= $url . '?' . $fields_string;

curl_setopt($curl, CURLOPT_URL, $url1);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
 
$folio = curl_exec($curl);

curl_close($curl);

?>
