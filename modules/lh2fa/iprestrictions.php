<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/iprestrictions.tpl.php');

$t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_iprestrictions');
$dataOptions = (array)$t2faOptions->data;

if (ezcInputForm::hasPostData()) {
    // E-mail attributes save
    if (isset($_POST['ip_restrictions'])) {
        $dataOptions['ip_restrictions'] = $_POST['ip_restrictions'];
    }

    if (isset($_POST['2fa_required_by_ip'])) {
        $dataOptions['2fa_required_by_ip'] = true;
    } else {
        $dataOptions['2fa_required_by_ip'] = false;
    }

    $t2faOptions->explain = '';
    $t2faOptions->type = 0;
    $t2faOptions->hidden = 1;
    $t2faOptions->identifier = '2fa_iprestrictions';
    $t2faOptions->value = serialize($dataOptions);
    $t2faOptions->saveThis();

    $tpl->set('settingsupdated',true);
}

$tpl->set('ip_restrictions',isset($dataOptions['ip_restrictions']) ? $dataOptions['ip_restrictions'] : '');
$tpl->set('required_by_ip', isset($dataOptions['2fa_required_by_ip']) ? $dataOptions['2fa_required_by_ip'] : false);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(array('url' => erLhcoreClassDesign::baseurl('2fa/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','IP Restrictions')));

?>