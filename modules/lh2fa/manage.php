<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/manage.tpl.php');

$instance = erLhcoreClassModelInstance::fetch((int) $Params['user_parameters']['id']);
$tpl->set('instance', $instance);

$settings = erLhcoreClassModelIClickRestAPI::fetch('2fa_options', $instance, 'erLhcoreClassModelChatConfig');
$data2fa = (array)$settings->data;

if (ezcInputForm::hasPostData()) {

    $definition = array(
        'ga_enabled' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'boolean'),
        'sms_enabled' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'boolean'),
        'email_enabled' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'boolean'),
        'email_subject' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'),
        'email_from' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'),
        'email_body' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw')
    );

    $form = new ezcInputForm(INPUT_POST, $definition);
    $Errors = array();

    if ($form->hasValidData('ga_enabled') && ! empty($form->ga_enabled)) {
        $data2fa['ga_enabled'] = 1;
    } else {
        $data2fa['ga_enabled'] = 0;
    }

    if ($form->hasValidData('sms_enabled') && ! empty($form->sms_enabled)) {
        $data2fa['sms_enabled'] = 1;
    } else {
        $data2fa['sms_enabled'] = 0;
    }

    if ($form->hasValidData('email_enabled') && ! empty($form->email_enabled)) {
        $data2fa['email_enabled'] = 1;
    } else {
        $data2fa['email_enabled'] = 0;
    }

    if ($form->hasValidData('email_subject')) {
        $data2fa['email_subject'] = $form->email_subject;
    } else {
        $data2fa['email_subject'] = '';
    }

    if ($form->hasValidData('email_from')) {
        $data2fa['email_from'] = $form->email_from;
    } else {
        $data2fa['email_from'] = '';
    }

    if ($form->hasValidData('email_body')) {
        $data2fa['email_body'] = $form->email_body;
    } else {
        $data2fa['email_body'] = '';
    }

    $settings->explain = '';
    $settings->type = 0;
    $settings->hidden = 1;
    $settings->identifier = '2fa_options';
    $settings->value = serialize($data2fa);

    $response = erLhcoreClassModelIClickRestAPI::saveThis(erLhcoreClassModelIClickRestAPI::getObjectAttr($settings), $instance, 'erLhcoreClassModelChatConfig');

    if ($response['error'] == false) {
        $tpl->set('updated',true);
    } else {
        $tpl->set('errors',is_array($response['result']) ? $response['result']  : array($reponse['result']));
    }
}

$tpl->setArray(array(
    'tfaoptions' => $data2fa,
    'instance' => $instance
));

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('instance/list'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Instances')),
    array('url' => erLhcoreClassDesign::baseurl('instance/edit') . '/' . $instance->id, 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Edit instance') . ' - ' . $instance->address),
    array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','E-Mail'))
);

?>