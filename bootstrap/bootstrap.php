<?php
#[\AllowDynamicProperties]
class erLhcoreClassExtension2fa
{

    public function __construct()
    {}

    public function run()
    {
        $this->registerAutoload();
    }
    
    public function registerAutoload()
    {
    	include 'extension/2fa/vendor/autoload.php';

        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('user.2fa_intercept', array($this, 'twoFactorAuthentication'));

        $dispatcher->listen('user.2fa_method_info', array($this, 'twoFactorAuthenticationInfo'));

        $dispatcher->listen('user.account', array($this, 'validate2FAaccountSettings'));

        // New user window was loaded. So we just save temporary 2fa settings
        $dispatcher->listen('user.new_user', array($this, 'validate2FAaccountSettingsNew'));

        // User was created so now we can save not only temporary store settings
        $dispatcher->listen('user.user_created', array($this, 'validate2FAaccountSettingsCreated'));

        // User edit save clicked
        $dispatcher->listen('user.edit_user_window', array($this, 'validate2FAaccountSettings'));

        $dispatcher->listen('instance.extensions_structure', array(
            $this,
            'checkStructure'
        ));

        $dispatcher->listen('instance.registered.created', array(
            $this,
            'instanceCreated'
        ));

        spl_autoload_register(array(
            $this,
            'autoload'
        ), true, false);
    }

    /**
     * Used only in automated hosting enviroment
     */
    public function instanceCreated($params)
    {
        try {
            // Just do table updates
            erLhcoreClassUpdate::doTablesUpdate(json_decode(file_get_contents('extension/2fa/doc/structure.json'), true));
        } catch (Exception $e) {
            erLhcoreClassLog::write(print_r($e, true));
        }
    }

    public function validate2FAaccountSettingsNew($params) {
        $params = array_merge($params, array('new_user_validation' => true));
        $this->validate2FAaccountSettings($params);
    }

    public function validate2FAaccountSettingsCreated($params) {
        $params = array_merge($params, array('new_user_validation' => true));
        $this->validate2FAaccountSettings($params);
    }

    public function validate2FAaccountSettings($params)
    {
        if (isset($_POST['savetwofa']) || isset($params['new_user_validation'])) {

            if (isset($params['tpl'])) {
                $params['tpl']->set('tab','tab_2fa');
            }

            $t2faOptions = erLhcoreClassModelChatConfig::fetch('2fa_options');
            $dataOptions = (array)$t2faOptions->data;

            $defaultProvider = isset($_POST['twofaDefault']) ? $_POST['twofaDefault'] : '';

            if (isset($dataOptions['sms_enabled']) && $dataOptions['sms_enabled'] == true) {
                $instance = erLhcoreClassModel2FAUser::getInstance($params['userData']->id, 'sms');
                if ($defaultProvider == 'sms') {
                    $instance->default = 1;
                } else {
                    $instance->default = 0;
                }

                if (isset($_POST['twofaphone'])){
                    $instance->setAttribute('phone',$_POST['twofaphone']);
                } else {
                    $instance->setAttribute('phone','');
                }

                if (isset($_POST['twofasmsEnabled'])){
                    $instance->enabled = 1;
                } else {
                    $instance->enabled = 0;
                }

                if ($params['userData']->id > 0) {
                    $instance->saveThis();
                }
            }

            if (isset($dataOptions['email_enabled']) && $dataOptions['email_enabled'] == true) {
                $instance = erLhcoreClassModel2FAUser::getInstance($params['userData']->id, 'email');

                if ($defaultProvider == 'email') {
                    $instance->default = 1;
                } else {
                    $instance->default = 0;
                }

                if (isset($_POST['twofaemailEnabled'])) {
                    $instance->enabled = 1;
                } else {
                    $instance->enabled = 0;
                }

                if ($params['userData']->id > 0) {
                    $instance->saveThis();
                }
            }

            if (isset($dataOptions['ga_enabled']) && $dataOptions['ga_enabled'] == true) {
                $instance = erLhcoreClassModel2FAUser::getInstance($params['userData']->id, 'ga');

                if ($defaultProvider == 'ga') {
                    $instance->default = 1;
                } else {
                    $instance->default = 0;
                }

                if (isset($_POST['twofagaEnabled'])){
                    $instance->enabled = 1;
                } else {
                    $instance->enabled = 0;
                }

                if ($params['userData']->id > 0) {
                    $instance->saveThis();
                }
            }

            if (isset($params['tpl'])) {
                $params['tpl']->set('twosettingsupdated',true);
            }

        }
    }

