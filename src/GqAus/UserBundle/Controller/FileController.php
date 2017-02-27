<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\FileForm;

class FileController extends Controller
{
    /**
     * Function to display all the Evidences
     * @param integer $request
     * return string
     */
    public function viewAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $userName = '';
        $courseCode ='';
        $userId ='';
        $evidenceService = $this->get('EvidenceService');
        if (in_array('ROLE_APPLICANT', $userRole)) {
            $userCourses = $user->getCourses();
            $evidences = $evidenceService->currentUser->getEvidences();
        } else {
            $userId = $request->get('userId');
            $toViewUser = $evidenceService->userService->getUserInfo($userId);
            $userCourses = $toViewUser->getCourses();
            $evidences = $toViewUser->getEvidences();
            $userName = $toViewUser->getFirstName()." ".$toViewUser->getLastName();
            $courseCode = $request->get('courseCode');
            $userId = $toViewUser->getId();
            
            $loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
            $checkStatus = $evidenceService->userService->getHaveAccessPage($loggedinUserId, $userId, $courseCode, $userRole);
            if(!$checkStatus)
                return $this->render('GqAusUserBundle:Default:error.html.twig');
            
            //$evidences = array();
        }
        $evidenceCats = $evidenceService->getEvidenceCats();
        $formattedEvd = $evidenceService->formatEvidencesListToDisplay($evidences);
        return $this->render('GqAusUserBundle:File:view.html.twig', array('evidences' => $formattedEvd['formattedEvidences'], 'evdMapping' => $formattedEvd['evdMapping'], 'courses' => $userCourses,'userName' => $userName,'courseCode' => $courseCode,'userId' => $userId, 'evidenceCats' => $evidenceCats));
    }
    /**
     * Function to display all the Evidences
     * @param integer $request
     * return string
     */
    public function mobileRoleWiseViewAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $userName = '';
        $courseCode ='';
        $userId ='';
        $evidenceService = $this->get('EvidenceService');
        if (in_array('ROLE_APPLICANT', $userRole)) {
            $userCourses = $user->getCourses();
            $evidences = $evidenceService->currentUser->getEvidences();
        } else {
            $userId = $request->get('userId');
            $toViewUser = $evidenceService->userService->getUserInfo($userId);
            $userCourses = $toViewUser->getCourses();
            $evidences = $toViewUser->getEvidences();
            $userName = $toViewUser->getFirstName()." ".$toViewUser->getLastName();
            $courseCode = $request->get('courseCode');
            $userId = $toViewUser->getId();
            //$evidences = array();
            $loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
            $checkStatus = $evidenceService->userService->getHaveAccessPage($loggedinUserId, $userId, $courseCode, $userRole);
            if(!$checkStatus)
                return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
        $formattedEvd = $evidenceService->formatEvidencesListToDisplay($evidences);
        return $this->render('GqAusUserBundle:File:mobileRoleWiseView.html.twig', array('evidences' => $formattedEvd['formattedEvidences'], 'evdMapping' => $formattedEvd['evdMapping'], 'courses' => $userCourses,'userName' => $userName,'courseCode' => $courseCode,'userId' => $userId));
    }
}