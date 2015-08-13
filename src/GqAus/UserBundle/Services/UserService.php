<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\User;
use GqAus\UserBundle\Entity\Applicant;
use GqAus\UserBundle\Entity\UserAddress;
use GqAus\UserBundle\Entity\UserCourses;

class UserService
{

    /**
     * @var Object
     */
    private $userId;

    /**
     * @var Object
     */
    private $repository;

    /**
     * @var Object
     */
    private $currentUser;

    /**
     * @var Object
     */
    private $container;

    /**
     * @var Object
     */
    private $mailer;

    /**
     * @var Object
     */
    private $guzzleService;

    /**
     * Constructor
     */
    public function __construct($em, $container, $mailer, $guzzleService)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->mailer = $mailer;
        $this->container = $container;
        $this->guzzleService = $guzzleService;
    }

    /**
     * function to get current user
     * return array
     */
    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }

    /**
     * function to save current user profile
     * return -
     */
    public function saveProfile()
    {
        $this->em->persist($this->currentUser);
        $this->em->flush();
    }

    /**
     * function to save personal profile
     * return -
     */
    public function savePersonalProfile($user, $image)
    {
        if (!empty($image)) {
            $user->setUserImage($image);
        }
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * function to request for forgot password .
     *  @return string
     */
    public function forgotPasswordRequest($email)
    {
        $message = '';
        $user = $this->repository->findOneBy(array('email' => $email));
        if (!empty($user)) {
            $token = uniqid();
            $nowtime = date('Y-m-d h:i:s');
            $tokenExpiryDate = date('Y-m-d H:i:s', strtotime($nowtime . ' + 4 hours'));
            $user->setPasswordToken($token);
            $user->setTokenStatus('1');
            $user->setTokenExpiry($tokenExpiryDate);
            $this->em->persist($user);
            $this->em->flush();

            $userName = $user->getUsername();
            $mailerInfo['to'] = $user->getEmail();
            $mailerInfo['subject'] = 'Request for Password Reset';
            $applicationUrl = $this->container->getParameter('applicationUrl');
            $mailerInfo['body'] = "Dear " . $userName . ",<br/><br/> We heard that you lost your password. Sorry about that! <br/>
            But don't worry! You can use the following link within the next 4 hours to reset your password
             <a href='" . $applicationUrl . "resetpassword/" . $token . "'>Click Here </a> <br/>
             If you don't use this link within 4 hours, it will expire. <br/>To get a new password reset link, visit " . $applicationUrl . "forgotpassword
             <br/><br/> Regards, <br/> OnlineRPL";

            $this->sendExternalEmail($mailerInfo);

            $message = '1';
        } else {
            $message = '0';
        }
        return $message;
    }

    /**
     * function to reset password.
     *  @return array
     */
    public function resetPasswordRequest($token, $method, $password)
    {
        $validRequest = 0;
        $message = '';
        $user = $this->repository->findOneBy(array('passwordToken' => $token, 'tokenStatus' => 1));
        if (!empty($user)) {
            $tokenExpiry = $user->getTokenExpiry();
            if ($tokenExpiry > date('Y-m-d h:i:s')) {
                if ($method == 'POST') {
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $user->setPassword($password);
                    $user->setTokenStatus('0');
                    $this->em->persist($user);
                    $this->em->flush();
                    $message = '1';
                }
                $validRequest = 1;
            }
        } else {
            $message = '0';
        }
        return array('message' => $message, 'validRequest' => $validRequest);
    }

    /**
     * function to download course conditions and terms.
     *  @return array
     */
    public function downloadCourseCondition($user = null, $file)
    {
        if ($user) {
            $this->updateCourseConditionStatus($user);
        }

        ignore_user_abort(true);
        $path = "../template/"; // change the path to fit your websites document structure
        $dlFile = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file); // simple file name validation
        $dlFile = filter_var($dlFile, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $path . $dlFile;

        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $pathParts = pathinfo($fullPath);
            $ext = strtolower($pathParts["extension"]);
            switch ($ext) {
                case "pdf":
                    header("Content-type: application/pdf");
                    header("Content-Disposition: attachment; filename=\"" . $pathParts["basename"] . "\""); // use 'attachment' to force a file download
                    break;
                // add more headers for other content types here
                default;
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: filename=\"" . $pathParts["basename"] . "\"");
                    break;
            }
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while (!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose($fd);
    }

    /**
     * function to update course condition status.
     *  @return array
     */
    public function updateCourseConditionStatus($user)
    {
        $user->setCourseConditionStatus('1');
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * function to get dashboard information.
     *  @return array
     */
    public function getDashboardInfo($user)
    {
        if (is_object($user) && count($user) > 0) {
            $percentage = $this->getUserProfilePercentage($user);
            $userCourses = $user->getCourses();
            $courseConditionStatus = $user->getCourseConditionStatus();
            return array('profileCompleteness' => $percentage,
                'userImage' => $this->userImage($user->getUserImage()),
                'currentIdPoints' => $this->getIdPoints($user),
                'userCourses' => $userCourses,
                'courseConditionStatus' => $courseConditionStatus);
        }
    }

    /**
     * function to get all document types.
     *  @return array
     */
    public function getDocumentTypes()
    {
        $documentType = $this->em->getRepository('GqAusUserBundle:DocumentType');
        return $documentType->findAll();
    }

    /**
     * function to get points for ID files uploaded.
     *  @return integer
     */
    public function getIdPoints($user)
    {
        $idFiles = $user->getIdfiles();
        $points = array();
        foreach ($idFiles as $file) {
            $points[] = $file->getType()->getPoints();
        }
        return array_sum($points);
        exit;
    }

    /**
     * function to delete Id files.
     *  @return string
     */
    public function deleteIdFiles($IdFileId, $IdFileType)
    {
        $userIdObj = $this->em->getRepository('GqAusUserBundle:UserIds');
        $userIds = $userIdObj->find($IdFileId);
        if (!empty($userIds)) {
            $fileName = $userIds->getPath();
            $this->em->remove($userIds);
            $this->em->flush();
            return $fileName;
        }
    }

    /**
     * Function to get user details
     * return $result array
     */
    public function getUserInfo($userId)
    {
        return $this->repository->findOneById($userId);
    }

    /**
     * Function to get user profile percentage
     * return $result array
     */
    public function getUserProfilePercentage($user)
    {
        $maximumPoints = 100;
        $profileCompleteness = 0;
        if (is_object($user) && count($user) > 0) {
            $userId = $user->getId();
            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();
            $email = $user->getEmail();
            $phone = $user->getPhone();
            $gender = $user->getGender();
            $usi = $user->getUniversalStudentIdentifier();
            $dob = $user->getDateOfBirth();
            $address = $user->getAddress();
            if (!empty($firstName)) {
                $profileCompleteness += 10;
            }
            if (!empty($lastName)) {
                $profileCompleteness += 10;
            }
            if (!empty($email)) {
                $profileCompleteness += 10;
            }
            if (!empty($phone)) {
                $profileCompleteness += 10;
            }
            if (!empty($gender)) {
                $profileCompleteness += 10;
            }
            if (!empty($usi)) {
                $profileCompleteness += 10;
            }
            if (!empty($dob)) {
                $profileCompleteness += 10;
            }

            if (!empty($address) && $address != '0') {
                $profileCompleteness += 30;
            }
        }
        $percentage = ($profileCompleteness * $maximumPoints) / 100;
        return $percentage = $percentage . '%';
    }

    /**
     * Function to get applicant information
     * return $result array
     */
    public function getApplicantInfo($user, $qcode)
    {
        $results = array();
        $results['profileCompleteness'] = $this->getUserProfilePercentage($user);
        $results['currentIdPoints'] = $this->getIdPoints($user);
        $results['userId'] = $user->getId();
        $results['userImage'] = $this->userImage($user->getUserImage());
        $results['userName'] = $user->getUsername();
        $otheruser = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $qcode,
            'user' => $user->getId()));
        if (!empty($otheruser)) {
            $assessor = $this->getUserInfo($otheruser->getAssessor());
            $results['assessorName'] = !empty($assessor) ? $assessor->getUsername() : '';
            $rto = $this->getUserInfo($otheruser->getRto());
            $results['rtoName'] = !empty($rto) ? $rto->getUsername() : '';
            $results['rtoCeoName'] = !empty($rto) ? $rto->getCeoname() : '';
            $results['rtoCeoEmail'] = !empty($rto) ? $rto->getCeoemail() : '';
            $results['rtoCeoPhone'] = !empty($rto) ? $rto->getCeophone() : '';

            $facilitator = $this->getUserInfo($otheruser->getFacilitator());
            $results['facilitatorName'] = !empty($facilitator) ? $facilitator->getUsername() : '';

            $results['facilitatorId'] = !empty($facilitator) ? $facilitator->getId() : '';
            $results['assessorId'] = !empty($assessor) ? $assessor->getId() : '';
            $results['rtoId'] = !empty($rto) ? $rto->getId() : '';

            $results['courseStatus'] = $otheruser->getCourseStatus();
            $results['rtostatus'] = $otheruser->getRtostatus();
            $results['assessorstatus'] = $otheruser->getAssessorstatus();
            $results['facilitatorstatus'] = $otheruser->getFacilitatorstatus();
            $results['coursePrimaryId'] = $otheruser->getId();
        }
        return $results;
    }

    /**
     * Function to update applicant evidences information
     * return $result array
     */
    public function updateApplicantEvidences($result)
    {
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findOneBy(array('user' => $result['userId'],
            'unitId' => $result['unit'], 'courseCode' => $result['courseCode']));
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->findOneBy(array('courseCode' => $result['courseCode'], 'user' => $result['userId']));
        if ($result['userRole'] == 'ROLE_FACILITATOR') {
            $courseUnitObj->setFacilitatorstatus($result['status']);
        } elseif ($result['userRole'] == 'ROLE_ASSESSOR') {
            $courseUnitObj->setAssessorstatus($result['status']);
        } elseif ($result['userRole'] == 'ROLE_RTO') {
            $courseUnitObj->setRtostatus($result['status']);
        }
        $this->em->persist($courseUnitObj);
        $this->em->flush();

        if ($result['status'] == '1') {
            $evidenceStatus = 'Approved';
        } else if ($result['status'] == '2') {
            $mailerInfo = array();
            $mailerInfo['unitId'] = $courseUnitObj->getId();
            $mailerInfo['subject'] = $result['courseCode'] . ' ' . $result['courseName'] . ' : ' . $result['unitName'] . ' Evidences are disapproved';
            $userName = $courseObj->getUser()->getUsername();
            $facilitatorName = $courseObj->getFacilitator()->getUsername();
            if ($result['userRole'] == 'ROLE_ASSESSOR') {
                $mailerInfo['to'] = $courseObj->getFacilitator()->getEmail();
                $mailerInfo['inbox'] = $courseObj->getFacilitator()->getId();
                $mailerInfo['sent'] = $result['currentUserId'];
                $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $facilitatorName . ", <br/><br/> Qualification : " . $result['courseCode'] . ' ' . $result['courseName'] . " <br/> Unit : " . $result['unit'] . ' ' . $result['unitName'] . " <br/>"
                    . " Evidences had not yet competetent for user " . $userName . "<br/><br/>"
                    . "Regards, <br/> " . $result['currentUserName'];
                $mailerInfo['fromEmail'] = $courseObj->getAssessor()->getEmail();
                $mailerInfo['fromUserName'] = $courseObj->getAssessor()->getUsername();
                $this->sendExternalEmail($mailerInfo);
                $this->sendMessagesInbox($mailerInfo);
            }

            $mailerInfo['sent'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['to'] = $courseObj->getUser()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getUser()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $userName . ", <br/><br/> Qualification : " . $result['courseCode'] . ' ' . $result['courseName'] . " <br/> Unit : " . $result['unit'] . ' ' . $result['unitName'] . " <br/>"
                . " Provided evidences for above unit are not yet competetent please add more evidences and get back to us <br/><br/>"
                . "Regards, <br/> " . $facilitatorName;
            $mailerInfo['fromEmail'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['fromUserName'] = $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);
        }
        return $result['status'];
    }

    /**
     * Function to get applicants list information
     * return $result array
     */
    public function getUserApplicantsList($userId, $userRole, $status, $page = null, $searchName = null, $searchTime = null, $filterByUser = null, $filterByStatus = null)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $nameCondition = null;
        if (in_array('ROLE_ASSESSOR', $userRole)) {
            $userType = 'assessor';
            $userStatus = 'assessorstatus';
        } elseif (in_array('ROLE_FACILITATOR', $userRole)) {
            $userType = 'facilitator';
            $userStatus = 'facilitatorstatus';
        } elseif (in_array('ROLE_RTO', $userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        } elseif (in_array('ROLE_MANAGER', $userRole)) {
            $userType = 'manager';
            $userStatus = '';
        } elseif (in_array('ROLE_SUPERADMIN', $userRole)) {
            $userType = 'superadmin';
            $userStatus = '';
        }

        $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('c')
            ->select("c, u")
            ->join('c.user', 'u');

        if ($userType != 'superadmin' && $userType != 'manager') {
            $res->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId);
        }
        if ($status != 2 && $userType == "assessor") {
            $res->andWhere(sprintf('c.%s = :%s', $userStatus, $userStatus))->setParameter($userStatus, $status);
            if ($status == 0) {
                $avals = array('2', '10', '11', '12', '13', '14');
                $res->andWhere('c.courseStatus IN (:ids)')->setParameter('ids', $avals);
            }
        }

        if ($userType == 'rto') {
            $res->andWhere(sprintf('c.%s = :%s', $userStatus, $userStatus))->setParameter($userStatus, $status);
            if ($status == 0) {
                $res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '15');
            }
        }

        if ($userType == 'facilitator') {
            if ($status == 1) {
                $res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0');
            } else {
                $res->andWhere(sprintf('c.%s != :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0');
            }
        }

        if ($userType == 'manager' || $userType == 'superadmin') {
            if ($status == 1) {
                $res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0'); //approved
            } else {
                $res->andWhere(sprintf('c.%s != :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0');
            }
        }

        if (!empty($searchName)) {
            $searchNamearr = explode(" ", $searchName);
            for ($i = 0; $i < count($searchNamearr); $i++) {
                if ($i == 0)
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                else
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
            }
            $res->andWhere($nameCondition);
        }

        if (!empty($searchTime)) {
            $searchTime = $searchTime * 7;
            $searchTime1 = $searchTime - 6;
            $res->andWhere("DATE_DIFF(c.targetDate, c.createdOn) >= " . $searchTime1);
            $res->andWhere("DATE_DIFF(c.targetDate, c.createdOn) <= " . $searchTime);
        }

        if (!empty($filterByUser)) {
            $res->andWhere('c.facilitator = :filterByUser OR c.assessor = :filterByUser')->setParameter('filterByUser', $filterByUser);
        }

        if (!empty($filterByStatus)) {
            $res->andWhere('c.courseStatus = :filterByStatus')->setParameter('filterByStatus', $filterByStatus);
        }
        $res->orderBy('c.id', 'DESC');
        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        /* Pagination */
        $applicantList = $res->getQuery()->getResult();
        return array('applicantList' => $applicantList, 'paginator' => $paginator, 'page' => $page);
    }

    /**
     * Function to get applicants list information
     * return $result array
     */
    public function getUserApplicantsListReports($userId, $userRole, $status, $page, $searchName = null, $searchQualification = null, $startDate = null, $endDate = null, $searchTime = null)
    {
        $nameCondition = null;
        $qualCondition = null;
        if (in_array('ROLE_ASSESSOR', $userRole)) {
            $userType = 'assessor';
            $userStatus = 'assessorstatus';
        } elseif (in_array('ROLE_FACILITATOR', $userRole)) {
            $userType = 'facilitator';
            $userStatus = 'facilitatorstatus';
        } elseif (in_array('ROLE_RTO', $userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        }
        if ($status == 3) {
            $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->createQueryBuilder('c')
                    ->select("c, u")
                    ->join('c.user', 'u')
                    ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId);
            if ($userType == 'rto') {
                $res->andWhere("c.courseStatus = '0' OR c.courseStatus = '15' OR c.courseStatus = '16'");
            }
        } else {
            if ($status == 11) {
                $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->createQueryBuilder('c')
                    ->select("c, u")
                    ->join('c.user', 'u')
                    ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
                    ->andWhere("c.assessorstatus = '1'");
            } else {
                $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                        ->createQueryBuilder('c')
                        ->select("c, u")
                        ->join('c.user', 'u')
                        ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId);
                if ($status == 2) {
                    $res->andWhere("c.courseStatus = '15'");
                } else if ($status == 1) {
                    $res->andWhere("c.courseStatus != '0'");
                } else {
                    $res->andWhere("c.courseStatus = '" . $status . "'");
                }
            }
        }

        if (!empty($searchName)) {
            $searchNamearr = explode(" ", $searchName);
            for ($i = 0; $i < count($searchNamearr); $i++) {
                if ($i == 0)
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                else
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
            }
            $res->andWhere($nameCondition);
        }

        if (!empty($searchTime)) {
            $searchTime = $searchTime * 7;
            $searchTime1 = $searchTime - 6;
            $res->andWhere("DATE_DIFF(c.targetDate, c.createdOn) >= " . $searchTime1);
            $res->andWhere("DATE_DIFF(c.targetDate, c.createdOn) <= " . $searchTime);
        }

        if (!empty($searchQualification)) {

            $searchQualificationarr = explode(" ", $searchQualification);
            for ($i = 0; $i < count($searchQualificationarr); $i++) {
                if ($i == 0)
                    $qualCondition .= "c.courseCode LIKE '%" . $searchQualificationarr[$i] . "%' OR c.courseName LIKE '%" . $searchQualificationarr[$i] . "%'";
                else
                    $qualCondition .= " OR c.courseCode LIKE '%" . $searchQualificationarr[$i] . "%' OR c.courseName LIKE '%" . $searchQualificationarr[$i] . "%'";
            }
            $res->andWhere($qualCondition);
        }
        if (!empty($startDate)) {
            $res->andWhere("c.createdOn BETWEEN '" . $startDate . " 00:00:00' and '" . $endDate . " 00:00:00'");
        }
        $res->orderBy('c.id', 'DESC');
        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        /* Pagination */

        $applicantList = $res->getQuery()->getResult();
        return array('applicantList' => $applicantList, 'paginator' => $paginator, 'page' => $page);
    }

    /**
     * Function to add qualification remainder
     */
    public function addQualificationReminder($userId, $userCourseId, $notes, $remindDate)
    {
        $userObj = $this->em->getRepository('GqAusUserBundle:User')
            ->find($userId);
        if (!empty($userCourseId)) {
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->find($userCourseId);
        } else {
            $courseObj = null;
        }
        if (empty($remindDate)) {
            $remindDate = date('d/m/Y H:i:s');
        }
        $remindDate = date('Y-m-d H:i:s', strtotime($remindDate));
        $reminderObj = new \GqAus\UserBundle\Entity\Reminder();
        $reminderObj->setCourse($courseObj);
        $reminderObj->setUser($userObj);
        $reminderObj->setDate($remindDate);
        $reminderObj->setMessage($notes);
        $reminderObj->setCompleted(0);
        $reminderObj->setCreatedby($this->currentUser);
        $this->em->persist($reminderObj);
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * Function to update applicant qualification list
     */
    public function updateUserApplicantsList($userId, $userRole, $courseCode)
    {
        if (in_array('ROLE_ASSESSOR', $userRole)) {
            $userType = 'assessor';
            $userStatus = 'assessorstatus';
        } elseif (in_array('ROLE_FACILITATOR', $userRole)) {
            $userType = 'facilitator';
            $userStatus = 'facilitatorstatus';
        } elseif (in_array('ROLE_RTO', $userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        }
        $rtoEnable = 0;
        $course = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array($userType => $userId, 'courseCode' => $courseCode));

        if (!empty($course)) {
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
                ->findOneBy(array('user' => $course->getUser()->getId(),
                'courseCode' => $course->getcourseCode()));

            if (!empty($courseObj)) {
                $courseUnitExistObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
                    ->findOneBy(array('user' => $course->getUser()->getId(),
                    'courseCode' => $course->getcourseCode(),
                    'status' => '1'));
                if (!empty($courseUnitExistObj)) {
                    $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
                        ->findOneBy(array('user' => $course->getUser()->getId(),
                        'courseCode' => $course->getcourseCode(),
                        $userStatus => array('0', '2'),
                        'status' => '1'));
                    if (empty($courseUnitObj) && (count($courseUnitObj) == '0')) {
                        $date = date('Y-m-d H:i:s');
                        if ($userType == 'facilitator') {
                            $course->setFacilitatorstatus('1');
                            $course->setFacilitatorDate($date);
                        } elseif ($userType == 'assessor') {
                            $course->setAssessorstatus('1');
                            $course->setAssessorDate($date);
                            $mailerInfo = array();
                            $mailerInfo['unitId'] = $courseUnitExistObj->getid();
                            $mailerInfo['sent'] = $course->getAssessor()->getId();
                            $mailerInfo['subject'] = "All evidences are enough competent in " . $course->getCourseCode() . " : " . $course->getCourseName();
                            $facilitatorName = $course->getFacilitator()->getUsername();
                            $mailerInfo['to'] = $course->getFacilitator()->getEmail();
                            $mailerInfo['inbox'] = $course->getFacilitator()->getId();
                            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $facilitatorName . ", <br/><br/> All the evidences for the Qualification : " . $course->getCourseCode() . " " . $course->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification.
                                 <br/><br/> Regards, <br/> " . $course->getAssessor()->getUsername();
                            $mailerInfo['fromEmail'] = $course->getAssessor()->getEmail();
                            $mailerInfo['fromUserName'] = $course->getAssessor()->getUsername();
                            $this->sendExternalEmail($mailerInfo);
                            $this->sendMessagesInbox($mailerInfo);

                            $applicantName = $course->getUser()->getUsername();
                            $mailerInfo['sent'] = $course->getFacilitator()->getId();
                            $mailerInfo['to'] = $course->getUser()->getEmail();
                            $mailerInfo['inbox'] = $course->getUser()->getId();
                            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $applicantName . ", <br/><br/> All the evidences for the Qualification : " . $course->getCourseCode() . " " . $course->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification.
                                 <br/><br/> Regards, <br/> " . $course->getFacilitator()->getUsername();
                            $mailerInfo['fromEmail'] = $course->getFacilitator()->getEmail();
                            $mailerInfo['fromUserName'] = $course->getFacilitator()->getUsername();
                            $this->sendExternalEmail($mailerInfo);
                            $this->sendMessagesInbox($mailerInfo);
                        } elseif ($userType == 'rto') {
                            $course->setRtostatus('1');
                            $course->setRtoDate($date);
                            $rtoEnable = 1;
                            //$course->setCourseStatus('1');
                        }
                        $this->em->merge($course);
                        $this->em->flush();
                        $this->em->clear();
                    }//if
                }//if
            }//if
        }//if
        return $rtoEnable;
    }

    /**
     * Function to get pending applicants count
     * return $count string
     */
    public function getPendingapplicantsCount($userId, $userRole, $applicantStatus)
    {
        if (in_array('ROLE_ASSESSOR', $userRole) || in_array('ROLE_RTO', $userRole)) {
            if (in_array('ROLE_ASSESSOR', $userRole)) {
                $userType = 'assessor';
                $userStatus = 'assessorstatus';
                $result = array($userType => $userId, $userStatus => $applicantStatus, 'courseStatus' => array(2, 10, 11, 12, 13, 14));
            } elseif (in_array('ROLE_RTO', $userRole)) {
                $userType = 'rto';
                $userStatus = 'rtostatus';
                $result = array($userType => $userId, $userStatus => $applicantStatus, 'courseStatus' => '15');
            }
            $getCourseStatus = $this->em->getRepository('GqAusUserBundle:UserCourses')->findBy($result);
        } elseif (in_array('ROLE_FACILITATOR', $userRole)) {
            $qb = $this->em->getRepository('GqAusUserBundle:UserCourses')->createQueryBuilder('u');
            $qb->where(sprintf('u.%s = :%s', 'facilitator', 'facilitator'))->setParameter('facilitator', $userId);
            $qb->andWhere('u.courseStatus != 0');

            $getCourseStatus = $qb->getQuery()->getResult();
        }
        return count($getCourseStatus);
    }

    /**
     * Function to get user dashboard info
     * return $result array
     */
    public function getUsersDashboardInfo($user)
    {
        if (is_object($user) && count($user) > 0) {
            $pendingApplicantsCount = $this->getPendingapplicantsCount($user->getId(), $user->getRoles(), '0');
            $unReadMessages = $this->getUnreadMessagesCount($user->getId());
            $todaysReminders = $this->getTodaysReminders($user->getId());
            return array('todaysReminders' => $todaysReminders,
                'unReadMessages' => $unReadMessages,
                'pendingApplicantsCount' => $pendingApplicantsCount);
        }
    }

    /**
     * Function to get todays reminders
     * return $result array
     */
    public function getTodaysReminders($userId)
    {
        $date = date('Y-m-d');
        $query = $this->em->getRepository('GqAusUserBundle:Reminder')
            ->createQueryBuilder('r')
            ->select("r, u")
            ->leftJoin('r.createdby', 'u')
            ->where('r.user = :userId and r.completed = 0 and r.date LIKE :date')->setParameter('userId', $userId)->setParameter('date', $date . '%')
            ->addOrderBy('r.date', 'ASC');
        $getReminders = $query->getQuery()->getResult();
        return $getReminders;
    }

    /**
     * function to send external email .
     *  @return string
     */
    public function sendExternalEmail($mailerInfo)
    {
        if (!empty($mailerInfo)) {
            if (isset($mailerInfo['fromEmail']) && $mailerInfo['fromEmail'] != "" && isset($mailerInfo['fromUserName']) && $mailerInfo['fromUserName'] != "") {
                $fromEmail = $mailerInfo['fromEmail'];
                $fromUser = $mailerInfo['fromUserName'];
            } else {
                $fromEmail = $this->container->getParameter('fromEmailAddress');
                $fromUser = 'Online RPL';
            }
            $emailContent = \Swift_Message::newInstance()
                ->setSubject($mailerInfo['subject'])
                ->setFrom(array($fromEmail => $fromUser))
                ->setTo($mailerInfo['to'])
                ->setBody($mailerInfo['body'])
                ->setContentType("text/html");
            $status = $this->mailer->send($emailContent);
        }
        $transport = $this->container->get('mailer')->getTransport();
        if (!$transport instanceof \Swift_Transport_SpoolTransport) {
            return;
        }

        $spool = $transport->getSpool();
        if (!$spool instanceof \Swift_MemorySpool) {
            return;
        }

        $spool->flushQueue($this->container->get('swiftmailer.transport.real'));

        return $status;
    }

    /**
     * Function to update todo status
     * return void
     */
    public function updateReminderStatus($id, $flag)
    {
        $remObj = $this->em->getRepository('GqAusUserBundle:Reminder')->find($id);
        $remObj->setCompleted($flag);
        $remObj->setCompletedDate(date('Y-m-d H:i:s'));
        $this->em->persist($remObj);
        $this->em->flush();
    }

    /**
     * Function to get Evidence Completeness
     * return void
     */
    public function getEvidenceCompleteness($userId, $courseCode = null)
    {
        $completeness = 0;
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'status' => '1'));
        $totalNoCourses = count($courseUnitObj);
        if ($totalNoCourses > 0) {
            $res = $this->em->getRepository('GqAusUserBundle:Evidence')
                ->createQueryBuilder('e')
                ->select("DISTINCT e.unit")
                ->where(sprintf('e.%s = :%s', 'user', 'user'))->setParameter('user', $userId)
                ->andWhere(sprintf('e.%s = :%s', 'course', 'course'))->setParameter('course', $courseCode)
                ->andWhere('e instance of \GqAus\UserBundle\Entity\Evidence\Text');
            $applicantList = $res->getQuery()->getResult();
            $evidenceCount = count($applicantList);
            $completeness = ($evidenceCount / $totalNoCourses) * 100;
        }
        return round($completeness) . '%';
    }

    /**
     * Function to fetch assessor other files
     * return array
     */
    public function fetchOtherFiles($user_id, $type = null)
    {
        $Otherfiles = $this->em->getRepository('GqAusUserBundle:OtherFiles');
        $params['assessor'] = $user_id;
        if ($type) {
            $params['type'] = $type;
        }
        $files = $Otherfiles->findBy($params);
        return $files;
    }

    /**
     * Function to delete assessor other files
     * return string
     */
    public function deleteOtherFiles($FileId)
    {
        $Otherfiles = $this->em->getRepository('GqAusUserBundle:OtherFiles');
        $fileId = $Otherfiles->find($FileId);
        if (!empty($fileId)) {
            $fileName = $fileId->getPath();
            $this->em->remove($fileId);
            $this->em->flush();
            return $fileName;
        }
    }

    /**
     * Function to get remaining weeks for the applicant status
     * return void
     */
    public function getTimeRemaining($id)
    {
        $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->createQueryBuilder('c')
                ->select("DATE_DIFF(c.targetDate, c.createdOn) as diff")
                ->where(sprintf('c.%s = :%s', 'id', 'id'))->setParameter('id', $id);
        $applicantList = $res->getQuery()->getResult();
        $diff = (($applicantList[0]['diff']) / 7);
        if (is_float($diff)) {
            $diff = $diff + 1;
        }
        return floor($diff) . ' week(s)';
    }

    /**
     * Function to get unread messages count
     * return void
     */
    public function getUnreadMessagesCount($userId)
    {
        $getMessages = $this->em->getRepository('GqAusUserBundle:Message')->findBy(array('inbox' => $userId,
            'read' => '0', 'toStatus' => '0'));
        return count($getMessages);
    }

    /**
     * Function to get inbox messages
     * return array
     */
    public function getmyinboxMessages($userId, $page)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select("m")
            ->where(sprintf('m.%s = :%s', 'inbox', 'inbox'))->setParameter('inbox', $userId)
            ->andWhere(sprintf('m.%s = :%s', 'toStatus', 'toStatus'))->setParameter('toStatus', '0')
            ->addOrderBy('m.created', 'DESC');
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($query, $page, $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator);
    }

    /**
     * Function to save the message
     * return void
     */
    public function saveMessageData($sentuser, $curuser, $msgdata)
    {
        $msgObj = new \GqAus\UserBundle\Entity\Message();
        $msgObj->setInbox($sentuser);
        $msgObj->setSent($curuser);
        $msgObj->setSubject($msgdata["subject"]);
        $msgObj->setMessage($msgdata["message"]);
        $msgObj->setRead(0);
        $msgObj->setFromStatus(0);
        $msgObj->setToStatus(0);
        $msgObj->setReply(0);
        $msgObj->setunitID($msgdata["unitId"]);
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to get sent messages
     * return array
     */
    public function getmySentMessages($userId, $page)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select("m")
            ->where(sprintf('m.%s = :%s', 'sent', 'sent'))->setParameter('sent', $userId)
            ->andWhere(sprintf('m.%s = :%s', 'fromStatus', 'fromStatus'))->setParameter('fromStatus', '0')
            ->addOrderBy('m.created', 'DESC');
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($query, $page, $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator);
    }

    /**
     * Function to get trashed messages
     * return array
     */
    public function getmyTrashMessages($userId, $page)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select("m");
        $query->andWhere(sprintf('m.%s = :%s AND m.%s = :%s', 'inbox', 'inbox', 'toStatus', 'toStatus'))
            ->setParameter('inbox', $userId)
            ->setParameter('toStatus', '1');
        $query->orWhere(sprintf('m.%s = :%s AND m.%s = :%s', 'sent', 'sent', 'fromStatus', 'fromStatus'))
            ->setParameter('sent', $userId)
            ->setParameter('fromStatus', '1')
            ->addOrderBy('m.created', 'DESC');
        //$query->orderBy('');
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($query, $page, $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator);
    }

    /**
     * Function to mark as read / unread
     */
    public function markReadStatus($id, $flag)
    {
        $msgObj = $this->em->getRepository('GqAusUserBundle:Message')->find($id);
        $msgObj->setRead($flag);
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to trash messages form inbox/sent items
     */
    public function setUserDeleteStatus($id, $flag, $type)
    {
        $msgObj = $this->em->getRepository('GqAusUserBundle:Message')->find($id);
        if ($type == 'to') {
            $msgObj->setToStatus($flag);
        } elseif ($type == 'from') {
            $msgObj->setFromStatus($flag);
        }
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to delete messages from tash
     */
    public function setToUserDeleteFromTrash($userId, $id, $flag)
    {
        $msgObj = $this->em->getRepository('GqAusUserBundle:Message')->find($id);
        if (!empty($msgObj)) {
            $inbox = $msgObj->getInbox()->getId();
            $sent = $msgObj->getSent()->getId();
            $toStatus = $msgObj->getToStatus();
            $fromStatus = $msgObj->getFromStatus();
            if (($userId == $inbox) && ($toStatus == '1')) {
                $msgObj->setToStatus($flag);
            } elseif (($userId == $sent) && ($fromStatus == '1')) {
                $msgObj->setFromStatus($flag);
            }
        }
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to get messages to view
     * return void
     */
    public function getMessage($mid)
    {
        return $this->em->getRepository('GqAusUserBundle:Message')->find($mid);
    }

    /**
     * Function to set the read messages status
     * return void
     */
    public function setReadViewStatus($mid)
    {
        $msgObj = $this->em->getRepository('GqAusUserBundle:Message')->find($mid);
        $msgObj->setRead("1");
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to send message to inbox
     */
    public function sendMessagesInbox($mailInfo)
    {
        $inbox = $this->getUserInfo($mailInfo['inbox']);
        $sent = $this->getUserInfo($mailInfo['sent']);
        $this->saveMessageData($inbox, $sent, $mailInfo);
    }

    /**
     * Function to send message to inbox
     */
    public function userImage($image)
    {
        $path = $this->container->getParameter('applicationUrl');
        $userImage = $path . 'public/uploads/' . $image;
        if (empty($image)) {
            $userImage = $path . 'public/images/profielicon.png';
        }
        return $userImage;
    }

    /**
     * Function to convert date to words
     */
    public function dateToWords($date)
    {
        $ts1 = strtotime($date);
        $ts2 = time();

        $secondsDiff = $ts2 - $ts1;

        /* Get the difference between the current time 
          and the time given in days */
        $days = floor($secondsDiff / 3600 / 24);

        /* If some forward time is given return error */
        if ($days < 0) {
            return -1;
        }

        switch ($days) {
            case 0: $word = "Today";
                break;
            case 1: $word = "Yesterday";
                break;
            case ($days >= 2 && $days <= 6):
                $word = sprintf("%d days ago", $days);
                break;
            case ($days >= 7 && $days < 14):
                $word = "1 week ago";
                break;
            case ($days >= 14 && $days <= 365):
                $word = sprintf("%d weeks ago", intval($days / 7));
                break;
            default : return date('d/m/Y', $ts1);
        }

        return $word;
    }

    /**
     * Function to approve certification by rto
     */
    public function rtoApproveCertification($courseCode, $applicantId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
            'user' => $applicantId));
        if (!empty($courseObj)) {
            $courseObj->setCourseStatus('16');
            $courseObj->setRtoDate(date('Y-m-d H:i:s'));
            $this->em->persist($courseObj);
            $this->em->flush();

            $mailerInfo = array();
            $mailerInfo['sent'] = $courseObj->getRto()->getId();
            $mailerInfo['unitId'] = '';
            $mailerInfo['subject'] = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
            $facilitatorName = $courseObj->getFacilitator()->getUsername();
            $mailerInfo['to'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $facilitatorName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification.
             <br/><br/> Regards, <br/> " . $courseObj->getRto()->getUsername();
            $mailerInfo['fromEmail'] = $courseObj->getRto()->getEmail();
            $mailerInfo['fromUserName'] = $courseObj->getRto()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);

            $applicantName = $courseObj->getUser()->getUsername();
            $mailerInfo['sent'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['to'] = $courseObj->getUser()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getUser()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $applicantName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification.
             <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
            $mailerInfo['fromEmail'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['fromUserName'] = $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);
        }
    }

    /**
     * Function to approve certification to rto
     */
    public function approveForRTOCertification($courseCode, $applicantId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
            'user' => $applicantId));
        if (!empty($courseObj)) {
            $courseObj->setCourseStatus('2');
            $courseObj->setFacilitatorstatus('1');
            $courseObj->setFacilitatorDate(date('Y-m-d H:i:s'));
            $this->em->persist($courseObj);
            $this->em->flush();

            $mailerInfo = array();
            $mailerInfo['unitId'] = '';
            $mailerInfo['sent'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['subject'] = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
            $rtoName = $courseObj->getRto()->getUsername();
            $mailerInfo['fromEmail'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['fromUserName'] = $courseObj->getFacilitator()->getUsername();
            $mailerInfo['to'] = $courseObj->getRto()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getRto()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $rtoName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences and moved portfolio to you.
             <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);

            $applicantName = $courseObj->getUser()->getUsername();
            $mailerInfo['to'] = $courseObj->getUser()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getUser()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $applicantName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Your portfolio has been submitted to RTO.
             <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);
        }
    }

    /**
     * Function to save applicant data
     */
    public function saveApplicantData($request)
    {
        $uniqid = uniqid();
        $data['firstname'] = $request->get('firstName');
        $data['lastname'] = $request->get('lastName');
        $data['email'] = $request->get('email');
        $data['newpassword'] = $request->get('password');
        $data['phone'] = $request->get('phone');
        $data['dateofbirth'] = $request->get('dateofbirth');
        $data['gender'] = $request->get('gender');
        $data['studentId'] = $request->get('studentId');
        $data['userImage'] = $request->get('userimage');
        $data['pwdToken'] = $request->get('pwdtoken');
        $data['tokenExpiry'] = $request->get('tokenexpiry');
        $data['tokenStatus'] = $request->get('tokenstatus');
        $data['courseConditionStatus'] = $request->get('courseconditionstatus');
        $data['ceoname'] = $request->get('ceoname');
        $data['ceoemail'] = $request->get('ceoemail');
        $data['ceophone'] = $request->get('ceophone');
        $data['createdby'] = $request->get('createdby');
        $data['status'] = $request->get('status');
        $data['address']['address'] = $request->get('address');
        $data['address']['pincode'] = $request->get('pincode');
        $data['newpassword'] = isset($data['newpassword']) ? $data['newpassword'] : $uniqid;
        $mailerInfo = array();
        $message = '';
        $emailFlag = '';
        $emailCourseFlag = '';
        $user = $this->checkEmailExist($data['email']);
        if (empty($data['firstname']) || empty($data['lastname']) || empty($data['email'])) {
            if (empty($data['firstname'])) {
                $message = 'First Name cannot be empty!';
            } elseif (empty($data['lastname'])) {
                $message = 'Last Name name cannot be empty!';
            } elseif (empty($data['email'])) {
                $message = 'Email cannot be empty!';
            }
        } else {
            if (!empty($data['email']) && count($user) <= 0) {
                $user = $this->addPersonalProfile('ROLE_APPLICANT', $data);
                $message = 'User added successfully!';
                $emailFlag = 'U';
            } else {
                $message = 'This User already exist!';
            }
            $courseData['courseCode'] = $request->get('courseCode');
            $courseData['courseName'] = $request->get('courseName');
            $courseData['courseStatus'] = $request->get('coursestatus');
            $courseData['targetDate'] = $request->get('targetdate');
            $courseData['crmId'] = $request->get('facilitatorCrmId');
            $courseData['zohoId'] = $request->get('zohoId');
            if (!empty($courseData['courseCode']) || !empty($courseData['courseName'])) {
                $res = $this->addUserCourse($courseData, $user);
                $message = $res['message'];
                $emailCourseFlag = $res['emailFlag'];
            }
        }
        if (!empty($emailFlag) || !empty($emailCourseFlag)) {
            $mailerInfo['to'] = $data['email'];
            if ($emailFlag == 'U') {
                $mailerInfo['subject'] = 'Account created for GQ Australia';
            } elseif ($emailCourseFlag == 'Q') {
                $mailerInfo['subject'] = 'Qualification: ' . $courseData['courseCode'] . ' is been Added';
            }
            $applicationUrl = $this->container->getParameter('applicationUrl');
            $body = "Dear " . $data['firstname'] . " " . $data['lastname'] . ",<br/><br/> ";
            if ($emailFlag == 'U') {
                $body .= "Account has been created for GQ Australia!";
            }
            if ($emailCourseFlag == 'Q') {
                $body .= " Qualification: " . $courseData['courseCode'] . " has been Added.";
            }
            if ($emailFlag == 'U') {
                $body .= " <a href='" . $applicationUrl . "'>Click Here </a> to login, Below are the account details.  <br/><br/> Email: " . $data['email'] . "<br/> Password: " . $data['newpassword'] . "<br/>";
            }
            $body .= "<br/><br/> Regards, <br/> OnlineRPL";
            $mailerInfo['body'] = $body;
            $this->sendExternalEmail($mailerInfo);
        }
        echo $message;
        exit;
    }

    /**
     * Function to add user course
     */
    public function addUserCourse($courseData, $user)
    {
        $emailFlag = '';
        if (empty($courseData['crmId'])) {
            $message = 'Facilitator CRM ID cannot be empty!';
        } elseif (empty($courseData['courseCode'])) {
            $message = 'Please enter course code!';
        } elseif (empty($courseData['courseName'])) {
            $message = 'Please enter course name!';
        } else {
            $courseExist = $this->checkUserCourseExist($courseData['courseCode'], $user->getId());
            $facilitatorRoleUser = $this->getCrmUserId($courseData['crmId']);
            if (!empty($facilitatorRoleUser)) {
                if ($courseExist <= 0) {
                    $userCoursesObj = new UserCourses();
                    $userCoursesObj->setUser($user);
                    $userCoursesObj->setCourseCode(isset($courseData['courseCode']) ? $courseData['courseCode'] : '');
                    $userCoursesObj->setCourseName(isset($courseData['courseName']) ? $courseData['courseName'] : '');
                    $userCoursesObj->setCourseStatus(isset($courseData['courseStatus']) ? $courseData['courseStatus'] : 1);
                    $userCoursesObj->setZohoId(isset($courseData['zohoId']) ? $courseData['zohoId'] : '');
                    $userCoursesObj->setCreatedOn(time());
                    $userCoursesObj->setFacilitator(isset($facilitatorRoleUser) ? $facilitatorRoleUser : '');
                    $userCoursesObj->setFacilitatorstatus(0);
                    $userCoursesObj->setAssessorstatus(0);
                    $userCoursesObj->setRtostatus(0);
                    $targetDate = date('Y-m-d H:m:s', strtotime('+90 days'));
                    $userCoursesObj->setTargetDate(isset($courseData['setTargetDate']) ? $courseData['setTargetDate'] : $targetDate);
                    $this->em->persist($userCoursesObj);
                    $this->em->flush();
                    $message = 'Qualification: ' . $courseData['courseCode'] . ' for this user added successfully!';
                    $emailFlag = 'Q';
                } else {
                    $message = 'Qualification: ' . $courseData['courseCode'] . ' for this user already exist!';
                }
            } else {
                $message = 'Invalid facilitator CRM Id!';
            }
        }
        return compact('message', 'emailFlag');
    }

    /**
     * Function to check User Course Exist
     */
    public function checkUserCourseExist($courseCode, $userId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
            'user' => $userId));
        return count($courseObj);
    }

    /*
     * Function to set the assessor and rto to applicant profile
     * return int
     */

    public function setRoleUsersForCourse($courseId, $role, $userId)
    {
        $course = $this->em->getRepository('GqAusUserBundle:UserCourses')->find($courseId);
        $user = $this->getUserInfo($userId);
        if ($role == \GqAus\UserBundle\Entity\Rto::ROLE) {
            $course->setRto($user);
        } else if ($role == \GqAus\UserBundle\Entity\Assessor::ROLE) {
            $course->setAssessor($user);
        } else if ($role == \GqAus\UserBundle\Entity\Facilitator::ROLE) {
            $course->setFacilitator($user);
        }
        $this->em->persist($course);
        $this->em->flush();
        $this->em->clear();
        $userInfo = $this->em->getRepository('GqAusUserBundle:User')->find($userId);
        return array('message' => 'success',
            'ceoName' => $userInfo->getCeoname(),
            'ceoEmail' => $userInfo->getCeoemail(),
            'ceoPhone' => $userInfo->getCeophone());
    }

    /*
     * Get List Users of specific role
     */

    public function getUsers($role)
    {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("SELECT id, firstname, lastname FROM user WHERE roletype = :role AND status = 1");
        $statement->bindValue('role', $role);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Function to send start competency conversation notification to applicant
     */
    public function sendConversationMessage($courseCode, $applicantId, $assessorId, $roomId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
            'user' => $applicantId));

        $applicant = $this->getUserInfo($applicantId);
        $assessor = $this->getUserInfo($assessorId);
        $mailerInfo = array();
        $mailerInfo['unitId'] = '';
        $mailerInfo['sent'] = $assessor->getId();
        $mailerInfo['subject'] = "Competency conversation invitation for " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
        $mailerInfo['to'] = $courseObj->getFacilitator()->getEmail();
        $mailerInfo['inbox'] = $courseObj->getFacilitator()->getId();
        $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $courseObj->getFacilitator()->getUsername() . ", <br/><br/> Please login to your GQ-RPL account and use this URL: " . $this->container->getParameter('applicationUrl') . "applicant/" . $roomId . " to join the competency conversation <br/> Awaiting for your response.
         <br/><br/> Regards, <br/> " . $assessor->getUsername();
        $mailerInfo['fromEmail'] = $assessor->getEmail();
        $mailerInfo['fromUserName'] = $assessor->getUsername();
        $this->sendExternalEmail($mailerInfo);
        $this->sendMessagesInbox($mailerInfo);

        $mailerInfo['sent'] = $courseObj->getFacilitator()->getId();
        $mailerInfo['subject'] = "Competency conversation invitation for " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
        $userName = $applicant->getUsername();
        $mailerInfo['to'] = $applicant->getEmail();
        $mailerInfo['inbox'] = $applicant->getId();
        $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $userName . ", <br/><br/> Please login to your GQ-RPL account and use this URL: " . $this->container->getParameter('applicationUrl') . "applicant/" . $roomId . " to join the competency conversation <br/> Awaiting for your response.
         <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
        $mailerInfo['fromEmail'] = $courseObj->getFacilitator()->getEmail();
        $mailerInfo['fromUserName'] = $courseObj->getFacilitator()->getUsername();
        $this->sendExternalEmail($mailerInfo);
        $this->sendMessagesInbox($mailerInfo);
    }

    /**
     * Function to get todo reminders
     * return $result array
     */
    public function getTodoReminders($userId)
    {
        $query = $this->em->getRepository('GqAusUserBundle:Reminder')
            ->createQueryBuilder('r')
            ->select("r, u")
            ->leftJoin('r.createdby', 'u')
            ->where('r.user = :userId and r.completed = 0')->setParameter('userId', $userId)
            ->addOrderBy('r.date', 'ASC');
        $getReminders = $query->getQuery()->getResult();
        return $getReminders;
    }

    /**
     * Function to get completed reminders
     * return $result array
     */
    public function getCompletedReminders($userId)
    {
        $query = $this->em->getRepository('GqAusUserBundle:Reminder')
            ->createQueryBuilder('r')
            ->select("r, u")
            ->leftJoin('r.createdby', 'u')
            ->where('r.user = :userId and r.completed = 1')->setParameter('userId', $userId)
            ->addOrderBy('r.completedDate', 'desc');
        $getReminders = $query->getQuery()->getResult();
        return $getReminders;
    }

    /**
     * Function to convert date time to words
     */
    public function toDoDateToWords($date, $tab)
    {

        $ts1 = strtotime(date("Y-m-d", strtotime($date)));
        $ts2 = strtotime(date("Y-m-d"));

        $secondsDiff = $ts1 - $ts2;

        /* Get the difference between the current time 
          and the time given in days */
        $days = floor($secondsDiff / 3600 / 24);
        $return = '';

        switch ($days) {
            case 0:
                if (strtotime($date) - time() < 0 && $tab == 'todo') {
                    $return .= '<span class="todo_daynote">Over Due </span>';
                }
                $word = date("h:i A", strtotime($date));
                break;
            case 1: $word = "Tomorrow";
                break;
            case -1: $word = "Yesterday";
                break;
            case ($days >= 2 && $days <= 6):
                $word = sprintf("%d days later", $days);
                break;
            case ($days >= -6 && $days <= -2):
                $word = substr(sprintf("%d days ago", $days), 1);
                break;
            case ($days >= 7 && $days < 14):
                $word = "1 week later";
                break;
            case ($days > -14 && $days <= -7):
                $word = "1 week ago";
                break;
            case ($days >= 14 && $days <= 365):
                $word = sprintf("%d weeks later", intval($days / 7));
                break;
            case ($days >= -365 && $days <= -14):
                $word = substr(sprintf("%d weeks ago", intval($days / 7)), 1);
                break;
            default : $word = date('d/m/Y h:i A', strtotime($date));
        }
        if ($days < 0 && $tab == 'todo') {
            $return .= '<span class="todo_daynote">Over Due </span>';
        }
        $return .= '<span class="todo_day">' . $word . '</span>';
        return $return;
    }

    /**
     * Function to get applicant unit status
     * return $approvalStatus int
     */
    public function getUnitStatusByRoleWise($applicantId, $userRole, $unitId, $courseCode)
    {
        $approvalStatus = 0;
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findOneBy(array(
            'user' => $applicantId,
            'unitId' => $unitId,
            'courseCode' => $courseCode));
        if ($userCourseUnits) {
            $approvalStatus = 0;
            switch ($userRole) {
                case 'ROLE_FACILITATOR' :
                    $approvalStatus = $userCourseUnits->getFacilitatorstatus();
                    break;
                case 'ROLE_ASSESSOR' :
                    $approvalStatus = $userCourseUnits->getAssessorstatus();
                    break;
                case 'ROLE_RTO' :
                    $approvalStatus = $userCourseUnits->getRtostatus();
                    break;
                default :
                    $approvalStatus = 0;
            }
        }
        return $approvalStatus;
    }

    /**
     * Function to get unit primary key
     * return $unitPId int
     */
    public function getUnitPrimaryId($applicantId, $unitId, $courseCode)
    {
        $unitPId = 0;
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findOneBy(array(
            'user' => $applicantId,
            'unitId' => $unitId,
            'courseCode' => $courseCode));
        if ($userCourseUnits) {
            $unitPId = $userCourseUnits->getId();
        }
        return $unitPId;
    }

    /**
     * Function to get inbox messages
     * return array
     */
    public function getFacilitatorApplicantMessages($unitId, $toId, $fromId)
    {
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select("m")
            ->where("m.unitID = :unitId")->setParameter('unitId', $unitId)
            ->andWhere("m.inbox = :toId and m.sent = :fromId or m.inbox = :fromId and m.sent = :toId")->setParameter('toId', $toId)->setParameter('fromId', $fromId)
            ->addOrderBy('m.created', 'DESC');
        $messages = $query->getQuery()->getResult();
        return $messages;
    }

    /**
     * Function to get Id file by id
     * return array
     */
    public function getIdFileById($IdFileId)
    {
        $IdObj = $this->em->getRepository('GqAusUserBundle:UserIds');
        $idFile = $IdObj->find($IdFileId);
        return $idFile;
    }

    /**
     * Function to get managers pending applicants count
     * return array
     */
    public function getManagersApplicantsCount($userId, $userRole)
    {
        if (in_array('ROLE_SUPERADMIN', $userRole)) {
            $userId = '';
        }
        $result = array();
        $result['facilitatorPendingApplicants'] = $this->applicantsCount($userId, 'facilitatorstatus', 0);
        $result['assessorsPendingApplicants'] = $this->applicantsCount($userId, 'assessorstatus', 0);
        $result['rtoPendingApplicants'] = $this->applicantsCount($userId, 'rtostatus', 0);
        return $result;
    }

    /**
     * Function to get pending applicants count
     * return array
     */
    public function applicantsCount($userId, $userTypeStatus, $status)
    {
        $qb = $this->em->getRepository('GqAusUserBundle:UserCourses')->createQueryBuilder('c');
        if ($userTypeStatus == 'facilitatorstatus') {
            $qb->where(sprintf('c.%s != :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0');
        } elseif ($userTypeStatus == 'assessorstatus') {
            $avals = array('2', '10', '11', '12', '13', '14');
            $qb->where('c.courseStatus IN (:ids)')->setParameter('ids', $avals);
        } elseif ($userTypeStatus == 'rtostatus') {
            $qb->where(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '15');
        }
        $getCourseStatus = $qb->getQuery()->getResult();
        return count($getCourseStatus);
    }

    /**
     * Function to manage users
     * return array
     */
    public function manageUsers($userId, $userRole, $searchName = '', $searchType = '', $page = null)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $nameCondition = null;
        $res = $this->em->getRepository('GqAusUserBundle:User')
            ->createQueryBuilder('u')
            ->select("u");
        if (!empty($searchType)) {
            if ($searchType == 2) {
                $res->where('u instance of \GqAus\UserBundle\Entity\Facilitator');
            } elseif ($searchType == 3) {
                $res->where('u instance of \GqAus\UserBundle\Entity\Assessor');
            } elseif ($searchType == 4) {
                $res->where('u instance of \GqAus\UserBundle\Entity\Rto');
            } elseif ($searchType == 5) {
                $res->where('u instance of \GqAus\UserBundle\Entity\Manager');
            }
        } else {
            if ($userRole == 'ROLE_SUPERADMIN') {
                $res->where('(u instance of \GqAus\UserBundle\Entity\Facilitator OR u instance of \GqAus\UserBundle\Entity\Assessor OR u instance of \GqAus\UserBundle\Entity\Rto OR u instance of \GqAus\UserBundle\Entity\Manager)');
            } else {
                $res->where('(u instance of \GqAus\UserBundle\Entity\Facilitator OR u instance of \GqAus\UserBundle\Entity\Assessor OR u instance of \GqAus\UserBundle\Entity\Rto)');
            }
        }

        if (!empty($searchName)) {
            $searchNamearr = explode(" ", $searchName);
            for ($i = 0; $i < count($searchNamearr); $i++) {
                if ($i == 0) {
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                } else {
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                }
            }
            $res->andWhere($nameCondition);
        }
        $res->andWhere('u.status = 1');
        $res->orderBy('u.id', 'DESC');
        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        /* Pagination */

        $applicantList = $res->getQuery()->getResult();
        return array('applicantList' => $applicantList, 'paginator' => $paginator, 'page' => $page);
    }

    /**
     * Function to get users by id
     * return array
     */
    public function getUser($userId)
    {
        $userObj = $this->em->getRepository('GqAusUserBundle:User')
            ->find($userId);
        return $userObj;
    }

    /**
     * Function to get users by role
     * return array
     */
    public function getUserByRole()
    {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("SELECT id, firstname, lastname, roletype, CONCAT(firstname, ' ', lastname) as username FROM user WHERE (roletype = :frole OR roletype = :arole) ORDER BY roletype");
        $statement->bindValue('frole', \GqAus\UserBundle\Entity\Facilitator::ROLE);
        $statement->bindValue('arole', \GqAus\UserBundle\Entity\Assessor::ROLE);
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }

    /**
     * Function to get qualification status
     * return array
     */
    public function getqualificationStatus()
    {
        $statusList = array(
            '1' => array('status' => 'Welcome Call Completed Docs Sent', 'order' => 1, 'Factive' => 1, 'Aactive' => 0),
            '4' => array('status' => 'Welcome Call VM Docs Sent', 'order' => 2, 'Factive' => 1, 'Aactive' => 0),
            '5' => array('status' => 'Partial Evidence Received', 'order' => 3, 'Factive' => 1, 'Aactive' => 0),
            '6' => array('status' => 'Evidence Being Reviewed', 'order' => 4, 'Factive' => 1, 'Aactive' => 0),
            '7' => array('status' => 'Evidence Feedback Provided', 'order' => 5, 'Factive' => 1, 'Aactive' => 0),
            '8' => array('status' => 'Needs Follow Up With Candidate', 'order' => 6, 'Factive' => 1, 'Aactive' => 0),
            '9' => array('status' => 'All Evidence Received', 'order' => 7, 'Factive' => 1, 'Aactive' => 0),
            '2' => array('status' => 'Portfoilo Sent To Remote Assessor', 'order' => 8, 'Factive' => 1, 'Aactive' => 0),
            '10' => array('status' => 'Competency Conversation Needed', 'order' => 9, 'Factive' => 0, 'Aactive' => 1),
            '11' => array('status' => 'Competency Conversation Booked', 'order' => 10, 'Factive' => 1, 'Aactive' => 0),
            '12' => array('status' => 'Competency Conversation Completed', 'order' => 11, 'Factive' => 0, 'Aactive' => 1),
            '13' => array('status' => 'Gap Training Required', 'order' => 12, 'Factive' => 0, 'Aactive' => 1),
            '3' => array('status' => 'Assessment Results Recived C', 'order' => 13, 'Factive' => 0, 'Aactive' => 1),
            '14' => array('status' => 'Assessment Feedback Required NYC', 'order' => 14, 'Factive' => 0, 'Aactive' => 1),
            '15' => array('status' => 'Portfolio Submitted To RTO', 'order' => 15, 'Factive' => 1, 'Aactive' => 0),
            '16' => array('status' => 'Certificate Received By GQ', 'order' => 16, 'Factive' => 0, 'Aactive' => 0),
            '0' => array('status' => 'RPL Completed', 'order' => 17, 'Factive' => 1, 'Aactive' => 0),
            '17' => array('status' => 'On Hold', 'order' => 18, 'Factive' => 1, 'Aactive' => 0),
        );
        return $statusList;
    }

    /*
     * filtering an array
     */

    public function filterByValue($array, $index, $value)
    {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key) {
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value) {
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray;
    }

    /**
     * Function to get qualification status
     * return array
     */
    public function getAssessorQualificationStatus()
    {
        $statusList = $this->getqualificationStatus();
        $status = $this->filterByValue($statusList, 'Aactive', 1);
        return $status;
    }

    /**
     * Function to get managers
     * return array
     */
    public function manageManagers($searchName = null, $page = null)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $nameCondition = null;
        $res = $this->em->getRepository('GqAusUserBundle:User')
            ->createQueryBuilder('u')
            ->select("u")
            ->where('u instance of \GqAus\UserBundle\Entity\Manager');

        if (!empty($searchName)) {
            $searchNamearr = explode(" ", $searchName);
            for ($i = 0; $i < count($searchNamearr); $i++) {
                if ($i == 0)
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                else
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
            }
            $res->andWhere($nameCondition);
        }
        $res->orderBy('u.id', 'DESC');
        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        /* Pagination */
        $managersList = $res->getQuery()->getResult();
        return array('managersList' => $managersList, 'paginator' => $paginator, 'page' => $page);
    }

    /**
     * Function to delete users
     * return $result array
     */
    public function deleteUser($deluserId, $delUserRole)
    {
        $res = $this->checkToDeleteUser($deluserId, $delUserRole);
        if ($res <= 0) {
            $this->updateUserStatus($deluserId);
            return 1;
        }
        return 0;
    }

    /**
     * Function to check to delete user
     */
    public function checkToDeleteUser($userId, $delUserRole)
    {
        if ($delUserRole == '2') {
            $fieldName = 'facilitator';
        } else if ($delUserRole == '3') {
            $fieldName = 'assessor';
        }
        if ($delUserRole == '2' || $delUserRole == '3') {
            $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->createQueryBuilder('c')
                ->select("c")
                ->where(sprintf('c.%s = :%s', $fieldName, $fieldName))->setParameter($fieldName, $userId)
                ->andWhere('c.courseStatus != 0');
            $result = $res->getQuery()->getResult();
            return count($result);
        }
        return 0;
    }

    /**
     * Function to update users status
     */
    public function updateUserStatus($userId)
    {
        $userObj = $this->em->getRepository('GqAusUserBundle:User')->find($userId);
        $userObj->setStatus('0');
        $this->em->persist($userObj);
        $this->em->flush();
    }

    /**
     * Function to add user profile
     */
    public function addPersonalProfile($role, $data, $image = null)
    {
        if ($role == 'ROLE_ASSESSOR') {
            $userObj = new \GqAus\UserBundle\Entity\Assessor();
        } elseif ($role == 'ROLE_FACILITATOR') {
            $userObj = new \GqAus\UserBundle\Entity\Facilitator();
        } elseif ($role == 'ROLE_MANAGER') {
            $userObj = new \GqAus\UserBundle\Entity\Manager();
        } elseif ($role == 'ROLE_APPLICANT') {
            $userObj = new \GqAus\UserBundle\Entity\Applicant();
        } elseif ($role == 'ROLE_RTO') {
            $userObj = new \GqAus\UserBundle\Entity\Rto();
        } else {
            $userObj = new \GqAus\UserBundle\Entity\Applicant();
        }
        if (!empty($image)) {
            $data['userImage'] = $image;
        }
        $userObj->setFirstName(isset($data['firstname']) ? $data['firstname'] : '');
        $userObj->setLastName(isset($data['lastname']) ? $data['lastname'] : '');
        $userObj->setEmail(isset($data['email']) ? $data['email'] : '');
        $userObj->setPhone(isset($data['phone']) ? $data['phone'] : '');
        $password = password_hash($data['newpassword'], PASSWORD_BCRYPT);
        $userObj->setPassword($password);
        $userObj->setTokenStatus(isset($data['tokenStatus']) ? $data['tokenStatus'] : 1);
        $userObj->setUserImage(isset($data['userImage']) ? $data['userImage'] : '');
        $userObj->setPasswordToken(isset($data['pwdToken']) ? $data['pwdToken'] : '');
        $userObj->setTokenExpiry(isset($data['tokenExpiry']) ? $data['tokenExpiry'] : '');
        $userObj->setCourseConditionStatus(isset($data['courseConditionStatus']) ? $data['courseConditionStatus'] : 0);
        $userObj->setDateOfBirth(isset($data['dateofbirth']) ? $data['dateofbirth'] : '');
        $userObj->setGender(isset($data['gender']) ? $data['gender'] : '');
        $userObj->setUniversalStudentIdentifier(isset($data['studentId']) ? $data['studentId'] : '');
        $userObj->setCeoname(isset($data['ceoname']) ? $data['ceoname'] : '');
        $userObj->setCeoemail(isset($data['ceoemail']) ? $data['ceoemail'] : '');
        $userObj->setCeophone(isset($data['ceophone']) ? $data['ceophone'] : '');
        $userObj->setCreatedby(isset($data['createdby']) ? $data['createdby'] : '');
        $userObj->setStatus(isset($data['status']) ? $data['status'] : '1');
        $userObj->setCrmId(isset($data['crmId']) ? $data['crmId'] : '');
        $userObj->setContactName(isset($data['contactname']) ? $data['contactname'] : '');
        $userObj->setContactEmail(isset($data['contactemail']) ? $data['contactemail'] : '');
        $userObj->setContactPhone(isset($data['contactphone']) ? $data['contactphone'] : '');
        $this->em->persist($userObj);
        $this->em->flush();
        $userId = $userObj->getId();
        if (!empty($userId)) {
            $this->saveUserAddress($data['address'], $userObj);
        }
        return $userObj;
    }

    /**
     * Function to save user address
     */
    public function saveUserAddress($data, $userObj)
    {
        $userAddressObj = new \GqAus\UserBundle\Entity\UserAddress();
        $userAddressObj->setUser($userObj);
        $userAddressObj->setAddress(isset($data['address']) ? $data['address'] : '');
        $userAddressObj->setArea(isset($data['area']) ? $data['area'] : '');
        $userAddressObj->setSuburb(isset($data['suburb']) ? $data['suburb'] : '');
        $userAddressObj->setCity(isset($data['city']) ? $data['city'] : '');
        $userAddressObj->setState(isset($data['state']) ? $data['state'] : '');
        $userAddressObj->setCountry(isset($data['country']) ? $data['country'] : '');
        $userAddressObj->setPincode(isset($data['pincode']) ? $data['pincode'] : '');
        $this->em->persist($userAddressObj);
        $this->em->flush();
    }

    /**
     * Function to check email exist
     */
    public function checkEmailExist($emailId)
    {
        $user = $this->em->getRepository('GqAusUserBundle:User')->findOneBy(array('email' => $emailId, 'status' => 1));
        return $user;
    }

    /**
     * Function to get CRM User id By Role
     */
    public function getCrmUserId($crmId)
    {
        $user = $this->em->getRepository('GqAusUserBundle:User')->findOneBy(array('crmId' => trim($crmId), 'status' => 1));
        return $user;
    }

    /**
     * Function check emailId exist
     */
    public function emailExist($emailId)
    {
        $user = $this->em->getRepository('GqAusUserBundle:User')->findOneBy(array('email' => $emailId, 'status' => 1));
        return count($user);
    }

    /**
     * Function to get user assigned qualifications
     * return string
     */
    public function getUserAssignedQualifications($userId, $userType)
    {
        if ($userType == '2') {
            $fieldName = 'facilitator';
        } elseif ($userType == '3') {
            $fieldName = 'assessor';
        } elseif ($userType == '4') {
            $fieldName = 'rto';
        }
        $userCourses = $this->em->getRepository('GqAusUserBundle:UserCourses')->findBy(array($fieldName => $userId));

        $field = '<div class="gq-applicant-filter-wrap-select">
                        <select name="course_' . $userId . '" id="course_' . $userId . '" class="styled" style="width:200px;">
                            <option value="" selected="selected">Select Qualification</option>';
        if (!empty($userCourses)) {
            foreach ($userCourses as $courses) {
                $field .= '<option value="' . $courses->getId() . '">' . $courses->getCourseCode() . ' : ' . $courses->getCourseName() . '</option>';
            }
        }
        $field .= '</select>
                    </div><br/>';
        return $field;
    }

    /**
     * Function to update course status
     */
    public function updateCourseStatus($courseStatus, $courseCode, $applicantId, $userRole)
    {
        $response = array();
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
            'user' => $applicantId));
        if (!empty($courseObj)) {
            $courseObj->setCourseStatus($courseStatus);

            // get status list
            $statusList = $this->getqualificationStatus();

            if (in_array('ROLE_ASSESSOR', $userRole)) {
                $sentId = $courseObj->getAssessor()->getId();
                $sentUserName = $courseObj->getAssessor()->getUsername();
                $sentEmail = $courseObj->getAssessor()->getEmail();
                $toEmail = $courseObj->getFacilitator()->getEmail();
                $toId = $courseObj->getFacilitator()->getId();
                $toUserName = $courseObj->getFacilitator()->getUsername();

                // if the assessor approves the qualification by updating the status
                if ($courseStatus == 3) {

                    // checking whether the all units of this qualification has been approved or not
                    $unitsApproval = $this->checkAssessorAllUnitsApproved($courseObj);
                    if ($unitsApproval == 0) { // if any unit pending approvals or any disapproved unit
                        $response['type'] = 'Error';
                        $response['code'] = 2;
                        $response['msg'] = 'Please approve all the units before approving the qualification.';
                        return $response;
                    }

                    $courseObj->setAssessorstatus('1');
                    $courseObj->setAssessorDate(date('Y-m-d H:i:s'));
                    $mailSubject = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
                    $mailMessage = "Dear " . $toUserName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification.
                                 <br/><br/> Regards, <br/> " . $sentUserName;
                    $mailMessageApplicant = "Dear " . $courseObj->getUser()->getUsername() . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification.
                                 <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
                }
            } else {

                $sentId = $courseObj->getFacilitator()->getId();
                $sentUserName = $courseObj->getFacilitator()->getUsername();
                $sentEmail = $courseObj->getFacilitator()->getEmail();

                if ($courseStatus == 2) {
                    // checking whether the assessor is assigned or not
                    $cAssessor = $courseObj->getAssessor();
                    if (!empty($cAssessor)) {
                        $courseObj->setFacilitatorstatus('1');
                        $courseObj->setFacilitatorDate(date('Y-m-d H:i:s'));
                        $toEmail = $courseObj->getAssessor()->getEmail();
                        $toId = $courseObj->getAssessor()->getId();
                        $toUserName = $courseObj->getAssessor()->getUsername();
                        $mailMessage = "Dear " . $toUserName . ", <br/><br/> Qualification Status of : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " has been updated to " . $statusList[$courseStatus]["status"] . ".
                        <br/><br/> Regards, <br/> " . $sentUserName;
                    } else {
                        $response['type'] = 'Error';
                        $response['code'] = 6;
                        $response['msg'] = 'Please assign assessor!';
                        return $response;
                    }
                } else if ($courseStatus == 15) {  // if the facilitator submits the portfolio to rto                
                    // checking whether the rto is assigned or not
                    $cRto = $courseObj->getRto();
                    if (!empty($cRto)) {
                        $toEmail = $courseObj->getRto()->getEmail();
                        $toId = $courseObj->getRto()->getId();
                        $toUserName = $courseObj->getRto()->getUsername();
                    } else {
                        $response['type'] = 'Error';
                        $response['code'] = 7;
                        $response['msg'] = 'Please assign rto!';
                        return $response;
                    }
                    // checking whether the assessor and rto approved the qualification or not
                    if ($courseObj->getAssessorstatus() != 1) {
                        //return 4;
                        $response['type'] = 'Error';
                        $response['code'] = 4;
                        $response['msg'] = 'Assessor has not yet approved the qualification.';
                        return $response;
                    }
                    $courseObj->setFacilitatorstatus('1');
                    $courseObj->setFacilitatorDate(date('Y-m-d H:i:s'));



                    $mailSubject = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
                    $mailMessage = "Dear " . $toUserName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences and moved portfolio to you.
                                 <br/><br/> Regards, <br/> " . $sentUserName;
                    $mailMessageApplicant = "Dear " . $courseObj->getUser()->getUsername() . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Your portfolio has been submitted to RTO.
                                 <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
                } else if ($courseStatus == 0) {  // if the facilitator issue the certificate                 
                    // checking whether the assessor and rto approved the qualification or not
                    if ($courseObj->getAssessorstatus() == 1 && $courseObj->getRtostatus() == 1) {

                        $mailSubject = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
                        $mailMessage = "Dear " . $toUserName . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification and issued the certificate.
                                      <br/><br/> Regards, <br/> " . $sentUserName;
                        $mailMessageApplicant = "Dear " . $courseObj->getUser()->getUsername() . ", <br/><br/> All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent <br/> Validated all the eviedences in the qualification and issued the certificate.
                                      <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
                    } else {
                        //return 3;
                        $response['type'] = 'Error';
                        $response['code'] = 3;
                        $response['msg'] = 'Assessor and Rto has not yet approved the qualification.';
                        return $response;
                    }
                }
            }
            $this->em->persist($courseObj);
            $this->em->flush();


            // checking whether if the subject and message variables are already defined if no assigning the default data
            if (!isset($mailSubject) && !isset($mailMessageApplicant)) {
                $mailSubject = "Qualification Status Updated of " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
                /* $mailMessage = "Dear " . $toUserName . ", <br/><br/> Qualification Status of : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " has been updated to ".$statusList[$courseStatus]["status"].".
                  <br/><br/> Regards, <br/> " . $sentUserName; */
                $mailMessageApplicant = "Dear " . $courseObj->getUser()->getUsername() . ", <br/><br/> Qualification Status of : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " has been updated to " . $statusList[$courseStatus]["status"] . ".
                     <br/><br/> Regards, <br/> " . $courseObj->getFacilitator()->getUsername();
            }

            $mailerInfo = array();
            $mailerInfo['unitId'] = '';
            $mailerInfo['subject'] = $mailSubject;

            if ((in_array('ROLE_ASSESSOR', $userRole)) || (in_array('ROLE_FACILITATOR', $userRole) && ($courseStatus == 2 || $courseStatus == 11 || $courseStatus == 15))) {

                $mailerInfo['sent'] = $sentId;
                $mailerInfo['to'] = $toEmail;
                $mailerInfo['inbox'] = $toId;
                $mailerInfo['message'] = $mailMessage;
                $mailerInfo['body'] = $mailMessage;
                $mailerInfo['fromEmail'] = $sentEmail;
                $mailerInfo['fromUserName'] = $sentUserName;
                $this->sendExternalEmail($mailerInfo);
                $this->sendMessagesInbox($mailerInfo);
            }

            $mailerInfo['sent'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['to'] = $courseObj->getUser()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getUser()->getId();
            $mailerInfo['message'] = $mailMessageApplicant;
            $mailerInfo['body'] = $mailMessageApplicant;
            $mailerInfo['fromEmail'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['fromUserName'] = $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);

            // update the zoho api status
            //$zohoId = '696292000010172044';
            if ($courseObj->getZohoId() != "") {
                $zohoId = $courseObj->getZohoId();
                $zohoUpdateResponse = $this->updateZohoAPIStatus($zohoId, $statusList[$courseStatus]["status"]);
                if ($zohoUpdateResponse != "Success") {
                    $response['type'] = 'Error';
                    $response['code'] = 5;
                    $response['msg'] = $zohoUpdateResponse;
                    return $response;
                }
            }

            $response['type'] = 'Success';
            $response['code'] = 1;
            $response['msg'] = 'Status updated successfully.';
        } else {
            $response['type'] = 'Error';
            $response['code'] = 0;
            $response['msg'] = 'Error in updating status.';
        }
        return $response;
    }

    /**
     * Function to update qualification rto status
     */
    public function updateCourseRTOStatus($userId, $userRole, $courseCode)
    {
        $rtoEnable = 0;
        if (in_array('ROLE_RTO', $userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';

            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array($userType => $userId, 'courseCode' => $courseCode));
            if (!empty($courseObj)) {
                $courseUnitCheckObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
                    ->findOneBy(array('user' => $courseObj->getUser()->getId(),
                    'courseCode' => $courseObj->getcourseCode(),
                    $userStatus => array('0', '2'),
                    'status' => '1'));
                if (empty($courseUnitCheckObj) && (count($courseUnitCheckObj) == '0')) {
                    $courseObj->setRtostatus('1');
                    $courseObj->setRtoDate(date('Y-m-d H:i:s'));
                    $this->em->persist($courseObj);
                    $this->em->flush();
                    $rtoEnable = 1;
                }
            }
        }
        return $rtoEnable;
    }

    /**
     * Function to update qualification rto status
     */
    public function checkAssessorAllUnitsApproved($courseObj)
    {
        $assessorApproval = 0;
        $courseUnitCheckObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
            ->findOneBy(array('user' => $courseObj->getUser()->getId(),
            'courseCode' => $courseObj->getcourseCode(),
            'assessorstatus' => array('0', '2'),
            'status' => '1'));
        if (empty($courseUnitCheckObj) && (count($courseUnitCheckObj) == '0')) {
            $assessorApproval = 1;
        }
        return $assessorApproval;
    }

    /**
     * Function to update qualification status in zoho crom
     */
    public function updateZohoAPIStatus($zohoId, $updatedStatus)
    {
        $return = '';
        $fieldsString = array('authtoken' => '7e32feeb048bdb5c679968c201833920', 'scope' => 'crmapi', 'id' => $zohoId, 'xmlData' => '<Potentials><row no="1"><FL val="Portfolio Stage">' . $updatedStatus . '</FL></row></Potentials>');
        $request = $this->guzzleService->post('https://crm.zoho.com/crm/private/xml/Potentials/updateRecords', '', $fieldsString);
        $response = $request->send();
        $result = $response->xml();
        $responseData = json_decode(json_encode((array) $result), 1);
        if (array_key_exists('error', $responseData)) {
            $return = $responseData['error']['message'];
        } else {
            $return = 'Success';
        }

        return $return;
    }

}
