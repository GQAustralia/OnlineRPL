<?php

namespace GqAus\UserBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use GqAus\UserBundle\Entity\UserIds;
use Gaufrette\Filesystem;

class FileUploader
{
     /**
     * @var Object
     */
    private $container;

    private $filesystem;
    
    /**
     * Constructor
     */
    public function __construct(Filesystem $filesystem, $em, $container)
    {
        $this->filesystem = $filesystem;
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->container = $container;
    }

    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }
    
    public function Process($files)
    {
        $fileNames = array();
        $i = 0;
        foreach ($files as $file) {
            $array = $this->uploadToAWS($file);            
            $fileNames[$i]['aws_file_name'] = $array['aws_file_name'];
            $fileNames[$i]['orginal_name'] = $array['orginal_name'];
            $i++;
        }
        return $fileNames;
        
    }
    
    /**
     * function to store documents types in AWS S3.
     *  @return array
     */
    public function uploadToAWS(UploadedFile $file)
    {
        $size =    $file->getClientSize();
        $maxFileSize = $this->container->getParameter('maxFileSize');
        if ($size <= $maxFileSize) {
            // Generate a unique filename based on the date and add file extension of the uploaded file
            $filename = sprintf('%s-%s-%s-%s.%s', date('Y'), date('m'), date('d'), uniqid(), $file->getClientOriginalExtension());
            $adapter = $this->filesystem->getAdapter();
            $adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
            $adapter->write($filename, file_get_contents($file->getPathname()));
            return array('aws_file_name' => $filename, 'orginal_name' => $file->getClientOriginalName());
        }
    }
    
    /**
     * function to save document types.
     *  @return array
     */
    public function uploadIdFiles($data)
    {        
        $fileNames = $this->uploadToAWS($data['browse']);
        if ($fileNames) {
            $userIdFiles = new UserIds();
            $userIdFiles->setUser($this->currentUser);
            $documentType = $this->em->getRepository('GqAusUserBundle:DocumentType');
            $documentID = $documentType->findOneById($data['type']->getId());
            $userIdFiles->setType($documentID);
            $userIdFiles->setName($fileNames['orginal_name']);
            $userIdFiles->setPath($fileNames['aws_file_name']);
            $this->em->persist($userIdFiles);
            $this->em->flush();
        } 
        return $fileNames;
    }
    
    /**
     * function to delete evidence file types in AWS S3.
     */
    public function delete($fileName)
    {
        $adapter = $this->filesystem->getAdapter();
        $adapter->delete($fileName);
    }
}
