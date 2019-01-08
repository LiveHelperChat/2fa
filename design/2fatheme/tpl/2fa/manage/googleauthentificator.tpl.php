<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Google Authentificator')?></h1>

<div class="row">
    <div class="col-xs-6">
        <?php if (isset($settingsupdated)) : ?>
            <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
        <?php endif;?>

        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Global settings')?></h4>
        <label><input value="on" type="checkbox" <?php if (isset($tfaoptions['ga_enabled']) && $tfaoptions['ga_enabled'] == true) : ?>checked="checked"<?php endif;?>  name="ga_enabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled for users to choose in personal settings')?></label>
    </div>
</div>

