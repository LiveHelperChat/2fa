<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Google Authentificator')?></h1>

<div class="row">
    <div class="col-6">
        <form action="" method="post">

            <?php if (isset($settingsupdated)) : ?>
                <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
                <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
            <?php endif;?>
            
            <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Global settings')?></h4>
            <label><input value="on" type="checkbox" <?php if (isset($tfaoptions['ga_enabled']) && $tfaoptions['ga_enabled'] == true) : ?>checked="checked"<?php endif;?>  name="ga_enabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled for users to choose in personal settings')?></label>
            
            <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Personal settings')?></h4>
            <?php include(erLhcoreClassDesign::designtpl('2fa/ga/user_settings.tpl.php'));?>

            <input type="submit" name="save2fa" class="btn btn-secondary" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Save settings')?>">
        </form>
    </div>
    <div class="col-6">
        <form action="" method="post" ng-non-bindable>

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

            <input type="submit" name="test2fa" class="btn btn-secondary" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify code')?>">
        </form>
    </div>
</div>

