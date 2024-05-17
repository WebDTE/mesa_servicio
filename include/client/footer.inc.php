        </div>
    </div>
    <div id="footer">
        <p>
            <?php echo __('Copyright &copy;'); ?>
            <?php echo date('Y'); ?>
            <?php echo __('https://prepaenlinea.sep.gob.mx/mesadeservicio/'); ?> -
            <?php echo __('All rights reserved.'); ?></p>
    </div>
<div id="overlay"></div>

<div id="loading">
    <h4><?php echo __('Porfavor espera!');?></h4>
    <p><?php echo __('Porfavor espera... esto puede tardar unos segundos!');?></p>
</div>

<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);

    function confirmEmail() {
        var input= document.getElementsByTagName('input');
        if(input[3].value == '') return true;
        else return confirm('¿El correo proporcionado: ' + input[3].value + ' es correcto?')
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
