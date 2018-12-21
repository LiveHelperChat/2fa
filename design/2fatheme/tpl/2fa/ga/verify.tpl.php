<script src="<?php echo erLhcoreClassDesign::designJS('js/2faga.js');?>"></script>
<div class="row">
    <div class="col-sm-7 col-xs-12">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enter code')?></label>
            <input id="gaCode" type="text" class="form-control" value="" />
        </div>
    </div>
    <div class="col-sm-5 col-xs-12">
        <div class="form-group">
            <div class="hidden-xs"><label>&nbsp;</label></div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-success" onclick="twofaga.verify($('#gaCode').val())"><i class="material-icons">verified_user</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify')?></button>
            </div>
        </div>
    </div>
</div>
