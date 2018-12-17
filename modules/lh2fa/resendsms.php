<?php

header ( 'content-type: application/json; charset=utf-8' );

$session = erLhcoreClassModel2FASession::findOne(array('filter' => array('hash' => $Params['user_parameters']['hash'])));

if ($session instanceof erLhcoreClassModel2FASession) {

    // session has expired
    if ($session->ctime < (time()-(10*60))) {
        $session->removeThis();
        echo json_encode(array('error' => true, 'url' => erLhcoreClassDesign::baseurl('user/login')));
        exit;
    }

    $active2FA = erLhcoreClassModel2FAUser::findOne(array('filter' => array('method' => 'sms', 'enabled' => 1, 'user_id' => $session->user_id)));

    if ($active2FA instanceof erLhcoreClassModel2FAUser) {

        if (class_exists('erLhcoreClassExtension2FAHandlersms')) {
            call_user_func('erLhcoreClassExtension2FAHandlersms::prepareSession',array('session' => & $session, '2fa' => $active2FA));
        }

        if ($session->getAttribute('sms_error') === null){
            echo json_encode(array('error' => false, 'msg' => 'Verification code was send!'));
        } else {
            echo json_encode(array('error' => true, 'msg' => $session->getAttribute('sms_error')));
        }


    } else {
        echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA Method could not be found')));
    }

} else {
    echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Invalid session')));
}
exit;

?>