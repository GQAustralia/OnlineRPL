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
            if ($data['session_user_role'] == 'ROLE_ASSESSOR') {
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
            $unitCode = $unitObj->getUnitId();
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
                'user' => $applicantId));
            if (!empty($courseObj)) {
                $data['courseCode'] = $courseCode;
                $data['courseName'] = $courseObj->getCourseName();
                $data['unitCode'] = $unitCode;
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
        $mailerInfo = array();
        $facilitatorInfo = $this->getQualificationUnitFacilitator($data['note_unit_id']);
        if (!empty($facilitatorInfo)) {
            $mailerInfo['sent'] = $data['session_user_id'];
            $mailerInfo['subject'] = "Notes added for course :" . $facilitatorInfo['courseCode'] . " : " . $facilitatorInfo['courseName'] . " - Unit : " . $facilitatorInfo['unitCode'];
            $mailerInfo['to'] = $facilitatorInfo['facilitatorEmail'];
            $mailerInfo['inbox'] = $facilitatorInfo['facilitatorId'];
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $facilitatorInfo['facilitatorUserName'] . ", <br/><br/> 
            Notes added for unit " . $facilitatorInfo['unitCode'] . " <br/> Notes: " . $data['unit_notes'] . "     <br/><br/>Regards, <br/> " . $data['session_user_name'];
            $mailerInfo['fromEmail'] = $data['session_user_email'];
            $mailerInfo['fromUserName'] = $data['session_user_name'];
            $mailerInfo['unitId'] = $data['note_unit_id'];
            $this->userService->sendExternalEmail($mailerInfo);
            $this->userService->sendMessagesInbox($mailerInfo);
        }
    }

}
