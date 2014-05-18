<?php

require __DIR__ . '/../amazon/autoload.php';

use Aws\S3\S3Client;
use Aws\Common\Enum\Size;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Model\MultipartUpload\UploadBuilder;

/**
 * Class for managing files in Amazon S3 storage
 *
 * @author Łukasz
 */
class AmazonS3 
{
    private $oClient;
    private $sBucket;
    
    public function __construct($sKey, $sSecret, $sBucket) 
    {
        $this->oClient = S3Client::factory(
                    array(
                        'key' => $sKey,
                        'secret' => $sSecret
                    ));
        
        $this->sBucket = $sBucket;
    }
    
    /**
     * Multipart upload for large files
     * 
     * @param string $sUploadedFile Name and path of file to upload
     * @param string $sRemoteFileName Filename on S3 storage when uploaded
     * @param integer $iNumberOfFileParts Number of parts which file was splitted
     * @return boolean <b>True</b> if success and <b>false</b> if failure
     */
    public function uploadMultiPartFile($sUploadedFile, $sRemoteFileName, $iNumberOfFileParts = 1)
    {
        $oUploader = UploadBuilder::newInstance()
                ->setClient($this->oClient)
                ->setSource($sUploadedFile)
                ->setBucket($this->sBucket)
                ->setKey($sRemoteFileName)
                ->setConcurrency($iNumberOfFileParts)
                ->setOption('CacheControl', 'max-age=3600')
                ->build();
        
        try 
        {
            $oUploader->upload();
            return 1;
        }
        catch (MultipartUploadException $e) 
        {
            $oUploader->abort();
            return 0;
        }
    }
    
    /**
     * Upload for normal files
     * 
     * @param string $sUploadedFile Name and path of file to upload
     * @param string $sRemoteFileName Filename on S3 storage when uploaded
     * @return string URL to file on storage
     */
    public function uploadFile($sUploadedFile, $sRemoteFileName)
    {
        $aResult = $this->oClient->putObject(array(
            'Bucket' => $this->sBucket,
            'Key'    => $sRemoteFileName,
            'SourceFile' => $sUploadedFile,
            'ACL' => 'public-read'
        ));
        $this->oClient->waitUntilObjectExists(array('Bucket' => $this->sBucket, 'Key' => $sRemoteFileName));
        
        return $aResult['ObjectURL'];
    }
    
    public function deleteFile($sRemoteFileName)
    {
        $aResult = $this->oClient->deleteObject(array(
            'Bucket' => $this->sBucket,
            'Key'    => $sRemoteFileName
        ));
        
        return $aResult['DeleteMarker'] ? 0 : 1;
    }
}
?>
