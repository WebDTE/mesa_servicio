<?php

require_once('class.orm.php');

class EncuestaPregunta extends VerySimpleModel {
    static $meta = array(
        'table' => ENCUESTA_PREGUNTA,
        'pk' => array('id_pregunta')
    );
    
    function getPreguntasPrincipales() {
        return self::objects()->filter(array('es_principal' =>1));
    }
    
    function getPregunta($id) {
        return self::objects()->filter(array('id_pregunta' =>$id))->first();
    }
}