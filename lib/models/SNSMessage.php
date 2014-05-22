<?php

/**
 * Description of User
 *
 * @author Łukasz Traczewski
 */
class SNSMessage extends Db
{
    
    private $_sTableName = "_test_push_sns";
    
    const SUBSCRIPTION_CONFIRMATION = 1;
    const NOTIFICATION = 2;
    const UNSUBSCRIBE_CONFIRMATION = 3;
    
    public function __construct()
    {
        parent::__construct($this->_sTableName);
    }

    public function getAllMessages()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
}

?>
