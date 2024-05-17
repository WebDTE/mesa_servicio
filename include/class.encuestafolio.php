<?php

require_once('class.orm.php');

class EncuestaFolio extends VerySimpleModel {
    static $meta = array(
        'table' => ENCUESTA_FOLIO,
        'pk' => array('id')
    );
    
    function guardarEncuestaFolio($folio, $encuesta) {
        
        $sql = "select count(*) + 1 as folio from encuesta_folio where YEAR(fecha_registro)=YEAR(now())";
        $count = db_result(db_query($sql));
  
        $encuestaFolio = new EncuestaFolio();
        $encuestaFolio->id = 0;
        $encuestaFolio->folio_encuesta=date("Y").str_pad($count,4, "0", STR_PAD_LEFT);
        $encuestaFolio->folio_estudiante = $folio;
        $encuestaFolio->encuesta = $encuesta;
        $encuestaFolio->fecha_registro = SqlFunction::NOW();
     
        if (!$encuestaFolio->save()){ 
            return null;
        }else{
            return $encuestaFolio;
        }
    }
}