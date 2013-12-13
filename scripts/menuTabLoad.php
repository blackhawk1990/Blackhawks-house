<?php
    
    include_once 'config.php';

    if(isset($_POST['v']))
    {
        $sView = mysql_real_escape_string(trim($_POST['v']));
        
        $oTemplate = new Template();
        $oTemplate->assign['upload_path'] = UPLOADS_PATH . REALIZATION_IMAGES_PATH;
        
        if($sView == 'realization_options')
        {
            //odczyt z bazy danych listy wszystkich realizacji i generowanie listy
            $oRealization = new Realization();
            $oRealizationData = $oRealization->getRealizations();
            $sRealizationsList = '';
            while(($aRealization = $oRealizationData->fetch_assoc()) != NULL)
            {
                $oDate = new Date('pl', $aRealization['date']);
                $sRealizationsList .= "<tr>
                                            <td>" . $aRealization['title'] . "</td>
                                            <td>" . $oDate->getDate() . "</td>
                                            <td>
                                                <a href=\"#\" id=\"" . $aRealization['id'] . "\" class=\"delete table-option\"><img src=\"" . STYLES_PATH . "img/icons/trash_can.png\" /></a>
                                            </td>
                                       </tr>";
            }
            
            $oTemplate->assign['realizations_list'] = $sRealizationsList;
        }
        
        echo $oTemplate->parse('../' . INCLUDES_PATH . $sView . '_view.html');
    }

?>