#!/usr/bin/php
<?php

/**
 * La entrada de este controlador viene como un flujo de correo de procmail 
 * indicado en /home/djaimes/.procmailrc 
 */

/**
 * Variables para depuración
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Leer el flujo del correo entrante
 */

$email = '';

if(($fp = fopen('php://stdin','r')) !== false){
	while(!feof($fp)){ 
		$email .= fread($fp, 1024);
	}
	fclose($fp);
}

// Repositorio de respaldo de correos .eml 
$mailpath = '/var/www/quemas/data/correo/';

// Nombre del archivo para respaldo del correo
$hora = new DateTime();
$hora->setTimezone(new DateTimeZone('America/Merida'));
$mailname = 'correo' .'_'.date('dmY').'_'.$hora->format("Gis").'.eml';

// Ruta del archivo donde depositaré el respaldo del correo
$mailfile = $mailpath . $mailname;

// Grabando una copia del correo para analizarlo
$file = fopen($mailfile,'w');
fwrite($file, $email);
fclose($file);
 
// Parsear el contenido del correo 
require_once('/var/www/quemas/lib/mailparser/MimeMailParser.class.php');

$Parser = new MimeMailParser();
$Parser->setPath($mailfile);

$to = $Parser->getHeader('to');
$from = $Parser->getHeader('from');
$subject = iconv_mime_decode($Parser->getHeader('subject'), 0, 'UTF-8');
$text = $Parser->getMessageBody('text');
$html = $Parser->getMessageBody('html');
$attachments = $Parser->getAttachments();

/**
 * Obtener un número de folio
 */
$url = 'http://quemas.geodatica.mx/controladores/indexmvc.php';
$curl = curl_init();
 
$fields = array(
	'controlador' => 'folio',
	'origen' => 'correo',
	'comentario' => 'Procesado con procmail'
);
 
$fields_string = http_build_query($fields);
 
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
 
$folio = curl_exec($curl);
 
curl_close($curl);

$log = "Folio: " . print_r($folio);
file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);


/**
 * Guardar las fotos por día
 */
$dia = date('d-m-Y');

$imgpath = '/var/www/quemas/data/fotos/' . $dia . '/';

if ( !is_dir($imgpath ) ){
    umask(0);
    mkdir($imgpath, 0755);
}

$thumbname = '';

if(count($attachments)>0){
	foreach($attachments as $attachment) {

        $imgname =  $folio . iconv_mime_decode($attachment->filename, 0, 'UTF-8');
        $ext = substr($imgname, strrpos($imgname,'.') +  1);

		if ( $ext === 'jpg' || $ext === 'jpeg' || $ext === 'png'){
            $imgfile = $imgpath . $imgname;
    		if ($fp = fopen($imgfile, 'w')) {
    		    while($bytes = $attachment->read()) {
             	    fwrite($fp, $bytes);
        	    }
            fclose($fp);

            // generar la foto pequeña

            list($width, $height) = getimagesize($imgfile);
            $newwidth = 640;
            $newheight = 480;
            $source = imagecreatefromjpeg($imgfile);
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            // Crear banda de metadatos
            $colorletras = imagecolorallocatealpha($thumb, 255, 255, 255, 25);
            //$metadata = $subject . ' ' .date('d/m/Y') . ' ' . $hora->format("G:i:s") . ' hrs';
            $metadata = $folio . ' ' .date('d/m/Y') . ' ' . $hora->format("G:i:s") . ' hrs';
            //|imagestring($thumb, 5, 10, 450, $metadata, $colorletras);
            imagettftext($thumb, 12, 0, 10, 450, $colorletras, '/var/www/quemas/lib/fonts/cour.ttf', $metadata);

            // aplicar marca de agua a thumb
            $marcapng = '/var/www/quemas/public/images/marcaaguageodatica.png';
            $marcaagua = imagecreatefrompng($marcapng);
            imagecopy($thumb,$marcaagua,$newwidth - 120, $newheight - 156,0,0,120,156);

            $thumbname = 'thumb_' . $imgname;
            $thumbfile = $imgpath . $thumbname;
            imagepng($thumb,$thumbfile);
            chmod($thumbfile, 0755);
            imagedestroy($source);
            imagedestroy($thumb);
            }
        }
    }   
}

?>
