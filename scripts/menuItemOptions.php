<?php
    
    require_once 'config.php';

    if(isset($_POST['v']))
    {
        $oDbHnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        $sView = mysqli_real_escape_string($oDbHnd, trim($_POST['v']));
        unset($_POST['v']);
        
        if($sView == 'delete_menu_item')
        {
            if(isset($_POST['id']))
            {
                $oDbHnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
                $iId = mysqli_real_escape_string($oDbHnd, trim($_POST['id']));
                
                $oMenu = new Menu();
                echo $oMenu->deleteRow($iId);
            }
        }
    }

?>