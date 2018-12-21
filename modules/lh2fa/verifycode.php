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

    $secret = erLhcoreClassModel2FAUser::findOne(array('filter' => array('method' => $Params['user_parameters']['method'], 'enabled' => 1, 'user_id' => $session->user_id)));

    if ($secret instanceof erLhcoreClassModel2FAUser) {

        $codeValid = false;
        if ($Params['user_parameters']['method'] == 'ga') {
            $g = new \Google\Authenticator\GoogleAuthenticator();
            $codeValid = $g->checkCode($secret->attr_array['secret'], $_POST['code']);
        } else {
            $codeValid = $session->getAttribute('code') == $_POST['code'];
        }

        if ($codeValid === true) {

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