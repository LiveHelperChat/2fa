<script src="<?php echo erLhcoreClassDesign::designJS('js/2fasms.js');?>"></script>
<div class="row">
    <div class="col-xs-12" id="sms-2fa-errors-container">
    <?php if (($error = $session->getAttribute('sms_error')) !== null) : $errors = array($error)?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <?php endif; ?>
    </div>
    <div class="col-xs-7">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enter code')?></label>
            <input id="smsCode" type="text" class="form-control" value="" />
        </div>
    </div>
    <div class="col-xs-5">
        <div><label>&nbsp;</label></div>
        <div class="btn-group pull-right" role="group">
            <button type="button" class="btn btn-default btn-success" onclick="twofasms.verify($('#smsCode').val())"><i class="material-icons">verified_user</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify')?></button>
            <button type="button" class="btn btn-info" onclick="twofasms.resend()"><i class="material-icons">sms</i>Resend</button>
        </div>
    </div>
</div>
