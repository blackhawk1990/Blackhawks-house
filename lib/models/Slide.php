<?php

/**
 * Description of Slide
 *
 * @author Łukasz Traczewski
 */
class Slide extends Db
{
    
    private $_sTableName = "_slider_slides";
    
    public function __construct()
    {
        parent::__construct($this->_sTableName);
    }
    
    public function getAllSlides()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
}

?>
