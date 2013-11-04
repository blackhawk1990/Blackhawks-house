<?php
    
    require_once '/../class.Path.php';
    
    $oPath = new Path();

    if (!empty($_FILES)) 
    {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
        
        move_uploaded_file($tempFile,$targetFile);
        $file = pathinfo($_FILES['Filedata']['name']);
        $file_ext = strtolower($file['extension']);
        
        if($file_ext == 'jpg' || $file_ext == 'bmp' || $file_ext == 'png')
        {
            require_once '/../' . $oPath->getClassPath() . 'class.SimpleImage.php';
            
            $oSimpleImage = new SimpleImage();

            $oSimpleImage->load('/../../' . $oPath->getRealizationImagesPath() . $_FILES['Filedata']['name']);
            $oSimpleImage->resizeToWidth(300);
            $oSimpleImage->save('/../../' . $oPath->getRealizationImagesPath() . $_FILES['Filedata']['name']);
        }
        
        echo $_FILES['Filedata']['name'];
    }

?>
