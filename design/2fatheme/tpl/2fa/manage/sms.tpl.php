<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','SMS')?></h1>

<div class="row">
    <div class="col-xs-6">
        <?php if (isset($errors)) : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
        <?php endif;?>

        <?php if (isset($settingsupdated)) : ?>
            <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
        <?php endif;?>

        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Global settings')?></h4>
        <label><input value="on" type="checkbox" <?php if (isset($tfaoptions['sms_enabled']) && $tfaoptions['sms_enabled'] == true) : ?>checked="checked"<?php endif;?>  name="sms_enabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled for users to choose in personal settings')?></label>

    </div>
</div>

