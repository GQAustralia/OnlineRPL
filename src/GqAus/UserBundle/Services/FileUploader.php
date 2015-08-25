<?php

namespace GqAus\UserBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use GqAus\UserBundle\Entity\UserIds;
use GqAus\UserBundle\Entity\OtherFiles;
use Gaufrette\Filesystem;
use \DateTime;

class FileUploader
{

    /**
     * @var Object
     */
    private $container;

    /**
     * @var Object
     */
    private $filesystem;

    /**
     * Constructor
     * @param object $filesystem
     * @param object $em
     * @param object $container
     * @param object $userService
     */
    public function __construct(Filesystem $filesystem, $em, $container, $userService)
    {
        $this->filesystem = $filesystem;
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $userService->getCurrentUser();
        $this->container = $container;
    }

    /**
     * function to upload files in AWS S3.
     * @param array $files
     *  return string
     */
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
     * @param object $file
     *  return array
     */
    public function uploadToAWS(UploadedFile $file)
    {
        $size = $file->getClientSize();
        $maxFileSize = $this->container->getParameter('maxFileSize');
        if ($size <= $maxFileSize) {
            // Generate a unique filename based on the date and add file extension of the uploaded file
            $filename = sprintf('%s-%s-%s-%s.%s', date('Y'), date('m'), date('d'), uniqid(),
                $file->getClientOriginalExtension());
            $adapter = $this->filesystem->getAdapter();
            $adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
            $adapter->write($filename, file_get_contents($file->getPathname()));
            return array('aws_file_name' => $filename, 'orginal_name' => $file->getClientOriginalName());
        }
    }

    /**
     * function to save document types.
     * @param array $data
     *  return array
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
            $now = new DateTime('now');
            $result = array(
                'id' => $userIdFiles->getId(),
                'name' => $fileNames['orginal_name'],
                'path' => $fileNames['aws_file_name'],
                'type' => $userIdFiles->getType()->getType(),
                'date' => $now->format('d/m/Y')
            );
            return json_encode($result);
        }
        return $fileNames;
    }

    /**
     * function to delete evidence file types in AWS S3.
     * @param string $fileName
     */
    public function delete($fileName)
    {
        $adapter = $this->filesystem->getAdapter();
        $adapter->delete($fileName);
    }

    /**
     * function to upload resume for assessor.
     * @param array $data
     *  return array
     */
    public function resume($data)
    {
        try {
            $fileNames = $this->uploadToAWS($data['browse']);
            $otherFiles = new OtherFiles();
            $otherFiles->setAssessor($this->currentUser);
            $otherFiles->setType($data['type']);
            $otherFiles->setName($fileNames['orginal_name']);
            $otherFiles->setPath($fileNames['aws_file_name']);
            $this->em->persist($otherFiles);
            $this->em->flush();
            $now = new DateTime('now');
            $result = array(
                'id' => $otherFiles->getId(),
                'name' => $fileNames['orginal_name'],
                'path' => $fileNames['aws_file_name'],
                'type' => $otherFiles->getType(),
                'date' => $now->format('d/m/Y')
            );
            return json_encode($result);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * function to find whether file exists or not in AWS S3.
     * @param string $fileName
     * return string
     */
    public function fileExists($fileName)
    {
        $adapter = $this->filesystem->getAdapter();
        return $adapter->exists($fileName);
    }

}
