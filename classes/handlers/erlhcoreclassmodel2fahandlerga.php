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

    public function getBody()
    {
        $tpl = new erLhcoreClassTemplate();
        return $tpl->fetch('2fa/ga/verify.tpl.php');
    }
}