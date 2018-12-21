<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/sms.tpl.php');

$ext = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa');

$userData = erLhcoreClassUser::instance()->getUserData();

$instance = erLhcoreClassModel2FAUser::getInstance($currentUser->getUserID(), 'sms');

$t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_options');
$dataOptions = (array)$t2faOptions->data;

if (ezcInputForm::hasPostData()) {

        if (isset($_POST['save2fa']) || isset($_POST['sendTestSMS'])) {


            if (isset($_POST['sms_enabled']) && $_POST['sms_enabled'] == 'on') {
                $dataOptions['sms_enabled'] = true;
            } else {
                $dataOptions['sms_enabled'] = false;
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

            if (isset($_POST['twofasmsEnabled']) && $_POST['twofasmsEnabled'] == true) {
                $instance->enabled = 1;
            } else {
                $instance->enabled = 0;
            }

            if (isset($_POST['twofaphone'])) {
                $instance->setAttribute('phone',$_POST['twofaphone']);
            } else {
                $instance->setAttribute('phone','');
            }

            $tpl->set('settingsupdated',true);

            $instance->saveThis();
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

                if ($session->getAttribute('sms_error') !== null){
                    throw new Exception($session->getAttribute('sms_error'));
                }

                $tpl->set('smssend',true);
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
    array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','SMS'))
);

?>