<?php
    
    require_once 'config.php';

    if(isset($_POST['v']))
    {
        $oDbHnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        $sView = mysqli_real_escape_string($oDbHnd, trim($_POST['v']));
        unset($_POST['v']);
        
        if($sView == 'add_realization')
        {
            if(!empty($_POST))
            {
                $aEscaped = array();

                foreach($_POST as $key => $value)
                {
                    $aEscaped[$key] = mysqli_real_escape_string($oDbHnd, trim($value));
                }
                
                $oDb = new Db();
                echo $oDb->saveRow($aEscaped);
            }
        }
        else if($sView == 'delete_realization')
        {
            if(isset($_POST['id']))
            {
                //wylaczenie ostrzezen
                //error_reporting(E_ALL ^ E_WARNING);
                
                $oDbHnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
                $iId = mysqli_real_escape_string($oDbHnd, trim($_POST['id']));
                
                $oRealization = new Realization();
                $sRealizationImageName = $oRealization->getRealizationImageName($iId);
                $oAmazonS3 = new AmazonS3(AMAZON_KEY, AMAZON_SECRET, AMAZON_BUCKET);
                
                if($oAmazonS3->deleteFile($sRealizationImageName))
                    echo $oRealization->deleteRow($iId);
                else
                    echo 0;
            }
        }
    }

?>