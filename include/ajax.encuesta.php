<?php

if(!defined('INCLUDE_DIR')){
    die('!');
}

require_once INCLUDE_DIR.'class.ajax.php';
require_once(INCLUDE_DIR . 'class.encuestarespuesta.php');

class EncuestaDependencia extends AjaxController {
    
    function getDependencias($idRespuesta) {
        if (!$_SERVER['HTTP_REFERER']){ Http::response(403, 'Forbidden.'); }
        
        if (!($existeDependencia = EncuestaRespuesta::getPreguntaDep($idRespuesta))){
            Http::response(404, 'Error al obtener información.'); }
            
        if (!(empty($existeDependencia->id_pregunta_dep))){
            $preguntaDep = EncuestaPregunta::getPregunta($existeDependencia->id_pregunta_dep);
            $respuestas = EncuestaRespuesta::getRespuestas($preguntaDep->id_pregunta);

            $html = "<div>".$preguntaDep->pregunta."</div>";
            foreach ($respuestas as $respuesta){
                $html = $html."<div>";
                if($respuesta->tipo == 'checkbox'){
                    $html = $html."<input type='".$respuesta->tipo."' name='res".$respuesta->id_pregunta."[]' value='".$respuesta->id."'>";
                }else{
                    $html = $html."<input type='".$respuesta->tipo."' name='res".$respuesta->id_pregunta."' required='required' value='".$respuesta->id."'>";
                }
                $html = $html.$respuesta->respuesta;
                $html = $html."</div>";
            }
            
            return $this->encode(array('data' => $html));
        } 
        
        return $this->encode(array('data' => null));
    }
}