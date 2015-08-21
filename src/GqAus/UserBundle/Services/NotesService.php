<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class NotesService
{

    /**
     * @var Object
     */
    private $em;

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
        $this->container = $container;
        $this->userService = $userService;
    }

    /**
     * Save Notes
     * Input : data
     * Output: boolean
     */
    public function saveNotes($data)
    {
        if (!empty($data['unit_notes'])) {
            $notesObj = new Note();
            $notesObj->setUnitID($data['note_unit_id']);
            $notesObj->setNote($data['unit_notes']);
            $notesObj->setType($data['unit_note_type']);
            $dateObj = new DateTime('now');
            $notesObj->setCreated($dateObj);
            $this->em->persist($notesObj);
            $this->em->flush();
            if ($data['session_user_role'] === 'ROLE_ASSESSOR') {
                $this->sendNotificationToFacilitator($data);
            }
            return "success";
        } else
            return "error";
    }

    /**
     * Function to get notes
     * return array 
     */
    public function getUnitNotes($unitId, $userType)
    {
        $return = array();
        $notesObj = $this->em->getRepository('GqAusUserBundle:Note');
        $unitNotes = $notesObj->findBy(array(
            'unitID' => $unitId,
            'type' => $userType), array('id' => 'DESC'));
        if ($unitNotes) {
            $return = $unitNotes;
        }
        return $return;
    }

    /**
     * Function to get facilitatorInfo
     * return array 
     */
    public function getQualificationUnitFacilitator($unitId)
    {
        $data = array();
        $unitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
            ->find($unitId);
        if (!empty($unitObj)) {
            $applicantId = $unitObj->getUser();
            $courseCode = $unitObj->getCourseCode();
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
                'user' => $applicantId));
            if (!empty($courseObj)) {
                $data['courseCode'] = $courseCode;
                $data['courseName'] = $courseObj->getCourseName();
                $data['unitCode'] = $unitObj->getUnitId();
                $data['facilitatorEmail'] = $courseObj->getFacilitator()->getEmail();
                $data['facilitatorId'] = $courseObj->getFacilitator()->getId();
                $data['facilitatorUserName'] = $courseObj->getFacilitator()->getUsername();
            }
        }
        return $data;
    }

    /**
     * Function to send Notification to facilitator
     * return array 
     */
    public function sendNotificationToFacilitator($data)
    {
        $facilitatorInfo = $this->getQualificationUnitFacilitator($data['note_unit_id']);
        if (!empty($facilitatorInfo)) {
                        
            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#', '#unitCode#');
            $subReplace = array($facilitatorInfo['courseCode'], $facilitatorInfo['courseName'], $facilitatorInfo['unitCode']);
            $messageSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('msg_add_notes_sub'));
            $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_add_notes_sub'));
            
            // finding and replacing the variables from message templates
            $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#unitCode#', '#unitNotes#',  '#fromUserName#');
            $msgReplace = array($facilitatorInfo['facilitatorUserName'], $facilitatorInfo['courseCode'], $facilitatorInfo['courseName'], $facilitatorInfo['unitCode'], $data['unit_notes'], $data['session_user_name']);
            $messageBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('msg_add_notes_con'));
            $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_notes_con'));
            
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName*/
            $this->userService->sendExternalEmail($facilitatorInfo['facilitatorEmail'], $mailSubject, $mailBody, $data['session_user_email'], $data['session_user_name']);
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId*/
            $this->userService->sendMessagesInbox($facilitatorInfo['facilitatorId'], $data['session_user_id'], $messageSubject, $messageBody, $data['note_unit_id'] );
        }
    }

}
