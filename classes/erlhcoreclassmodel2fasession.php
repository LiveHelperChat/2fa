<?php
#[\AllowDynamicProperties]
class erLhcoreClassModel2FASession
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_2fa_session';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtension2fa::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'hash' => $this->hash,
            'ctime' => $this->ctime,
            'valid' => $this->valid,
            'retries' => $this->retries,
            'remember' => $this->remember,
            'attr' => $this->attr,
        );
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

    public function removeAttribute($attr)
    {
        if (isset($this->attr_array[$attr])) {
            $attrArray = $this->attr_array;
            unset($attrArray[$attr]);

            $this->attr_array = $attrArray;
            $this->attr = json_encode($attrArray);
            $this->saveThis();
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
        $this->saveThis();
    }

    public $id = null;

    public $user_id = 0;

    public $valid = 0;

    public $ctime = 0;

    public $retries = 0;

    public $remember = 0;

    public $hash = '';

    public $attr = '';

    const RETRIES_MAX = 3;
}

?>