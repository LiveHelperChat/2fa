<?php
    $instance = erLhcoreClassModel2FAUser::getInstance($user->id, 'ga');
    if ($user->id > 0) {

        if ($instance->getAttribute('secret') === null) {
            $g = new \Google\Authenticator\GoogleAuthenticator();
            $instance->setAttribute('secret', $g->generateSecret());
        }
        
        $img = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($user->id, $instance->getAttribute('secret'), erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtension2fa')->settings['ga_title']);

    }
?><?php include(erLhcoreClassDesign::designtpl('2fa/ga/user_settings.tpl.php'));?>