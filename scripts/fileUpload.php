<?php
    
    include_once 'config.php';

    if (!empty($_FILES))
    {
        $file = pathinfo($_FILES['Filedata']['name']);
        $filename = $file['filename'];
        $file_ext = strtolower($file['extension']);
        
        if($file_ext == 'jpg' || $file_ext == 'JPG' || $file_ext == 'bmp' || $file_ext == 'BMP' || $file_ext == 'png'|| $file_ext == 'PNG')
        {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
            $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

            if (!file_exists($targetPath)) 
            {
                mkdir($targetPath);
            }

            move_uploaded_file($tempFile,$targetFile);
        
            $oSimpleImage = new SimpleImage();
            $sUploadPath = __DIR__ . '/../' . UPLOADS_PATH . REALIZATION_IMAGES_PATH;
            $sConvertedFile = $filename . '.png';

            $oSimpleImage->load($sUploadPath . $_FILES['Filedata']['name']);
            $oSimpleImage->resizeToWidth(300);
            $oSimpleImage->save($sUploadPath . $sConvertedFile, IMAGETYPE_PNG);
            if(!($file_ext == 'png' || $file_ext == 'PNG'))
            {
                unlink($sUploadPath . $_FILES['Filedata']['name']);
            }
            
            echo $sConvertedFile;
        }
    }

?>