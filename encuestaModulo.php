<?php

require('client.inc.php');
define('SOURCE','Web'); //Ticket source.

if ($_POST) {
    $i = 0;
    $array = null;
    $folio = null;
    foreach ($_POST as $param_name => $param_val) {
        if(substr( $param_name,0,3) === "res" ){
            if(is_array($param_val)){
                foreach($param_val as $value){
                    $array[$i] = $value;
                     $i++;
                }
            }else{
                $array[$i] = $param_val;
                 $i++;
            }
        }else if($param_name === "folio"){
            $folio = $param_val;
        }
    }
    
    if (empty($array) || count($array) <= 1){
        $errors['err'] = 'Favor de ingresar todas las respuestas.';
        require(CLIENTINC_DIR.'header.Modulo.php');
        require(CLIENTINC_DIR.'open.encuestaModulo.php');   
        require(CLIENTINC_DIR.'footer.inc.php');
    }else{
        if(EncuestaModulo::guardarModuloRespuesta($folio, $array)){
            $encuestaModulo = 1;
            require(CLIENTINC_DIR.'header.Modulo.php');
            require(CLIENTINC_DIR.'open.encuestaModulo.php');
            require(CLIENTINC_DIR.'footer.inc.php');
        }else{
            $errors['err'] = 'Error al guardar las respuestas de la encuesta, favor de intentarlo nuevamente.';
            require(CLIENTINC_DIR.'header.Modulo.php');
            require(CLIENTINC_DIR.'open.encuestaModulo.php');
            require(CLIENTINC_DIR.'footer.inc.php');
        }  
    }
}else{
    require(CLIENTINC_DIR.'header.Modulo.php');
    require(CLIENTINC_DIR.'open.encuestaModulo.php');
    require(CLIENTINC_DIR.'footer.inc.php'); 
}