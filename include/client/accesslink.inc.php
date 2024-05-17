<?php
if(!defined('OSTCLIENTINC')){
    die('Access Denied');
}

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired()){
    $button = __("Email Access Link");
}else{
    $button = __("View Ticket");
}
?>

<h1><?php echo __('Check Ticket Status'); ?></h1>
<p>
    <?php
        echo __('Please provide your email address and a ticket number.');
        if ($cfg->isClientEmailVerificationRequired()){
            echo ' '.__('An access link will be emailed to you.');
        }else{
            echo ' '.__('This will sign you in to view your ticket.');
        }
    ?>
</p>

<form action="login.php" method="post" id="clientLogin">
    <?php csrf_token(); ?>
    
<div class="my-5">
    <div>
        <div><strong><?php echo Format::htmlchars($errors['login']); ?></strong></div>
        <div class="mb-3 for-tabla">
            <input id="email" placeholder="<?php echo __('e.g. john.doe@dominio.com'); ?>" name="lemail" size="30" value="<?php echo $email; ?>" class="form-control">            
        </div>
        <!-- <div>
            <label for="email"><?php echo __('Email Address'); ?>:
            <input id="email" placeholder="<?php echo __('e.g. john.doe@dominio.com'); ?>" type="text"
                name="lemail" size="30" value="<?php echo $email; ?>" class="nowarn"></label>
        </div> -->
        <div class="mb-3 for-tabla">
            <input id="ticketno" placeholder="<?php echo __('e.g. 051243'); ?>"  name="lemail" size="30" value="<?php echo $ticketid; ?>" class="form-control">
            
        </div>
        <!-- <div>
            <label for="ticketno"><?php echo __('Ticket Number'); ?>:
            <input id="ticketno" type="text" name="lticket" placeholder="<?php echo __('e.g. 051243'); ?>"
                size="30" value="<?php echo $ticketid; ?>" class="nowarn"></label>
        </div> -->
        <p class="text-center mb-5">
            <input class="btn btnh btn-mes-ser mx-auto" type="submit" value="<?php echo $button; ?>">
            <!-- <input class="btn" type="submit" value="<?php echo $button; ?>"> -->
        </p>
    </div>
    
    <div class="instructions mb-3">
        <?php if ($cfg && $cfg->getClientRegistrationMode() !== 'disabled') { ?>
                <?php echo __('Have an account with us?'); ?>
                <a href="login.php"><?php echo __('Sign In'); ?></a> 
            <?php
            if ($cfg->isClientRegistrationEnabled()) { ?>
        <?php echo sprintf(__('or %s register for an account %s to access all your tickets.'),
            '<a href="account.php?do=create">','</a>');
            }
        }?>
    </div>
</div>
</form>
<br>
<p>
<?php
if ($cfg->getClientRegistrationMode() != 'disabled' || !$cfg->isClientLoginRequired()) {
    echo sprintf(
    __("If this is your first time contacting us or you've lost the ticket number, please %s open a new ticket %s"),
        '','');
} ?>
</p>
