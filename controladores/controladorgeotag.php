<?php
/**
 *
 * Controlador Geotag
 * 
 * http://quemas.geodatica.org/controladores/bootstrap.php?controlador=geotag
 * 
 */

class ControladorGeotag
{
    function main(array $getVars)
    {
        // Completar el arreglo getVars para enviarlo al controlador reporte
        $getVars['origen'] = 'correo';
        $getVars['comentario'] = 'Proceso de foto con procmail';

        $rutaFoto = SERVER_ROOT . '/data/fotos/' . $getVars['imageName'];

        $exifProperties = $this->getImageGPS($rutaFoto);

        $getVars['latitud'] = $exifProperties['latitude']   + (rand(0,1000)/1000);
        $getVars['longitud'] = $exifProperties['longitude'] + (rand(0,1000)/1000); 

        // Generar el reporte de la quema

        $nombreControlador = 'reporte';
        $targetControlador = SERVER_ROOT . '/controladores/' . 'controlador' . strtolower($nombreControlador) . '.php';
        include_once($targetControlador);
        $nombreClase = 'Controlador' . ucfirst($nombreControlador); // Crear el objeto controlador secundario
        $controlador = new $nombreClase;
        $controlador->main($getVars);

        /* if ($getVars['origen'] == 'correo'){
	     echo $json;	// Si viene por correo
     }
     else{
     	     return $json;	// Si viene por sistema web
     }*/
    }

    function getImageGPS($image = '')
    {
        $exif = exif_read_data($image, 0, true);
        if ($exif && isset($exif['GPS'])) {
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude    = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude   = $exif['GPS']['GPSLongitude'];

            $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

            return array('latitude' => $latitude, 'longitude' => $longitude);
        } else {
            return false;
        }
    }

    function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

    /**
     *
     * Imprimir las propiedas exif
     *
     */
    function imprimirExif($image = '')
    {
        $exif = exif_read_data($image, 0, true);
        print_r($exif);
    }

    /**
     *
     * Ruta de la foto
     *
     */
    //$imageURL = "../data/fotos/02-11-2022/Folio-11582_FOTO_cecati.jpg";


    /**
     *
     * Extraer las coordenadas de la foto
     *
     */
    //$imgLocation = get_image_location($imageURL);

    //$imgLocation = get_image_location($imageURL);

    //latitude & longitude
    //$imgLat = $imgLocation['latitude'];
    //$imgLng = $imgLocation['longitude'];

    /**
     *
     * Prepara URL para ingresar reporte a postgis
     *
     */
    //$data = array(  "controlador" => 'reporte',
    //     		"origen" => 'foto',
    //    		"latitud"=> $imgLat,
    //   		"longitud"=> $imgLng,
    //  		"correo"=> "djaimes@geodatica.org"
    //	);

    //print_r($data);

    //echo "LatLng(". $imgLat . "," . $imgLng. ")" . "\n";

    // imprimirExif($imageURL);
}
