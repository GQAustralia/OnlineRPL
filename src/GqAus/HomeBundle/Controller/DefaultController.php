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
        } else if (in_array('ROLE_MANAGER', $userRole) || in_array('ROLE_SUPERADMIN', $userRole)) {
            $results = $this->get('UserService')->getManagersApplicantsCount($userId, $userRole);
            return $this->render('GqAusHomeBundle:Default:user-dashboard.html.twig', $results);
        } else { /* 2-Facilitator, 3-Assessor, 4-Rto */
           $appResults = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '1');
           $results = $userService->getUsersDashboardInfo($user);
           $todoReminders = $userService->getTodoReminders($userId);
           $todoCompletedReminders = $userService->getCompletedReminders($userId);

           $todoRemindersCount = count($todoReminders);
           $todoCompletedRemindersCount = count($todoCompletedReminders);
           $totalRemindersCount = $todoRemindersCount + $todoCompletedRemindersCount;
           /* dump($appResults['applicantList']);
           exit; */
           if($todoRemindersCount > 0) {
                $percentageForItem = $totalRemindersCount/$todoRemindersCount;
                $percentage = ($todoCompletedRemindersCount/$totalRemindersCount)*100;
            } else {
                    $percentageForItem = 0;
                    $percentage = 100;
            }

           $results['todoRemindersCount'] = $todoRemindersCount;
           $results['completedRemindersCount'] = $todoCompletedRemindersCount;
           $results['totalRemindersCount'] = $totalRemindersCount;
           $results['todoReminders'] = $todoReminders;
           $results['completedReminders'] = $todoCompletedReminders;
           $results['percentage'] = $percentage;	   
           $results['applicantList'] = $appResults['applicantList'];
           $results['paginator'] = $appResults['paginator'];
           $results['page'] = $appResults['page'];
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

}
