<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/attemptlimit.tpl.php');
$tpl->set('errors',array('You have reached max of ' . erLhcoreClassModel2FASession::RETRIES_MAX . ' retries limit'));

$Result['pagelayout'] = 'login';
$Result['content'] = $tpl->fetch();
$Result['path'] = array(array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')));

?>