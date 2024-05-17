<?php

require('client.inc.php');
define('SOURCE','Web'); //Ticket source.

if ($_POST) {
    $ticketId = $_POST['ticketId'];
    $token = $_POST['token'];
    if (isset($ticketId) && isset($token)) {
        $i = 0;
        $array = null;
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
            }
        }
        
        if (empty($ticketId) || empty($token) || empty($array) || count($array) <= 1){
           $errors['err'] = 'Favor de ingresar todas las respuestas.';
            require(CLIENTINC_DIR.'header.inc.php');
            require(CLIENTINC_DIR.'open.encuesta.php');   
            require(CLIENTINC_DIR.'footer.inc.php');
        }else{
            if(EncuestaTicket::guardarTicketRespuesta($ticketId,$token,$array)){
                require(CLIENTINC_DIR.'header.inc.php');
                echo '<div class=\'row\'>
                <div class=\'col-md-12\'>
                    <br/><br/><br/><br/>
                    <div class=\'alert alert-success\' role=\'alert\'>
                      <br/>Las respuestas se guardaron con éxito, gracias por ayudarnos a mejorar el servicio.<br/><br/>
                      <b>Prepa en L&iacute;nea SEP</b>
                    </div>
                    </div>
                </div>'; 
                require(CLIENTINC_DIR.'footer.inc.php');
            }else{
                $errors['err'] = 'Error al guardar las respuestas de la encuesta, favor de intentarlo nuevamente.';
                require(CLIENTINC_DIR.'header.inc.php');
                require(CLIENTINC_DIR.'open.encuesta.php');   
                require(CLIENTINC_DIR.'footer.inc.php');
            }  
        }
    }else{
        $errors['err'] = 'No se encontro información del ticket con los parámetros proporcionados.';
        require(CLIENTINC_DIR.'header.inc.php');
        require(CLIENTINC_DIR.'open.encuesta.php');   
        require(CLIENTINC_DIR.'footer.inc.php');
    }
}else{
    require(CLIENTINC_DIR.'header.inc.php');
    require(CLIENTINC_DIR.'open.encuesta.php');   
    require(CLIENTINC_DIR.'footer.inc.php'); 
}