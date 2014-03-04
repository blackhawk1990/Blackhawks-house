<?php

class Paginator 
{
    private $iNumOfPosAtPage;
    private $iActualPage;
    private $sActualParams;
    private $oDataRecords;
    
    public function __construct($oRecords, $iNumOfPosAtPage, $iActualPage, $sActualParams) 
    {
        $this->iNumOfPosAtPage = $iNumOfPosAtPage;
        $this->iActualPage = $iActualPage;
        $this->sActualParams = $sActualParams;
        $this->$oDataRecords = $oRecords;
    }
    
    /**
     * Creates paginator
     * 
     * @return string Paginator HTML
     */
    public function generatePaginator()
    {
        $sHTML = '';
        $oDataRecords = $this->oDataRecords;
        $i = 0;
        $iLength = 0;
        
        while($oDataRecords->fetch_all() != NULL)
        {
            $iLength++;
        }
        
        $iNumOfPages = $iLength / $this->iNumOfPosAtPage;
        
        for($i = 0;$i < $iNumOfPages;$i++)
        {
            if($i == $this->iActualPage)
            {
                $sHTML .= '<a class="active" href="?' . $this->sActualParams . '&p=' . $this->iActualPage . '">' . $i . '</a>';
            }
            else
            {
                $sHTML .= '<a href="?' . $this->sActualParams . '&p=' . $this->iActualPage . '">' . $i . '</a>';
            }
            $i++;
        }
        
        return $sHTML;
    }
}

?>