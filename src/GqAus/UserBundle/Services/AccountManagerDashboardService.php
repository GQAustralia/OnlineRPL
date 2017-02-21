<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Resolvers\ItComputeDaysDifference;
use GqAus\UserBundle\Resolvers\ItReturnsQualificationStatusMessage;

class AccountManagerDashboardService extends CustomRepositoryService
{
    use ItComputeDaysDifference, ItReturnsQualificationStatusMessage;

    CONST QUALIFICATION_COMPLETE_STATUS = 16;

    protected $courseRepository;

    /**
     * SetNewUserPasswordService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);

        $this->courseRepository = $em->getRepository('GqAusUserBundle:UserCourses');
    }

    /**
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
            LEFT JOIN USER u
            ON m.from_user = u.id
            WHERE m.to_user = ' . $recipientUserId . '
            AND m.read_status = 0
            GROUP BY u.role_type
        ');

        return $this->mapRolesToMessagesRoleIdWithTotalMessages($result);
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getApplicantsOverviewCourseStatusCounter($userId)
    {
        $userCourses = $this->courseRepository->findBy(['manager' => $userId]);

        return $this->buildApplicantsOverviewQualificationTotals($userCourses);
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getApplicantsOverviewApplicantList($userId)
    {echo '<pre>';

        $result = [];

        $queryTop5Users = $this->all('
            SELECT DISTINCT (user_id) 
            FROM user_courses 
            WHERE manager=' . $userId . ' 
            ORDER BY created_on 
            DESC LIMIT 5
        ');

        if (!count($queryTop5Users)) {
            return [];
        }

        $top5Users = implode(',', array_column($queryTop5Users, 'user_id'));

        $userCourses =  $this->all('SELECT * FROM user_courses WHERE user_id IN (' . $top5Users . ')');

        foreach($userCourses as $userCourse) {
            $qualificationStatus =
            $result[$userCourse['user_id']][] = [
                'course_code' => $userCourse['course_code'],
                'course_name' => $userCourse['course_name'],
                'days' => $this->computeDaysBetween($userCourse['created_on']),
                'status' => $this->getQualificationStatus($userCourse['course_status'])
            ];
        }

        print_r($result); die;
    }

    /**
     * @param array $userCourses
     *
     * @return array
     */
    private function buildApplicantsOverviewQualificationTotals($userCourses = [])
    {
        $incompleteQualificationCount = 0;
        $completeQualificationCount = 0;
        $qualificationsDaysRangeCount = [
            '_0_30_' => ['total' => 0, 'min' => 0, 'max' => 30],
            '_31_60_' => ['total' => 0, 'min' => 31, 'max' => 60],
            '_61_90_' => ['total' => 0, 'min' => 61, 'max' => 90],
            '_91_120_' => ['total' => 0, 'min' => 90, 'max' => 120],
            '_121_150_' => ['total' => 0, 'min' => 121, 'max' => 150],
            '_151_180_' => ['total' => 0, 'min' => 151, 'max' => 180]
        ];

        foreach ($userCourses as $userCourse) {

            ($userCourse->getCourseStatus() == self::QUALIFICATION_COMPLETE_STATUS)
                ? $completeQualificationCount++
                : $incompleteQualificationCount++;

            foreach ($qualificationsDaysRangeCount as $key => $value) {
                $totalDays = $this->computeDaysBetween($userCourse->getCreatedOn());

                if ($this->getDaysCountRange($totalDays, $value['min'], $value['max'])) {
                    $qualificationsDaysRangeCount[$key]['total']++;
                    break;
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
        return filter_var(
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
}
