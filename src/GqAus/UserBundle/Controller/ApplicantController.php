<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApplicantController extends Controller
{
   /**
    * Function to get applicant details page
    * return $result array
    */
    public function detailsAction($qcode, $uid, Request $request)
    {
        $user = $this->get('UserService')->getUserInfo($uid);
        $results = $this->get('CoursesService')->getCoursesInfo($qcode);
        if (!empty($user) && isset($results['courseInfo']['id'])) {
            $applicantInfo = $this->get('UserService')->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
            return $this->render('GqAusUserBundle:Applicant:details.html.twig', array_merge($results, $applicantInfo));
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
    }
    
    /**
    * Function to update user unit evidence status
    * return $result array
    */
    public function setUserUnitEvidencesStatusAction()
    {
        $userId = $this->getRequest()->get('userId');
        $unit = $this->getRequest()->get('unit');
        $status = $this->getRequest()->get('status');
        $userRole = $this->getRequest()->get('userRole');
        $currentUserName = $this->get('security.context')->getToken()->getUser()->getUserName();
        echo $status = $this->get('UserService')->updateApplicantEvidences($userId, $unit, $userRole, $status, $currentUserName);
        exit;
    }
    
    /**
    * Function to add reminder/notes
    */
    public function addReminderAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userCourseId = $this->getRequest()->get('userCourseId');
        $remindDate = $this->getRequest()->get('remindDate');
        $message = $this->getRequest()->get('message');
        echo $status = $this->get('UserService')->addQualificationReminder($userId, $userCourseId, $message, $remindDate);
        exit;
    }
    
    /**
    * Function list applicants list
    * return $result array
    */
    public function applicantsListAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $this->get('UserService')->updateUserApplicantsList($userId, $userRole);
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '0');
        $results['pageRequest'] = 'submit'; 
        return $this->render('GqAusUserBundle:Applicant:list.html.twig', $results);
    }
    
    /**
    * Function search applicants list
    * return $result array
    */
    public function searchApplicantsListAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $searchName = $this->getRequest()->get('searchName');
        $searchTime = $this->getRequest()->get('searchTime');
        $status = $this->getRequest()->get('status');
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, $status, $searchName, $searchTime);
        $results['pageRequest'] = 'ajax'; 
        echo $this->renderView('GqAusUserBundle:Applicant:applicants.html.twig', $results); exit;
    }
}
