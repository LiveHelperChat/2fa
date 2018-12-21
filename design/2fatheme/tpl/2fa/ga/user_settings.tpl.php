<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            <label><input value="on" type="checkbox" <?php if ($instance->enabled == true) : ?>checked="checked"<?php endif;?> name="twofagaEnabled" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Enabled')?></label>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label><input value="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'ga' : print 'on'?>" type="<?php (isset($twofasingledefault) && $twofasingledefault == true) ? print 'radio' : print 'checkbox'?>" <?php if ($instance->default == true) : ?>checked="checked"<?php endif;?> name="twofaDefault" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Default')?></label>
        </div>
    </div>
</div>

<?php if ($instance->user_id > 0 && isset($img)) : ?>
<div class="form-group">
    <div><label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Scan the code with your mobile phone')?>. <a onclick="return twofaRegenerate()"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Regenerate')?></a></label></div>
    <a href="<?php echo $img; ?>"><img id="twofa-ga-img" src="<?php echo $img?>" alt="" /></a>
</div>

<script>
    function twofaRegenerate() {
        $.postJSON(WWW_DIR_JAVASCRIPT  + '2fa/regeneratega/<?php print $instance->user_id?>', function(data) {
            if (data.error == false) {
                $('#twofa-ga-img').attr('src',data.src);
            } else {
                alert(data.msg);
            }
        });
        return false;
    }
</script>
<?php endif; ?>