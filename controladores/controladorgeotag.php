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

        $getVars['latitud'] = $exifProperties['latitude'];
        $getVars['longitud'] = $exifProperties['longitude']; 

        // Generar el reporte de la quema
        $nombreControlador = 'reporte';
        $targetControlador = SERVER_ROOT . '/controladores/' . 'controlador' . strtolower($nombreControlador) . '.php';
        include_once($targetControlador);

        // Crear el objeto controlador secundario
        $nombreClase = 'Controlador' . ucfirst($nombreControlador); 
        $controlador = new $nombreClase;
        $controlador->main($getVars);
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
     * Imprimir las propiedas exif
     */
    function imprimirExif($image = '')
    {
        $exif = exif_read_data($image, 0, true);
        print_r($exif);
    }
}
