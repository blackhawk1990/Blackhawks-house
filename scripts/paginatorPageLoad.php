<?php
    
    include_once 'config.php';

    if(isset($_POST['v']))
    {
        $oDbHnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        $sView = mysqli_real_escape_string($oDbHnd, trim($_POST['v']));
        
        $oTemplate = new Template();
        $oTemplate->assign['realizations'] = '';
        
        if($sView == 'portfolio_page')
        {
            //*****<wczytywanie informacji z bazy danych (podzial na strony)>*****//
            $oRealization = new Realization();
            $iActualPage = 1;

            if(isset($_POST['p']))
            {
                $iActualPage = mysqli_real_escape_string($oDbHnd, trim($_POST['p']));
            }

            $iStartPos = ($iActualPage - 1) * PORTFOLIO_NUM_OF_REALIZATIONS_VIEWED;
            $iHowMany = PORTFOLIO_NUM_OF_REALIZATIONS_VIEWED;
            $oRealizationData = $oRealization->getRealizationsInterval($iStartPos, $iHowMany);
            //*****</wczytywanie informacji z bazy danych (podzial na strony)>****//

            while(($aRealizations = $oRealizationData->fetch_assoc()) != NULL)
            {
                $date = new Date('pl', $aRealizations['date']);
                $oTemplate->assign['realizations'] .= "<div class=\"realization\">
                                                    <div class=\"realization-content\">
                                                        <h1>" . $aRealizations['title'] . "</h1>

                                                        <p>
                                                            " . $aRealizations['text'] . "
                                                        </p>

                                                        <p>
                                                            Użyte technologie: " . $aRealizations['used_technologies'] . "
                                                        </p>

                                                        <h3>Link: " . ($aRealizations['url'] != '' ? "<a href=\"" . $aRealizations['url'] . "\" target=\"_blank\">" . $aRealizations['url'] . "</a>" : "brak") . "</h3>

                                                        <h4>Data wykonania: " . $date->getDate() . "</h4>
                                                    </div>
                                                    <img src=\"" . UPLOADS_PATH . REALIZATION_IMAGES_PATH . $aRealizations['image'] . "\" alt=\"\" />
                                                </div>";
            }
        }

        echo $oTemplate->parse(BASE_PATH . INCLUDES_PATH . $sView . '_view.html');
    }

?>