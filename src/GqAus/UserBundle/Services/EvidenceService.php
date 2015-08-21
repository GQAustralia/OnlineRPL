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
        $this->currentUser = $userService->getCurrentUser();
        $this->container = $container;
        $this->userService = $userService;
    }

    /**
     * Function to save evidence
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
                    $fileObj->setUnit($data['hid_unit']);
                    $fileObj->setCourse($data['hid_course']);
                    $this->em->persist($fileObj);
                    $this->em->flush();

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
     * Save Evidence Assessment 
     * Input : data
     * Output: boolean
     */
    public function saveEvidenceAssessment($data)
    {
        if (!empty($data['self_assessment'])) {
            $textObj = new Text();
            $textObj->setContent($data['self_assessment']);
            $textObj->setUnit($data['hid_unit_assess']);
            $textObj->setCourse($data['hid_course_assess']);
            $textObj->setUser($this->currentUser);
            $this->em->persist($textObj);
            $this->em->flush();
            $this->updateCourseUnits($this->userId, $data['hid_unit_assess'], $data['hid_course_assess']);
            return "1&&" . $data['hid_unit_assess'];
        } else
            return "0&&" . $data['hid_unit_assess'];
    }

    /**
     * Function to get file size
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
                            $this->em->persist($newObj);
                            $this->em->flush();
                            $this->updateCourseUnits($this->userId, $unitId, $courseCode);
                        }
                    }//foreach
                }//if
            }//foreach
        }
        return $unitId;
    }

    /**
     * Function to delete evidence
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
    public function updateEvidence($evidenceId, $evidenceTitle)
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

    /**
     * Function to save recording
     * return -
     */
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

    /**
     * Function to update coures units
     * return -
     */
    public function updateCourseUnits($userId, $unitId, $courseCode)
    {
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
            ->findOneBy(array('user' => $userId, 'unitId' => $unitId, 'courseCode' => $courseCode));
        if ($courseUnitObj->getFacilitatorstatus() == 2 or $courseUnitObj->getAssessorstatus() == 2) {

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
            
            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#', '#unitId#');
            $subReplace = array($courseObj->getCourseCode(), $courseObj->getCourseName(), $courseUnitObj->getUnitId());
            $messageSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('msg_add_evidence_sub'));
            $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_add_evidence_sub'));

            $facilitatorName = $courseObj->getFacilitator()->getUsername();
            // finding and replacing the variables from message templates
            $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#unitId#', '#fromUserName#');
            $msgReplace = array($facilitatorName, $courseObj->getCourseCode(), $courseObj->getCourseName(), $courseUnitObj->getUnitId(), $userInfo->getUsername());
            $messageBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('msg_add_evidence_con'));
            $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_evidence_con'));
            
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName*/
            $this->userService->sendExternalEmail($courseObj->getFacilitator()->getEmail(), $mailSubject, $mailBody, $userInfo->getEmail(), $userInfo->getUsername());
             /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId*/
            $this->userService->sendMessagesInbox($courseObj->getFacilitator()->getId(), $userId, $messageSubject, $messageBody, $courseUnitObj->getId());

            // checking whether the assessor is assigned or not
            $cAssessor = $courseObj->getAssessor();
            if (!empty($cAssessor)) {
                $assessorName = $courseObj->getAssessor()->getUsername();
                $msgReplace = array($assessorName, $courseObj->getCourseCode(), $courseObj->getCourseName(), $courseUnitObj->getUnitId(), $courseObj->getFacilitator()->getUsername());
                $messageBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('msg_add_evidence_con'));
                $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_evidence_con'));
                
                /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName*/
                $this->userService->sendExternalEmail($courseObj->getAssessor()->getEmail(), $mailSubject, $mailBody, $courseObj->getFacilitator()->getEmail(), $courseObj->getFacilitator()->getUsername() );
                /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId*/
                $this->userService->sendMessagesInbox($courseObj->getAssessor()->getId(), $courseObj->getFacilitator()->getId(), $messageSubject, $messageBody, $courseUnitObj->getId());
                
            }
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
