<?php

class Paginator 
{
    private $oTemplate;
    private $iLength;
    private $iNumOfPosAtPage;
    private $iActualPage;
    private $sActualParams;
    
    public function __construct($iLength, $iNumOfPosAtPage, $iActualPage, $sActualParams) 
    {
        $this->oTemplate = new Template();
        
        $this->iLength = $iLength;
        $this->iNumOfPosAtPage = $iNumOfPosAtPage;
        $this->iActualPage = $iActualPage;
        $this->sActualParams = $sActualParams;
    }
    
    /**
     * Creates PHP version of paginator
     * 
     * @return string Paginator HTML
     */
    public function generatePHPPaginator()
    {
        $sHTML = '';
        
        $iNumOfPages = ceil($this->iLength / $this->iNumOfPosAtPage);
        
        $sHTML .= '<li><a href="?' . $this->sActualParams . '&p=1">&lt;</a></li>';
        
        for($i = 0;$i < $iNumOfPages;$i++)
        {
            if(($i + 1) == $this->iActualPage)
            {
                $sHTML .= '<li class="active"><a href="?' . $this->sActualParams . '&p=' . $this->iActualPage . '">' . ($i + 1) . '</a></li>';
            }
            else
            {
                $sHTML .= '<li><a href="?' . $this->sActualParams . '&p=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
            }
        }
        
        $sHTML .= '<li><a href="?' . $this->sActualParams . '&p=' . $iNumOfPages . '">&gt;</a></li>';
        
        $this->oTemplate->assign['paginator'] = $sHTML;
        $this->oTemplate->assign['scripts-path'] = SCRIPTS_PATH;
        
        return $this->oTemplate->parse(INCLUDES_PATH . 'paginator.html');
    }
    
    /**
     * Creates Javascript version of paginator
     * 
     * @return string Paginator HTML
     */
    public function generateJSPaginator($sContainerId)
    {
        $sHTML = '';
        
        $iNumOfPages = ceil($this->iLength / $this->iNumOfPosAtPage);
        
        $sHTML .= '<li class="static"><a href="#' . $sContainerId . '" onclick="loadPage(this, \'portfolio_page\', { p : 1 });return false;">&lt;</a></li>';
        
        for($i = 0;$i < $iNumOfPages;$i++)
        {
            if(($i + 1) == $this->iActualPage)
            {
                $sHTML .= '<li class="active"><a href="#' . $sContainerId . '" onclick="loadPage(this, \'portfolio_page\', { p : ' . ($i + 1) . ' });return false;">' . ($i + 1) . '</a></li>';
            }
            else
            {
                $sHTML .= '<li><a href="#' . $sContainerId . '" onclick="loadPage(this, \'portfolio_page\', { p : ' . ($i + 1) . ' });return false;">' . ($i + 1) . '</a></li>';
            }
        }
        
        $sHTML .= '<li class="static"><a href="#' . $sContainerId . '" onclick="loadPage(this, \'portfolio_page\', { p : ' . $iNumOfPages . ' });return false;">&gt;</a></li>';
        
        $this->oTemplate->assign['paginator'] = $sHTML;
        $this->oTemplate->assign['scripts-path'] = SCRIPTS_PATH;
        
        return $this->oTemplate->parse(INCLUDES_PATH . 'paginator.html');
    }
}

?>