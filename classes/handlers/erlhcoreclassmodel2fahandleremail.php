<?php

class erLhcoreClassExtension2FAHandleremail {

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
        return "E-Mail Verification";
    }

    public function getBody($session, $method, $defaultMethod = '')
    {
        $tpl = new erLhcoreClassTemplate();
        $tpl->set('session',$session);
        $tpl->set('method',$method);
        $tpl->set('default_method',$defaultMethod);
        
        return $tpl->fetch('2fa/email/verify.tpl.php');
    }

    // Send SMS Event if it's required
    public static function prepareSession($params) {

        if ((isset($params['total']) && $params['total'] == 1) || $params['2fa']->default == 1 || (isset($params['test']) && $params['test'] === true)) {
            try {

                $diff = (time() - $params['2fa']->lsend);
                if ($diff < self::TIMEOUT_RESEND) {
                    throw new Exception('Please wait a little while before trying again!');
                }

                $params['2fa']->lsend = time();
                $params['2fa']->saveThis();

                $code = '';
                for ($i = 1; $i <= 6; $i++) {
                    $code .= mt_rand(1,9);
                }

                $params['session']->setAttribute('code',$code);

                $user = erLhcoreClassModelUser::fetch($params['2fa']->user_id);

                if ($user instanceof erLhcoreClassModelUser) {

                    $t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_options');
                    $dataOptions = (array)$t2faOptions->data;

                    $mail = new PHPMailer(true);
                    $mail->CharSet = "UTF-8";
                    $mail->Subject = isset($dataOptions['email_subject']) ? $dataOptions['email_subject'] : erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Your code');
                    $mail->Body = str_replace('{code}', $code, (isset($dataOptions['email_body']) ? $dataOptions['email_body'] : erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Verification code: {code}')));
                    $mail->FromName = isset($dataOptions['email_subject']) ? $dataOptions['email_subject'] : erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','2FA Verification');
                    $mail->AddAddress( $user->email );

                    erLhcoreClassChatMail::setupSMTP($mail);

                    try {
                        $mail->Send();
                    } catch (Exception $e) {
                        throw $e;
                    }

                    $mail->ClearAddresses();

                } else {
                    throw new Exception('User could not be found');
                }

                $params['session']->removeAttribute('email_error');

            } catch (Exception $e) {
                $params['session']->setAttribute('email_error',$e->getMessage());
            }
        }
    }
}