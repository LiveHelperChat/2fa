<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','SMS')?></h1>

<div class="row">
    <div class="col-xs-6">

        <?php if (isset($errors)) : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
        <?php endif;?>

        <?php if (isset($smssend)) : ?>
            <?php $msg = 'SMS Was send'; ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
        <?php endif;?>

        <?php if (isset($settingsupdated)) : ?>
            <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
        <?php endif;?>

        <form action="" method="post">
            <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Global settings')?></h4>
            <label><input value="on" type="checkbox" <?php if (isset($tfaoptions['sms_enabled']) && $tfaoptions['sms_enabled'] == true) : ?>checked="checked"<?php endif;?>  name="sms_enabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled for users to choose in personal settings')?></label>

            <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Personal settings')?></h4>
            <?php include(erLhcoreClassDesign::designtpl('2fa/sms/user_settings.tpl.php'));?>

            <div class="btn-group" role="group" aria-label="...">
                <input type="submit" name="save2fa" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Save settings')?>">
                <input type="submit" name="sendTestSMS" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Send test SMS')?>">
            </div>
        </form>
    </div>
    <div class="col-xs-6">
        <form action="" method="post">

            <?php if (isset($codevalid) && $codevalid === false) : ?>
                <?php $errors = array(erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Code invalid')); ?>
                <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
            <?php elseif (isset($codevalid) && $codevalid === true) : ?>
                <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Code valid!'); ?>
                <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
            <?php endif; ?>

            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enter code to test')?></label>
                <input class="form-control" type="text" name="code" value="">
            </div>

            <input type="submit" name="testsms" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify code')?>">
        </form>
    </div>
</div>

