<?php
    if(!defined('OSTCLIENTINC'))
        die('Access Denied!');
    
    $preguntas = EncuestaPregunta::getPreguntasPrincipales();
?>

<style> 
    .ocultarFolio { margin-top: 15px; display: none; } 
    .mostrarFolio { margin-top: 15px; display: block; } 
</style>

<h1>Encuesta de satisfacci&oacute;n</h1>
<br/><br/>
<div class="row"><div class="col-md-12">
    <p style="color:#5C5CAE;">
    Para <b>Prepa en Línea-SEP</b> es importante conocer su opinión de la atención prestada a su solicitud para la mejora de servicio, 
    le presentamos una breve encuesta y agradecemos su apoyo.</p>
</div></div>
<form id="encuestaForm" method="post" action="encuestaModulo.php">
    <?php csrf_token(); ?>
    <div class="row">
        <?php foreach ($preguntas as $pregunta) {?>
        <div class="col-md-12"><?php echo($pregunta->pregunta); ?></div>
        <?php 
            $respuestas = EncuestaRespuesta::getRespuestas($pregunta->id_pregunta);
            foreach ($respuestas as $respuesta) {?>
                <div class="col-md-12">
                    <input type="<?php echo($respuesta->tipo); ?>" 
                        name="res<?php echo($respuesta->id_pregunta); ?>"
                        required="required"
                        value="<?php echo($respuesta->id); ?>"
                        onclick="javascript:
                             $.ajax('ajax.php/encuesta/dependencias/' + this.value,{
                                 dataType: 'json',
                                 success: function(json) {
                                     $('#dep<?php echo($respuesta->id_pregunta); ?>').empty().append(json.data);
                                     $(document.head).append(json.media);
                                 }
                             });
                             
                             if(this.value === '2'){
                                $('#folioDiv').removeClass('ocultarFolio');
                                $('#folioDiv').addClass('mostrarFolio');
                             }else{
                                $('#folioDiv').removeClass('mostrarFolio');
                                $('#folioDiv').addClass('ocultarFolio');
                             }
                        " ><?php echo($respuesta->respuesta); ?>
                </div><br/><br/>
        <?php } ?>
        <?php } ?>
        <div id="dep<?php echo($respuesta->id_pregunta); ?>" class="row" style="margin-top: 15px;"></div>
    </div>
    <div id="folioDiv" class="col-md-12 ocultarFolio">
        <label>ID o Número de usuario (opcional):</label>
        <input type="text" name="folio" value=""/>
    </div>
    <hr/>
    <p class="buttons" style="text-align:center;">
        <input type="submit" value="Enviar encuesta" class="btn">
    </p>
</form>

<div class="modal fade" id="mensaje" tabindex="-1" role="dialog" aria-labelledby="mensajeLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mensajeLabel">Aviso</h5>
        </div>
        <div class="modal-body"><br/>
            Las respuestas se guardaron con éxito, gracias por ayudarnos a mejorar el servicio.<br/><br/>
            <b>Prepa en L&iacute;nea SEP</b>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>
        </div>
    </div>
  </div>
</div>

<?php 
if ($_POST) { 
    if($encuestaModulo === 1) {?>
    <script type="text/javascript">
       $(window).on('load', function() {
           $('#mensaje').modal('show');

           setTimeout(function() {
               $('#mensaje').modal('hide');
           }, 5000);
       });
    </script>
<?php 
    } 
}