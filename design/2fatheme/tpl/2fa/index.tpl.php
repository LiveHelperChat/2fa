<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')?></h1>

<div class="row">
    <div class="col-sm-4">
        <ul>
            <li><a href="<?php echo erLhcoreClassDesign::baseurl('2fa/googleauthentificator')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Google Authentificator')?></a></li>
            <li><a href="<?php echo erLhcoreClassDesign::baseurl('2fa/sms')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','SMS')?></a></li>
            <li><a href="<?php echo erLhcoreClassDesign::baseurl('2fa/email')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','E-Mail')?></a></li>
        </ul>
    </div>
</div>

<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Restrictions')?></h1>

<div class="row">
    <div class="col-sm-4">
        <ul>
            <li><a href="<?php echo erLhcoreClassDesign::baseurl('2fa/iprestrictions')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','IP Restrictions')?></a></li>
        </ul>
    </div>
</div>

