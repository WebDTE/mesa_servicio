<?php
    $title=($cfg && is_object($cfg) && $cfg->getTitle())  ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
    $signin_url = ROOT_PATH . "login.php".($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
    $signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

    header("Content-Type: text/html; charset=UTF-8");
    header("Content-Security-Policy: frame-ancestors ".$cfg->getAllowIframes().";");

    if (($lang = Internationalization::getCurrentLanguage())) {
        $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
        $langs = Internationalization::rfc1766($langs);
        header("Content-Language: ".implode(', ', $langs));
    }
?>

<!DOCTYPE html>
<html<?php
    if ($lang && ($info = Internationalization::getLanguageInfo($lang)) && (@$info['direction'] == 'rtl')){
        echo ' dir="rtl" class="rtl"';
    }
    if ($lang) {
        echo ' lang="' . $lang . '"';
    }

    // Dropped IE Support Warning
    if (osTicket::is_ie()){
        $ost->setWarning(__('osTicket no longer supports Internet Explorer.'));
    }
?>
>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" type="image/x-icon" href="https://prepaenlinea.sep.gob.mx/wp-content/themes/PL-SEP-2024/img/favicon.png">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?cc2f481" media="screen"/> -->
    <!-- <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?cc2f481" media="screen"/> -->
    
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?cc2f481" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?cc2f481" media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?cc2f481" rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/jquery-ui-timepicker-addon.css?cc2f481" media="all"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?cc2f481" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?cc2f481" media="screen"/>
    <link rel="stylesheet" id="google-fonts-css" href="https://fonts.googleapis.com/css2?family=Montserrat%3Aital%2Cwght%400%2C300%3B0%2C400%3B0%2C500%3B0%2C700%3B1%2C300%3B1%2C400%3B1%2C500%3B1%2C700&amp;display=swap&amp;ver=6.4.2" type="text/css" media="all">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?cc2f481"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?cc2f481"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?cc2f481"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?cc2f481"/>
    <link rel='stylesheet' id='estilos-css' href='https://prepaenlinea.sep.gob.mx/wp-content/themes/PL-SEP-2024/css/css.min.css?ver=6.4.1' type='text/css' media='all' />
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/v2.css?cc2f481" media="screen"/>
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

    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    // Offer alternate links for search engines
    // @see https://support.google.com/webmasters/answer/189077?hl=en
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
        <?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
            hreflang="x-default" />
        <?php
    }?>
