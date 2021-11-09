<?php

class erLhcoreClassExtension2FAHandlersms {

    const TIMEOUT_RESEND = 120;

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

    public function getBody($session, $method, $defaultMethod = '')
    {
        $tpl = new erLhcoreClassTemplate();
        $tpl->set('session', $session);
        $tpl->set('method', $method);
        $tpl->set('default_method', $defaultMethod);
        
        return $tpl->fetch('2fa/sms/verify.tpl.php');
    }

    // Send SMS Event if it's required
    public static function prepareSession($params) {

        if ((isset($params['total']) && $params['total'] == 1) || $params['2fa']->default == 1 || (isset($params['test']) && $params['test'] === true)) {

            $code = '';
            for ($i = 1; $i <= 6; $i++) {
                $code .= mt_rand(1,9);
            }

            $params['session']->setAttribute('code',$code);

            try {

                $diff = (time() - $params['2fa']->lsend);
                if ($diff < self::TIMEOUT_RESEND) {
                    throw new Exception('Please wait a little while before trying again!');
                }

                $params['2fa']->lsend = time();
                $params['2fa']->saveThis();

                erLhcoreClassChatEventDispatcher::getInstance()->dispatch('user.2fa_sms', array( 'session' => $params['session'], '2fa' => $params['2fa']));
                $params['session']->removeAttribute('sms_error');
            } catch (Exception $e) {
                $params['session']->setAttribute('sms_error',$e->getMessage());
            }
        }
    }
}