<?php

require_once('class.orm.php');
require_once(INCLUDE_DIR . 'class.encuestarespuesta.php');

class EncuestaTicket extends VerySimpleModel {
    static $meta = array(
        'table' => ENCUESTA_TICKET,
        'pk' => array('id')
    );
     
    function guardarTicketRespuesta($idTicket,$token,$array) {
        if (!($ticket = Ticket::lookup($idTicket))) {
            return false; 
        }else if(!($ticket->token == $token)){ 
            return false; 
        }else if(!empty($ticket->encuesta)){ 
            return false; 
        }else{
            $puntos = 0;
            foreach ($array as $idRes){
                $respuesta = EncuestaRespuesta::getRespuesta($idRes);
                if (!(empty($respuesta) || empty($ticket))){
                    $ticketRes = new EncuestaTicket();
                    $ticketRes->id = 0;
                    $ticketRes->id_ticket = $idTicket;
                    $ticketRes->id_responsable = $ticket->staff_id;
                    $ticketRes->id_pregunta = $respuesta->id_pregunta;
                    $ticketRes->id_respuesta = $respuesta->id;
                    $ticketRes->fecha_registro = SqlFunction::NOW();
                    $ticketRes->save();
                    $puntos = $puntos + $respuesta->puntos;
                }
            }
            $ticket->encuesta = $puntos;
            $ticket->survey = new SqlFunction('NOW');
            if (!$ticket->save()){ return false; }
        }
        
        return true;
    }
}