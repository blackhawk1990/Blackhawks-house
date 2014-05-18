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
            
            move_uploaded_file($tempFile, $targetFile);
        
            $oSimpleImage = new SimpleImage();
            $sTempResizePath = __DIR__ . '/../' . UPLOADS_PATH . REALIZATION_IMAGES_PATH;
            $sConvertedFile = $filename . '.png';

            $oSimpleImage->load($sTempResizePath . $_FILES['Filedata']['name']);
            $oSimpleImage->resizeToWidth(300);
            $oSimpleImage->save($sTempResizePath . $sConvertedFile, IMAGETYPE_PNG);
            
            //upload to an Amazon S3 storage
            $oAmazonS3 = new AmazonS3(AMAZON_KEY, AMAZON_SECRET, AMAZON_BUCKET);
            $oAmazonS3->uploadFile($sTempResizePath . $sConvertedFile, $sConvertedFile);
            //delete temp files
            unlink($sTempResizePath . $sConvertedFile);
            unlink($sTempResizePath . $_FILES['Filedata']['name']);
            
            echo $sConvertedFile;
        }
    }

?>