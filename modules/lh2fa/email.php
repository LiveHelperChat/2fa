<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/email.tpl.php');

$ext = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

$userData = erLhcoreClassUser::instance()->getUserData();

$instance = erLhcoreClassModel2FAUser::getInstance($currentUser->getUserID(), 'email');

$t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_options');
$dataOptions = (array)$t2faOptions->data;

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['save2fa']) || isset($_POST['testsms'])) {

        // E-mail attributes save
        if (isset($_POST['email_subject'])) {
            $dataOptions['email_subject'] = $_POST['email_subject'];
        }

        if (isset($_POST['email_enabled']) && $_POST['email_enabled'] == 'on') {
            $dataOptions['email_enabled'] = true;
        } else {
            $dataOptions['email_enabled'] = false;
        }

        if (isset($_POST['email_body'])) {
            $dataOptions['email_body'] = $_POST['email_body'];
        }

        if (isset($_POST['email_from'])) {
            $dataOptions['email_from'] = $_POST['email_from'];
        }

        // General attributes set
        if (isset($_POST['twofaDefault']) && $_POST['twofaDefault'] == true) {
            $instance->default = 1;
        } else {
            $instance->default = 0;
        }

        if (isset($_POST['twofaemailEnabled']) && $_POST['twofaemailEnabled'] == true) {
            $instance->enabled = 1;
        } else {
            $instance->enabled = 0;
        }

        $instance->saveThis();

        $t2faOptions->explain = '';
        $t2faOptions->type = 0;
        $t2faOptions->hidden = 1;
        $t2faOptions->identifier = '2fa_options';
        $t2faOptions->value = serialize($dataOptions);
        $t2faOptions->saveThis();

        $tpl->set('settingsupdated',true);
    }

    if (isset($_POST['testsms'])) {

        $session = erLhcoreClassModel2FASession::findOne(array('filter' => array('user_id' => $currentUser->getUserID())));

        if ($session instanceof erLhcoreClassModel2FASession) {
            if ($session->getAttribute('code') == $_POST['code']) {
                $tpl->set('codevalid', true);
                $session->removeThis();
            } else {
                $tpl->set('codevalid', false);
            }
        } else {
            $tpl->set('codevalid', false);
        }

    } else if (isset($_POST['sendTestSMS'])) {

        $twofa = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

        try {
            $session = $twofa->generateSession($currentUser->getUserID(), false, array($instance), true);

            if ($session->getAttribute('email_error') !== null) {
                throw new Exception($session->getAttribute('email_error'));
            }

            $tpl->set('emailsend',true);
        } catch (Exception $e) {
            $tpl->set('errors', array($e->getMessage()));
        }
    }
}

$tpl->set('instance', $instance);
$tpl->set('tfaoptions', $dataOptions);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('2fa/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')),
    array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','E-Mail'))
);

?>