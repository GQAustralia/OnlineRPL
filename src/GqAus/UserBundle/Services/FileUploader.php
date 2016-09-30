<?php

namespace GqAus\UserBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use GqAus\UserBundle\Entity\UserIds;
use GqAus\UserBundle\Entity\OtherFiles;
use Gaufrette\Filesystem;
use GqAus\UserBundle\Entity\UserCourse\File;
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
		$this->userService = $userService;
    }

    /**
     * function to upload files in AWS S3.
     * @param array $files
     *  return string
     */
    public function process($files)
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
            return array('aws_file_name' => $filename, 'orginal_name' => $file->getClientOriginalName(),'file_size' =>$file->getClientSize());
        }
    }

    /**
     * function to save document types.
     * @param array $data
     *  return array
     */
    public function uploadIdFiles($data)
    {
      //
        $fileInfo = $data->get('fileInfo');
        $fileName = $data->get('fileName');
        $otherInfo= $data->get('otherInfo');
        $size = $fileInfo['size'];
        $mimeType = $fileInfo['type'];
        $otherInfo = $data->get('otherInfo');
       // $size = $this->fileSize($size);
        $pos = strpos($mimeType, '/');
        $type = substr($mimeType, 0, $pos);
       // $size   = '900';
       // $fileNames = $this->uploadToAWS($data['browse']);        
       // if ($fileNames) {
            $userIdFiles = new UserIds();
            $userIdFiles->setUser($this->currentUser);
            $documentType = $this->em->getRepository('GqAusUserBundle:DocumentType');
            $documentID = $documentType->findOneByType($otherInfo['docType']);  
            $userIdFiles->setType($documentID);
            $userIdFiles->setName($fileInfo['name']);
            $userIdFiles->setPath($fileName);
            $userIdFiles->setSize($size);            
            $this->em->persist($userIdFiles);
            $this->em->flush();
            $now = new DateTime('now');
            $result = array(
                'id' =>   $userIdFiles->getId(),
                'name' => $fileInfo['name'],
                'path' => $fileName,
                'type' => $userIdFiles->getType()->getType(),
                'date' => $now->format('d/m/Y'),
                'size' => $size
            );
            $logType = $this->userService->getlogType('2');
            $this->userService->createUserLog('2', $logType['message']);			
            return json_encode($result);
        //}
        $logType = $this->userService->getlogType('2');
        $this->userService->createUserLog('2', $logType['message']);		
        return $fileNames;
    }
    /**
     * function to save enrollment form.
     * @param array $data
     *  return array
     */
    public function uploadEnrollmentForm($data)
    {   
        $fileInfo = $data->get('fileInfo');
        $fileName = $data->get('fileName');
        $otherInfo= $data->get('otherInfo');
        $size = $fileInfo['size'];
        $mimeType = $fileInfo['type'];
        $otherInfo = $data->get('otherInfo');        
       // $size = $this->fileSize($size);
        $pos = strpos($mimeType, '/');
        $type = substr($mimeType, 0, $pos); 
        $typeForm = 'EnrollmentForm';         
        $userEnrollForms = $this->em->getRepository('GqAusUserBundle:UserCourse\File');
        $userCourse = $this->em->getRepository('GqAusUserBundle:UserCourses');
        $courseID = $userCourse->findOneBy(array('courseCode' => $otherInfo['userCourseId'],'user' => $otherInfo['userId']));  //dump($courseID);  exit;   
        $userEnrollForms->setCourse($courseID);
        $userEnrollForms->setType('EnrollmentForm');
        $userEnrollForms->setPath($fileName);
                    
        $this->em->persist($userEnrollForms);
        $this->em->flush();
        $now = new DateTime('now');
        $result = array(
            'id' =>   $userEnrollForms->getId(),
            'usercourse_id' => '36',          
            'type' => $typeForm,
            'path' => $fileName           
        );
        return json_encode($result);
       
    }
    public function uploadImgFiles($data)
    {       
        $fileInfo = $data->get('fileInfo');
        $fileName = $data->get('fileName');
        $otherInfo= $data->get('otherInfo');
        $size = $fileInfo['size'];
        $mimeType = $fileInfo['type'];
        $otherInfo = $data->get('otherInfo');
       // $size = $this->fileSize($size);
        $pos = strpos($mimeType, '/');
        $type = substr($mimeType, 0, $pos); 
       
        return json_encode( str_replace('"', '', $fileName));
        
            return $fileName;
      
    }

    /**
     * function to delete evidence file types in AWS S3.
     * @param string $fileName
     */
    public function delete($fileName)
    {   
        $adapter = $this->filesystem->getAdapter();
        $adapter->delete($fileName);
		$logType = $this->userService->getlogType('4');
		$this->userService->createUserLog('4', $logType['message']);		
    }

    /**
     * function to upload resume for assessor.
     * @param array $data
     *  return array
     */
    public function resume($data)
    {
      
          $fileInfo = $data->get('fileInfo');
        $fileName = $data->get('fileName');
        $type = 'matrix';
        $otherInfo= $data->get('otherInfo');
           // $fileNames = $data['browse'];
            $otherFiles = new OtherFiles();
            $otherFiles->setAssessor($this->currentUser);
            $otherFiles->setType($type);
            $otherFiles->setName($fileInfo['name']);
            $otherFiles->setPath($fileName);
            $otherFiles->setSize($fileInfo['size']);            
            $this->em->persist($otherFiles);
            $this->em->flush();
            $now = new DateTime('now');
            $result = array(
                'id' => $otherFiles->getId(),
                'name' => $fileInfo['name'],
                'path' => $fileName,
                'type' => $otherFiles->getType(),
                'date' => $now->format('d/m/Y')
            );
            return json_encode($result);
        
       
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
