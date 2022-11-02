#!/usr/bin/php
<?php

/**
 * Obtener un número de folio
 */
$url = 'http://quemas.geodatica.org/controladores/bootstrap.php';

$curl = curl_init();
 
$fields = array(
	'controlador' => 'folio',
	'origen' => 'correo',
	'comentario' => 'procmail'
);
 
$fields_string = http_build_query($fields);

$url1= $url . '?' . $fields_string;

curl_setopt($curl, CURLOPT_URL, $url1);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
$info = curl_exec($curl);

$folioArray = json_decode($info);

print_r($folioArray->folio);

curl_close($curl);

?>
