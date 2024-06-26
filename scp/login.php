<?php

require_once('../main.inc.php');
if(!defined('INCLUDE_DIR')){
    die('Fatal Error. Kwaheri!');
}

// Bootstrap gettext translations. Since no one is yet logged in, use the
// system or browser default
TextDomain::configureForUser();

require_once(INCLUDE_DIR.'class.staff.php');
require_once(INCLUDE_DIR.'class.csrf.php');

$content = Page::lookupByType('banner-staff');

$dest = $_SESSION['_staff']['auth']['dest'];
$msg = $_SESSION['_staff']['auth']['msg'];
$msg = $msg ?: ($content ? $content->getLocalName() : __('Authentication Required'));
$dest=($dest && (!strstr($dest,'login.php') && !strstr($dest,'ajax.php')))?$dest:'index.php';
$show_reset = false;

if ($_POST) {
    $json = isset($_POST['ajax']) && $_POST['ajax'];
    $respond = function($code, $message) use ($json, $ost) {
        if ($json) {
            $payload = is_array($message) ? $message
                : array('message' => $message);
            $payload['status'] = (int) $code;
            Http::response(200, JSONDataEncoder::encode($payload),
                'application/json');
        }
        else {
            // Extract the `message` portion only
            if (is_array($message)){
                $message = $message['message'];
            }
            Http::response($code, $message);
        }
    };
    $redirect = function($url) use ($json) {
        if ($json){
            Http::response(200, JsonDataEncoder::encode(array(
                'status' => 302, 'redirect' => $url)), 'application/json');
        }else{
            Http::redirect($url);
        }
    };

    // Check the CSRF token, and ensure that future requests will have to
    // use a different CSRF token. This will help ward off both parallel and
    // serial brute force attacks, because new tokens will have to be
    // requested for each attempt.
    if (!$ost->checkCSRFToken()) {
        $_SESSION['_staff']['auth']['msg'] = __('Valid CSRF Token Required');
        $redirect($_SERVER['REQUEST_URI']);
    }

}
if ($_POST && isset($_POST['userid'])) {
    // Lookup support backends for this staff
    $username = trim($_POST['userid']);
    if ($user = StaffAuthenticationBackend::process($username,$_POST['passwd'], $errors)) {
        $redirect($dest);
    }

    $msg = $errors['err'] ?: __('Invalid login');
    $show_reset = true;

    if ($json) {
        $respond(401, ['message' => $msg, 'show_reset' => $show_reset]);
    }
    else {
        // Rotate the CSRF token (original cannot be reused)
        $ost->getCSRF()->rotate();
    }
}
elseif ($_GET['do']) {
    switch ($_GET['do']) {
    case 'ext':
        // Lookup external backend
        if ($bk = StaffAuthenticationBackend::getBackend($_GET['bk'])){
            $bk->triggerAuth();
        }
    }
    Http::redirect('login.php');
}elseif (!$thisstaff || !($thisstaff->getId() || $thisstaff->isValid())) {
    if (($user = StaffAuthenticationBackend::processSignOn($errors, false))
            && ($user instanceof StaffSession)) {
        Http::redirect($dest);
    } else if (isset($_SESSION['_staff']['auth']['msg'])) {
        $msg = $_SESSION['_staff']['auth']['msg'];
    }
}
elseif ($thisstaff && $thisstaff->isValid()) {
    Http::redirect($dest);
}

// Browsers shouldn't suggest saving that username/password
Http::response(422);

define("OSTSCPINC",TRUE); //Make includes happy!
include_once(INCLUDE_DIR.'staff/login.tpl.php');
?>
