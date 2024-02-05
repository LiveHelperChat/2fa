<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','IP Restrictions')?></h1>

<p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Force user who are not in defined IP range to setup 2FA before allowing to login.')?></p>

E.g

<ul>
    <li>Wildcard format:     1.2.3.*</li>
    <li>CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0</li>
    <li>Start-End IP format: 1.2.3.0-1.2.3.255</li>
</ul>

<?php if (isset($settingsupdated)) : ?>
    <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Settings updated'); ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif;?>

<form action="" method="post">
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>
    <div class="form-group">
        <input placeholder="191.168.1.*" name="ip_restrictions" type="text" class="form-control form-control-sm" value="<?php echo htmlspecialchars($ip_restrictions);?>" />
    </div>

    <div class="form-group">
        <label><input type="checkbox" value="on" name="2fa_required_by_ip" <?php if ($required_by_ip == true) : ?>checked="checked"<?php endif;?> > Require 2FA setup if user is logging outside of defined IP range.</label>
    </div>

    <button class="btn btn-sm btn-primary" name="SaveIPRestrictions" type="submit">Save</button>
</form>


