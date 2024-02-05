<div class="row" ng-non-bindable>
    <div class="col-6">
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->enabled == true) : ?>checked="checked"<?php endif;?> name="twofaemailEnabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled')?></label>
        </div>
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->require_by_ip == true) : ?>checked="checked"<?php endif;?> name="twofaemailRequireByIP" /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Require only if I login from outside defined IP range. Your IP')?> - <span class="badge bg-secondary"><?php echo htmlspecialchars(erLhcoreClassIPDetect::getIP());?></span> </label>
            <p><small class="text-muted"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','If no IP range is defined 2FA will always be required.')?></small></p>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><input value="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'email' : print 'on'?>" type="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'radio' : print 'checkbox'?>" <?php if ($instance->default == true) : ?>checked="checked"<?php endif;?> name="twofaDefault" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Default')?></label>
        </div>
    </div>
</div>