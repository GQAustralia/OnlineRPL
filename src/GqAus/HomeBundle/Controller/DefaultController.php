<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
    * Function for dashboard landing page
    * params -
    * return $result array
    */
    public function indexAction(Request $request)
    {    
        $session = $request->getSession();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $session_user = $this->get('security.context')->getToken()->getUser();
        $session->set('user_id', $session_user->getId());
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        /*$this->get('UserService')->updateUserApplicantsList($userId, $userRole);*/
        if (in_array('ROLE_APPLICANT',$userRole)) {
            $results = $userService->getDashboardInfo($user);
            $results['statusList'] = $userService->getqualificationStatus();
            return $this->render('GqAusHomeBundle:Default:index.html.twig', $results);
        } else if (in_array('ROLE_MANAGER',$userRole) || in_array('ROLE_SUPERADMIN',$userRole)) {
            $results = $this->get('UserService')->getManagersApplicantsCount($userId, $userRole);
            return $this->render('GqAusHomeBundle:Default:user-dashboard.html.twig', $results);
        } else {
            $appResults = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '0');
            $results = $userService->getUsersDashboardInfo($user);
            $results['applicantList'] = $appResults['applicantList'];
            $results['paginator'] = $appResults['paginator'];
            $results['page'] = $appResults['page'];
            $results['pageRequest'] = "";    
            $results['status'] = 0;           
            return $this->render('GqAusHomeBundle:Default:dashboard.html.twig', $results);
        }
    }
    
    /**
    * function to download related file
    * params $file string
    */
    public function downloadAction($file)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $userService->downloadCourseCondition($user, $file);
        exit;
    }
    
    /**
    * function to update Condition status
    */
    public function updateConditionAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $userService->updateCourseConditionStatus($user);
        exit;
    }
    
    public function unauthorizedAction()
    {
        return $this->render('GqAusHomeBundle:Default:unauthorized.html.twig');
    }
}
