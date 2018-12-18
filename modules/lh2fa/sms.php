<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/sms.tpl.php');

$ext = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

$userData = erLhcoreClassUser::instance()->getUserData();

$instance = erLhcoreClassModel2FAUser::getInstance($currentUser->getUserID(), 'sms');

if (ezcInputForm::hasPostData()) {

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

                if ($session->getAttribute('sms_error') !== null){
                    throw new Exception($session->getAttribute('sms_error'));
                }

                $tpl->set('smssend',true);
            } catch (Exception $e) {
                $tpl->set('errors', array($e->getMessage()));
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

            if (isset($_POST['phone'])) {
                $instance->setAttribute('phone',$_POST['phone']);
            } else {
                $instance->setAttribute('phone','');
            }
        }

        $instance->saveThis();
}

$tpl->set('instance', $instance);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('2fa/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA')),
    array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','SMS'))
);

?>