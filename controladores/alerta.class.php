<?php

class alerta{
    private $variables = array(
                                "[ASUNTO]",
                                "[NOMBRE]",
                                "[NARRADO]",
                                "[MARCADOR]",
                                "[MINUTO]",
                                "[IMGPATH]",
                                "[TEXTOIMGPATH]"
                            );
    private $valores = array(
                            'asunto' => 'ningun_asunto', 
                            'nombre' => 'ningun_nombre',
                            'narrado' => 'nada_narrado',
                            'marcador' => 'ningun_marcador',
                            'minuto' => 'ningun_minuto',
                            'imgpath' => 'ninguna_imagen',
                            'textoimgpath' => 'ningun_texto'
                        );

    /**
     * Constructor
     */
    function alerta($asunto, $narrado, $marcador, $minuto, $imgpath){
        $this->valores['asunto'] = $asunto;
        $this->valores['narrado'] = $narrado;
        $this->valores['marcador'] = $marcador;
        $this->valores['minuto'] = $minuto;
        $this->valores['imgpath'] = $imgpath;
        if ($imgpath === '#'){
            $this->valores['textoimgpath'] = '';
        }else{
            $this->valores['textoimgpath'] = 'ver foto';
        }
    }

    /**
    * Recuperar lista de correo
    */
    function enviarAlertas(){
        $sql = 'select nombre, correo from suscriptores where activo = 1';
        require_once '/var/www/html/jr2015/lib/db/dbClass.php';
        $db = new dbClass();
        $rs = $db->ReturnQueryAsArray($sql);
        foreach($rs as $suscriptor){
	        $this->enviarCorreo($suscriptor);	
        }
        $db->close();
    }

    /**
     * Enviar correo
     */
    function enviarCorreo($suscriptor){
	    $correo = $suscriptor['correo'];
        $this->valores['nombre'] = $suscriptor['nombre'];
        $cabeceras = "From: juegos.regionales@palmartec.com". PHP_EOL .
                     "MIME-Version: 1.0". PHP_EOL . 
                     "Content-Type: text/html; charset=UTF-8" . PHP_EOL;
    
        $mensaje = file_get_contents("/var/www/html/jr2015/app/alerta.html");
        $mensaje = str_replace($this->variables, $this->valores, $mensaje);

	    mail($correo, $this->valores['asunto'], $mensaje, $cabeceras);
    }
}
?>

