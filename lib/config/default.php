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
define("DB_HOST", 'blhousedb.c3nadpwnteyb.us-west-2.rds.amazonaws.com');
define("DB_NAME", 'blackhawk');
define("DB_LOGIN", 'blackhawk90');
define("DB_PASS", 'luc4sn1d');
//define("DB_HOST", 'ec2-54-200-17-110.us-west-2.compute.amazonaws.com');
//define("DB_NAME", 'blackhawk');
//define("DB_LOGIN", 'root');
//define("DB_PASS", 'b4rc3l0na');
define("AMAZON_KEY", 'AKIAJNKZKNW6PS6RJY3A');
define("AMAZON_SECRET", '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');
define("AMAZON_URL", 'https://i.ltraczewski.tk/');
define("AMAZON_BUCKET", 'blhouse-bucket');
define("NUM_OF_REALIZATIONS_VIEWED", 2); //liczba widocznych nowych realizacji na str glownej
define("PORTFOLIO_NUM_OF_REALIZATIONS_VIEWED", 2); //liczba pozycji na jednej stronie portfolio

?>