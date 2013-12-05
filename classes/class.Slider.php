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

    private $sliderData;
    
    /**
     * @param string $sDbTableName Db table from which slides data are fetched
     */
    public function __construct($sDbTableName)
    {
        $oDb = new Db($sDbTableName);
        $this->sliderData = $oDb->_query;
    }
    
    public function getSlider()
    {
        $sSliderContent = '';
        
        $i = 1;
        while(($aSlide = $this->sliderData->fetch_assoc()) != NULL)
        {
            $sSliderContent .= $this->getSlide($aSlide['title'], $aSlide['content'], $aSlide['image'], $i);
            $i++;
        }
        
        if($i === 1) //slides doesn't exist
        {
            $sSliderContent = $this->getSlide('No slides', 'Not even one slide exists in database', 'std_banner_bg.png', 1);
        }

        $sSliderContainer = '<div id="content-wrapper">
                                <div id="content">
                                    ' . $sSliderContent . '
                                </div>
                             </div>
                             <div id="banner-control"></div>';
        
        return $sSliderContainer;
    }
    
    private function getSlide($sTitle, $sContent, $sImageFilename, $iSlideNum)
    {
        $sSlideContent = '<div id="banner-' . $iSlideNum . '" class="banner" style="background: url(\'images/' . $sImageFilename . '\') no-repeat;">
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
