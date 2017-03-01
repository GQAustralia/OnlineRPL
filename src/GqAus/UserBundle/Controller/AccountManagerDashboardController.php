<?php

namespace GqAus\UserBundle\Controller;

use GqAus\UserBundle\Resolvers\ItComputeDays;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountManagerDashboardController extends Controller
{
    use ItComputeDays;

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $dashboard = $this->get('AccountManagerDashboardService');
        $coursesService = $this->get('CoursesService');
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $userId = $sessionUser->getId();

        $totalUserMessages = $dashboard->countUserReceivedMessages($userId);
        $qualificationRangeCounter = $dashboard->getApplicantsOverviewQualificationStatusTotals($userId);
        $applicantsOverviewApplicantList = $dashboard->getApplicantsOverviewApplicantList($userId, $coursesService);
        $evidencesForReview = $dashboard->getEvidencesForReviewList();
        $remindersList = $dashboard->getRemindersList($userId);

        //print_r($remindersList); die;
        return $this->render('GqAusUserBundle:AccountManagerDashboard:index.html.twig', [
            'messagesTotal' => $totalUserMessages,
            'user' => $this->getUserInfo(),
            'appOverviewCount' => $qualificationRangeCounter,
            'applicantsOverviewApplicantList' => $applicantsOverviewApplicantList,
            'evidences' => $evidencesForReview,
            'reminders' => $remindersList
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addNewTaskAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');
        $reminderService = $this->get('ReminderService');
        $userService = $this->get('UserService');
        $userCourseService = $this->get('UserCourseService');

        $userCourse = $userCourseService->findOneById($request->request->get('user_course_id'));
        $user = $userService->findUserById($request->request->get('user_id'));
        $createdBy = $userService->findUserById($request->request->get('created_by'));

        $reminder = $reminderService->factory(
            $userCourse,
            $user,
            $request->request->get('date'),
            $request->request->get('type'),
            $createdBy,
            $request->request->get('message')
        );

        $reminder = $reminderService->create($reminder);

        $dueDays = $this->computeDaysDifference($request->request->get('date'));
        $dueType = ($dueDays > 0) ? 'dueSoon' : 'dueToday';

        return $response->fractal()->respondSuccess([
            'dueType' => $dueType,
            'dueDays' => $dueDays,
            'reminderId' => $reminder->getId()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function completeTaskAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');
        $accountDashboard = $this->get('AccountManagerDashboardService');

        $task = $accountDashboard->completeTask($request->request->get('task_id'));

        return $response->fractal()->respondSuccess(['task' => $task]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadModalTaskAction(Request $request)
    {
        $dashboard = $this->get('AccountManagerDashboardService');
        $remindersList = $dashboard->getRemindersList($request->request->get('user_id'));

        return $this->render(
            'GqAusUserBundle:AccountManagerDashboard:_modal_all_task.html.twig',
            ['reminders' => $remindersList]
        );
    }

    /**
     * @return array
     */
    private function getUserInfo()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getUserImage()
        ];
    }

    public function indexOldAction(Request $request)
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
        } else if (in_array('ROLE_SUPERADMIN', $userRole)) {
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
