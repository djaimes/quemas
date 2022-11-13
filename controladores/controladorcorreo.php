#!/usr/bin/php
<?php

/**
 * 
 * La entrada de este controlador viene como un flujo de correo de procmail 
 * indicado en /home/reporte/.procmailrc 
 *
 */

/**
 * 
 * Variables para depuración
 *
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// URL para ejecutar el sistema
define('SITE_ROOT', 'http://quemas.geodatica.org');

// Raíz del sistema
define('SERVER_ROOT', '/var/www/html/quemas');

/**
 * Leer el flujo del correo entrante
 */

$email = '';

if (($fp = fopen('php://stdin', 'r')) !== false) {
    while (!feof($fp)) {
        $email .= fread($fp, 1024);
    }
    fclose($fp);
}

// Repositorio de respaldo de correos .eml 
$mailpath = '/var/www/html/quemas/data/correo/';

// Nombre del archivo para respaldo del correo
$hora = new DateTime();
$hora->setTimezone(new DateTimeZone('America/Merida'));
$mailname = 'correo' . '_' . date('dmY') . '_' . $hora->format("Gis") . '.eml';

// Ruta del archivo donde depositaré el respaldo del correo
$mailfile = $mailpath . $mailname;

// Grabando una copia del correo para analizarlo
$file = fopen($mailfile, 'w');
fwrite($file, $email);
fclose($file);

// Parsear el contenido del correo 
require_once('/var/www/html/quemas/librerias/php-mime-mail-parser/MimeMailParser.class.php');

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
 *
 * Ejemplo: 
 *
 * http://quemas.geodatica.org/controladores/bootstrap.php?controlador=folio&origen=correo&comentario=procmail
 *
 */
$url = 'http://quemas.geodatica.org/controladores/bootstrap.php';

$curl = curl_init();

$fields = array(
    'controlador' => 'folio',
    'origen' => 'curl',
    'comentario' => 'procmail'
);

$fields_string = http_build_query($fields);

$url1 = $url . '?' . $fields_string;

curl_setopt($curl, CURLOPT_URL, $url1);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

$info = curl_exec($curl);

$folioArray = json_decode($info);

$folio = $folioArray->folio;

curl_close($curl);


/**
 * 
 * Enviar acuse por correo al usuario que reportó la quema
 *
 */

$mensaje = 'Hemos recibido su reporte. Para su seguimiento le hemos asignado el folio: ' . $folio;
mail($from, 'Acuse de reporte de quemas', $mensaje);


/**
 * 
 * Guardar las fotos por día
 *
 */
$dia = date('d-m-Y');

//$imgpath = '/var/www/html/quemas/data/fotos/' . $dia . '/';
$imgpath = '/var/www/html/quemas/data/fotos/';

if (!is_dir($imgpath)) {
    umask(0);
    mkdir($imgpath, 0755);
}

$thumbname = '';

if (count($attachments) > 0) {
    foreach ($attachments as $attachment) {

        $imgname =  iconv_mime_decode($attachment->filename, 0, 'UTF-8');

        $imgnameFoto = 'F' . $folio . '-' . $imgname;

        $ext = substr($imgname, strrpos($imgname, '.') +  1);

        if ($ext === 'jpg' || $ext === 'jpeg' || $ext === 'png') {
            $imgfile = $imgpath . $imgnameFoto;
            if ($fp = fopen($imgfile, 'w')) {
                while ($bytes = $attachment->read()) {
                    fwrite($fp, $bytes);
                }
                fclose($fp);
                chmod($imgfile, 0755);

                // Extraer coordenadas de la foto con el controladorgeotag
                $getVars = array();
                $getVars['imageName'] = $imgnameFoto;
                $getVars['correo'] = $from;
                $nombreControlador = 'geotag';
                $targetControlador = SERVER_ROOT . '/controladores/' . 'controlador' . strtolower($nombreControlador) . '.php';
                include_once($targetControlador);
                $nombreClase = 'Controlador' . ucfirst($nombreControlador); // Crear el objeto controlador secundario
                $controlador = new $nombreClase;
                $controlador->main($getVars);

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
                $metadata = $folio . ' ' . date('d/m/Y') . ' ' . $hora->format("G:i:s") . ' hrs';

                //|imagestring($thumb, 5, 10, 450, $metadata, $colorletras);
                imagettftext($thumb, 12, 0, 10, 450, $colorletras, '/var/www/html/quemas/lib/fonts/cour.ttf', $metadata);

                // aplicar marca de agua a thumb
                $marcapng = '/var/www/html/quemas/public/images/marcaaguageodatica.png';
                $marcaagua = imagecreatefrompng($marcapng);
                imagecopy($thumb, $marcaagua, $newwidth - 120, $newheight - 156, 0, 0, 120, 156);

                $imgnameThumb = 'F' . $folio . '_thumb' . $imgname;

                $thumbfile = $imgpath . $imgnameThumb;

                imagepng($thumb, $thumbfile);
                chmod($thumbfile, 0755);
                imagedestroy($source);
                imagedestroy($thumb);
            }
        }
    }
}

?>