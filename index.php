<?php

require('client.inc.php');
require_once INCLUDE_DIR . 'class.page.php';
$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');

?>
<div id="landing_page">
    <div>
        <div>
        <?php
            if($cfg && ($page = $cfg->getLandingPage())){?>
                <p>
                    <?php echo $page->getBodyWithImages(); ?>
                </p>
        <?php } ?>
        </div>
    </div>

    <div class="clear"></div>

    <div class="row mt-5">
        <div class="col-12 text-center mb-4">
          <a href="<?php echo ROOT_PATH; ?>open_1.php" class="btn btnh btn-mes-ser ">Aspirantes</a>
        </div>

        <div class="col-12 text-center mb-4">
          <a href="<?php echo ROOT_PATH; ?>open_2.php" class="btn btnh btn-mes-ser ">Estudiantes</a>
        </div>

        <div class="col-12 text-center mb-4">
          <a href="<?php echo ROOT_PATH; ?>open_3.php" class="btn btnh btn-mes-ser ">Egresados</a>
        </div>

        <div class="col-12 text-center mb-4">
          <a href="<?php echo ROOT_PATH; ?>open_4.php" class="btn btnh btn-mes-ser ">Instituciones externas</a>
        </div>
        
      </div>   
      
      <div class="row">
        <div class="col-12 mt-5 text-center">
          <a class="link" href="<?php echo ROOT_PATH; ?>kb/index.php">Preguntas frecuentes</a>
        </div>
      </div>      

    <!-- <div class="row">
      <div class="col-12 col-md-3 mb-3">
        <div class="rcorners bg-prepa-verde">
            <a href="<?php echo ROOT_PATH; ?>aspirantes.php">
              <div class="row">
                <div class="col-12 text-center">
                  <img src="images/aspirantes.png" class="img-fluid">
                </div>
                <div class="col-12 text-center text-white">
                  <p style="font-weight: bold;">Aspirantes</p>
                </div>
              </div>
            </a>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <div class="rcorners bg-prepa-morado">
            <a href="<?php echo ROOT_PATH; ?>estudiantes.php">
              <div class="row">
                <div class="col-12 text-center">
                  <img src="images/estudiantes.png" class="img-fluid"/>
                </div>
                <div class="col-12 text-center text-white">
                  <p style="font-weight: bold;">Estudiantado</p>
                </div>
              </div>
            </a>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <div class="rcorners bg-prepa-coral">
            <a href="<?php echo ROOT_PATH; ?>egresados.php">
              <div class="row">
                <div class="col-12 text-center">
                    <img src="images/egresados.png" class="img-fluid"/>
                </div>
                <div class="col-12 text-center text-white">
                  <p style="font-weight: bold;">Egresados(as)</p>
                </div>
              </div>

            </a>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <div class="rcorners bg-prepa-aqua">
           <a href="<?php echo ROOT_PATH; ?>instituciones.php">
             <div class="row">
               <div class="col-12 text-center">
                 <img src="images/instituciones.png" class="img-fluid"/>
               </div>
               <div class="col-12 text-center text-white">
                 <p style="font-weight: bold;">Instituciones Externas</p>
               </div>
             </div>
           </a>
       </div>
      </div>
    </div> -->
</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>

<?php
$cats = Category::getPopup();
foreach ($cats as $C) { ?>
    <div class="modal fade" id="mensaje" tabindex="-1" role="dialog" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding-bottom: 0px !important;">
                <?php echo $C->getDescription(); ?>
            </div>
            <div class="modal-footer" style="padding:0px !important; border-top:0px !important;">
                <img src="images/footer.png" border=0 style="width:99%; height:100%"/>
            </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#mensaje').modal('show');
        });
    </script>
<?php } ?>
