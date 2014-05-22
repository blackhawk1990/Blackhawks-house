<?php


    if(isset($_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE']) && isset($_POST))
    {
        $string = '';
        $post = file_get_contents('php://input');
        $aMessage = json_decode($post);
        
        foreach($aMessage as $key => $value)
            $string .= $key . ': ' . $value . "\r\n";
        
        file_put_contents('push_log.txt', $string);
    }

?>
