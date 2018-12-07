<?php

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
        );
    }

    public $id = null;

    public $user_id = 0;

    public $valid = 0;

    public $ctime = 0;

    public $retries = 0;
    
    public $remember = 0;

    public $hash = '';
}

?>