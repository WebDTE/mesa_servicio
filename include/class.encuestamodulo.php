<?php

require_once('class.orm.php');

class EncuestaModulo extends VerySimpleModel {
    static $meta = array(
        'table' => ENCUESTA_MODULO,
        'pk' => array('id')
    );
    
   function guardarModuloRespuesta($folio,$array) {
        $puntos = 0;
        
        foreach ($array as $idRes){
            $respuesta = EncuestaRespuesta::getRespuesta($idRes);
            if (!(empty($respuesta))){
                $puntos = $puntos + $respuesta->puntos;
            }
        }
        
        $encuestaFolio = EncuestaFolio::guardarEncuestaFolio($folio,$puntos);
        
        if(!empty($encuestaFolio)){
            foreach ($array as $idRes){
                $respuesta = EncuestaRespuesta::getRespuesta($idRes);
                if (!(empty($respuesta))){
                    $encuestaModulo = new EncuestaModulo();
                    $encuestaModulo->id = 0;
                    $encuestaModulo->id_folio = $encuestaFolio->id;
                    $encuestaModulo->id_pregunta = $respuesta->id_pregunta;
                    $encuestaModulo->id_respuesta = $respuesta->id;
                    $encuestaModulo->fecha_registro = SqlFunction::NOW();
                    $encuestaModulo->save();
                }
            }
        }
        
        return true;
   }
}