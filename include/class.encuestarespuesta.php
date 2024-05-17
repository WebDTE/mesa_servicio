<?php

require_once('class.orm.php');

class EncuestaRespuesta extends VerySimpleModel {
    static $meta = array(
        'table' => ENCUESTA_RESPUESTA,
        'pk' => array('id'),
        'joins' => array(
            'encuestapregunta' => array(
                'constraint' => array('id_pregunta' => 'EncuestaPregunta.id_pregunta'),
                'null' => false,
            ),
        )
    );
    
    function getRespuesta($id) {
        return self::objects()->filter(array('id' => $id))->first();
    }
    
    function getRespuestas($idPregunta) {
        return self::objects()->filter(array('id_pregunta' => $idPregunta));
    }
    
    function getPreguntaDep($idPreRes) {
        return self::objects()->filter(array('id' => $idPreRes))->first();
    }
}