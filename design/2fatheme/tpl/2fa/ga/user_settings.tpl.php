<div class="row" ng-non-bindable>
    <div class="col-6">
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->enabled == true) : ?>checked="checked"<?php endif;?> name="twofagaEnabled" /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled')?></label>
        </div>
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->require_by_ip == true) : ?>checked="checked"<?php endif;?> name="twofagaRequireByIP" /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Require only if I login from outside defined IP range. Your IP')?> - <span class="badge bg-secondary"><?php echo htmlspecialchars(erLhcoreClassIPDetect::getIP());?></span> </label>
            <p><small class="text-muted"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','If no IP range is defined 2FA will always be required.')?></small></p>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><input value="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'ga' : print 'on'?>" type="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'radio' : print 'checkbox'?>" <?php if ($instance->default == true) : ?>checked="checked"<?php endif;?> name="twofaDefault" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Default')?></label>
        </div>
    </div>
</div>

<?php if ($instance->user_id > 0 && isset($img)) : ?>
<div class="form-group">
    <div><label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Scan the code with your mobile phone')?>. <a id="2fa-regenerate-click" class="action-image"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Regenerate')?></a></label></div>
    <a href="<?php echo $img; ?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','If you do not see an image click me')?>" id="twofa-ga-url">
        <img id="twofa-ga-img" src="<?php echo $imgLoader?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','If you do not see an image click me')?>" />
    </a>
</div>

<script>
(function(){

    setTimeout(function(){
        $('#twofa-ga-img').attr('src','<?php echo $img?>');
    },1500);

    $('#2fa-regenerate-click').click(function(){
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/regeneratega/<?php print $instance->user_id?>', function(data) {
            $('#twofa-ga-img').attr('src',data.src_loading);

            if (data.error == false) {
                $('#twofa-ga-url').attr('href',data.src);

                setTimeout(function(){
                    $('#twofa-ga-img').attr('src',data.src);
                },1000);

            } else {
                alert(data.msg);
            }
        });
        return false;
    });

})();
</script>
<?php endif; ?>