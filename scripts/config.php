<?php

    include '../config/default.php';
    
    /*****************auto loading all classes in classes catalog*********************/
    $sClassesPath = '../' . CLASSES_PATH;
    $oClassesDir = dir($sClassesPath);
    while(($sFile = $oClassesDir->read()) != NULL)
    {
        if($sFile != '.' && $sFile != '..')
        {
            require_once $sClassesPath . $sFile;
        }
    }
    
    /*****************auto loading all models in models catalog*********************/
    $sModelsPath = '../' . MODELS_PATH;
    $oModelsDir = dir($sModelsPath);
    while(($sFile = $oModelsDir->read()) != NULL)
    {
        if($sFile != '.' && $sFile != '..')
        {
            require_once $sModelsPath . $sFile;
        }
    }

?>
