<?php
if(!defined('OSTCLIENTINC'))
    die('Access Denied!');
?>

<h1>Consulta de Responsable de Control Escolar (RCE)</h1>
<p>Favor de completar el siguiente formulario para conocer a tu RCE</p>
<br/><br/>
<form id="rceForm" method="post" action="rce.php">
    <?php csrf_token(); ?>
    <table class="mx-auto for-tabla" cellpadding="1" cellspacing="0" border="0">
        <tbody>
            <tr>
                <!-- <td><div class="form-header" style="margin-bottom:0.5em"><b>Folio: *</b></div></td> -->
                <td><input type="text" class="mb-3" id="folio" name="folio" placeholder="Ingrese su folio"
                           required="required" pattern="[0-9]+" size="12" maxlength="12"/></td>
            </tr>
            <tr>
                <!-- <td><div class="form-header" style="margin-bottom:0.5em"><b>CURP: *</b></div></td> -->
                <td>
                    <input id="curp" type="text" class="mb-3" name="curp"
                        required="true" placeholder="Ingrese su CURP" 
                        maxlength="18" minlength="18"
                        pattern="([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)"
                      />
                </td>
            </tr>           
        </tbody>
    </table>
    <hr/>

    <div class="row justify-content-center text-center">
        <div class="col-12 col-md-6">
            <a href="<?php echo ROOT_PATH; ?>estudiantes.php" class="btn btnh btn-mes-ser">Regresar</a>
        </div>
        <div class="col-12 col-md-6">
            <input type="submit" value="Consultar" class="btn btnh btn-mes-ser">
        </div>
    </div>
</form>
