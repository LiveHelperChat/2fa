<?php $instance = erLhcoreClassModel2FAUser::getInstance($user->id, 'email'); ?>
<?php include(erLhcoreClassDesign::designtpl('2fa/email/user_settings.tpl.php'));?>