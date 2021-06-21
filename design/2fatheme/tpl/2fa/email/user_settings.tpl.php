<div class="row" ng-non-bindable>
    <div class="col-6">
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->enabled == true) : ?>checked="checked"<?php endif;?> name="twofaemailEnabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled')?></label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><input value="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'email' : print 'on'?>" type="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'radio' : print 'checkbox'?>" <?php if ($instance->default == true) : ?>checked="checked"<?php endif;?> name="twofaDefault" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Default')?></label>
        </div>
    </div>
</div>