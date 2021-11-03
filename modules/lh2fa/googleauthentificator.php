<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/googleauthentificator.tpl.php');

$g = new \Google\Authenticator\GoogleAuthenticator();

$ext = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

$userData = erLhcoreClassUser::instance()->getUserData();

$instance = erLhcoreClassModel2FAUser::getInstance($currentUser->getUserID(), 'ga');

$t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_options');
$dataOptions = (array)$t2faOptions->data;

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

        if (isset($_POST['ga_enabled']) && $_POST['ga_enabled'] == 'on') {
            $dataOptions['ga_enabled'] = true;
        } else {
            $dataOptions['ga_enabled'] = false;
        }

        $t2faOptions->explain = '';
        $t2faOptions->type = 0;
        $t2faOptions->hidden = 1;
        $t2faOptions->identifier = '2fa_options';
        $t2faOptions->value = serialize($dataOptions);
        $t2faOptions->saveThis();

        if (isset($_POST['twofaDefault']) && $_POST['twofaDefault'] == true) {
            $instance->default = 1;
        } else {
            $instance->default = 0;
        }
        
        if (isset($_POST['twofagaEnabled']) && $_POST['twofagaEnabled'] == true) {
            $instance->enabled = 1;
        } else {
            $instance->enabled = 0;
        }

        $tpl->set('settingsupdated',true);

        $instance->saveThis();
    }
}

$link = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($userData->id, $secret, $ext->settings['ga_title']);

$tpl->set('img', $link);
$tpl->set('instance', $instance);
$tpl->set('tfaoptions', $dataOptions);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('2fa/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')),
    array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Google Authentificator'))
);

?>