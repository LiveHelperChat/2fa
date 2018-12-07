<?php

$session = erLhcoreClassModel2FASession::findOne(array('filter' => array('hash' => $Params['user_parameters']['hash'])));

if ($session instanceof erLhcoreClassModel2FASession) {

    // session has expired
    if ($session->ctime < (time()-(10*60))) {
        $session->removeThis();
        echo json_encode(array('error' => true, 'url' => erLhcoreClassDesign::baseurl('user/login')));
        exit;
    }

    // Remove current session
    $session->removeThis();

    // Login user instantly as during password change he verified his logins
    erLhcoreClassUser::instance()->setLoggedUser($session->user_id, $session->remember == 1);

    erLhcoreClassModule::redirect('/');
    exit;

} else {
    erLhcoreClassModule::redirect('user/login');
    exit;
}

?>