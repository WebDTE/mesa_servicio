<?php
    $title=($cfg && is_object($cfg) && $cfg->getTitle())  ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
    header("Content-Type: text/html; charset=UTF-8");
    header("Content-Security-Policy: frame-ancestors ".$cfg->getAllowIframes().";");

    if (($lang = Internationalization::getCurrentLanguage())) {
        $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
        $langs = Internationalization::rfc1766($langs);
        header("Content-Language: ".implode(', ', $langs));
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?cc2f481" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?cc2f481" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?cc2f481" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?cc2f481" media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?cc2f481" rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/jquery-ui-timepicker-addon.css?cc2f481" media="all"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?cc2f481" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?cc2f481" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?cc2f481"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?cc2f481"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?cc2f481"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?cc2f481"/>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-3.5.1.min.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.12.1.custom.min.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-timepicker-addon.js?cc2f481"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?cc2f481"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?cc2f481"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?cc2f481"></script>
    <script src="https://kit.fontawesome.com/cdf4e31978.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="" class="container">
        <div id="header">
            <div class="">
                <img src="<?php echo ROOT_PATH; ?>images/logo.png" border=0 style="width: 100%; max-width:500px; display:block; margin: 0 auto;">
              </a>
            </div>
        </div>
        <div class="clear"></div>
        <?php
        if($nav){ ?>
        <ul id="nav" style='text-align:center;color:#7C7A7A;padding-top: 10px; font-weight: bold;font-size: 1.2em;'>MÓDULO DE ATENCIÓN</ul>
        <?php
        }?>
        <div id="content">

         <?php if($errors['err']) { ?>
            <div id="msg_error"><?php echo $errors['err']; ?></div>
         <?php }elseif($msg) { ?>
            <div id="msg_notice"><?php echo $msg; ?></div>
         <?php }elseif($warn) { ?>
            <div id="msg_warning"><?php echo $warn; ?></div>
         <?php }
