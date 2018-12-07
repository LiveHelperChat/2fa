<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Google Authentificator')?></h1>

<div class="row">
    <div class="col-xs-6">
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
                <div><label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Scan the code with your mobile phone')?>. <a href="<?php echo erLhcoreClassDesign::baseurl('2fa/googleauthentificator')?>?new=1"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Regenerate')?></a></label></div>
                <a href="<?php echo $img; ?>"><img src="<?php echo $img?>" alt="" /></a>
            </div>
            <input type="submit" name="save2fa" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Save settings')?>">
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

            <input type="submit" name="test2fa" class="btn btn-default" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify code')?>">
        </form>
    </div>
</div>

