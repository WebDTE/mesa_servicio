<?php

require_once('class.orm.php');

class Estudiante extends VerySimpleModel {
    static $meta = array(
        'table' => ESTUDIANTE_TABLE,
        'pk' => array('folio')
    );
    
    function getResponsable($folio, $curp) {
        if(is_numeric($folio)){
            if(strlen($curp) == 18){       
                $letras     = substr($curp,0,4);
                $numeros    = substr($curp,4,6);
                $letras2    = substr($curp,10,6);

                if(is_string($letras) && is_string($letras2) && is_numeric($numeros)){
                    $array = self::objects()->values_flat('folio','nombre','primer_apellido','segundo_apellido','matricula','generacion','responsable','responsable_correo')->filter(
                    array('folio' => $folio, 'curp' => $curp))->first();
                    return $array;
                }
             }
        }
    }
}
