<script src="<?php echo erLhcoreClassDesign::designJS('js/2faga.js');?>"></script>
<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enter code')?></label>
            <input id="gaCode" type="text" class="form-control" value="" />
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <div><label>&nbsp;</label></div>
            <input type="submit" class="btn btn-default btn-block" onclick="twofaga.verify($('#gaCode').val())" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verify')?>" />
        </div>
    </div>
</div>
