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

        <form action="" method="post">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label><input value="on" type="checkbox" <?php if ($instance->enabled == true) : ?>checked="checked"<?php endif;?> name="Enabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled for my account')?></label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label><input value="on" type="checkbox" <?php if ($instance->default == true) : ?>checked="checked"<?php endif;?> name="Default" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Default for my account')?></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo $instance->getAttribute('phone');?>" class="form-control" />
            </div>
            <input type="submit" name="save2fa" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Save settings')?>">
            <input type="submit" name="sendTestSMS" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Send test SMS')?>">
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

