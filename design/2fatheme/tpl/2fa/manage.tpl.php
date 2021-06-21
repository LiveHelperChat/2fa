<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif;?>

<?php if (isset($updated)) : ?>
    <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings were updated'); ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif;?>

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-item"><a class="active nav-link" href="#twofa-sms" aria-controls="twofa-sms" role="tab" data-toggle="tab" ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','SMS');?></a></li>
    <li role="presentation" class="nav-item"><a class="nav-link" href="#twofa-email" aria-controls="twofa-email" role="tab" data-toggle="tab" ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Email');?></a></li>
    <li role="presentation" class="nav-item"><a class="nav-link" href="#twofa-ga" aria-controls="twofa-ga" role="tab" data-toggle="tab" ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Google Authenticator');?></a></li>
</ul>

<form action="" method="post" autocomplete="off">

    <div class="tab-content" ng-non-bindable>
        <div role="tabpanel" class="tab-pane active" id="twofa-sms">
            <?php include(erLhcoreClassDesign::designtpl('2fa/manage/sms.tpl.php'));?>
        </div>
        <div role="tabpanel" class="tab-pane" id="twofa-email">
            <?php include(erLhcoreClassDesign::designtpl('2fa/manage/email.tpl.php'));?>
        </div>
        <div role="tabpanel" class="tab-pane" id="twofa-ga">
            <?php include(erLhcoreClassDesign::designtpl('2fa/manage/googleauthentificator.tpl.php'));?>
        </div>
    </div>

    <input type="submit" class="btn btn-secondary" name="UpdateAgentSMSInfoAction" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Update');?>" />

</form>