    /**
     * Checks automated hosting structure
     *
     * This part is executed once in manager is run this cronjob.
     * php cron.php -s site_admin -e instance -c cron/extensions_update
     *
     * */
    public function checkStructure()
    {
        erLhcoreClassUpdate::doTablesUpdate(json_decode(file_get_contents('extension/2fa/doc/structure.json'), true));
    }

    public function twoFactorAuthenticationInfo($twofa)
    {
        if (class_exists('erLhcoreClassExtension2FAHandler' . $twofa['2fa']->method)) {
            return array(
                'status' => erLhcoreClassChatEventDispatcher::STOP_WORKFLOW,
                'info' => call_user_func('erLhcoreClassExtension2FAHandler' .$twofa['2fa']->method . '::getInfo',array())
            );
        }
    }
    
    public function twoFactorAuthentication($params) 
    {
        $active2FA = erLhcoreClassModel2FAUser::getList(array('sort' => '`default` DESC','filter' => array('enabled' => 1, 'user_id' => $params['current_user']->getUserID())));

        if (!empty($active2FA)) {

            $session = $this->generateSession($params['current_user']->getUserID(),((isset($params['remember']) && $params['remember'] == true) ? 1 : 0), $active2FA);

            // Logout user as we will login him after 2fa
            $params['current_user']->logout();

            erLhcoreClassModule::redirect('2fa/authentication','/' . $session->hash);
            exit;
        }
    }

    public function generateSession($userId, $remember, $active2FAList, $test = false) {

        // Remove previous attempts
        foreach (erLhcoreClassModel2FASession::getList(array('filter' => array('user_id' => $userId))) as $twofaSession){
            $twofaSession->removeThis();
        }

        // Create a new 2FASession
        $session = new erLhcoreClassModel2FASession();
        $session->user_id = $userId;
        $session->ctime = time();
        $session->hash = erLhcoreClassChat::generateHash();
        $session->remember = $remember;
        $session->saveThis();

        foreach ($active2FAList as $active2FA) {
            if (class_exists('erLhcoreClassExtension2FAHandler' .$active2FA->method)) {
                call_user_func('erLhcoreClassExtension2FAHandler' .$active2FA->method . '::prepareSession',array('total' => count($active2FAList), 'test' => $test, 'session' => & $session, '2fa' => $active2FA));
            }
        }

        return $session;
    }

    public function autoload($className)
    {
        $classesArray = array(
            'erLhcoreClassModel2FAUser' => 'extension/2fa/classes/erlhcoreclassmodel2fauser.php',
            'erLhcoreClassModel2FASession' => 'extension/2fa/classes/erlhcoreclassmodel2fasession.php',
            'erLhcoreClassExtension2FAHandlerga' => 'extension/2fa/classes/handlers/erlhcoreclassmodel2fahandlerga.php',
            'erLhcoreClassExtension2FAHandlersms' => 'extension/2fa/classes/handlers/erlhcoreclassmodel2fahandlersms.php',
            'erLhcoreClassExtension2FAHandleremail' => 'extension/2fa/classes/handlers/erlhcoreclassmodel2fahandleremail.php'
        );

        if (key_exists($className, $classesArray)) {
            include_once $classesArray[$className];
        }
    }

    public static function getSession()
    {
        if (! isset(self::$persistentSession)) {
            self::$persistentSession = new ezcPersistentSession(ezcDbInstance::get(), new ezcPersistentCodeManager('./extension/2fa/pos'));
        }
        return self::$persistentSession;
    }

    public function __get($var)
    {
        switch ($var) {

            // Not used at the moment
            case 'settings':
                $this->settings = include ('extension/2fa/settings/settings.ini.php');
                return $this->settings;
                break;

            default:
                ;
                break;
        }
    }

    private static $persistentSession;
}


