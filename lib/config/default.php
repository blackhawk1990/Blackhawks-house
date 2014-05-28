<?php

/*******************MAIN CONFIGURATION FILE************************/

//generating Base Path
$sProtocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$aRestOfUrl = explode('/', $_SERVER['REQUEST_URI']);

if(count($aRestOfUrl) > 0)
{
    $iLength = count($aRestOfUrl);
    for($i = 2;$i < $iLength;$i++)
        unset($aRestOfUrl[$i]);
    
    $iLength = count($aRestOfUrl);
    for($i = 0;$i < $iLength;$i++)
    {
        if(strripos($aRestOfUrl[$i], '?') !== FALSE)
        {
            unset($aRestOfUrl[$i]);
        }
    }
}
$sRestOfUrl = implode('/', $aRestOfUrl) . '/';

define("PAGE_CHARSET", 'UTF-8');
define("MAIN_PATH", './');
define("BASE_URL", $sProtocol . $_SERVER['HTTP_HOST'] . $sRestOfUrl);
define("BASE_PATH", __DIR__ . '/../../');
define("CLASSES_PATH", 'lib/classes/');
define("STYLES_PATH", 'styles/');
define("LAYOUTS_PATH", 'lib/layouts/');
define("SCRIPTS_PATH", 'scripts/');
define("JS_SCRIPTS_PATH", 'js/');
define("MODELS_PATH", 'lib/models/');
define("INCLUDES_PATH", 'lib/includes/');
define("UPLOADS_PATH", 'uploads/');
define("TEMPLATES_PATH", 'lib/templates/');
define("REALIZATION_IMAGES_PATH", 'realization_images/');
define("DEFAULT_LAYOUT", 'default.html');
define("AMAZON_URL", 'http://i.ltraczewski.tk/');
define("AMAZON_BUCKET", 'blhouse-bucket');
define("DB_HOST", 'blhousedb.c3nadpwnteyb.us-west-2.rds.amazonaws.com');
define("DB_NAME", 'blackhawk');
define("DB_LOGIN", 'blackhawk90');
define("DB_PASS", 'luc4sn1d');
define("NUM_OF_REALIZATIONS_VIEWED", 2); //liczba widocznych nowych realizacji na str glownej
define("PORTFOLIO_NUM_OF_REALIZATIONS_VIEWED", 2); //liczba pozycji na jednej stronie portfolio

/*****************auto loading all classes in classes catalog*********************/
$oClassesDir = dir(BASE_PATH . CLASSES_PATH);
while(($sFile = $oClassesDir->read()) != NULL)
{
    if($sFile != '.' && $sFile != '..')
    {
        require_once BASE_PATH . CLASSES_PATH . $sFile;
    }
}

/*****************auto loading all models in models catalog*********************/
$oModelsDir = dir(BASE_PATH. MODELS_PATH);
while(($sFile = $oModelsDir->read()) != NULL)
{
    if($sFile != '.' && $sFile != '..')
    {
        require_once BASE_PATH. MODELS_PATH . $sFile;
    }
}

//loading from db
$oConfig = new Config();
$oConfigData = $oConfig->getAmazonCredentials();
$sAmazonKey = '';
$sAmazonSecret = '';

while (($aValues = $oConfigData->fetch_assoc()) != NULL)
{
    switch($aValues['label'])
    {
        case 'AMAZON_KEY':
            $sAmazonKey = $aValues['value'];
            break;
        case 'AMAZON_SECRET':
            $sAmazonSecret = $aValues['value'];
            break;
    }
}

/*********************************config from db********************************/
define("AMAZON_KEY", $sAmazonKey);
define("AMAZON_SECRET", $sAmazonSecret);

?>