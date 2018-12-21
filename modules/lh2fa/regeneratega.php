<?php

header ( 'content-type: application/json; charset=utf-8' );

try {
    $g = new \Google\Authenticator\GoogleAuthenticator();

    $ext = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

    $userData = erLhcoreClassModelUser::fetch($Params['user_parameters']['user_id']);

    if ($userData->id != erLhcoreClassUser::instance()->getUserID() && !erLhcoreClassUser::instance()->hasAccessTo('lhuser', 'edituser')) {
        throw new Exception('You do not have permission to regenerate QR Code for this user!');
    }

    $instance = erLhcoreClassModel2FAUser::getInstance($userData->id, 'ga');

    $secret = $g->generateSecret();
    
    $instance->setAttribute('secret',$secret);

    $link = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($userData->email, $secret, $ext->settings['ga_title']);

    echo json_encode(array('error' => false, 'src' => $link));

} catch (Exception $e) {
    echo json_encode(array('error' => true,'msg' => $e->getMessage()));
}
exit;



