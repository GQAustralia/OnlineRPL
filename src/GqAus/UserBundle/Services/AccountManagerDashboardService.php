<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Resolvers\ItComputeDaysDifference;
use GqAus\UserBundle\Resolvers\ItReturnsQualificationStatusMessage;
use GqAus\HomeBundle\Services\CoursesService;

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
            LEFT JOIN USER u
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
        $userCourses = $this->courseRepository->findBy(['manager' => $userId]);

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
        $evidenceIds = $this->all('
            SELECT DISTINCT user_id 
            FROM evidence 
            ORDER BY created DESC limit 5
        ');

        if (!count($evidenceIds)) {
            return [];
        }

        $evidenceIds = implode(',', array_column($evidenceIds, 'user_id'));

        $evidencesLessThan8Days = $this->queryEvidenceForReview($evidenceIds, 7, 0);
        $evidencesGreaterThan7Days = $this->queryEvidenceForReview($evidenceIds, 30, 8);

        return [
            'lessThan8Days' => $this->buildEvidencesForReview($evidencesLessThan8Days),
            'greaterThan7Days' => $this->buildEvidencesForReview($evidencesGreaterThan7Days)
        ];
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

    /**
     * @param $filterType
     * @param $userId
     *
     * @return array
     */
    private function queryApplicantsOverview($filterType, $userId)
    {
        $filterTypeMap = ['complete' => '>=16', 'incomplete' => '<=15'];

        $qualification = $this->all('
            SELECT DISTINCT (user_id)
            FROM user_courses
            WHERE manager=' . $userId . '
            AND course_status ' . $filterTypeMap[$filterType] . '
            ORDER BY created_on
            DESC LIMIT 5
        ');

        if (!count($qualification)) {
            return [];
        }

        $qualificationUserIds = implode(',', array_column($qualification, 'user_id'));

        return $this->all('
                  SELECT u.first_name, u.last_name, uc.user_id, uc.course_code, uc.course_name, uc.created_on, uc.course_status 
                  FROM user_courses uc 
                  LEFT JOIN user u 
                  ON uc.user_id=u.id 
                  WHERE uc.user_id IN (' . $qualificationUserIds . ')
                  AND uc.course_status ' . $filterTypeMap[$filterType] . '
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

            $days = $this->computeDaysBetween($userCourse['created_on']);

            $result[$userCourse['user_id']]['courses'][] = [
                'course_name' => $userCourse['course_name'],
                'days' => $days,
                'status' => $this->getQualificationStatus($userCourse['course_status']),
                'color_status' => $this->geDaysColorStatus($days),
                /*'percentage' => $coursesService->getEvidenceByCourse($userCourse['user_id'], $userCourse['course_code'])*/
                'percentage' => 50
            ];

            $result[$userCourse['user_id']]['name'] = $userCourse['first_name'] . ' ' . $userCourse['last_name'];
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
     * @param $evidenceIds
     * @param $from
     * @param $to
     *
     * @return array
     */
    private function queryEvidenceForReview($evidenceIds, $from, $to)
    {
        return $this->all('
                    SELECT e.user_id, 
                        usr.first_name, 
                        usr.last_name, 
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
                    WHERE user_id IN(' . $evidenceIds . ')
                    AND e.facilitator_view_status="0"
                    AND e.created BETWEEN NOW() - INTERVAL ' . $from . ' DAY AND NOW() - INTERVAL ' . $to . ' DAY
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

        foreach ($evidences as $evidence) {
            $fileName = $this->getFileNameFromEvidence($evidence);

            if ($fileName) {
                $result[$evidence['user_id']]['evidences'][] = [
                    'file_name' => $fileName,
                    'unit_code' => $evidence['unit_code'],
                    'created' => $evidence['created'],
                ];

                $result[$evidence['user_id']]['name'] = $evidence['first_name'] . ' ' . $evidence['last_name'];
            }
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
}