</head>
<body>
    <!-- menu -->  
        <!-- menu gobierno -->  
        <nav class="navbar navbar-expand-lg nav-gob">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="https://prepaenlinea.sep.gob.mx/wp-content/themes/PL-SEP-2024/img/logoheader.svg" alt="Logo Gobierno de México" width="80"></a>
                <div>
                    <div class="navbar-nav ms-auto ">
                        <div class="nav-item">
                            <a class="nav-link" href="https://www.gob.mx/tramites">Trámites</a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="https://www.gob.mx/tramites" target="_blank">Gobierno</a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="https://www.gob.mx/busqueda?utf8=%E2%9C%93" target="_blank"><img src="https://prepaenlinea.sep.gob.mx/wp-content/themes/PL-SEP-2024/img/lupa.png" alt="lupa"></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    <!-- menu gobiero -->  
    <!-- menu principal -->  
        <div class="menu-principal f-top">
            <div class="text-start ms-3">
              <a href="https://prepaenlinea.sep.gob.mx/"><img class="logo" src="https://prepaenlinea.sep.gob.mx/wp-content/themes/PL-SEP-2024/img/lcono-proteccion.svg" width="104" alt="Logo"></a>
            </div>
    
            <div class="menu-desk" id="menu-buttoms">
              <a class="link-menu d-none d-md-inline-block" href="https://prepaenlinea.sep.gob.mx/convocatorias-2024/"><svg width="35" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Capa_1" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><style>	.mst0{fill:none;stroke:#E0E7A5;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}	.icono-m-1{fill:none;stroke:#E0E7A5;stroke-width:5;stroke-linecap:round;stroke-miterlimit:10;}</style><polyline class="mst0" points="85.4,12 75,27.6 71.1,23.7 "></polyline><path class="mst0" d="M90,25c0,8.3-6.7,15-15,15s-15-6.7-15-15s6.7-15,15-15"></path><polyline class="mst0" points="85.4,62 75,77.6 71.1,73.7 "></polyline><path class="mst0" d="M90,75c0,8.3-6.7,15-15,15s-15-6.7-15-15s6.7-15,15-15"></path><g>	<g>		<circle class="icono-m-1" cx="30" cy="34.8" r="11.3"></circle>	</g>	<path class="icono-m-1" d="M31.8,47.6l-3.7,0c-8.3,0-15,6.7-15,15l0,6c0,0.8,0.7,1.5,1.5,1.5L45.4,70c0.8,0,1.5-0.7,1.5-1.5v-5.9  C46.9,54.3,40.1,47.5,31.8,47.6z"></path></g></svg> Registro</a>   
              <a class="link-menu d-none d-md-inline-block" href="https://prepaenlinea.sep.gob.mx/mesadeservicio"><svg class="iconos-m" width="30" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 95 95"><defs><style>      .icono-m-1 {        stroke-linejoin: round;      }      .icono-m-1, .icono-m-2 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-width: 5px;      }      .icono-m-2 {        stroke-miterlimit: 10;      }    </style></defs><g data-name="Capa 1"><path class="icono-m-1" d="M7.5,57.5H87.5c2.76,0,5,2.24,5,5v30H2.5v-30c0-2.76,2.24-5,5-5Z"></path><g><circle class="icono-m-2" cx="47.49" cy="15.84" r="13.34"></circle><path class="icono-m-2" d="M67.5,48.77c0-9.83-7.98-17.8-17.81-17.78h-4.45c-9.81,.03-17.75,7.98-17.75,17.79"></path></g></g></svg> Mesa de servicio</a>
              <a class="link-menu d-none d-md-inline-block" data-bs-toggle="modal" data-bs-target="#micomunidad"  href="#micomunidad"><svg  class="iconos-m"  width="30" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 82.28 82.12"><defs><style>      .icono-m-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g data-name="Capa 1"><g><g><circle class="icono-m-1" cx="20.14" cy="19.64" r="10.02"></circle><path class="icono-m-1" d="M28.34,13.89c1.32-.62,2.69-1.14,4.1-1.57,2.14-.64,3.62-2.57,3.62-4.8h0c0-3.31-3.17-5.76-6.35-4.82C16.75,6.53,6.53,16.75,2.7,29.71c-.94,3.17,1.51,6.35,4.82,6.35h0c2.23,0,4.16-1.49,4.8-3.62,.49-1.64,1.12-3.22,1.87-4.73"></path></g><g><circle class="icono-m-1" cx="62.64" cy="20.14" r="10.02"></circle><path class="icono-m-1" d="M68.39,28.34c.62,1.32,1.14,2.69,1.57,4.1,.64,2.14,2.57,3.62,4.8,3.62h0c3.31,0,5.76-3.17,4.82-6.35-3.83-12.96-14.04-23.18-27.01-27.01-3.17-.94-6.35,1.51-6.35,4.82h0c0,2.23,1.49,4.16,3.62,4.8,1.64,.49,3.22,1.12,4.73,1.87"></path></g><g><circle class="icono-m-1" cx="62.14" cy="62.48" r="10.02"></circle><path class="icono-m-1" d="M53.94,68.23c-1.32,.62-2.69,1.14-4.1,1.57-2.14,.64-3.62,2.57-3.62,4.8h0c0,3.31,3.17,5.76,6.35,4.82,12.96-3.83,23.18-14.04,27.01-27.01,.94-3.17-1.51-6.35-4.82-6.35h0c-2.23,0-4.16,1.49-4.8,3.62-.49,1.64-1.12,3.22-1.87,4.73"></path></g><g><circle class="icono-m-1" cx="19.64" cy="61.99" r="10.02"></circle><path class="icono-m-1" d="M13.89,53.78c-.62-1.32-1.14-2.69-1.57-4.1-.64-2.14-2.57-3.62-4.8-3.62h0c-3.31,0-5.76,3.17-4.82,6.35,3.83,12.96,14.04,23.18,27.01,27.01,3.17,.94,6.35-1.51,6.35-4.82h0c0-2.23-1.49-4.16-3.62-4.8-1.64-.49-3.22-1.12-4.73-1.87"></path></g></g></g></svg> Mi comunidad</a>
              <a class="link-menu d-none d-md-inline-block cursor" onClick="muestra_oculta('contenido')"> <svg class="iconos-m" width="30" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 54.99 54.96"><defs><style>      .icono-m-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g data-name="Capa 1"><g><line class="icono-m-1" x1="52.49" y1="52.46" x2="36.62" y2="36.59"></line><circle class="icono-m-1" cx="22.48" cy="22.48" r="19.98"></circle></g></g></svg></a>         
              <div id="contenido" style="opacity: 0;" >
                <form action="https://prepaenlinea.sep.gob.mx/" method="get" enctype="multipart/form-data" class="form-only-controls">               
                    <div class="input-group">
                        <input type="text" id="s" name="s" placeholder="Busca en PL-SEP" value="" class="form-control text-left autocomplete" />
                        <button type="submit" class="btn btn-default link-menu"><span class="text-hide sr-only">Buscar</span>
                          <svg class="iconos-m" width="30" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 54.99 54.96"><defs><style>.icono-m-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g data-name="Capa 1"><g><line class="icono-m-1" x1="52.49" y1="52.46" x2="36.62" y2="36.59"></line><circle class="icono-m-1" cx="22.48" cy="22.48" r="19.98"></circle></g></g></svg>
                        </button>
                    </div>                
                </form>
              </div>
            </div>
        
            <div class="button_container" onclick="myFunction()" id="toggle">
              <span class="top"></span>
              <span class="middle"></span>
              <span class="bottom"></span>
              <div class="middle text-m">MENÚ</div>
            </div>  
        </div>
    <!-- menu principal -->  
    <!-- fullpage menu -->  
        <div id="overlay" class="overlaym" >
            <nav class="dt d-none d-md-inline-block">
                <div class="menu-dt container">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link" id="v-pills-conocenos-tab" data-bs-toggle="pill" data-bs-target="#v-pills-conocenos" type="button" role="tab" aria-controls="v-pills-conocenos" aria-selected="true">Conócenos <i class="fa-solid fa-sort-down"></i></button>
                        <button class="nav-link" id="v-pills-perfiles-tab" data-bs-toggle="pill" data-bs-target="#v-pills-perfiles" type="button" role="tab" aria-controls="v-pills-perfiles" aria-selected="false">Perfiles de la
                            comunidad <i class="fa-solid fa-sort-down"></i></button>
                        <button class="nav-link" id="v-pills-programa-tab" data-bs-toggle="pill" data-bs-target="#v-pills-programa" type="button" role="tab" aria-controls="v-pills-programa" aria-selected="false">Nuestro programa <i class="fa-solid fa-sort-down"></i></button>
                        <button class="nav-link" id="v-pills-desintegral-tab" data-bs-toggle="pill" data-bs-target="#v-pills-desintegral" type="button" role="tab" aria-controls="v-pills-desintegral" aria-selected="false">Desarrollo integral <i class="fa-solid fa-sort-down"></i></button>
                        <a href="https://prepaenlinea.sep.gob.mx/boletines" class="nav-link">Boletines</a>
                        <button class="nav-link" id="v-pills-transparencia-tab" data-bs-toggle="pill" data-bs-target="#v-pills-transparencia" type="button" role="tab" aria-controls="v-pills-transparencia" aria-selected="false">Transparencia <i class="fa-solid fa-sort-down"></i></button>
                        <button class="nav-link" id="v-pills-contacto-tab" data-bs-toggle="pill" data-bs-target="#v-pills-contacto" type="button" role="tab" aria-controls="v-pills-contacto" aria-selected="false">Contacto <i class="fa-solid fa-sort-down"></i></button>
                        <hr class="menu">
                        <a class="nav-link" href="https://prepaenlinea.sep.gob.mx/convocatorias-2024/"><svg class="iconos-m" width="30" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Capa_1" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><style>	.mst0{fill:none;stroke:#E0E7A5;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}	.icono-m-1{fill:none;stroke:#E0E7A5;stroke-width:5;stroke-linecap:round;stroke-miterlimit:10;}</style><polyline class="mst0" points="85.4,12 75,27.6 71.1,23.7 "></polyline><path class="mst0" d="M90,25c0,8.3-6.7,15-15,15s-15-6.7-15-15s6.7-15,15-15"></path><polyline class="mst0" points="85.4,62 75,77.6 71.1,73.7 "></polyline><path class="mst0" d="M90,75c0,8.3-6.7,15-15,15s-15-6.7-15-15s6.7-15,15-15"></path><g>	<g>		<circle class="icono-m-1" cx="30" cy="34.8" r="11.3"></circle>	</g>	<path class="icono-m-1" d="M31.8,47.6l-3.7,0c-8.3,0-15,6.7-15,15l0,6c0,0.8,0.7,1.5,1.5,1.5L45.4,70c0.8,0,1.5-0.7,1.5-1.5v-5.9  C46.9,54.3,40.1,47.5,31.8,47.6z"></path></g></svg> Registro</a>
                        <a href="https://prepaenlinea.sep.gob.mx/mesadeservicio" class="nav-link"><svg class="iconos-m" width="23" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 95 95"><defs><style>.icono-m-1 {stroke-linejoin: round;} .icono-m-1, .icono-m-2 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-width: 5px;      }      .icono-m-2 {        stroke-miterlimit: 10;      }    </style></defs><g data-name="Capa 1"><path class="icono-m-1" d="M7.5,57.5H87.5c2.76,0,5,2.24,5,5v30H2.5v-30c0-2.76,2.24-5,5-5Z"></path><g><circle class="icono-m-2" cx="47.49" cy="15.84" r="13.34"></circle><path class="icono-m-2" d="M67.5,48.77c0-9.83-7.98-17.8-17.81-17.78h-4.45c-9.81,.03-17.75,7.98-17.75,17.79"></path></g></g></svg> Mesa de servicio</a>
                        <a data-bs-toggle="modal" data-bs-target="#micomunidad"  href="#micomunidad"  class="nav-link"><svg  class="iconos-m"  width="23" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 82.28 82.12"><defs><style>      .icono-m-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g data-name="Capa 1"><g><g><circle class="icono-m-1" cx="20.14" cy="19.64" r="10.02"></circle><path class="icono-m-1" d="M28.34,13.89c1.32-.62,2.69-1.14,4.1-1.57,2.14-.64,3.62-2.57,3.62-4.8h0c0-3.31-3.17-5.76-6.35-4.82C16.75,6.53,6.53,16.75,2.7,29.71c-.94,3.17,1.51,6.35,4.82,6.35h0c2.23,0,4.16-1.49,4.8-3.62,.49-1.64,1.12-3.22,1.87-4.73"></path></g><g><circle class="icono-m-1" cx="62.64" cy="20.14" r="10.02"></circle><path class="icono-m-1" d="M68.39,28.34c.62,1.32,1.14,2.69,1.57,4.1,.64,2.14,2.57,3.62,4.8,3.62h0c3.31,0,5.76-3.17,4.82-6.35-3.83-12.96-14.04-23.18-27.01-27.01-3.17-.94-6.35,1.51-6.35,4.82h0c0,2.23,1.49,4.16,3.62,4.8,1.64,.49,3.22,1.12,4.73,1.87"></path></g><g><circle class="icono-m-1" cx="62.14" cy="62.48" r="10.02"></circle><path class="icono-m-1" d="M53.94,68.23c-1.32,.62-2.69,1.14-4.1,1.57-2.14,.64-3.62,2.57-3.62,4.8h0c0,3.31,3.17,5.76,6.35,4.82,12.96-3.83,23.18-14.04,27.01-27.01,.94-3.17-1.51-6.35-4.82-6.35h0c-2.23,0-4.16,1.49-4.8,3.62-.49,1.64-1.12,3.22-1.87,4.73"></path></g><g><circle class="icono-m-1" cx="19.64" cy="61.99" r="10.02"></circle><path class="icono-m-1" d="M13.89,53.78c-.62-1.32-1.14-2.69-1.57-4.1-.64-2.14-2.57-3.62-4.8-3.62h0c-3.31,0-5.76,3.17-4.82,6.35,3.83,12.96,14.04,23.18,27.01,27.01,3.17,.94,6.35-1.51,6.35-4.82h0c0-2.23-1.49-4.16-3.62-4.8-1.64-.49-3.22-1.12-4.73-1.87"></path></g></g></g></svg> Mi comunidad</a>
                        </div>
            
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade" id="v-pills-conocenos" role="tabpanel" aria-labelledby="v-pills-conocenos-tab" tabindex="0"> 
                                <ul id="menu-dt-conoce" class="menu">
                                    <li id="menu-item-2604" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2604"><a href="https://prepaenlinea.sep.gob.mx/conocenos/conoce-prepa-en-linea-sep/">Conoce Prepa en Línea-SEP</a></li>
                                    <li id="menu-item-2605" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2605"><a href="https://prepaenlinea.sep.gob.mx/conocenos/modelo-educativo/">Modelo educativo</a></li>
                                    <li id="menu-item-2606" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2606"><a href="https://prepaenlinea.sep.gob.mx/conocenos/requerimientos-tecnologicos/">Requerimientos tecnológicos</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="v-pills-perfiles" role="tabpanel" aria-labelledby="v-pills-perfiles-tab" tabindex="0">
                                <ul id="menu-dt-perfiles" class="menu">
                                    <li id="menu-item-3155" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3155"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/aspirantes/">Aspirantes</a></li>
                                    <li id="menu-item-5533" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5533"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/estudiantes/">Estudiantes</a></li>
                                    <li id="menu-item-3835" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3835"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/egresados/">Egresados</a></li>
                                    <li id="menu-item-3154" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3154"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-virtuales/">Asesores virtuales</a></li>
                                    <li id="menu-item-5666" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5666"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-tecnologicos/">Asesores tecnológicos</a></li>
                                    <li id="menu-item-23685" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23685"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-de-talleres-extraescolares/">Asesores de talleres extraescolares</a></li>
                                    <li id="menu-item-23686" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23686"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-en-la-didactica-del-conocimiento/">Asesores en la didáctica del conocimiento</a></li>
                                    <li id="menu-item-3833" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3833"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/tutores-escolares/">Tutores escolares</a></li>
                                    <li id="menu-item-23230" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23230"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/tutores-escolares-de-regularizacion/">Tutores escolares de regularización</a></li>
                                    <li id="menu-item-23687" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23687"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/tutores-de-integridad-academica/">Tutores de integridad académica</a></li>
                                    <li id="menu-item-28875" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-28875"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/monitores-de-la-practica-tutorial/">Monitores de la práctica tutorial</a></li>
                                    <li id="menu-item-3151" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3151"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/responsables-de-control-escolar/">Responsables de control escolar</a></li>
                                    <li id="menu-item-3152" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3152"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/supervisores-para-el-acompanamiento-y-la-mejora-educativa/">Supervisores para el acompañamiento y la mejora educativa</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="v-pills-programa" role="tabpanel" aria-labelledby="v-pills-programa-tab" tabindex="0">
                                <ul id="menu-dt-nuestropro" class="menu">
                                    <li id="menu-item-2610" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2610"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/plan-de-estudios/">Plan de estudios</a></li>
                                    <li id="menu-item-2607" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2607"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/certificado-electronico/">Certificado electrónico</a></li>
                                    <li id="menu-item-2609" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2609"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/perfil-de-ingreso/">Perfil de ingreso</a></li>
                                    <li id="menu-item-2611" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2611"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/regularizacion/">Regularización</a></li>
                                    <li id="menu-item-2612" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2612"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/reingreso-revalidacion-y-equivalencia-de-estudios/">Revalidación y equivalencia de estudios</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="v-pills-desintegral" role="tabpanel" aria-labelledby="v-pills-desintegral-tab" tabindex="0">
                                <ul id="menu-dt-desintegral" class="menu">
                                    <li id="menu-item-21751" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21751"><a href="https://prepaenlinea.sep.gob.mx/desarrollo-integral/difusion-cultural/">Difusión cultural</a></li>
                                    <li id="menu-item-21750" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21750"><a href="https://prepaenlinea.sep.gob.mx/desarrollo-integral/talleres-extraescolares/">Talleres extraescolares</a></li>
                                    <li id="menu-item-21749" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21749"><a href="https://prepaenlinea.sep.gob.mx/desarrollo-integral/orientacion-educativa/">Orientación educativa</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="v-pills-transparencia" role="tabpanel" aria-labelledby="v-pills-transparencia-tab" tabindex="0">
                                <ul id="menu-dt-transparencia" class="menu">
                                    <li id="menu-item-2625" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2625"><a href="https://prepaenlinea.sep.gob.mx/transparencia/acuerdos-y-normas/">Acuerdos y normas</a></li>
                                    <li id="menu-item-2626" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2626"><a href="https://prepaenlinea.sep.gob.mx/transparencia/aviso-de-privacidad/">Aviso de privacidad</a></li>
                                    <li id="menu-item-23721" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23721"><a href="https://prepaenlinea.sep.gob.mx/transparencia/estadisticas/">Estadísticas</a></li>
                                    <li id="menu-item-2627" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2627"><a href="https://prepaenlinea.sep.gob.mx/transparencia/circulares/">Circulares</a></li>
                                    <li id="menu-item-2628" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2628"><a href="https://prepaenlinea.sep.gob.mx/transparencia/numeralia/">Numeralia</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="v-pills-contacto" role="tabpanel" aria-labelledby="v-pills-contacto-tab" tabindex="0">
                                <ul id="menu-dt-contacto" class="menu">
                                    <li id="menu-item-2631" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2631"><a href="https://prepaenlinea.sep.gob.mx/contacto/directorio-de-atencion/">Directorio de atención</a></li>
                                    <li id="menu-item-2629" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2629"><a href="https://prepaenlinea.sep.gob.mx/contacto/mapa-del-sitio/">Mapa del sitio</a></li>
                                    <li id="menu-item-2630" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2630"><a href="https://prepaenlinea.sep.gob.mx/contacto/preguntas-frecuentes/">Preguntas frecuentes</a></li>
                                </ul>
                            </div>  
                        </div>
            
                        <div class="banner-menu d-none d-lg-block">
                            <a href="https://prepaenlinea.sep.gob.mx/mesadeservicio" target="_blank"><img class="banner" src="https://prepaenlinea.sep.gob.mx/wp-content/themes/PL-SEP-2024/img/Bannner_300x600.jpg" width="250" alt="banner"></a>
                            
                        </div>
            
                    </div>
            
                    <div class="input-wrapper">
                        <form action="https://prepaenlinea.sep.gob.mx/" method="get" enctype="multipart/form-data" class="form-only-controls">
                            <div class="input-group">
                                <input type="text" name="s" placeholder="Busca en PL-SEP" value="" class="form-control text-left autocomplete" />
                                <button type="submit" class="btn btn-default link-menu"><span class="text-hide sr-only">Buscar</span>
                                     <svg class="iconos-m" width="20" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 54.99 54.96"><defs><style>      .icono-m-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g data-name="Capa 1"><g><line class="icono-m-1" x1="52.49" y1="52.46" x2="36.62" y2="36.59"></line><circle class="icono-m-1" cx="22.48" cy="22.48" r="19.98"></circle></g></g></svg>
                                </button>
                            </div>
                        </form>     
                    </div>
                </div>
            </nav>
          
            <nav class="movil sidebar menu-dt py-2 d-block d-md-none">
                <div class="container-xxl">
                    <ul class="nav flex-column" id="nav_accordion">
                        <li class="nav-item has-submenu">
                            <a class="nav-link" href="#"> Conócenos <i class="fa-solid fa-sort-down"></i> </a>
                            <ul class="submenu collapse">
                                <div class="menu-dt-conoce-container">
                                    <ul id="menu-dt-conoce-1" class="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2604"><a href="https://prepaenlinea.sep.gob.mx/conocenos/conoce-prepa-en-linea-sep/">Conoce Prepa en Línea-SEP</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2605"><a href="https://prepaenlinea.sep.gob.mx/conocenos/modelo-educativo/">Modelo educativo</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2606"><a href="https://prepaenlinea.sep.gob.mx/conocenos/requerimientos-tecnologicos/">Requerimientos tecnológicos</a></li>
                                    </ul>
                                </div> 
                            </ul>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" href="#"> Perfiles de la comunidad <i class="fa-solid fa-sort-down"></i> </a>
                            <ul class="submenu collapse">
                                <div class="menu-dt-perfiles-container">
                                    <ul id="menu-dt-perfiles-1" class="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3155"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/aspirantes/">Aspirantes</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5533"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/estudiantes/">Estudiantes</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3835"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/egresados/">Egresados</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3154"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-virtuales/">Asesores virtuales</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5666"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-tecnologicos/">Asesores tecnológicos</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23685"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-de-talleres-extraescolares/">Asesores de talleres extraescolares</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23686"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/asesores-en-la-didactica-del-conocimiento/">Asesores en la didáctica del conocimiento</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3833"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/tutores-escolares/">Tutores escolares</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23230"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/tutores-escolares-de-regularizacion/">Tutores escolares de regularización</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23687"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/tutores-de-integridad-academica/">Tutores de integridad académica</a></li>
                                        <li id="menu-item-28875" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-28875"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/monitores-de-la-practica-tutorial/">Monitores de la práctica tutorial</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3151"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/responsables-de-control-escolar/">Responsables de control escolar</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3152"><a href="https://prepaenlinea.sep.gob.mx/perfiles-de-la-comunidad/supervisores-para-el-acompanamiento-y-la-mejora-educativa/">Supervisores para el acompañamiento y la mejora educativa</a></li>
                                    </ul>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" href="#"> Nuestro programa <i class="fa-solid fa-sort-down"></i> </a>
                            <ul class="submenu collapse">
                                <div class="menu-dt-nuestropro-container">
                                    <ul id="menu-dt-nuestropro-1" class="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2610"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/plan-de-estudios/">Plan de estudios</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2607"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/certificado-electronico/">Certificado electrónico</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2609"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/perfil-de-ingreso/">Perfil de ingreso</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2611"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/regularizacion/">Regularización</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2612"><a href="https://prepaenlinea.sep.gob.mx/nuestro-programa/reingreso-revalidacion-y-equivalencia-de-estudios/">Revalidación y equivalencia de estudios</a></li>
                                    </ul>
                                </div> 
                            </ul>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" href="#"> Desarrollo integral <i class="fa-solid fa-sort-down"></i> </a>
                            <ul class="submenu collapse">
                                <div class="menu-dt-desintegral-container">
                                    <ul id="menu-dt-desintegral-1" class="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21751"><a href="https://prepaenlinea.sep.gob.mx/desarrollo-integral/difusion-cultural/">Difusión cultural</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21750"><a href="https://prepaenlinea.sep.gob.mx/desarrollo-integral/talleres-extraescolares/">Talleres extraescolares</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21749"><a href="https://prepaenlinea.sep.gob.mx/desarrollo-integral/orientacion-educativa/">Orientación educativa</a></li>
                                    </ul>
                                </div>   
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="https://prepaenlinea.sep.gob.mx/boletines"> Boletines </a>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" href="#"> Transparencia <i class="fa-solid fa-sort-down"></i> </a>
                            <ul class="submenu collapse">
                                <div class="menu-dt-transparencia-container">
                                    <ul id="menu-dt-transparencia-1" class="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2625"><a href="https://prepaenlinea.sep.gob.mx/transparencia/acuerdos-y-normas/">Acuerdos y normas</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2626"><a href="https://prepaenlinea.sep.gob.mx/transparencia/aviso-de-privacidad/">Aviso de privacidad</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23721"><a href="https://prepaenlinea.sep.gob.mx/transparencia/estadisticas/">Estadísticas</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2627"><a href="https://prepaenlinea.sep.gob.mx/transparencia/circulares/">Circulares</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2628"><a href="https://prepaenlinea.sep.gob.mx/transparencia/numeralia/">Numeralia</a></li>
                                    </ul>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" href="#"> Contacto <i class="fa-solid fa-sort-down"></i> </a>
                            <ul class="submenu collapse">
                                <div class="menu-dt-contacto-container">
                                    <ul id="menu-dt-contacto-1" class="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2631"><a href="https://prepaenlinea.sep.gob.mx/contacto/directorio-de-atencion/">Directorio de atención</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2629"><a href="https://prepaenlinea.sep.gob.mx/contacto/mapa-del-sitio/">Mapa del sitio</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2630"><a href="https://prepaenlinea.sep.gob.mx/contacto/preguntas-frecuentes/">Preguntas frecuentes</a></li>
                                    </ul>
                                </div>
                            </ul>
                        </li>
                        
                        <hr class="menu">
                        <li>
                        <a class="nav-link" href="https://prepaenlinea.sep.gob.mx/convocatorias-2024/" ><svg class="iconos-m" width="30" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Capa_1" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><style>	.mst0{fill:none;stroke:#E0E7A5;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}	.icono-m-1{fill:none;stroke:#E0E7A5;stroke-width:5;stroke-linecap:round;stroke-miterlimit:10;}</style><polyline class="mst0" points="85.4,12 75,27.6 71.1,23.7 "></polyline><path class="mst0" d="M90,25c0,8.3-6.7,15-15,15s-15-6.7-15-15s6.7-15,15-15"></path><polyline class="mst0" points="85.4,62 75,77.6 71.1,73.7 "></polyline><path class="mst0" d="M90,75c0,8.3-6.7,15-15,15s-15-6.7-15-15s6.7-15,15-15"></path><g>	<g>		<circle class="icono-m-1" cx="30" cy="34.8" r="11.3"></circle>	</g>	<path class="icono-m-1" d="M31.8,47.6l-3.7,0c-8.3,0-15,6.7-15,15l0,6c0,0.8,0.7,1.5,1.5,1.5L45.4,70c0.8,0,1.5-0.7,1.5-1.5v-5.9  C46.9,54.3,40.1,47.5,31.8,47.6z"></path></g></svg> Registro</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link"  href="https://prepaenlinea.sep.gob.mx/mesadeservicio"><svg class="iconos-m"   width="20" xmlns="http://www.w3.org/2000/svg" data-name="Capa 2" viewBox="0 0 95 95"><defs><style>      .cls-1 {        stroke-linejoin: round;      }      .cls-1, .cls-2 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-width: 5px;      }      .cls-2 {        stroke-miterlimit: 10;      }    </style></defs><g id="Capa_1-2" data-name="Capa 1"><path class="cls-1" d="M7.5,57.5H87.5c2.76,0,5,2.24,5,5v30H2.5v-30c0-2.76,2.24-5,5-5Z"></path><g><circle class="cls-2" cx="47.49" cy="15.84" r="13.34"></circle><path class="cls-2" d="M67.5,48.77c0-9.83-7.98-17.8-17.81-17.78h-4.45c-9.81,.03-17.75,7.98-17.75,17.79"></path></g></g></svg> Mesa de servicio </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link"  data-bs-toggle="modal" data-bs-target="#micomunidad"  href="#micomunidad"><svg class="iconos-m" width="20" xmlns="http://www.w3.org/2000/svg" data-name="Capa 2" viewBox="0 0 82.28 82.12"><defs><style>      .cls-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g id="Capa_1-2" data-name="Capa 1"><g><g><circle class="cls-1" cx="20.14" cy="19.64" r="10.02"></circle><path class="cls-1" d="M28.34,13.89c1.32-.62,2.69-1.14,4.1-1.57,2.14-.64,3.62-2.57,3.62-4.8h0c0-3.31-3.17-5.76-6.35-4.82C16.75,6.53,6.53,16.75,2.7,29.71c-.94,3.17,1.51,6.35,4.82,6.35h0c2.23,0,4.16-1.49,4.8-3.62,.49-1.64,1.12-3.22,1.87-4.73"></path></g><g><circle class="cls-1" cx="62.64" cy="20.14" r="10.02"></circle><path class="cls-1" d="M68.39,28.34c.62,1.32,1.14,2.69,1.57,4.1,.64,2.14,2.57,3.62,4.8,3.62h0c3.31,0,5.76-3.17,4.82-6.35-3.83-12.96-14.04-23.18-27.01-27.01-3.17-.94-6.35,1.51-6.35,4.82h0c0,2.23,1.49,4.16,3.62,4.8,1.64,.49,3.22,1.12,4.73,1.87"></path></g><g><circle class="cls-1" cx="62.14" cy="62.48" r="10.02"></circle><path class="cls-1" d="M53.94,68.23c-1.32,.62-2.69,1.14-4.1,1.57-2.14,.64-3.62,2.57-3.62,4.8h0c0,3.31,3.17,5.76,6.35,4.82,12.96-3.83,23.18-14.04,27.01-27.01,.94-3.17-1.51-6.35-4.82-6.35h0c-2.23,0-4.16,1.49-4.8,3.62-.49,1.64-1.12,3.22-1.87,4.73"></path></g><g><circle class="cls-1" cx="19.64" cy="61.99" r="10.02"></circle><path class="cls-1" d="M13.89,53.78c-.62-1.32-1.14-2.69-1.57-4.1-.64-2.14-2.57-3.62-4.8-3.62h0c-3.31,0-5.76,3.17-4.82,6.35,3.83,12.96,14.04,23.18,27.01,27.01,3.17,.94,6.35-1.51,6.35-4.82h0c0-2.23-1.49-4.16-3.62-4.8-1.64-.49-3.22-1.12-4.73-1.87"></path></g></g></g></svg> Mi comunidad </a>
                        </li>
                    </ul>
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="https://prepaenlinea.sep.gob.mx/" method="get" enctype="multipart/form-data" class="form-only-controls">
                                <div class="input-group">
                                    <input type="text" name="s" placeholder="Busca en PL-SEP" value="" class="form-control text-left autocomplete" />
                                    <button type="submit" class="btn btn-default link-menu"><span class="text-hide sr-only">Buscar</span>
                                         <svg class="iconos-m" width="20" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 54.99 54.96"><defs><style>      .icono-m-1 {        fill: none;        stroke: #E0E7A5;        stroke-linecap: round;        stroke-linejoin: round;        stroke-width: 5px;      }    </style></defs><g data-name="Capa 1"><g><line class="icono-m-1" x1="52.49" y1="52.46" x2="36.62" y2="36.59"></line><circle class="icono-m-1" cx="22.48" cy="22.48" r="19.98"></circle></g></g></svg>
                                    </button>
                                </div>
                            </form>
                        </div>     
                    </div>       
                </div>      
            </nav>
          
            <div class="menu-social">
                <div class="container-fluid">
                    <div class="row justify-content-center mso">
                        <div class="col d-block d-sm-block d-md-none">
                            <hr class="social-line">
                        </div>
                        <div class="col d-none d-md-inline-block">
                            <hr class="social-line">
                        </div>        
                        <div class="col d-flex justify-content-center">
                            <a title="Facebook" href="https://www.facebook.com/PrepaEnLineadelaSEP/" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                            <a title="X" href="https://twitter.com/PrepaLineaSEP" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                            <a title="Instagram"  href="https://www.instagram.com/prepaenlineasep/" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                            <a title="Youtube" href="https://www.youtube.com/@PrepaenLineaMexico" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-youtube"></i></a>
                            <a title="Tik tok" href="https://www.tiktok.com/@prepaenlinea_sep" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-tiktok"></i></a>
                            <a title="Spotify" href="https://open.spotify.com/show/5GH1mXSrMx6AMchq1EAsHc?si=f407167b9a89491a&nd=1" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fa-brands fa-spotify"></i></a>
                        </div>
                        <div class="col d-none d-md-inline-block">
                            <hr class="social-line">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- fullpge menu -->  
