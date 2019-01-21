<script src="<?php echo erLhcoreClassDesign::designJS('js/2fasms.js');?>"></script>
<div class="row">
    <div class="col-12" id="sms-2fa-errors-container">
    <?php if (($error = $session->getAttribute('sms_error')) !== null) : $errors = array($error)?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <?php endif; ?>
    </div>
    <div class="col-12">
          <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation("2fa/admin","Please enter the security code below when you receive it. If you haven't received one within the next 2 minutes click re-send.")?></p>
    </div>
    <div class="col-sm-7 col-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enter code')?></label>
            <input id="smsCode" type="text" class="form-control" value="" />
        </div>
    </div>
    <div class="col-sm-5 col-12">
        <div class="hidden-xs"><label>&nbsp;</label></div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-secondary btn-success" onclick="twofasms.verify($('#smsCode').val())"><i class="material-icons">verified_user</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify')?></button>
            <button type="button" class="btn btn-info" onclick="twofasms.resend()"><i class="material-icons">sms</i><?php if ($method->default == 1) : ?>Re-send<?php else : ?>Send<?php endif; ?></button>
        </div>
    </div>
</div>
