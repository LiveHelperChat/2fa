<?php

class erLhcoreClassExtension2FAHandlersms {

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
        return "SMS Verification";
    }

    public function getBody($session)
    {
        $tpl = new erLhcoreClassTemplate();
        $tpl->set('session',$session);
        return $tpl->fetch('2fa/sms/verify.tpl.php');
    }

    // Send SMS Event if it's required
    public static function prepareSession($params) {

        $code = '';
        for ($i = 1; $i <= 6; $i++) {
            $code .= mt_rand(1,9);
        }

        $params['session']->setAttribute('code',$code);

        if ($params['total'] == 1 ||$params['2fa']->default == 1 || (isset($params['test']) && $params['test'] === true)) {
            try {
                erLhcoreClassChatEventDispatcher::getInstance()->dispatch('user.2fa_sms', array( 'session' => $params['session'], '2fa' => $params['2fa']));
                $params['session']->removeAttribute('sms_error');
            } catch (Exception $e) {
                $params['session']->setAttribute('sms_error',$e->getMessage());
            }
        }
    }
}