<!-- menu -->  

    <section class="section-w"></section>

    <!-- <div id="container" class="container"> Le quité el ID container, para volverlo responsivo pero no estoy seguro si el ID es importante así que lo dejo comentado-->
    <div id="" class="container">
        <?php
        if($ost->getError()){
            echo sprintf('<div class="error_bar">%s</div>', $ost->getError());
        }elseif($ost->getWarning()){
            echo sprintf('<div class="warning_bar">%s</div>', $ost->getWarning());
        }elseif($ost->getNotice()){
            echo sprintf('<div class="notice_bar">%s</div>', $ost->getNotice());
        }
        ?>
        <div id="header">
            <div class="row">
                <div class="col-12 col-md-4 logo">
                    <a href="<?php echo ROOT_PATH; ?>index.php" title="<?php echo __('Support Center'); ?>">
                        <img src="images/logo.png" alt="<?php echo $ost->getConfig()->getTitle(); ?>">
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="<?php echo ROOT_PATH; ?>index.php" title="<?php echo __('Support Center'); ?>"><div class="titulo">MESA DE SERVICIO<br><span>PREPA EN LÍNEA-SEP</span></div></a>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end">
                
                    <a href="<?php echo ROOT_PATH; ?>view.php" title="<?php echo __('Support Center'); ?>" class="btn btnh btn-consulta mb-3">Consulta ticket</a>
                    <a href="ta/temasAyuda.html" class="btn btnh btn-formato mb-3">Formatos por tema</a>
                </div>
            </div>      

            <!-- header anterior -->
            <!-- <div class="">
              <a class="pull-left" id="logo" href="<?php echo ROOT_PATH; ?>index.php" Le quité el ID container, para volverlo responsivo pero no estoy seguro si el ID es importante así que lo dejo comentado
              <a class="" id="" href="<?php echo ROOT_PATH; ?>index.php"
              title="<?php echo __('Support Center'); ?>">
              
                  <img src="<?php echo ROOT_PATH; ?>logo.php" border=0 alt="<?php
                  echo $ost->getConfig()->getTitle(); ?>" style="width: 100%">
               
                <img src="images/logo.png" border=0 alt="<?php
                echo $ost->getConfig()->getTitle(); ?>" style="width: 100%; max-width:500px; display:block; margin: 0 auto;">
              </a>
            </div> -->

        </div>

        <div class="clear"></div>
        <!-- <?php
        if($nav){ ?>
        <ul id="nav" class="flush-left">
            <?php
            if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
                foreach($navs as $name =>$nav) {
                    echo sprintf('<li><a class="%s %s" href="%s">%s</a></li>%s',$nav['active']?'active':'',$name,(ROOT_PATH.$nav['href']),$nav['desc'],"\n");
                }
            } ?>
            <li>
            <?php
                if (($all_langs = Internationalization::getConfiguredSystemLanguages())
                    && (count($all_langs) > 1)
                ) {
                    $qs = array();
                    parse_str($_SERVER['QUERY_STRING'], $qs);
                    foreach ($all_langs as $code=>$info) {
                        list($lang, $locale) = explode('_', $code);
                        $qs['lang'] = $code;
                ?>
                        <a class="flag flag-<?php echo strtolower($info['flag'] ?: $locale ?: $lang); ?>"
                            href="?<?php echo http_build_query($qs);
                            ?>" title="<?php echo Internationalization::getLanguageDescription($code); ?>">&nbsp;</a>
                <?php }
                }
            ?>
          </li>
          <li style="float:right">
           <?php
              if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) {
               echo Format::htmlchars($thisclient->getName()).'&nbsp;|';
               ?>
              <a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a> |
              <a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a> -
              <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
          <?php
          } elseif($nav) {
              if ($cfg->getClientRegistrationMode() == 'public') { ?>
                  <?php echo __('Guest User'); ?> | <?php
              }
              if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                  <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a><?php
              }
              elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
                  <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
          <?php
              }
          } ?>
        </li>
        </ul>
        <?php
        }else{ ?>
         <hr>
        <?php
        } ?> -->
        <div id="content">

         <?php if($errors['err']) { ?>
            <div id="msg_error"><?php echo $errors['err']; ?></div>
         <?php }elseif($msg) { ?>
            <div id="msg_notice"><?php echo $msg; ?></div>
         <?php }elseif($warn) { ?>
            <div id="msg_warning"><?php echo $warn; ?></div>
         <?php } ?>
