<div role="tabpanel" class="tab-pane <?php if ($tab == 'tab_2fa') : ?>active<?php endif;?>" id="twofa">
    <?php
        $t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_options');
        $dataOptions = (array)$t2faOptions->data;
        $twofasingledefault = true;
    ?>

    <?php if ($user->id > 0) : ?>
        <form action="" method="post">
    <?php endif; ?>

    <?php if (isset($twosettingsupdated)) : ?>
        <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php endif;?>

    <ul class="nav nav-tabs" role="tablist">
        <?php if (isset($dataOptions['sms_enabled']) && $dataOptions['sms_enabled'] == true) : ?>
        <li role="presentation"><a href="#twofa-sms" aria-controls="twofa-sms" role="tab" data-toggle="tab" ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','SMS');?></a></li>
        <?php endif; ?>
        <?php if (isset($dataOptions['email_enabled']) && $dataOptions['email_enabled'] == true) : ?>
        <li role="presentation"><a href="#twofa-email" aria-controls="twofa-email" role="tab" data-toggle="tab" ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Email');?></a></li>
        <?php endif; ?>
        <?php if (isset($dataOptions['ga_enabled']) && $dataOptions['ga_enabled'] == true) : ?>
        <li role="presentation"><a href="#twofa-ga" aria-controls="twofa-ga" role="tab" data-toggle="tab" ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Google Authenticator');?></a></li>
        <?php endif; ?>
    </ul>

    <div class="tab-content">
        <?php if (isset($dataOptions['sms_enabled']) && $dataOptions['sms_enabled'] == true) : ?>
        <div role="tabpanel" class="tab-pane active" id="twofa-sms">
            <?php include(erLhcoreClassDesign::designtpl('2fa/account/sms.tpl.php'));?>
        </div>
        <?php endif; ?>
        <?php if (isset($dataOptions['email_enabled']) && $dataOptions['email_enabled'] == true) : ?>
        <div role="tabpanel" class="tab-pane" id="twofa-email">
            <?php include(erLhcoreClassDesign::designtpl('2fa/account/email.tpl.php'));?>
        </div>
        <?php endif; ?>
        <?php if (isset($dataOptions['ga_enabled']) && $dataOptions['ga_enabled'] == true) : ?>
        <div role="tabpanel" class="tab-pane" id="twofa-ga">
            <?php include(erLhcoreClassDesign::designtpl('2fa/account/ga.tpl.php'));?>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($user->id > 0) : ?>
         <input type="submit" name="savetwofa" value="Save" class="btn btn-default" />
        </form>
    <?php else : ?>
        <input type="submit" class="btn btn-default" name="Update_account" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save');?>">
    <?php endif; ?>

</div>