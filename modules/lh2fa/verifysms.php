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

    $secret = erLhcoreClassModel2FAUser::findOne(array('filter' => array('method' => 'sms', 'enabled' => 1, 'user_id' => $session->user_id)));

    if ($secret instanceof erLhcoreClassModel2FAUser) {

        if ($session->getAttribute('code') == $_POST['code']) {

            // Login by session hash will work now
            $session->valid = 1;
            $session->saveThis();

            echo json_encode(array('error' => false, 'url' => erLhcoreClassDesign::baseurl('2fa/loginbyhash') . '/' . $session->hash));
        } else {
            $session->retries++;
            $session->saveThis();

            if ($session->retries < 3) {
                echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Invalid code')));
            } else {
                $session->removeThis();
                echo json_encode(array('error' => true, 'url' => erLhcoreClassDesign::baseurl('user/login')));
            }
        }

    } else {
        echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA Method could not be found')));
    }

} else {
    echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Invalid session')));
}
exit;

?>