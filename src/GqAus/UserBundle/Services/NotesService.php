<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class NotesService {

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
     * @var Object
     */
    public $emailService;

    /**
     * Constructor
     * @param object $em
     * @param object $container
     * @param object $userService
     */
    public function __construct($em, $container, $userService, $emailService) {
        $this->em = $em;
        $session = $container->get('session');
        $this->container = $container;
        $this->userService = $userService;
        $this->emailService = $emailService;
    }

    /**
     * Function to save Notes
     * @param array $data
     * return string
     */
    public function saveNotes($data) {
        if (!empty($data['unit_notes'])) {
            $note_unit_id = ($data['note_unit_id'] == null) ? 0 : $data['note_unit_id'];
            $course_id = ($data['course_id'] == null) ? 0 : $data['course_id'];
            $notesObj = new Note();
            $notesObj->setUnitID($note_unit_id);
            $notesObj->setNote($data['unit_notes']);
            $notesObj->setType($data['unit_note_type']);
            $notesObj->setCourseId($course_id);
            $dateObj = new DateTime('now');
            $notesObj->setCreated($dateObj);
            $this->em->persist($notesObj);
            $this->em->flush();
            if (($data['session_user_role'] === 'ROLE_ASSESSOR') && (!empty($note_unit_id))) {
                $this->sendNotificationToFacilitator($data);
            }
            return "success";
        } else
            return "error";
    }

    /**
     * Function to get notes
     * @param int $unitId
     * @param string $userType
     * return array
     */
    public function getUnitNotes($unitId, $userType) {
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
     * Function to update acknowledge
     * @param int $unitId
     * @param string $userType
     * return array
     */
    public function acknowledgeNote($noteId, $userId, $courseCode, $unitCode) {
        $return = array();
        $notesObj = $this->em->getRepository('GqAusUserBundle:Note');
        $unitNotes = $notesObj->findOneById(array(
            'id' => $noteId), array('id' => 'DESC'));

        if ($unitNotes) {
            $unitNotes->setAcknowledged(1);
            $this->em->persist($unitNotes);
            $this->em->flush();
            return $this->getNotesByUnitAndCourse($userId, $courseCode, $unitCode, 'f');
        }

        return "error";
    }
    /**
     * Function to delete the note 
     * @param type $noteId
     * @return string
     */
    public function deleteNote($userId, $courseCode,$noteId){
        $return = array();
        $unitNoteObj = $this->em->getRepository('GqAusUserBundle:Note')->findOneById(array('id' => $noteId));
        if ($unitNoteObj) {
            $unitCode = $unitNoteObj->getUnitId();
            $this->em->remove($unitNoteObj);
            $this->em->flush();
            return $this->getNotesByUnitAndCourse($userId, $courseCode, $unitCode, 'f');
        }
        return "error";
    }

    /**
     * Function to save Notes
     * @param array $data
     * return string
     */
    public function saveCandidateNotes($userId, $courseCode, $unitCode, $note) {
        if (!empty($note)) {

            $courseInfo = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->findOneBy(array('courseCode' => $courseCode, 'user' => $userId));

            $notesObj = new Note();
            $notesObj->setUnitID($unitCode);
            $notesObj->setNote($note);
            $notesObj->setType('f');
            $notesObj->setCourseId($courseInfo->getId());
            $dateObj = new DateTime('now');
            $notesObj->setCreated($dateObj);
            $notesObj->setAcknowledged(0);
            $this->em->persist($notesObj);
            $this->em->flush();

            return $this->getNotesByUnitAndCourse($userId, $courseCode, $unitCode, 'f');
        } else
            return "error";
    }
    /**
     * Function to save the note from facilitator
     * @param type $noteId
     * @param type $noteMsg
     * @return string
     */
    public function saveFacilitatorNotes($userId,$courseCode,$noteId, $noteMsg) {
        if (!empty($noteId) && !empty($noteMsg) ) {
            $unitNoteObj = $this->em->getRepository('GqAusUserBundle:Note')->findOneById(array('id' => $noteId));
            $unitNoteObj->setNote($noteMsg);
            $this->em->persist($unitNoteObj);
            $this->em->flush();
            return $this->getNotesByUnitAndCourse($userId, $courseCode, $unitNoteObj->getUnitID(), 'f');
        } else
            return "error";
    }

    /**
     * Function to get notes
     * @param int $unitId
     * @param string $userType
     * return array
     */
    public function getNotesByUnitAndCourse($userId, $courseCode, $unitCode, $type) {
        $return = array();

        $courseInfo = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->findOneBy(array('courseCode' => $courseCode, 'user' => $userId));

        $notesObj = $this->em->getRepository('GqAusUserBundle:Note');

        $unitNotes = $notesObj->findBy(array(
            'unitID' => $unitCode,
            'courseId' => $courseInfo->getId(),
            'type' => $type), array('id' => 'DESC'));

        $unitNotesArr = array();
        foreach ($unitNotes as $note) {
            $noteArr = [];
            $noteArr['id'] = $note->getId();
            $noteArr['unitID'] = $note->getUnitID();
            $noteArr['note'] = $note->getNote();
            $noteArr['type'] = $note->getType();
            $noteArr['courseId'] = $note->getCourseId();
            $note_created_date = $note->getCreated();
            $noteArr['created'] = $note_created_date->format('d/m/Y');
            $noteArr['acknowledged'] = $note->getAcknowledged();
            $unitNotesArr[trim($note->getId())] = $noteArr;
        }
        return $unitNotesArr;
    }

    /**
     * Function to get facilitatorInfo
     * @param int $unitId
     * return array 
     */
    public function getQualificationUnitFacilitator($unitId) {
        $data = array();
        $unitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
                ->find($unitId);
        if (!empty($unitObj)) {
            $applicantId = $unitObj->getUser();
            $courseCode = $unitObj->getCourseCode();
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->findOneBy(array('courseCode' => $courseCode, 'user' => $applicantId));
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
     * @param int $data
     */
    public function sendNotificationToFacilitator($data) {
        $facilitatorInfo = $this->getQualificationUnitFacilitator($data['note_unit_id']);
        if (!empty($facilitatorInfo)) {

            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#', '#unitCode#');
            $subReplace = array($facilitatorInfo['courseCode'], $facilitatorInfo['courseName'],
                $facilitatorInfo['unitCode']);
            $messageSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('msg_add_notes_sub'));
            $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_add_notes_sub'));

            // finding and replacing the variables from message templates
            $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#unitCode#', '#unitNotes#', '#fromUserName#');
            $msgReplace = array($facilitatorInfo['facilitatorUserName'], $facilitatorInfo['courseCode'],
                $facilitatorInfo['courseName'], $facilitatorInfo['unitCode'], $data['unit_notes'], $data['session_user_name']);
            $messageBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('msg_add_notes_con'));
            $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_notes_con'));
												
            $emailService = $this->emailService;
            $mailBody = $emailService->getNotificationToApplicantEmailMsg($facilitatorInfo['facilitatorId'], $mailBody, $data['session_user_id']);
            
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            $this->userService->sendExternalEmail($facilitatorInfo['facilitatorEmail'], $mailSubject, $mailBody, $data['session_user_email'], $data['session_user_name']);
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
            $this->userService->sendMessagesInbox($facilitatorInfo['facilitatorId'], $data['session_user_id'], $messageSubject, $messageBody, $data['note_unit_id'], 1, $facilitatorInfo['courseCode']);
        }
    }

}
