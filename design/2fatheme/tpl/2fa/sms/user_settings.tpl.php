<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->enabled == true) : ?>checked="checked"<?php endif;?> name="twofasmsEnabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled')?></label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><input value="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'sms' : print 'on'?>" type="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'radio' : print 'checkbox'?>" <?php if ($instance->default == true) : ?>checked="checked"<?php endif;?> name="twofaDefault" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Default')?></label>
        </div>
    </div>
</div>
<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Your mobile phone number')?></label>
    <input type="text" name="twofaphone" value="<?php echo $instance->getAttribute('phone');?>" class="form-control" />
</div>