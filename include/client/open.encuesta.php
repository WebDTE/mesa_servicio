<?php
    if(!defined('OSTCLIENTINC'))
        die('Access Denied!');

    $ticket=null;
    $ticketId=null;
    $token=null;
    $error = null;
    
    if($_REQUEST['id'] && $_REQUEST['token']) {
       $ticketId = $_REQUEST['id'];
       $token = $_REQUEST['token'];
    }else{
       $ticketId = Format::input($_POST['ticketId']);
       $token = Format::input($_POST['token']);
    }
        
    if (empty($ticketId) || empty($token)){
         $error=1;
    }else{
        if (!($ticket = Ticket::lookup($ticketId))) {
           $error=1;
        }
        else{
            if(!($ticket->ticket_id == $ticketId && $ticket->token == $token)){
                $error=1;
            }
            else if ($ticket->encuesta != 0 || !empty($ticket->survey)){
                $error=2;
            }
            else if($ticket->status_id != 3){
                $error=3;
            }
            else{
                $now = date("Y-m-d");
                $closed = $ticket->closed;
                $diff = strtotime($now) - strtotime($closed);
                $days =  round($diff / (60 * 60 * 24));
                if($days > 3){
                    $error=4;
                }
            }
        }
    }
    
    if (empty($error)){
        $preguntas = EncuestaPregunta::getPreguntasPrincipales();
?>
<h1>Encuesta de satisfacci&oacute;n (ticket #<?php echo($ticket->number); ?>)</h1>
<br/><br/>
<div class="row"><div class="col-md-12">
    <p style="color:#5C5CAE;">
    Para <b>Prepa en Línea-SEP</b> es importante conocer su opinión de la atención prestada a su solicitud para la mejora de servicio, 
    le presentamos una breve encuesta y agradecemos su apoyo.</p>
</div></div>
<form id="encuestaForm" method="post" action="encuesta.php">
    <?php csrf_token(); ?>
    <input type="hidden" id="ticketId" name="ticketId" value="<?php echo($ticketId); ?>"/>
    <input type="hidden" id="token" name="token" value="<?php echo($token); ?>"/>
    <div class="row">
        <?php foreach ($preguntas as $pregunta) {?>
        <div class="col-md-12"><?php echo($pregunta->pregunta); ?></div>
        <?php 
            $respuestas = EncuestaRespuesta::getRespuestas($pregunta->id_pregunta);
            foreach ($respuestas as $respuesta) {?>
                <div class="col-md-12">
                    <input type="<?php echo($respuesta->tipo); ?>" 
                        name="res<?php echo($respuesta->id_pregunta); ?>"
                        required="required" value="<?php echo($respuesta->id); ?>"
                        value="<?php echo($respuesta->id); ?>"
                        onclick="javascript:
                             $.ajax('ajax.php/encuesta/dependencias/' + this.value,{
                                 dataType: 'json',
                                 success: function(json) {
                                     $('#dep<?php echo($respuesta->id_pregunta); ?>').empty().append(json.data);
                                     $(document.head).append(json.media);
                                 }
                             });" ><?php echo($respuesta->respuesta); ?>
                </div><br/><br/>
        <?php } ?>
        <?php } ?>
        <div id="dep<?php echo($respuesta->id_pregunta); ?>" class="row" style="margin-top: 15px;"></div>
    </div>
    <hr/>
    <p class="buttons" style="text-align:center;">
        <input type="submit" value="Enviar encuesta" class="btn">
    </p>
</form>
<?php }else{
    if($error == 2){
        echo '<div class=\'row\'>
            <div class=\'col-md-12\'>
                <br/><br/><br/><br/>
                <div class=\'alert alert-danger\' role=\'alert\'>
                   <br/>Ya ha contestado la encuesta. Gracias por ayudarnos a mejorar el servicio.<br/><br/>
                </div>
            </div>
        </div>';
    }
    else if($error == 3){
        echo '<div class=\'row\'>
            <div class=\'col-md-12\'>
                <br/><br/><br/><br/>
                <div class=\'alert alert-danger\' role=\'alert\'>
                   <br/>El ticket aun esta en proceso de atención, no es posible contestar la encuesta en este momento.<br/><br/>
                </div>
            </div>
        </div>';
    }   
    else if($error == 4){
        echo '<div class=\'row\'>
            <div class=\'col-md-12\'>
                <br/><br/><br/><br/>
                <div class=\'alert alert-danger\' role=\'alert\'>
                   <br/>No es posible contestar la encuesta, debido a que han pasado más de 72 horas desde la emisión de la respuesta.<br/><br/>
                </div>
            </div>
        </div>';
    }     
    else{
        echo '<div class=\'row\'>
          <div class=\'col-md-12\'>
              <br/><br/><br/><br/>
              <div class=\'alert alert-danger\' role=\'alert\'>
                <br/>No se encontro ninguna solicitud con los parámetros indicados.<br/><br/>
              </div>
          </div>
        </div>';
    }
}
