<?php

require_once CLASSES_PATH . 'class.Db.php';

/**
 * Description of User
 *
 * @author Łukasz Traczewski
 */
class User extends Db
{
    
    private $_sTableName = "_users";
    
    public function __construct()
    {
        parent::__construct($this->_sTableName);
    }
    
    public function getUserData($iId = NULL)
    {
        $sQuery = "SELECT `login`, `password`, `role` FROM `" . $this->_sTableName . "`
            WHERE id = " . $iId;
        
        if($iId != NULL)
        {
            return $this->query($this->_Hnd, $sQuery);
        }
        
        return NULL;
    }

    public function getUsersData()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
}

?>
