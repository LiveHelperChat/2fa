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

    $secret = erLhcoreClassModel2FAUser::findOne(array('filter' => array('method' => $Params['user_parameters']['method'], 'is_setup' => 0, 'enabled' => 1, 'user_id' => $session->user_id)));

    if (!($secret instanceof erLhcoreClassModel2FAUser)) {
        $secret = erLhcoreClassModel2FAUser::findOne(array('filter' => array('method' => $Params['user_parameters']['method'], 'is_setup' => 1, 'enabled' => 0, 'user_id' => $session->user_id)));
    }

    if ($secret instanceof erLhcoreClassModel2FAUser) {

        $codeValid = false;
        if ($Params['user_parameters']['method'] == 'ga') {
            $g = new \Google\Authenticator\GoogleAuthenticator();
            $codeValid = $g->checkCode($secret->attr_array['secret'], $_POST['code']);
        } else {
            $codeValid = $session->getAttribute('code') == $_POST['code'];
        }

        if ($codeValid === true) {

            // Reset so if user re-logins sending works again
            $secret->lsend = 0;
            $secret->is_setup = 0; // Remove that it's setup
            $secret->enabled = 1;  // Enable it just
            $secret->saveThis();

            // Login by session hash will work now
            $session->valid = 1;
            $session->saveThis();

            echo json_encode(array('error' => false, 'url' => erLhcoreClassDesign::baseurl('2fa/loginbyhash') . '/' . $session->hash));
        } else {
            $session->retries++;
            $session->saveThis();

            if ($session->retries < erLhcoreClassModel2FASession::RETRIES_MAX) {
                echo json_encode(array('error' => true, 'msg' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Invalid code')));
            } else {
                $session->removeThis();
                echo json_encode(array('error' => true, 'url' => erLhcoreClassDesign::baseurl('2fa/attemptlimit')));
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