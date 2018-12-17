<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/googleauthentificator.tpl.php');

$g = new \Google\Authenticator\GoogleAuthenticator();

$ext = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

$userData = erLhcoreClassUser::instance()->getUserData();

$instance = erLhcoreClassModel2FAUser::getInstance($currentUser->getUserID(), 'ga');

if ((isset($_GET['new']) && $_GET['new'] == 1) || ($secret = $instance->getAttribute('secret')) == '') {
    $secret = $g->generateSecret();
    $instance->setAttribute('secret',$secret);

    // New authentificator request
    if (isset($_GET['new']) && $_GET['new'] == 1) {
        erLhcoreClassModule::redirect('2fa/googleauthentificator');
        exit;
    }
}

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['test2fa'])) {
        if ($g->checkCode($secret, $_POST['code'])) {
            $tpl->set('codevalid', true);
        } else {
            $tpl->set('codevalid', false);
        }
    } else {
                
        if (isset($_POST['Default']) && $_POST['Default'] == true) {
            $instance->default = 1;
        } else {
            $instance->default = 0;
        }
        
        if (isset($_POST['Enabled']) && $_POST['Enabled'] == true) {
            $instance->enabled = 1;
        } else {
            $instance->enabled = 0;
        }
        $instance->saveThis();
    }
}

$link = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($userData->email, $secret, 'LiveHelperChatIconnectel');

$tpl->set('img', $link);
$tpl->set('instance', $instance);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('2fa/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')),
    array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Google Authentificator'))
);

?>