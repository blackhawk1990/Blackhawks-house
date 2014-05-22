<?php
    
    require_once 'config.php';

    if(isset($_POST['v']))
    {
        $oDbHnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        $sView = mysqli_real_escape_string($oDbHnd, trim($_POST['v']));
        
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
        else if($sView == 'menu_options')
        {
            //odczyt z bazy danych listy wszystkich pozycji menu i generowanie listy
            $oMenu = new Menu();
            $oMenuData = $oMenu->getMainMenuItems();
            $sMenuItemsList = '';
            while(($aMenuItem = $oMenuData->fetch_assoc()) != NULL)
            {
                $sMenuItemsList .= "<tr>
                                            <td>" . $aMenuItem['name'] . "</td>
                                            <td>" . $aMenuItem['label'] . "</td>
                                            <td>" . $aMenuItem['count'] . "</td>
                                            <td>
                                                <a href=\"#\" id=\"" . $aMenuItem['id'] . "\" class=\"delete table-option\"><img src=\"" . STYLES_PATH . "img/icons/trash_can.png\" /></a>
                                            </td>
                                       </tr>";
            }
            
            $oTemplate->assign['menu_options_list'] = $sMenuItemsList;
        }

        echo $oTemplate->parse(BASE_PATH . INCLUDES_PATH . $sView . '_view.html');
    }

?>