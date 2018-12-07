<?php

$tpl = erLhcoreClassTemplate::getInstance( '2fa/index.tpl.php');
$Result['content'] = $tpl->fetch();
$Result['path'] = array(array('url' => erLhcoreClassDesign::baseurl('2fa/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','2FA')));

?>