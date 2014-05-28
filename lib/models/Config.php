<?php

/**
 * Description of Config
 *
 * @author Łukasz Traczewski
 */
class Config extends Db
{
    
    private $_sTableName = "_config";
    
    public function __construct()
    {
        parent::__construct($this->_sTableName);
    }
    
    public function getConfig()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
    public function getAmazonCredentials()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`
            WHERE `label` = 'AMAZON_KEY' OR `label` = 'AMAZON_SECRET'";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
}

?>
