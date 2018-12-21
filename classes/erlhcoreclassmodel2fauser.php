<?php

class erLhcoreClassModel2FAUser
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_2fa_user';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtension2fa::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'method' => $this->method,
            'attr' => $this->attr,
            'enabled' => $this->enabled,
            'default' => $this->default,
        );
    }

    public function __toString()
    {
        return $this->method;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'attr_array':
                $this->attr_array = array();

                if ($this->attr != '') {
                    $attr = json_decode($this->attr, true);
                    if (is_array($attr)) {
                        $this->attr_array = $attr;
                    }
                }
                return $this->attr_array;
                break;

            default:
                ;
                break;
        }
    }

    public function getAttribute($attr) {
        if (isset($this->attr_array[$attr])) {
            return $this->attr_array[$attr];
        }
        return null;
    }

    public function setAttribute($attr, $val) {
        $attrArray = $this->attr_array;
        $attrArray[$attr] = $val;

        $this->attr_array = $attrArray;
        $this->attr = json_encode($attrArray);
        
        if ($this->user_id > 0){
            $this->saveThis();
        }
    }

    public function getMethodInfo()
    {
        $response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('user.2fa_method_info', array('2fa' => $this));

        if ($response !== false) {
            return $response['info'];
        }

        return null;
    }

    public static function getInstance($userId, $method) {

        if (isset(self::$instances[$userId . '_' . $method])) {
            return self::$instances[$userId . '_' . $method];
        }

        if ($userId > 0) {
            $instance = self::findOne(array('filter' => array('user_id' => $userId, 'method' => $method)));

            if ($instance instanceof erLhcoreClassModel2FAUser) {
                return $instance;
            }
        }

        $instance = new erLhcoreClassModel2FAUser();
        $instance->user_id = $userId;
        $instance->method = $method;

        if ($instance->user_id > 0) {
            $instance->saveThis();
        }

        self::$instances[$userId . '_' . $method] = $instance;

        return $instance;
    }

    private static $instances = array();

    public $id = null;

    public $user_id = 0;

    public $enabled = 0;

    public $default = 0;

    public $method = '';

    public $attr = '';
}

?>