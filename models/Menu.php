<?php

require_once CLASSES_PATH . 'class.Db.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Łukasz Traczewski
 */
class Menu extends Db
{
    
    private $_sTableName = "_main_menu";
    
    public function __construct()
    {
        parent::__construct($this->_sTableName);
    }
    
    public function getMainMenuItems()
    {
        $sQuery = "SELECT * FROM `" . $this->_sTableName . "`
            ORDER BY `count` ASC";
        
        return $this->query($this->_Hnd, $sQuery);
    }
    
}

?>
