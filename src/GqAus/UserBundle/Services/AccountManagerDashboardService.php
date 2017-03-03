<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Resolvers\ItComputeDays;
use GqAus\UserBundle\Resolvers\ItReturnsQualificationStatusMessage;
use GqAus\HomeBundle\Services\CoursesService;

class AccountManagerDashboardService extends CustomRepositoryService
{
    use ItComputeDays, ItReturnsQualificationStatusMessage;

    CONST QUALIFICATION_COMPLETE_STATUS = 0;

    protected $courseRepository;
    protected $reminderRepository;

    /**
     * SetNewUserPasswordService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);

        $this->courseRepository = $em->getRepository('GqAusUserBundle:UserCourses');
        $this->reminderRepository = $em->getRepository('GqAusUserBundle:Reminder');
    }

    /**
     * Messages Total
     *
     * Counts total message from each user role
     *
     * 1 = applicant
     * 2 = facilitator
     * 3 = assessor
     * 4 = rto
     * 5 = manager
     * 6 = superadmin
     *
     * @param int $recipientUserId
     *
     * @return array
     */
    public function countUserReceivedMessages($recipientUserId)
    {
        $result = $this->all('
            SELECT u.role_type, COUNT(*) AS total
            FROM message m 
            LEFT JOIN user u
            ON m.from_user = u.id
            WHERE m.to_user = ' . $recipientUserId . '
            AND m.read_status = 0
            GROUP BY u.role_type
        ');

        return $this->mapRolesToMessagesRoleIdWithTotalMessages($result);
    }

    /**
     * Applicants Overview Total
     *
     * @param int $userId
     *
     * @return array
     */
    public function getApplicantsOverviewQualificationStatusTotals($userId)
    {
        $userCourses = $this->courseRepository->findBy(['facilitator' => $userId]);

        return $this->buildApplicantsOverviewQualificationTotals($userCourses);
    }

    /**
     * Applicants Overview List
     *
     * @param $userId
     * @param CoursesService $coursesService
     * @return array
     */
    public function getApplicantsOverviewApplicantList($userId, CoursesService $coursesService)
    {
        $incompleteQualifications = $this->queryApplicantsOverview('incomplete', $userId);
        $completeQualifications = $this->queryApplicantsOverview('complete', $userId);

        return [
            'incomplete' => $this->buildApplicationsOverviewApplicantList($incompleteQualifications, $coursesService),
            'complete' => $this->buildApplicationsOverviewApplicantList($completeQualifications, $coursesService)
        ];
    }

    /**
     * Evidences for Review
     * @return array
     */
    public function getEvidencesForReviewList()
    {
        $evidencesLessThan8Days = $this->queryEvidenceForReview(7, 0);
        $evidencesGreaterThan7Days = $this->queryEvidenceForReview(180, 8);

        return [
            'lessThan8DaysTotal' => count($evidencesLessThan8Days),
            'greaterThan7DaysTotal' => count($evidencesGreaterThan7Days),
            'lessThan8Days' => $this->buildEvidencesForReview($evidencesLessThan8Days),
            'greaterThan7Days' => $this->buildEvidencesForReview($evidencesGreaterThan7Days)
        ];
    }

    /**
     * @param $userId
     *
     * @return array
     */
    public function getRemindersList($userId)
    {
        $overdue = $this->getReminders($userId, 'overdue');
        $dueToday = $this->getReminders($userId, 'dueToday');
        $doneDueToday = $this->getReminders($userId, 'doneDueToday');
        $dueSoon = $this->getReminders($userId, 'dueSoon');
        $completed = $this->getReminders($userId, 'completed');
        $allTasks = $this->getReminders($userId, 'allTasks');

        return [
            'overdue' => $this->buildReminder($overdue),
            'dueToday' => $this->buildReminder($dueToday),
            'doneDueToday' => $this->buildReminder($doneDueToday),
            'dueSoon' => $this->buildReminder($dueSoon),
            'completed' => $this->buildReminder($completed),
            'allTasks' => $this->buildReminder($allTasks)
        ];
    }

    /**
     * @param $taskId
     *
     * @return null|object
     */
    public function completeTask($taskId)
    {
        $dateNow = date('Y-m-d');
        $task = $this->reminderRepository->findOneBy(['id' => $taskId]);

        $task->setCompleted(1);
        $task->setCompletedDate($dateNow);

        $this->update($task);

        return $task;
    }

    /**
     * @param $id
     *
     * @return null|object
     */
    public function findOneById($id)
    {
        return $this->repository->findBy(['id' => $id]);
    }

    /**
     * @param array $userCourses
     *
     * @return array
     */
    private function buildApplicantsOverviewQualificationTotals($userCourses = [])
    {
        $qualificationsDaysRangeCount = [
            '_0_30_' => ['total' => 0, 'min' => 0, 'max' => 30],
            '_31_60_' => ['total' => 0, 'min' => 31, 'max' => 60],
            '_61_90_' => ['total' => 0, 'min' => 61, 'max' => 90],
            '_91_120_' => ['total' => 0, 'min' => 90, 'max' => 120],
            '_121_150_' => ['total' => 0, 'min' => 121, 'max' => 150],
            '_151_180_' => ['total' => 0, 'min' => 151, 'max' => 180]
        ];

        $incompleteQualificationCount = 0;
        $completeQualificationCount = 0;

        foreach ($userCourses as $userCourse) {

            if ($userCourse->getCourseStatus() == self::QUALIFICATION_COMPLETE_STATUS) {
            				$completeQualificationCount++;
            }
            else {
            				$incompleteQualificationCount++;

				            foreach ($qualificationsDaysRangeCount as $key => $value) {
				                $totalDays = $this->computeDaysLeft($userCourse->getTargetDate());
				
				                if ($this->getDaysCountRange($totalDays, $value['min'], $value['max'])) {
				                    $qualificationsDaysRangeCount[$key]['total']++;
				                    break;
				                }
				            }
            }
        }

        return [
            'incomplete' => $incompleteQualificationCount,
            'complete' => $completeQualificationCount,
            'daysRange' => $qualificationsDaysRangeCount
        ];

        return $result;
    }

    /**
     * @param $totalDays
     * @param $min
     * @param $max
     * @return mixed
     */
    private function getDaysCountRange($totalDays, $min, $max)
    {
        return filter_var($totalDays, FILTER_VALIDATE_INT) === 0 || filter_var(
            $totalDays,
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max
                ]
            ]
        );
    }

    /**
     * @param $messages
     * @return array
     */
    private function mapRolesToMessagesRoleIdWithTotalMessages($messages)
    {
        $roles = ['applicants', 'facilitators', 'assessors', 'rtos', 'managers', 'superadmins'];
        $roleIdAndTotalMessages = array_fill(1, 6, 0);

        foreach ($messages as $message) {
            $roleIdAndTotalMessages[$message['role_type']] = $message['total'];
        }

        return array_combine($roles, $roleIdAndTotalMessages);
    }

    /**
     * @param $filterType
     * @param $userId
     *
     * @return array
     */
    private function queryApplicantsOverview($filterType, $userId)
    {
        $filterTypeMap = ['complete' => '= 0', 'incomplete' => '!= 0'];

        return $this->all('
                  SELECT 
                      u.id,
                      u.first_name,
                      u.last_name,
                      u.user_img,
                      uc.user_id,
                      uc.course_code,
                      uc.course_name,
                      uc.created_on,
                      uc.course_status,
        														uc.target_date
                  FROM user_courses uc
                  LEFT JOIN user u ON uc.user_id=u.id
                  WHERE uc.course_status ' . $filterTypeMap[$filterType] . '
                  AND facilitator=' . $userId . '
                  ORDER BY uc.created_on ASC
                  LIMIT 10
        ');
    }

    /**
     * @param $userCourses
     * @param CoursesService $coursesService
     * @return array
     */
    private function buildApplicationsOverviewApplicantList($userCourses, CoursesService $coursesService)
    {
        $result = [];

        foreach ($userCourses as $userCourse) {

            $days = $this->computeDaysLeft($userCourse['target_date']);

            $result[] = [
                'id' => $userCourse['id'],
                'user_id' => $userCourse['user_id'],
                'name' => $userCourse['first_name'] . ' ' . $userCourse['last_name'],
                'avatar' => $userCourse['user_img'],
                'days' => $days,
                'course_name' => $userCourse['course_name'],
                'course_code' => $userCourse['course_code'],
                'status' => $this->getQualificationStatus($userCourse['course_status']),
                'percentage' => 50,
                /*'percentage' => $coursesService->getEvidenceByCourse($userCourse['user_id'], $userCourse['course_code'])*/
                'color_status' => $this->geDaysColorStatus($days),

            ];
        }

        return $result;
    }

    /**
     * @param $days
     *
     * @return string
     */
    private function geDaysColorStatus($days)
    {
        if ($this->getDaysCountRange($days, 0, 30)) {
            return 'danger';
        }

        if ($this->getDaysCountRange($days, 31, 120)) {
            return 'warning';
        }

        if ($this->getDaysCountRange($days, 121, 180)) {
            return 'safe';
        }
    }

    /**
     * @param $from
     * @param $to
     *
     * @return array
     */
    private function queryEvidenceForReview($from, $to)
    {
        return $this->all('
                    SELECT 
                        e.id,
                        e.user_id, 
                        usr.first_name, 
                        usr.last_name,
                        usr.user_img,
                        e.type,
                        e.unit_code,
                        e.created,
                        audio.path AS audiopath,
                        audio.name AS audioname,
                        file.path as filepath,
				        file.name as filename,
                        image.path AS imagepath,
                        image.name AS imagename,
                        video.path AS videopath,
                        video.name AS videoname,
                        text.content AS textcontent
                    FROM evidence e
                    LEFT JOIN evidence_audio audio ON e.id=audio.id
                    LEFT JOIN evidence_file file ON e.id=file.id
                    LEFT JOIN evidence_image image ON e.id=image.id
                    LEFT JOIN evidence_text text ON e.id=text.id
                    LEFT JOIN evidence_video video ON e.id=video.id
                    LEFT JOIN user usr ON usr.id=e.user_id
                    WHERE e.facilitator_view_status="0"
                    AND e.created BETWEEN NOW() - INTERVAL ' . $from . ' DAY AND NOW() - INTERVAL ' . $to . ' DAY
                    ORDER BY e.created ASC
        ');
    }

    /**
     * @param $evidences
     *
     * @return array
     */
    public function buildEvidencesForReview($evidences)
    {
        $result = [];
        $limiter = 0;

        foreach ($evidences as $evidence) {

            if ($limiter == 10) {
                break;
            }

            $fileName = $this->getFileNameFromEvidence($evidence);

            $result[] = [
                'avatar' => $evidence['user_img'],
                'file_name' => $fileName,
                'unit_code' => $evidence['unit_code'],
                'created' => $evidence['created'],
                'name' => $evidence['first_name'] . ' ' . $evidence['last_name']
            ];

            $limiter++;
        }

        return $result;
    }

    /**
     * @param $evidence
     *
     * @return mixed
     */
    private function getFileNameFromEvidence($evidence)
    {
        if ($evidence['audioname']) {
            return $evidence['audioname'];
        }

        if ($evidence['imagename']) {
            return $evidence['imagename'];
        }

        if ($evidence['videoname']) {
            return $evidence['videoname'];
        }

        if ($evidence['filename']) {
            return $evidence['filename'];
        }

        return '';
    }

    /**
     * @param $userId
     * @param $listType
     *
     * @todo needs to reconstruct logic
     * @return array
     */
    private function getReminders($userId, $listType)
    {
        $isCompleteQuery = ' AND completed = 0';

        if ($listType == 'dueToday') {
            $condition = ' AND date BETWEEN "' . date('Y-m-d' . ' 00:00:00') . '" AND "' . date('Y-m-d' . ' 23:59:59') . '"';
            return $this->getRemindersQuery($userId, $isCompleteQuery, $condition);
        }

        if ($listType == 'doneDueToday') {
            $isCompleteQuery = ' AND completed = 1';
            $condition = ' AND date BETWEEN "' . date('Y-m-d' . ' 00:00:00') . '" AND "' . date('Y-m-d' . ' 23:59:59') . '"';
            return $this->getRemindersQuery($userId, $isCompleteQuery, $condition);
        }

        if ($listType == 'overdue') {
            $condition = ' AND date < CURDATE()';
            return $this->getRemindersQuery($userId, $isCompleteQuery, $condition);
        }

        if ($listType == 'dueSoon') {
            $condition = ' AND date > "' . date('Y-m-d' . ' 23:59:59') . '"';
            return $this->getRemindersQuery($userId, $isCompleteQuery, $condition);
        }
        
        if ($listType == 'completed') {
            $isCompleteQuery = ' AND completed = 1';
            $condition = '';
            return $this->getRemindersQuery($userId, $isCompleteQuery, $condition);
        }
        
        if ($listType == 'allTasks') {
            $isCompleteQuery = '';
            $condition = '';
            return $this->getRemindersQuery($userId, $isCompleteQuery, $condition);
        }
    }

    private function getRemindersQuery($userId, $isCompleteQuery, $condition)
    {
        return $this->all('
            SELECT id, date AS due_date, message, completed FROM reminder
            WHERE user_id = ' . $userId . $isCompleteQuery . $condition . '
        ');
    }

    private function buildReminder($reminders = [])
    {
        $result = array_map(function ($reminder) {
            return [
                'id' => $reminder['id'],
                'due_date' => $reminder['due_date'],
                'message' => $reminder['message'],
                'days_due' => $this->computeDaysDifference($reminder['due_date']),
                'status' => $this->buildReminderStatus($reminder['due_date'], $reminder['completed'])
            ];
        }, $reminders);

        return $result;
    }
    
    private function buildReminderStatus($dueDate, $completed)
    {
        $startDate = new \DateTime($dueDate);
        $endDate = new \DateTime();
        if ($completed == 1) {
            return 'done';
        }
        if($startDate->format('U') < $endDate->format('U')){
            return 'overdue';
        }
        if($startDate->format('U') > $endDate->format('U')){
            return 'pending';
        }
        return 'pending';
    }
}
