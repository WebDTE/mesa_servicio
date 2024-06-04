<?php
require('client.inc.php');
define('SOURCE','Web'); 
$errors=array();

if ($_POST) {
    $vars = $_POST;
    $vars['folio']=$vars['folio'];
    $vars['curp']=$vars['curp'];

    if ($vars['folio'] && $vars['curp']) {
        
        $array = Estudiante::getResponsable($vars['folio'],$vars['curp']);
        
        if (empty($array)) {
            $errors['err'] = 'No se encontro ningún registro de estudiante con los datos ingresados. Favor de verificar la información.';
            require(CLIENTINC_DIR.'header.inc.php');
            require(CLIENTINC_DIR.'open.rce.php');   
            require(CLIENTINC_DIR.'footer.inc.php');
        }else{
            require(CLIENTINC_DIR.'header.inc.php');?>

            <h1>Responsable de Control Escolar (RCE)</h1>
            <hr/><br><br>
            <p style="text-align: justify; ">Apreciable estudiante, a continuación se muestra el nombre de su Responsable de Control Escolar (RCE), 
                quien tiene las siguientes funciones:
                <ul>
                    <li>Acompañarle a lo largo de su Trayectoria Escolar</li>
                    <li>Revisar sus documentos y dictaminar su expediente estudiantil</li>
                    <li>Atender sus dudas o consultas respecto a los procesos administrativos escolares a través de la 
                Mesa de Servicio.</li>
                </ul>
            </p>
            <br><br>
            <table  cellpadding="1" cellspacing="0" border="0" class="mx-auto for-tabla">
                <tr>
                    <td style="background-color:#C2D04C;"><div class="form-header" style="margin-bottom:0.5em"><b>Folio</b></div></td>
                    <td><?php echo($array[0]); ?></td>
                </tr>
                <tr>
                    <td style="background-color:#C2D04C;"><div class="form-header" style="margin-bottom:0.5em"><b>Nombre</b></div></td>
                    <td><?php echo($array[1]); ?></td>
                </tr>
                <tr>
                    <td style="background-color:#C2D04C;"><div class="form-header" style="margin-bottom:0.5em"><b>Primer Apellido</b></div></td>
                    <td><?php echo($array[2]); ?></td>
                </tr>
                <tr>
                    <td style="background-color:#C2D04C;"><div class="form-header" style="margin-bottom:0.5em"><b>Segundo Apellido</b></div></td>
                    <td><?php echo($array[3]); ?></td>
                </tr>
                <tr>
                    <td style="background-color:#C2D04C;"><div class="form-header" style="margin-bottom:0.5em"><b>Matrícula</b></div></td>
                    <td><?php echo($array[4]); ?></td>
                </tr>  
                <tr>
                    <td style="background-color:#C2D04C;"><div class="form-header" style="margin-bottom:0.5em"><b>Generación</b></div></td>
                    <td><?php echo($array[5]); ?></td>
                </tr>
                <tr><td><br/></td><td><br/></td></tr>
                <tr>
                    <td style="background-color:#CF5F62;"><div class="form-header" style="margin-bottom:0.5em"><b>Nombre RCE</b></div></td>
                    <td><?php echo($array[6]); ?></td>
                </tr>
            </table>  
            
            <br/><br/>
            <p class="buttons" style="text-align:center;">
                <a href="<?php echo ROOT_PATH; ?>rce.php" class="btn btnh btn-mes-ser">Aceptar</a>
            </p>
            <?php 
            require(CLIENTINC_DIR.'footer.inc.php'); 
        }
    }else{
        $errors['err'] = 'Ingresar todos los campos marcados como requeridos.';
        require(CLIENTINC_DIR.'header.inc.php');
        require(CLIENTINC_DIR.'open.rce.php');   
        require(CLIENTINC_DIR.'footer.inc.php');
    }
}else{
   require(CLIENTINC_DIR.'header.inc.php');
   require(CLIENTINC_DIR.'open.rce.php');   
   require(CLIENTINC_DIR.'footer.inc.php'); 
}

