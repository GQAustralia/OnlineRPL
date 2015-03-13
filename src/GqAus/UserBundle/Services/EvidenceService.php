<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Evidence\File;
use GqAus\UserBundle\Entity\Evidence\Image;
use GqAus\UserBundle\Entity\Evidence\Audio;
use GqAus\UserBundle\Entity\Evidence\Video;
use GqAus\UserBundle\Entity\Evidence\Text;
use GqAus\UserBundle\Entity\Evidence\Recording;
use Symfony\Component\HttpFoundation\Response;

class EvidenceService
{
    private $userId;
    private $repository;
    private $currentUser;
    /**
     * @var Object
     */
    private $container;
    
    private $userService;
    
    /**
     * Constructor
     */
    public function __construct($em, $container, $userService)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->container = $container;
        $this->userService = $userService;
    }

    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }
    
    public function saveEvidence($evidences, $data)
    {
        $i = 0;
        $seterror = 'no';
        $maxFileSize = $this->container->getParameter('maxFileSize');
        if (!empty($evidences)) {
            foreach ($evidences as $evidence) {
                $size = $data['file'][$i]->getClientSize();
                if ($size <= $maxFileSize) {
                    $mimeType = $data['file'][$i]->getClientMimeType();
                    $size = $data['file'][$i]-> getClientSize();
                    $size = $this->fileSize($size);
                    $pos = strpos($mimeType, '/');
                    $type = substr($mimeType,0,$pos);
                    switch ($type) {
                        case 'image':
                            $fileObj = new Image();
                            break;
                        case 'audio':
                            $fileObj = new Audio();
                            break;
                        case 'video':
                            $fileObj = new Video();
                            break;
                        case 'text':
                            $fileObj = new File();
                            break;
                        case 'application':
                            $fileObj = new File();
                            break;
                        default :
                            $fileObj = new File();
                            break;
                    }
                    $fileObj->setPath($evidence['aws_file_name']);
                    $fileObj->setName($evidence['orginal_name']);
                    $fileObj->setUser($this->currentUser);
                    $fileObj->setSize($size);
                    $fileObj->setUnit($data['hid_unit']);
                    $fileObj->setCourse($data['hid_course']);
                    $this->em->persist($fileObj);
                    $this->em->flush();
                    
                    $this->updateCourseUnits($this->userId, $data['hid_unit']);
                    $i++;
                } else {
                    $seterror = 'yes';
                }
            }//for
        }
        
        if (!empty($data['self_assessment'])) {
            $textObj = new Text();
            $textObj->setContent($data['self_assessment']);
            $textObj->setUnit($data['hid_unit']);
            $textObj->setCourse($data['hid_course']);
            $textObj->setUser($this->currentUser);
            $this->em->persist($textObj);
            $this->em->flush();
            $this->updateCourseUnits($this->userId, $data['hid_unit']);
        }
        return ($seterror == 'no')?$data['hid_unit']:$seterror;
    }
    
    public function fileSize($size)
    {
        if ($size >= 1073741824) {
          $fileSize = round($size / 1024 / 1024 / 1024) . 'GB';
        } elseif ($size >= 1048576) {
            $fileSize = round($size / 1024 / 1024) . 'MB';
        } elseif($size >= 1024) {
            $fileSize = round($size / 1024) . 'KB';
        } else {
            $fileSize = $size . ' bytes';
        }
        return $fileSize;
    }
    
    public function saveExistingEvidence($request)
    {
        $evidences = $request->get('evidence-file');
        $unitId = $request->get('select_hid_unit');
        $courseCode = $request->get('select_hid_course');
            
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
        $audioObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
        $videoObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
        $fileObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
        $textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
        if (!empty($evidences)) {
            foreach ($evidences as $key => $evidence) {
                if (!empty($evidence)) {
                    foreach ($evidence as $val) {
                        switch ($key) {
                            case 'image':
                                $evidenceObj = $imgObj->find($val);
                                $newObj = new Image();
                                break;
                            case 'audio':
                                $evidenceObj = $audioObj->find($val);
                                $newObj = new Audio();
                                break;
                            case 'video':
                                $evidenceObj = $videoObj->find($val);
                                $newObj = new Video();
                                break;
                            case 'file':
                                $evidenceObj = $fileObj->find($val);
                                $newObj = new File();
                                break;
                            case 'text':
                                $evidenceObj = $textObj->find($val);
                                $newObj = new Text();
                                break;
                            default :
                                $evidenceObj = $fileObj->find($val);
                                $newObj = new File();
                                break;
                        }
                        if (!empty($evidenceObj)) {
                            if ($key == 'text') {
                                $newObj->setContent($evidenceObj->getContent());
                            } else {
                                $newObj->setPath($evidenceObj->getPath());
                                $newObj->setName($evidenceObj->getName());
                                $newObj->setSize($evidenceObj->getSize());
                            }
                            $newObj->setUser($this->currentUser);                    
                            $newObj->setUnit($unitId);
                            $newObj->setCourse($courseCode);
                            $this->em->persist($newObj);
                            $this->em->flush();
                            $this->updateCourseUnits($this->userId, $unitId);
                        }
                    }//foreach
                }//if
            }//foreach
        }
        return $unitId;
    }
    
    public function deleteEvidence($evidenceId, $evidenceType)
    {
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
        $audioObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
        $videoObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
        $fileObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
        $textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
        
        switch ($evidenceType) {
            case 'image':
                $evidenceObj = $imgObj->find($evidenceId);
                break;
            case 'audio':
                $evidenceObj = $audioObj->find($evidenceId);
                break;
            case 'video':
                $evidenceObj = $videoObj->find($evidenceId);
                break;
            case 'file':
                $evidenceObj = $fileObj->find($evidenceId);
                break;
            case 'text':
                $evidenceObj = $textObj->find($evidenceId);
                break;
            default :
                $evidenceObj = $fileObj->find($evidenceId);
                break;
        }
        
        if (!empty($evidenceObj)) {
            $fileName = $evidenceObj->getPath();
            $this->em->remove($evidenceObj);
            $this->em->flush();
            return $fileName;
        }
    }
    
    /**
    * Function to get elective units
    * return $result array
    */
    public function getUserUnitEvidences($userId, $unitId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        return $reposObj->findBy(array('user' => $userId, 'unit' => $unitId));
    }
    
    /**
    * Function to update Evidence
    */
    public function updateInactiveEvidence($evidenceId, $evidenceType)
    {
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
        $audioObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
        $videoObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
        $fileObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
        $textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
        
        switch ($evidenceType) {
            case 'image':
                $evidenceObj = $imgObj->find($evidenceId);
                break;
            case 'audio':
                $evidenceObj = $audioObj->find($evidenceId);
                break;
            case 'video':
                $evidenceObj = $videoObj->find($evidenceId);
                break;
            case 'file':
                $evidenceObj = $fileObj->find($evidenceId);
                break;
            case 'text':
                $evidenceObj = $textObj->find($evidenceId);
                break;
            default :
                $evidenceObj = $fileObj->find($evidenceId);
                break;
        }
        
        if (!empty($evidenceObj)) {
            $evidenceObj->setUnit('');
            $this->em->persist($evidenceObj);
            $this->em->flush();
            return true;
        }
    }
    
    /**
    * Function to update Evidence Title
    */
    public function updateEvidence($evidenceId,$evidenceTitle)
    {
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence')->find($evidenceId);
        $imgObj->setName($evidenceTitle);
        $this->em->persist($imgObj);
        $this->em->flush();
    }
    
    /**
    * Function to get all evidences of the user for one course
    * return $result array
    */
    public function getUserCourseEvidences($userId, $courseId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        return $reposObj->findBy(array('user' => $userId, 'course' => $courseId));
    }
    
    public function saveRecord($evidence, $applicantID, $unitCode, $courseCode)
    {        
        $user = $this->repository->findOneById($applicantID);
        $recordingObj = new Recording();        
        $recordingObj->setPath($evidence);
        $recordingObj->setName('');
        $recordingObj->setSize('');
        $recordingObj->setUnit($unitCode);
        $recordingObj->setCourse($courseCode);
        $recordingObj->setUser($user);
        $this->em->persist($recordingObj);
        $this->em->flush();
    }
    
    public function updateCourseUnits($userId, $unitId)
    {
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findOneBy(array('user' => $userId,
                                                                                        'unitId' => $unitId));
        if ($courseUnitObj->getFacilitatorstatus() == 2 or $courseUnitObj->getAssessorstatus() == 2) {
            
            
            $mailerInfo = array();
            $mailerInfo['sent'] = $userId;
            $courseUnitObj->setFacilitatorstatus(0);
            $courseUnitObj->setAssessorstatus(0);
            $courseUnitObj->setRtostatus(0);
            $this->em->persist($courseUnitObj);
            $this->em->flush();
            
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->findOneBy(array('courseCode' => $courseUnitObj->getCourseCode(), 'user' => $userId));
            $courseObj->setFacilitatorstatus(0);
            $courseObj->setAssessorstatus(0);   
            $this->em->persist($courseObj);
            $this->em->flush();
            
            $userInfo = $this->userService->getUserInfo($userId);
            
            $mailerInfo['subject'] = "Evidence added to " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();            
            $userName = $courseObj->getFacilitator()->getUsername();
            $mailerInfo['to'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear ".$userName.", \n Evidence has been added to the Qualification : " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName() ." for unit  Unit : ".$unitId.". \n Please check and review the evidence.
             \n\n Regards, \n ". $userInfo->getUsername();
            $this->userService->sendExternalEmail($mailerInfo);
            $this->userService->sendMessagesInbox($mailerInfo);
            
            $userName = $courseObj->getAssessor()->getUsername();
            $mailerInfo['to'] = $courseObj->getAssessor()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getAssessor()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear ".$userName.", \n Evidence has been added to the Qualification : " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName() ." for unit  Unit : ".$unitId.". \n Please check and review the evidence.
             \n\n Regards, \n ". $userInfo->getUsername();
            $this->userService->sendExternalEmail($mailerInfo);
            $this->userService->sendMessagesInbox($mailerInfo);
            
        }
    }
    
    /**
    * Function to get evidence
    * return $result array
    */
    public function getEvidenceById($evidenceId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        return $reposObj->find($evidenceId);
    }
}