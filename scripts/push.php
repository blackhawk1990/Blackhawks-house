<?php

    require_once 'config.php';

    if(isset($_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE']) && isset($_POST))
    {
        $iMessageType = 0;
        
        $sPost = file_get_contents('php://input');
        $aMessage = json_decode($sPost);

        switch($aMessage->Type)
        {
            case 'SubscriptionConfirmation':
                $iMessageType = SNSMessage::SUBSCRIPTION_CONFIRMATION;
                break;
            case 'Notification':
                $iMessageType = SNSMessage::NOTIFICATION;
                break;
            case 'UnsubscribeConfirmation':
                $iMessageType = SNSMessage::UNSUBSCRIBE_CONFIRMATION;
                break;
        }
        
        $aDataToSave = array(
            'subject' => $aMessage->Subject,
            'message' => $aMessage->Message,
            'type' => $iMessageType,
            'timestamp' => $aMessage->Timestamp,
            'message_id' => $aMessage->MessageId
        );

        $oSNSMessage = new SNSMessage();
        $oSNSMessage->saveRow($aDataToSave);
    }

?>