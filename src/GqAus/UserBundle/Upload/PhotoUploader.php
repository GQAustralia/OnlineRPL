<?php

namespace GqAus\UserBundle\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Gaufrette\Filesystem;

class PhotoUploader
{
    private static $allowedMimeTypes = array(
        'image/jpeg',
        'image/jpg',        
        'image/JPEG',
        'image/JPG',
        'JPEG',
        'JPG',
        'image/png',
        'application/octet-stream',
        'image/gif'
    );

    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file)
    {
        echo "<pre>"; print_r($file); exit;
        // Check if the file's mime type is in the list of allowed mime types.
        if (!in_array($file->getClientMimeType(), self::$allowedMimeTypes)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }

        // Generate a unique filename based on the date and add file extension of the uploaded file
        $filename = sprintf('%s/%s/%s/%s.%s', date('Y'), date('m'), date('d'), uniqid(), $file->getClientOriginalExtension());

        $adapter = $this->filesystem->getAdapter();
        $adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
        echo $filename."//".$file->getPathname(); exit;
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }
}
