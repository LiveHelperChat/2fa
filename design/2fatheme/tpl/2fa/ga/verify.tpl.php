<script src="<?php echo erLhcoreClassDesign::designJS('js/2faga.js');?>"></script>
<div class="row" ng-non-bindable>
    <div class="col-12">
          <p>You can obtain a security code from your Google Authenticator App. Please enter the security code below.</p>
    </div>
    <div class="col-sm-6 col-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enter code')?></label>
            <input id="gaCode" type="text" class="form-control form-control-sm" value="" />
        </div>
    </div>
    <div class="col-sm-6 col-12">
        <div class="form-group">
            <div class="hidden-xs"><label>&nbsp;</label></div>
            <div class="btn-group d-flex" role="group">
                <button type="button" class="btn btn-secondary btn-sm btn-success w-100" onclick="twofaga.verify($('#gaCode').val())"><i class="material-icons">verified_user</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify')?></button>
            </div>
        </div>
    </div>
</div>
