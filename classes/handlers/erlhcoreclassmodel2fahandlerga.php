<?php

class erLhcoreClassExtension2FAHandlerga {

    public static function getInfo()
    {
        return new self();
    }

    public function getImage()
    {
        return null;
    }

    public function getTitle()
    {
        return "Google Authentificator";
    }

    public function getBody($session, $method, $defaultMethod = '', $isSetup = false)
    {
        $tpl = new erLhcoreClassTemplate();
        $tpl->set('session',$session);
        $tpl->set('method',$method);
        $tpl->set('default_method',$defaultMethod);
        $tpl->set('is_setup',$isSetup);
        return $tpl->fetch('2fa/ga/verify.tpl.php');
    }

    // Do nothing in GA Extension
    public static function prepareSession($params) {

    }
}