#!/usr/bin/php
<?php

// Recibiendo el correo, lo recibo de stdin como flujo de procmail
$email = '';

if(($fp = fopen('php://stdin','r')) !== false){
	while(!feof($fp)){
		$email .= fread($fp, 1024);
	}
	fclose($fp);
}

// Directorio donde almaceno los correos
$mailpath = '/var/www/quemas/data/correo/';

// Nombre del archivo de correo
$hora = new DateTime();
$hora->setTimezone(new DateTimeZone('America/Mexico_City'));
$mailname = 'correo' .'_'.date('dmY').'_'.$hora->format("Gis").'.eml';

// $path es la ruta del archivo de correo
$mailfile = $mailpath . $mailname;

// Grabando una copia del correo para su posterior parseo
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
 * Checar si ya existe el directorio del día
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
        $imgname = iconv_mime_decode($attachment->filename, 0, 'UTF-8');
        $ext = substr($imgname, strpos($imgname,'.') +  1);
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
            $metadata = $subject . ' ' .date('d/m/Y') . ' ' . $hora->format("G:i:s") . ' hrs';
            //|imagestring($thumb, 5, 10, 450, $metadata, $colorletras);
            imagettftext($thumb, 12, 0, 10, 450, $colorletras, '/var/www/quemas/lib/fonts/cour.ttf', $metadata);

            // aplicar marca de agua a thumb
            $marcapng = '/var/www/quemas/public/images/marcaagua.png';
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
