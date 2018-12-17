<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/authentication.tpl.php');

$session = erLhcoreClassModel2FASession::findOne(array('filter' => array('hash' => $Params['user_parameters']['hash'])));

if ($session instanceof erLhcoreClassModel2FASession && $session->ctime > (time()-(10*60))) {
    $tpl->set('methods', erLhcoreClassModel2FAUser::getList(array('sort' => '`default` DESC','filter' => array('enabled' => 1, 'user_id' => $session->user_id))));
    $tpl->set('hash', $session->hash);
    $tpl->set('session', $session);
} else {
    $tpl->set('errors', array(erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verification hash has expired!')));
}

$Result['pagelayout'] = 'login';
$Result['content'] = $tpl->fetch();
$Result['path'] = array(array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')));

?>