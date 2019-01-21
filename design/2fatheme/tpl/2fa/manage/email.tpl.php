<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','E-Mail')?></h1>

<div class="row">
    <div class="col-6">

        <?php if (isset($errors)) : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
        <?php endif;?>

        <?php if (isset($emailsend)) : ?>
            <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Test email was sent'); ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
        <?php endif;?>

        <?php if (isset($settingsupdated)) : ?>
            <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
            <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
        <?php endif;?>

        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Global settings')?></h4>
        <label><input value="on" type="checkbox" <?php if (isset($tfaoptions['email_enabled']) && $tfaoptions['email_enabled'] == true) : ?>checked="checked"<?php endif;?>  name="email_enabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled for users to choose in personal settings')?></label>

        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','E-Mail settings')?></h4>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Subject')?></label>
                    <input type="text" class="form-control" name="email_subject" value="<?php (isset($tfaoptions['email_subject']) && $tfaoptions['email_subject'] != '') ? print htmlspecialchars($tfaoptions['email_subject']) : print erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Your code')?>" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','From name')?></label>
                    <input type="text" class="form-control" name="email_from" value="<?php (isset($tfaoptions['email_from']) && $tfaoptions['email_from'] != '') ? print htmlspecialchars($tfaoptions['email_from']) : print erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA Verification')?>" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Message body</label>
            <textarea class="form-control" placeholder="Your verification code: {code}" name="email_body"><?php (isset($tfaoptions['email_body'])) ? print htmlspecialchars($tfaoptions['email_body']) : print erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verification code: {code}')?></textarea>
        </div>

    </div>
</div>

