<?php

header ( 'content-type: application/json; charset=utf-8' );

$session = erLhcoreClassModel2FASession::findOne(array('filter' => array('hash' => $Params['user_parameters']['hash'])));

if ($session instanceof erLhcoreClassModel2FASession) {

    // session has expired
    if ($session->ctime < (time()-(10*60))) {
        $session->removeThis();
        echo json_encode(array('error' => true, 'url' => erLhcoreClassDesign::baseurl('2fa/expired')));
        exit;
    }

    $validMethod = array(
        'sms',
        'email',
        'ga',
    );

    erLhcoreClassChatEventDispatcher::getInstance()->dispatch('chat.validstatus_chat', array('user.2fa_methods' => & $validMethod));

    if (!in_array($Params['user_parameters']['method'], $validMethod)) {
        echo json_encode(array('error' => true, 'msg' => 'Provided method is not valid!'));
        exit;
    }

    $active2FA = erLhcoreClassModel2FAUser::findOne(array('filter' => array('method' => $Params['user_parameters']['method'], 'enabled' => 1, 'user_id' => $session->user_id)));

    if ($active2FA instanceof erLhcoreClassModel2FAUser) {

        if (class_exists('erLhcoreClassExtension2FAHandler' . $Params['user_parameters']['method'])) {
            call_user_func('erLhcoreClassExtension2FAHandler'.$Params['user_parameters']['method'].'::prepareSession',array('test' => true, 'session' => & $session, '2fa' => $active2FA));
        }

        if ($session->getAttribute($Params['user_parameters']['method'].'_error') === null) {
            echo json_encode(array('error' => false, 'msg' => 'We\'ve sent you a verification code.'));
        } else {
            echo json_encode(array('error' => true, 'msg' => $session->getAttribute($Params['user_parameters']['method'] . '_error')));
        }

    } else {
        echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA Method could not be found')));
    }

} else {
    echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Invalid session')));
}
exit;

?>