<?php

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
        $active2FA = erLhcoreClassModel2FAUser::getList(array('filter' => array('enabled' => 1, 'user_id' => $params['current_user']->getUserID())));

        if (!empty($active2FA)) {

            // Remove previous attempts
            foreach (erLhcoreClassModel2FASession::getList(array('filter' => array('user_id' => $params['current_user']->getUserID()))) as $twofaSession){
                $twofaSession->removeThis();
            }

            // Create a new 2FASession
            $session = new erLhcoreClassModel2FASession();
            $session->user_id = $params['current_user']->getUserID();
            $session->ctime = time();
            $session->hash = erLhcoreClassChat::generateHash();
            $session->remember = (isset($params['remember']) && $params['remember'] == true) ? 1 : 0;
            $session->saveThis();

            // Logout user as we will login him after 2fa
            $params['current_user']->logout();

            erLhcoreClassModule::redirect('2fa/authentication','/' . $session->hash);
            exit;
        }
    }
    
    public function autoload($className)
    {
        $classesArray = array(
            'erLhcoreClassModel2FAUser' => 'extension/2fa/classes/erlhcoreclassmodel2fauser.php',
            'erLhcoreClassModel2FASession' => 'extension/2fa/classes/erlhcoreclassmodel2fasession.php',
            'erLhcoreClassExtension2FAHandlerga' => 'extension/2fa/classes/handlers/erlhcoreclassmodel2fahandlerga.php'
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


