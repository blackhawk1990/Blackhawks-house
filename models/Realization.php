<?php

/**
 * Description of Realization
 *
 * @author Łukasz Traczewski
 */
class Realization extends Db
{
    
    private $_sTableName = "_realizations";
    
    public function __construct()
    {
        parent::__construct($this->_sTableName);
    }
    
    public function getRealizations()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`
            ORDER BY `date` DESC";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
    public function getRealizationsInterval($iStart, $iEnd)
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`
            ORDER BY `date` DESC
            LIMIT " . $iStart . "," . $iEnd;
        
        return $this->query($this->_Hnd, $sQuery);
    }

    public function getRealizationById($iId = NULL)
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`
            WHERE id = " . $iId;
        
        if($iId != NULL)
        {
            return $this->query($this->_Hnd, $sQuery);
        }
        
        return NULL;
    }
    
    public function getRealizationImageName($iId)
    {
        $sQuery = "SELECT image FROM `" . $this->_sTableName . "`
            WHERE `id` = ". $iId;
        
        $oRealizationData = $this->query($this->_Hnd, $sQuery);
        $aRealizationData = $oRealizationData->fetch_assoc();
        
        return $aRealizationData['image'];
    }
}

?>
