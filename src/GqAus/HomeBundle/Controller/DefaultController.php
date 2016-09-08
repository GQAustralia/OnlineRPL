<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * Function for dashboard landing page
     * return array
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $session->set('user_id', $sessionUser->getId());
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if (in_array('ROLE_APPLICANT', $userRole)) {
            $results = $userService->getDashboardInfo($user);
            $results['statusList'] = $userService->getQualificationStatus();
            return $this->render('GqAusHomeBundle:Default:index.html.twig', $results);
        } else if ( in_array('ROLE_SUPERADMIN', $userRole)) {
            $results = $this->get('UserService')->getSuperAdminDashboardInfo($user);
            return $this->render('GqAusHomeBundle:Default:user-dashboard.html.twig', $results);
        } else { /* 2-Facilitator, 3-Assessor, 4-Rto */           
           $results = $userService->getUsersDashboardInfo($user);
           $results['paginator'] = '';
           $results['page'] = '';
           $results['pageRequest'] = '';
           $results['status'] = 0; 

           return $this->render('GqAusHomeBundle:Default:dashboard.html.twig', $results);   
        }
    }

    /**
     * function to download related file
     * @param string $file
     */
    public function downloadAction($file)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $this->get('UserService')->downloadCourseCondition($user, $file);
        exit;
    }

    /**
     * function to update Condition status
     */
    public function updateConditionAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $this->get('UserService')->updateCourseConditionStatus($user);
        exit;
    }

    /**
     * function for unauthorized page
     */
    public function unauthorizedAction()
    {
        return $this->render('GqAusHomeBundle:Default:unauthorized.html.twig');
    }

    /**
     * function to get un read evidences count
     */
    public function unreadEvidenceCountAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $evidenceCount = $this->get('UserService')->getUnreadEviencesCount($user);
        echo $evidenceCount;
        exit;
    }

}
