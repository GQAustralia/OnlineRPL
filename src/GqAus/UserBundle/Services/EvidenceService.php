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

    /**
     * @var Object
     */
    private $userId;

    /**
     * @var Object
     */
    private $repository;

    /**
     * @var Object
     */
    public $currentUser;

    /**
     * @var Object
     */
    private $container;

    /**
     * @var Object
     */
    public $userService;

    /**
     * Constructor
     * @param object $em
     * @param object $container
     * @param object $userService
     */
    public function __construct($em, $container, $userService)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $userService->getCurrentUser();
        $this->container = $container;
        $this->userService = $userService;
    }

    /**
     * Function to save evidence
     * @param array $evidences
     * @param array $data
     * return string
     */
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
                    $size = $data['file'][$i]->getClientSize();
                    $size = $this->fileSize($size);
                    $pos = strpos($mimeType, '/');
                    $type = substr($mimeType, 0, $pos);
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
                    if(isset($data['hid_unit'])) // null value added for unmapped file upload
                        $fileObj->setUnit($data['hid_unit']);
                    if(isset($data['hid_course'])) // null value added for unmapped file upload
                        $fileObj->setCourse($data['hid_course']);
                    $this->em->persist($fileObj);
                    $this->em->flush();

                    $logType = $this->userService->getlogType('7');
                    $this->userService->createUserLog('7', $logType['message']);
                    if(isset($data['hid_unit']) && isset($data['hid_course'])) // Uploading evidence by candidate then update course units
                        $this->updateCourseUnits($this->userId, $data['hid_unit'], $data['hid_course']);
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
            $this->updateCourseUnits($this->userId, $data['hid_unit'], $data['hid_course']);
        }
        return ($seterror == 'no') ? $data['hid_unit'] : $seterror;
    }

     /**
     * Function to save evidence
     * @param array $evidences
     * @param array $data
     * return string
     */
     public function saveS3ToEvidence($data)
    {

        if (!isset($data['self_assessment'])) {
            $i = 0;
            $seterror = 'no';
            $filName = $data['path'];
            $jobId = $data['jobId'];
            $size = $data['size'];
            ;
            $mimeType = $data['type'];
            $size = $this->fileSize($size);
            $pos = strpos($mimeType, '/');
            $type = substr($mimeType, 0, $pos);
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
                    $type = 'file';
                    break;
                case 'application':
                    $fileObj = new File();
                    break;
                default :
                    $fileObj = new File();
                    break;
            }
            $fileObj->setPath($filName);
            $fileObj->setName($data['name']);
            $fileObj->setJobId($jobId);
            $fileObj->setFacilitatorViewStatus('0');
            $fileObj->setUser($this->currentUser);
            $fileObj->setSize($size);
            $categoryObj = $this->em->getRepository('GqAusUserBundle:EvidenceCategory')->findOneById($data['category']);
            $fileObj->setCategory($categoryObj);
            if (isset($data['unitCode'])) // null value added for unmapped file upload
                $fileObj->setUnit($data['unitCode']);
            if (isset($data['courseCode'])) // null value added for unmapped file upload
                $fileObj->setCourse($data['courseCode']);
            $this->em->persist($fileObj);
            $this->em->flush();
            $evidenceId = $fileObj->getId();
            $fileNumber = $data['fileNum'];
            if((isset($data['unitCode']) && !empty($data['unitCode'])) && (isset($data['courseCode']) && !empty($data['courseCode']))) // Uploading evidence by candidate then update course units
            $this->updateCourseUnits($this->userId, $data['unitCode'], $data['courseCode'],'', false);
        } else {
        				
            if (!empty($data['self_assessment_id'])) {
            	
            				$textObjTemp = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
            				$textObj = $textObjTemp->findOneById($data['self_assessment_id']);
            }
            else {
            	$textObj = new Text();
            }
            
            $textObj->setContent($data['self_assessment']);
            $textObj->setUnit($data['unitCode']);
            $textObj->setCourse($data['courseCode']);
            $textObj->setUser($this->currentUser);
            $textObj->setFacilitatorViewStatus('0');
            if (empty($data['self_assessment'])) {
            	
            				$this->em->remove($textObj);
            				$this->em->flush();
            				$evidenceId = '';
            }
            else {
            				$this->em->persist($textObj);
            				$this->em->flush();
            				$evidenceId = $textObj->getId();
            }
            
            $this->updateCourseUnits($this->userId, $data['unitCode'], $data['courseCode'],'', false);
        }
       
        return array('evidenceId' => $evidenceId);
    }

    /**
     * Save Evidence Assessment 
     * @param array $data
     * return string
     */
    public function saveEvidenceAssessment($data)
    {
        if (!empty($data['self_assessment'])) {
            $textObj = new Text();
            $textObj->setContent($data['self_assessment']);
            $textObj->setUnit($data['hid_unit_assess']);
            $textObj->setCourse($data['hid_course_assess']);
            $textObj->setSelfAssesssment($data['setAssessment']);
            $textObj->setJobId('');
            $textObj->setFacilitatorViewStatus('0');
            $textObj->setUser($this->currentUser);
            $this->em->persist($textObj);
            $this->em->flush();
            $this->updateCourseUnits($this->userId, $data['hid_unit_assess'], $data['hid_course_assess'],'1');
            
            $logType = $this->userService->getlogType('10');
            $this->userService->createUserLog('10', $logType['message']);

            return "1&&" . $data['hid_unit_assess'];
        } else
            $logType = $this->userService->getlogType('11');
            $this->userService->createUserLog('11', $logType['message']);
            return "0&&" . $data['hid_unit_assess'];
    }
    /**
     * Update Evidence Assessment 
     * @param array $data
     * return string
     */
    public function updateEvidenceAssessment($data){
        if (!empty($data['self_assessment'])) {
            $textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
            $newObj = $textObj->find($data['selfAssId']);
            $newObj->setContent($data['self_assessment']);
            $newObj->setSelfAssesssment($data['setAssessment']);
            $this->em->persist($newObj);
            $this->em->flush();
            $this->updateCourseUnits($this->userId, $data['hid_unit_assess'], $data['hid_course_assess'],'1');
            
            $logType = $this->userService->getlogType('10');
            $this->userService->createUserLog('10', $logType['message']);

            return "1&&" . $data['hid_unit_assess'];
        } else
            $logType = $this->userService->getlogType('11');
            $this->userService->createUserLog('11', $logType['message']);
            return "0&&" . $data['hid_unit_assess'];

    }

    /**
     * Function to get file size
     * @param int $size
     * return string
     */
    public function fileSize($size)
    {
        if ($size >= 1073741824) {
            $fileSize = round($size / 1024 / 1024 / 1024) . 'GB';
        } elseif ($size >= 1048576) {
            $fileSize = round($size / 1024 / 1024) . 'MB';
        } elseif ($size >= 1024) {
            $fileSize = round($size / 1024) . 'KB';
        } else {
            $fileSize = $size . ' bytes';
        }
        return $fileSize;
    }

    /**
     * Function to save existing evidence
     * @param object $request
     * return string
     */
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
                            $newObj->setJobId("");
                            $newObj->setFacilitatorViewStatus('0');
                            $this->em->persist($newObj);
                            $this->em->flush();
                            $this->updateCourseUnits($this->userId, $unitId, $courseCode,'',false);
                        }
                    }//foreach
                }//if
            }//foreach
        }
        return $unitId;
    }

    /**
     * Function to delete evidence
     * @param int $evidenceId
     * @param string $evidenceType
     * return string
     */
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
			
            $logType = $this->userService->getlogType('8');
            $this->userService->createUserLog('8', $logType['message']);
			
            return $fileName;
        }
    }

    /**
     * Function to get elective units
     * @param int $userId
     * @param int $unitId
     * return array
     */
    public function getUserUnitEvidences($userId, $unitId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        return $reposObj->findBy(array('user' => $userId, 'unit' => $unitId));
    }

    /**
     * Function to update Evidence
     * @param int $evidenceId
     * @param string $evidenceType
     * return boolean
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
           // $evidenceObj->setUnit('');
            $this->em->persist($evidenceObj);
            $this->em->flush();
            return true;
        }
    }

    /**
     * Function to update Evidence Title
     * @param int $evidenceId
     * @param string $evidenceTitle
     */
    public function updateEvidence($evidenceId, $evidenceTitle)
    {
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence')->find($evidenceId);
        $imgObj->setName($evidenceTitle);
        $this->em->persist($imgObj);
        $this->em->flush();
    }

    /**
     * Function to get all evidences of the user for one course
     * @param int $userId
     * @param int $courseId
     * return array
     */
    public function getUserCourseEvidences($userId, $courseId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        return $reposObj->findBy(array('user' => $userId, 'course' => $courseId));
    }

    /**
     * Function to save recording
     * @param string $evidence
     * @param int $applicantID
     * @param string $unitCode
     * @param string $courseCode
     */
    public function saveRecord($evidence, $applicantID, $unitCode, $courseCode)
    {
        $unitCode = ($unitCode == 'empty') ? '' : $unitCode;
        $user = $this->repository->findOneById($applicantID);
        $recordingObj = new Recording();
        $recordingObj->setPath($evidence);
        $recordingObj->setName('');
        $recordingObj->setSize('');
        $recordingObj->setUnit($unitCode);
        $recordingObj->setCourse($courseCode);
        $recordingObj->setFacilitatorViewStatus('0');
        $recordingObj->setUser($user);
        $this->em->persist($recordingObj);
        $this->em->flush();
    }

    /**
     * Function to update coures units
     * @param int $userId
     * @param string $unitId
     * @param string $courseCode
     */
    public function updateCourseUnits($userId, $unitId, $courseCode,$submit_review=null,$evd=null)
    {
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
            ->findOneBy(array('user' => $userId, 'unitId' => $unitId, 'courseCode' => $courseCode));
        
        //to update - when candidate submit the unit review status 
        if($submit_review!=null){
          $courseUnitObj->setIssubmitted(1);
          $courseUnitObj->setStatus(1);
          $this->em->persist($courseUnitObj);
          $this->em->flush();  
        }
        else if ($courseUnitObj->getFacilitatorstatus() == 2 or $courseUnitObj->getAssessorstatus() == 2) {
            if($evd)
            {
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
             }
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseUnitObj->getCourseCode(), 'user' => $userId));
            $userInfo = $this->userService->getUserInfo($userId);

            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#', '#unitId#');
            $subReplace = array($courseObj->getCourseCode(), $courseObj->getCourseName(), $courseUnitObj->getUnitId());
            $messageSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('msg_add_evidence_sub'));
            $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_add_evidence_sub'));

            $facilitatorName = $courseObj->getFacilitator()->getUsername();
            // finding and replacing the variables from message templates
            $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#unitId#', '#fromUserName#','#applicationUrl#');
            $msgReplace = array($facilitatorName, $courseObj->getCourseCode(), $courseObj->getCourseName(), 
                $courseUnitObj->getUnitId(), $userInfo->getUsername(), $this->container->getParameter('applicationUrl'));
            $messageBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('msg_add_evidence_con'));
            $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_evidence_con'));
            $emailService = $this->get('EmailService');
            $mailBody = $emailService->getNotificationToApplicantEmailMsg($userId, $mailBody, $userId, $courseObj);
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            $this->userService->sendExternalEmail($courseObj->getFacilitator()->getEmail(), $mailSubject, 
                $mailBody, $userInfo->getEmail(), $userInfo->getUsername());
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
            $this->userService->sendMessagesInbox($courseObj->getFacilitator()->getId(), $userId, 
                $messageSubject, $messageBody, $courseUnitObj->getId(), 1);

            // checking whether the assessor is assigned or not
            $cAssessor = $courseObj->getAssessor();
            if (!empty($cAssessor)) {
                $assessorName = $courseObj->getAssessor()->getUsername();
                $msgReplace = array($assessorName, $courseObj->getCourseCode(), $courseObj->getCourseName(),
                    $courseUnitObj->getUnitId(), $courseObj->getFacilitator()->getUsername(), $this->container->getParameter('applicationUrl'));
                $messageBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('msg_add_evidence_con'));
                $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_evidence_con'));
																
                $emailService = $this->get('EmailService');
                $mailBody = $emailService->getNotificationToApplicantEmailMsg($userId, $mailBody, $courseObj->getFacilitator()->getId(), $courseObj);
                /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
                $this->userService->sendExternalEmail($courseObj->getAssessor()->getEmail(), 
                    $mailSubject, $mailBody, $courseObj->getFacilitator()->getEmail(),
                    $courseObj->getFacilitator()->getUsername());
                /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
                $this->userService->sendMessagesInbox($courseObj->getAssessor()->getId(), 
                    $courseObj->getFacilitator()->getId(), $messageSubject, $messageBody, $courseUnitObj->getId(), 1);
            }
        }
    }

    /**
     * Function to get evidence
     * @param int $evidenceId
     * return array
     */
    public function getEvidenceById($evidenceId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        return $reposObj->find($evidenceId);
    }
	    /**
     * Function to get self assessment
     * @param int $userId
     * @param string $courseCode
     * @param string $UnitCode
     * return array
     */
    public function getSelfAssessmentFromUnit($userId, $courseCode, $unitCode){
        $connection = $this->em->getConnection();
        $statement = $connection->prepare('SELECT * FROM evidence as e,evidence_text as et WHERE e.user_id = :applicantId AND e.unit_code = :unitCode AND e.course_code = :courseCode AND e.type = :type AND e.id=et.id');
        $statement->bindValue('applicantId', $userId);
        $statement->bindValue('courseCode', $courseCode);
        $statement->bindValue('unitCode', $unitCode);
        $statement->bindValue('type', 'text');
        $statement->execute();
        $allRcrds = $statement->fetchAll();
        return $allRcrds;
    }
    /**
     * Function to get the evidence showing type means fancybox or else....
     * @param string $$evidenceType
     * return string
     */
    public function getEvidenceShowType($evidenceType){
        switch($evidenceType){
            case 'image':
                 $evtype = "photo";
                 $evfancy = "fancybox";
                 break;
            case 'audio':
                 $evtype = "mic";
                 $evfancy = "fancybox fancybox.iframe";
                 break; 
            case 'video':
                 $evtype = "videocam";
                 $evfancy = "fancybox fancybox.iframe";
                 break;
            case 'file':
                 $evtype = "description";
                 $evfancy = "fancybox fancybox.iframe";
                 break;
            case 'recording':
                 $evtype = "fiber_manual_record";
                 $evfancy = "fancybox fancybox.iframe";
                 break;
            case 'text':
                 $evtype = "text_fields";
                 $evfancy = "text";
                 break;
            default:
                 $evtype = "";
                 $evfancy = "";
                 break;            
        }
        return $evtype;
    }
    /**
     * Function to get the EvidenceType By Evidence Id
     * @param type $evidenceId
     * @return string
     */
    public function getEvidenceTypeByEvidenceId($evidenceId)
    {
        switch($evidenceId){
            case 1:
                $evType ='photo';
                break;
            case 2:
                $evType ='description';
                break;
            default:
                $evType ='photo';
                break;
        }
        return $evType;
    }
    
    
    /**
    * Function to Format Evidences
    * @param array $evidences
    * @return array $evidenceList
    */
    public function formatEvidencesListToDisplay($evidences)
    {
        $formattedEvidences = $evidenceTypeCount = $mappedEvidence = $unMappedEvidences = $mappedToMultipleUnit = $mappedToOneUnit = $mappingCount = $evidenceList = array();
        if(!empty($evidences)){
            foreach($evidences as $key => $evidence){
                $evdPath = (method_exists($evidence,'getName')) ?  $evidence->getPath() : $evidence->getContent();
                $evidenceTypeCount[$evidence->getType()][] = $evdPath;
                if($evidence->getUnit())
                    $mappedEvidence[$evdPath][] = $evidence->getUnit();
                else
                    $unMappedEvidences[$evdPath][] = $evidence->getId();

                $formattedEvidences[$evdPath][] = $evidence;
            }
            foreach($mappedEvidence as $mKey => $mappedEvd){
                if(count($mappedEvd) > 1)
                    $mappedToMultipleUnit[] = $mKey;
                else if(count($mappedEvd) == 1)
                    $mappedToOneUnit[] = $mKey;
            }
        }
        $evdMapping['unMappedEvidences'] = $unMappedEvidences;
        $evdMapping['mappedToOneUnit'] = $mappedToOneUnit;
        $evdMapping['mappedToMultipleUnit'] = $mappedToMultipleUnit;
        $evdMapping['typeCount'] = $evidenceTypeCount;        
        $evidenceList['evdMapping'] = $evdMapping;
        $evidenceList['formattedEvidences'] = $formattedEvidences;
        return $evidenceList;
    }

      /**
     * Function to get elective units
     * @param int $userId
     * @param int $unitId
     * return array
     */
    public function getUserUnitwiseEvidences($userId, $unitId, $courseCode)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        $evidences = $reposObj->findBy(array('user' => $userId, 'unit' => $unitId, 'course' => $courseCode));
        return $evidences;
    }
    
    /**
     * Function to get elective units
     * @param int $userId
     * @param int $unitId
     * return array
     */
    public function updateSthreeJobId($jobId)
    {
        $evdObj = $this->em->getRepository('GqAusUserBundle:Evidence')->findOneBy(array('jobId' => $jobId));
        if (!empty($evdObj)) {
            $evdObj->setJobId('');
            $this->em->persist($evdObj);
            $this->em->flush();
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Function to update evidence view status
     * @param int $id
     */
    public function updateEvidenceViewStaus($id)
    {
        $evidenceIds = array();
        $evidenceIds = explode(',', $id);
        if(!empty($evidenceIds) && is_array($evidenceIds)){
            foreach($evidenceIds as $idVal){
                $remObj = $this->em->getRepository('GqAusUserBundle:Evidence')->find($idVal);
                $remObj->setFacilitatorViewStatus('1');
                $this->em->persist($remObj);
                $this->em->flush();
            }
        }
    }

    /**
     * Function to convert file size to bytes
     * @param string $size
     * return int $byteSize
     */
    public function convertSizetoBytes($fileSizeString)
    {   
	preg_match('/[^\d]+/', $fileSizeString, $unitMatch);
	preg_match('/\d+/', $fileSizeString, $sizeMatch);
      
	$fileSizeUnit = $unitMatch[0];
        $fileSize = $sizeMatch[0];

	switch($fileSizeUnit){
            case 'KB':
                    $byteSize = $fileSize * 1024;
                    break;
            case 'MB':
                    $byteSize = $fileSize * (1024 * 1024);
                    break;
            case 'GB':
                    $byteSize = $fileSize * ((1024 * 1024) * 10);
                    break;
            case 'TB':
                    $byteSize = $fileSize * ((1024 * 1024) * 100);
                    break;
            case 'PB':
                    $byteSize = $fileSize * ((1024 * 1024) * 1000);
                    break;
            default:
                    $byteSize = '0';
	}
	return $byteSize;
    }
    /**
     * Function to get if the evidence is submitted or not  
     * @param type $evdId
     */
    public function getEvidenceIsSubmittedOrNot($evdId)
    {
         $evdObj = $this->em->getRepository('GqAusUserBundle:Evidence')->find($evdId);
         $isSubmitted = 0;
         if(!empty($evdObj)){
             $userId = $evdObj->getUser()->getId();
             $unitId = $evdObj->getUnit();
             $courseCode = $evdObj->getCourse();
             if(!empty($userId) && !empty($unitId) && !empty($courseCode)){
                 $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findOneBy(array('user' => $userId, 'unitId' => $unitId, 'courseCode' => $courseCode));
                 if(!empty($courseUnitObj)){
                    $isSubmitted =  $courseUnitObj->getIssubmitted();
                }  
             }
         }
         return $isSubmitted;
    }

    /**
     * Function to get file extension type
     * @param string $fileName
     * return bool true or false
     */
    public function getFileExtensionType($fileName)
    {
        $fileExt = explode('.', $fileName);
        $fileExtIndex = (count($fileExt)-1);
        $fileExtType = $fileExt[$fileExtIndex];
        $msDocExtensions = $this->container->getParameter('ms_docs');
        if(in_array($fileExtType, $msDocExtensions))
            $msDocStatus = true;
        else
            $msDocStatus = false;
	return $msDocStatus;
    }
    
    /**
     * function to update Evidence Completed Status
     * @param Array
     */
    
    public function unitSubmit($data)
    {
        if (!empty($data['unitCode']) && !empty($data['courseCode'])) {
            $this->updateCourseUnits($this->userId, $data['unitCode'], $data['courseCode'], '1');
            $logType = $this->userService->getlogType('10');
            $this->userService->createUserLog('10', $logType['message']);
            return array('success'=>'Updated Succesfully');
        } else {
            $logType = $this->userService->getlogType('11');
            $this->userService->createUserLog('11', $logType['message']);
            return array('error'=>'Unit or Course ID missing');
        }
    }
    
    /**
     * 
     * @param type $userId
     * @param type $courseCode
     * @param type $unitCode
     * @param type $evidenceKeys
     * @return 
     */
    
    public function copyEvidence($userId,$courseCode,$unitCode,$category,$evidenceKeys)
    {
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
        $audioObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
        $videoObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
        $fileObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
        $textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
        foreach($evidenceKeys as $evidence){
            $evdObj = $this->em->getRepository('GqAusUserBundle:Evidence')->find($evidence);
            switch ($evdObj->getType()) {
                case 'image':
                 //   $evidenceObj = $imgObj->find($val);
                    $newObj = new Image();
                    break;
                case 'audio':
                  //  $evidenceObj = $audioObj->find($val);
                    $newObj = new Audio();
                    break;
                case 'video':
                  //  $evidenceObj = $videoObj->find($val);
                    $newObj = new Video();
                    break;
                case 'file':
                   // $evidenceObj = $fileObj->find($val);
                    $newObj = new File();
                    break;
                case 'text':
                   // $evidenceObj = $textObj->find($val);
                    $newObj = new Text();
                    break;
                default :
                   // $evidenceObj = $fileObj->find($val);
                    $newObj = new File();
                    break;
            }
            $newObj->setPath($evdObj->getPath());
            $newObj->setName($evdObj->getName());
            $newObj->setSize(0);
            $newObj->setUser($this->currentUser);
            $newObj->setUnit($unitCode);
            $newObj->setCourse($courseCode);
            $categoryObj = $this->em->getRepository('GqAusUserBundle:EvidenceCategory')->findOneById($category);
            $newObj->setCategory($categoryObj);
            $newObj->setJobId("");
            $newObj->setFacilitatorViewStatus('0');
            $this->em->persist($newObj);
            $this->em->flush();
            $this->updateCourseUnits($this->userId, $unitCode, $courseCode, '', false);
        }
        return ['sucess'=>true];
    }
    
    public function deleteEvidences($evidences)
    {
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
        $audioObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
        $videoObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
        $fileObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
        $textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
        $fileName = '';
        foreach ($evidences as $evidence) {
            $evdObj = $this->em->getRepository('GqAusUserBundle:Evidence')->findOneById($evidence);

            switch ($evdObj->getType()) {
                case 'image':
                    $evidenceObj = $imgObj->findOneById($evidence);
                    break;
                case 'audio':
                    $evidenceObj = $audioObj->findOneById($evidence);
                    break;
                case 'video':
                    $evidenceObj = $videoObj->findOneById($evidence);
                    break;
                case 'file':
                    $evidenceObj = $fileObj->findOneById($evidence);
                    break;
                case 'text':
                    $evidenceObj = $textObj->findOneById($evidence);
                    break;
                default :
                    $evidenceObj = $fileObj->findOneById($evidence);
                    break;
            }

            if (!empty($evidenceObj)) {
                $fileName = $evidenceObj->getPath();
                $this->em->remove($evidenceObj);
                $this->em->flush();

                $logType = $this->userService->getlogType('8');
                $this->userService->createUserLog('8', $logType['message']);

                
            }
        }
        return array('fileName' => $fileName);
    }
    
    public function getEvidenceCats(){
        $evidenceCats = $this->em->getRepository('GqAusUserBundle:EvidenceCategory')->findAll();   
        return $evidenceCats;
    }
}
