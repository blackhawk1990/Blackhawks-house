<?php

require_once 'class.Db.php';

/**
 * Description of class Slider
 * Class for generating slider and slides
 * 
 * @author Łukasz
 */
class Slider 
{

    private $aSliderData;
    
    /**
     * @param string $sDbTableName Db table from which slides data are fetched
     */
    public function __construct($sDbTableName) 
    {
        $oDb = new Db($sDbTableName);
        $this->aSliderData = $oDb->_query;
        var_dump($this->aSliderData);die;
    }
    
    public function getSlider()
    {
        
    }
    
    private function getSlide($sTitle, $sContent)
    {
        $sSlideContent = '<div id="banner-1" class="banner">
                            <div class="banner-content">
                                <div class="banner-text">
                                    <h1>' . $sTitle . '</h1>
                                    <p>
                                        ' . $sContent . '
                                    </p>
                                </div>
                            </div>
                         </div>';
        
        return $sSlideContent;
    }
            
}
?>
