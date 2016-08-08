<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\User;
use GqAus\UserBundle\Entity\Applicant;
use GqAus\UserBundle\Entity\UserAddress;
use GqAus\UserBundle\Entity\UserCourses;
use GqAus\UserBundle\Entity\Facilitator;
use GqAus\UserBundle\Entity\Assessor;
use GqAus\UserBundle\Entity\Rto;
use GqAus\UserBundle\Entity\Manager;
use GqAus\UserBundle\Entity\Superadmin;
use GqAus\UserBundle\Entity\Reminder;
use GqAus\UserBundle\Entity\Message;
use GqAus\UserBundle\Entity\Evidence\Text;
use GqAus\UserBundle\Entity\Faq;

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
     * @param object $em
     * @param object $container
     * @param object $mailer
     * @param object $guzzleService
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
	
    public function getRequestUser($userId)
    {
        return $this->repository->findOneById($userId);
    }	

    /**
     * function to save current user profile
     */
    public function saveProfile()
    {
        $this->em->persist($this->currentUser);
        $this->em->flush();
    }

    /**
     * function to save personal profile
     * @param object $user
     * @param string $image
     */
    public function savePersonalProfile($user, $image)
    {
        if (!empty($image)) {
            $user->setUserImage($image);
        }
        try{
        $this->em->persist($user);
        $this->em->flush();
        return true;
        }catch (Exception $exe) {
            return false;
        }
    }

    /**
     * function to request for forgot password .
     * @param string $email
     * return string
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
            // finding and replacing the variables from message templates
            $mailSubject = $this->container->getParameter('mail_forgot_password_sub');
            $search = array('#toUserName#', '#applicationUrl#', '#token#');
            $replace = array($userName, $this->container->getParameter('applicationUrl'), $token);
            $mailBody = str_replace($search, $replace, $this->container->getParameter('mail_forgot_password_con'));
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            $this->sendExternalEmail($user->getEmail(), $mailSubject, $mailBody, 
                $this->container->getParameter('fromEmailAddress'),
                $this->container->getParameter('default_from_username'));

            $message = '1';
        } else {
            $message = '0';
        }
        return $message;
    }

    /**
     * function to reset password.
     * @param string $token
     * @param string $method
     * @param string $password
     * return array
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
     * @param object $user
     * @param string $file
     */
    public function downloadCourseCondition($user = null, $file)
    {
        if ($user) {
            $this->updateCourseConditionStatus($user);
        }

        ignore_user_abort(true);
        $path = '../template/'; // change the path to fit your websites document structure
        $dlFile = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file); // simple file name validation
        $dlFile = filter_var($dlFile, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $path . $dlFile;

        if ($fd = fopen($fullPath, 'r')) {
            $fsize = filesize($fullPath);
            $pathParts = pathinfo($fullPath);
            $ext = strtolower($pathParts['extension']);
            switch ($ext) {
                case "pdf":
                    header('Content-type: application/pdf');
                    header("Content-Disposition: attachment; filename=\"" . $pathParts["basename"] . "\""); 
                    // use 'attachment' to force a file download
                    break;
                // add more headers for other content types here
                default;
                    header('Content-type: application/octet-stream');
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
     * @param object $user
     */
    public function updateCourseConditionStatus($user)
    {
        $user->setCourseConditionStatus('1');
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * function to get dashboard information.
     * @param object $user
     */
    public function getDashboardInfo($user)
    {
        if (is_object($user) && count($user) > 0) {
            $percentage = $this->getUserProfilePercentage($user);
            return array('profileCompleteness' => $percentage,
                'userImage' => $this->userImage($user->getUserImage()),
                'currentIdPoints' => $this->getIdPoints($user),
                'userCourses' => $user->getCourses(),
                'courseConditionStatus' => $user->getCourseConditionStatus());
        }
    }

    /**
     * function to get all document types.
     * return array
     */
    public function getDocumentTypes()
    {
        $documentType = $this->em->getRepository('GqAusUserBundle:DocumentType');
        return $documentType->findAll();
    }

    /**
     * function to get points for ID files uploaded.
     * @param object $user
     * return integer
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
     * @param int $IdFileId
     * @param string $IdFileType
     * return string
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
     * @param int $userId
     * return array
     */
    public function getUserInfo($userId)
    {
        return $this->repository->findOneById($userId);
    }

    /**
     * Function to get user profile percentage
     * @param object $user
     * return string
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
            //if (!empty($dob)) {
            //    $profileCompleteness += 10;
            //}

            if (!empty($address) && $address != '0' && $address->getAddress()!="") {
                $profileCompleteness += 10;                
            }
            if (!empty($address) && $address != '0' && $address->getArea()!="") {
                $profileCompleteness += 5;
            }
            if (!empty($address) && $address != '0' && $address->getCity()!="") {
                $profileCompleteness += 5;
            }
            if (!empty($address) && $address != '0' && $address->getState()!="") {
                $profileCompleteness += 5;
            }
            if (!empty($address) && $address != '0' && $address->getPincode()!="") {
                $profileCompleteness += 5;
            }
            if (!empty($address) && $address != '0' && $address->getCountry()!="") {
                $profileCompleteness += 5;
            }
            if (!empty($address) && $address != '0' && $address->getSuburb()!="") {
                $profileCompleteness += 5;
            }
        }
        $percentage = ($profileCompleteness * $maximumPoints) / 100;
        return $percentage = $percentage . '%';
    }

    /**
     * Function to get applicant information
     * @param object $user
     * @param string $qcode
     * return array
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
            $results['assessorfirstName'] = !empty($assessor) ? $assessor->getFirstname() : '';
            $results['assessorlastName'] = !empty($assessor) ? $assessor->getLastname() : '';
            $results['assessorName'] = !empty($assessor) ? $assessor->getUsername() : '';
            $results['assessorImage'] = !empty($assessor) ? $this->userImage($assessor->getUserImage()) : '';
            $results['assessorEmail'] =  !empty($assessor) ? $assessor->getEmail() : '';
            $results['assessorPhone'] =  !empty($assessor) ? $assessor->getPhone() : '';
            
            $rto = $this->getUserInfo($otheruser->getRto());
			$results['assessorImage'] = !empty($assessor) ? $this->userImage($assessor->getUserImage()) : '';
			
            $results['rtoName'] = !empty($rto) ? $rto->getUsername() : '';
            $results['rtoCeoName'] = !empty($rto) ? $rto->getCeoname() : '';
            $results['rtoCeoEmail'] = !empty($rto) ? $rto->getCeoemail() : '';
            $results['rtoCeoPhone'] = !empty($rto) ? $rto->getCeophone() : '';

            $facilitator = $this->getUserInfo($otheruser->getFacilitator());
            $results['facilitatorfirstName'] = !empty($facilitator) ? $facilitator->getFirstname() : '';
            $results['facilitatorlastName'] = !empty($facilitator) ? $facilitator->getLastname() : '';
            $results['facilitatorName'] = !empty($facilitator) ? $facilitator->getUsername() : '';
            $results['facilitatorImage'] = !empty($facilitator) ? $this->userImage($facilitator->getUserImage()) : '';
            $results['facilitatorEmail'] =  !empty($facilitator) ? $facilitator->getEmail() : '';
            $results['facilitatorPhone'] =  !empty($facilitator) ? $facilitator->getPhone() : '';
            $results['facilitatorId'] = !empty($facilitator) ? $facilitator->getId() : '';
            $results['assessorId'] = !empty($assessor) ? $assessor->getId() : '';
            $results['rtoId'] = !empty($rto) ? $rto->getId() : '';

            $results['courseStatus'] = $otheruser->getCourseStatus();
            $results['rtostatus'] = $otheruser->getRtostatus();
            $results['assessorstatus'] = $otheruser->getAssessorstatus();
            $results['facilitatorstatus'] = $otheruser->getFacilitatorstatus();
            $results['coursePrimaryId'] = $otheruser->getId();
            $results['rtoUnitStatus'] = $this->checkAllUnitsApprovalByRole($otheruser, 'rtostatus');
        }
        return $results;
    }

    /**
     * Function to update applicant evidences information
     * @param array $result
     * return array
     */
    public function updateApplicantEvidences($result)
    {
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
            ->findOneBy(array('user' => $result['userId'],
            'unitId' => $result['unit'], 'courseCode' => $result['courseCode']));
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->findOneBy(array('courseCode' => $result['courseCode'], 'user' => $result['userId']));
        switch ($result['userRole']) {
            case 'ROLE_FACILITATOR':
                $courseUnitObj->setFacilitatorstatus($result['status']);
                break;
            case 'ROLE_ASSESSOR':
                $courseUnitObj->setAssessorstatus($result['status']);
                break;
            case 'ROLE_RTO':
                $courseUnitObj->setRtostatus($result['status']);
                break;
        }
        $this->em->persist($courseUnitObj);
        $this->em->flush();

        if ($result['status'] == '1') {
            $evidenceStatus = 'Approved';
        } else if ($result['status'] == '2') {
            $userName = $courseObj->getUser()->getUsername();
            $facilitatorName = $courseObj->getFacilitator()->getUsername();

            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#', '#unitName#');
            $subReplace = array($result['courseCode'], $result['courseName'], $result['unitName']);
            $facMessageSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('msg_disappove_evdience_fac_sub'));
            $facMailSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('mail_disappove_evdience_fac_sub'));

            // finding and replacing the variables from message templates
            $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#unitId#', '#unitName#', '#fromUserName#');
            $msgReplace = array($userName, $result['courseCode'], $result['courseName'], $result['unit'], 
                $result['unitName'], $facilitatorName);
            $facMessageBody = str_replace($msgSearch, $msgReplace,
                $this->container->getParameter('msg_disappove_evdience_fac_con'));
            $facMailBody = str_replace($msgSearch, $msgReplace,
                $this->container->getParameter('mail_disappove_evdience_fac_con'));
            if ($result['userRole'] == 'ROLE_ASSESSOR') {
                $asrMessageSubject = str_replace($subSearch, $subReplace,
                    $this->container->getParameter('msg_disappove_evdience_asr_sub'));
                $asrMailSubject = str_replace($subSearch, $subReplace,
                    $this->container->getParameter('mail_disappove_evdience_asr_sub'));
                $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#unitId#', '#unitName#',
                    '#userName#', '#fromUserName#');
                $msgReplace = array($facilitatorName, $result['courseCode'], $result['courseName'],
                    $result['unit'], $result['unitName'], $userName, $result['currentUserName']);
                $asrMessageBody = str_replace($msgSearch, $msgReplace,
                    $this->container->getParameter('msg_disappove_evdience_asr_con'));
                $asrMailBody = str_replace($msgSearch, $msgReplace,
                    $this->container->getParameter('mail_disappove_evdience_asr_con'));
                /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
               /* $this->sendExternalEmail($courseObj->getFacilitator()->getEmail(), $asrMailSubject, $asrMailBody,
                    $courseObj->getAssessor()->getEmail(), $courseObj->getAssessor()->getUsername()); */
                /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
                $this->sendMessagesInbox($courseObj->getFacilitator()->getId(), $result['currentUserId'],
                    $asrMessageSubject, $asrMessageBody, $courseUnitObj->getId());
            }
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            /* $this->sendExternalEmail($courseObj->getUser()->getEmail(), $facMailSubject, $facMailBody,
                $courseObj->getFacilitator()->getEmail(), $courseObj->getFacilitator()->getUsername()); */
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
            $this->sendMessagesInbox($courseObj->getUser()->getId(), $courseObj->getFacilitator()->getId(),
                $facMessageSubject, $facMessageBody, $courseUnitObj->getId());
        }
        return $result['status'];
    }

    /**
     * Function to get applicants list information
     * @param int $userId
     * @param string $userRole
     * @param int $status
     * @param int $page
     * @param string $searchName
     * @param string $searchTime
     * @param string $filterByUser
     * @param int $filterByStatus
     * return array
     */
    public function getUserApplicantsList($userId, $userRole, $status, $page = null, $searchName = null, 
        $searchTime = null, $filterByUser = null, $filterByStatus = null)
    {
        if ($page <= 0 ) {
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
        $fields = 'partial c.{id, courseCode, courseName, courseStatus}, partial u.{id, firstName, lastName}';
        $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('c')
            ->select($fields)
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
                $res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '1');
            } else {
                $res->andWhere(sprintf('c.%s != :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0');
            }
        }

        if ($userType == 'manager' || $userType == 'superadmin') {
            if ($status == 1) {
                $res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))
                    ->setParameter('courseStatus', '0'); //approved
            } else {
                $res->andWhere(sprintf('c.%s != :%s', 'courseStatus', 'courseStatus'))
                    ->setParameter('courseStatus', '0');
            }
        }

        if (!empty($searchName)) {
            $searchNamearr = explode(" ", $searchName);
            for ($i = 0; $i < count($searchNamearr); $i++) {
                if ($i == 0)
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' "
                    . "OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR u.email LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR u.phone LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR c.courseName LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR c.courseCode LIKE '%" . $searchNamearr[$i] . "%'";
                else
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' "
                    . "OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR u.email LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR u.phone LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR c.course_name LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR c.courseName LIKE '%" . $searchNamearr[$i] . "%'"
                    . "OR c.courseCode LIKE '%" . $searchNamearr[$i] . "%'";
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
            $res->andWhere('c.facilitator = :filterByUser OR c.assessor = :filterByUser')
                ->setParameter('filterByUser', $filterByUser);
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
     * Function to get facilitator portfolio
     * @param int $userId
     * return facilitator portfolio counts
     */
    public function getFacilitatorPortfolioCounts($userId, $userRole){

        $allRecordsCount = $this->getUserApplicantsByRoleDateRangeCount($userId, $userRole);
        $thirtyDayRecordsCount = $this->getUserApplicantsByRoleDateRangeCount($userId, $userRole, '1', '0', '30');
        $sixtyDayRecordsCount  = $this->getUserApplicantsByRoleDateRangeCount($userId, $userRole, '1', '31', '60');
        $ninetyDayRecordsCount = $this->getUserApplicantsByRoleDateRangeCount($userId, $userRole, '1', '61', '90');
        $ninetyDayPlusRecordsCount = $this->getUserApplicantsByRoleDateRangeCount($userId, $userRole, '2', '91', '');
        $thirtyDayRecordsPercent = $sixtyDayRecordsPercent = $ninetyDayRecordsPercent = $ninetyDayPlusRecordsPercent = 0;
        if($allRecordsCount > 0) {

            $thirtyDayRecordsPercent = ($thirtyDayRecordsCount/$allRecordsCount)*100;
            $sixtyDayRecordsPercent = ($sixtyDayRecordsCount/$allRecordsCount)*100;
            $ninetyDayRecordsPercent = ($ninetyDayRecordsCount/$allRecordsCount)*100;
            $ninetyDayPlusRecordsPercent = ($ninetyDayPlusRecordsCount/$allRecordsCount)*100;
        }
        return array(
                    'allApplicantsCount' => $allRecordsCount,
                    'thirtyDaysApplicantsCount' => $thirtyDayRecordsCount, 
                    'sixtyDaysApplicantsCount' => $sixtyDayRecordsCount,
                    'ninetyDaysApplicantsCount' => $ninetyDayRecordsCount,
                    'ninetyDaysPlusRecordsCount' => $ninetyDayPlusRecordsCount,
                    'thirtyDayApplicantsPercent' => $thirtyDayRecordsPercent,
                    'sixtyDaysApplicantsPercent' => $sixtyDayRecordsPercent,
                    'ninetyDaysApplicantsPercent' => $ninetyDayRecordsPercent,
                    'ninetyDaysPlusRecordsPercent' => $ninetyDayPlusRecordsPercent,
                );
    }

    /**
     * Function to get pending applicants for facilitator by date range
     * @param int $userId
     * @param int $rangeCase
     * @param int $dateRangeStart start date range
     * @param int $dateRangeEnd end date range
     * return count
     */
    public function getUserApplicantsByRoleDateRangeCount($userId, $userRole, $rangeCase = null, $dateRangeStart = null, $dateRangeEnd = null){   
        $applicantList = $this->getUserApplicantsByRoleDateRange($userId, $userRole, $rangeCase, $dateRangeStart, $dateRangeEnd);
        return (count($applicantList))? count($applicantList) : '0';
    }


    /**
     * Function to get pending applicants for facilitator by date range
     * @param int $userId
     * @param int $rangeCase
     * @param int $dateRangeStart start date range
     * @param int $dateRangeEnd end date range
     * @param boolean $debug option
     * return array
     */
    public function getUserApplicantsByRoleDateRange($userId, $userRole, $rangeCase = null, $dateRangeStart = null, $dateRangeEnd = null, $debug = null){
        
        $userCheckField = (in_array('ROLE_FACILITATOR', $userRole)) ? 'facilitator' : 'assessor';
        $fields = 'partial u.{id, courseCode, courseName, courseStatus, rtoDate, rtostatus, facilitatorstatus}';
        $query  = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('u')
            ->select($fields)            
            ->where(sprintf('u.%s = :%s ', $userCheckField, $userCheckField))->setParameter($userCheckField, $userId);

        if (in_array('ROLE_ASSESSOR', $userRole) || in_array('ROLE_RTO', $userRole)) {
            if (in_array('ROLE_ASSESSOR', $userRole)) {
                $userType = 'assessor';
                $userStatus = 'assessorstatus';
                $courseStatus = array('2', '10', '11', '12', '13', '14');
            } elseif (in_array('ROLE_RTO', $userRole)) {
                $userType = 'rto';
                $userStatus = 'rtostatus';
                $courseStatus = array('15');
            }

            $query->andWhere('u.courseStatus IN (:courseStatus)')->setParameter('courseStatus', $courseStatus);            
        } elseif (in_array('ROLE_FACILITATOR', $userRole)) {
            $query->andWhere(sprintf('u.courseStatus <> 0 '));
        }

        if($rangeCase){
            $startDateTimeMin = '23:59:59.999999';
            $endDateTimeMin = '00:00:00.000000';
            $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $dateRangeStart, date('Y')))." ".$startDateTimeMin;
            $dateEnd = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $dateRangeEnd, date('Y')))." ".$endDateTimeMin;

            switch ($rangeCase) {
                case '1':
                        if($dateRangeStart < 1)
                            $dateStart = date('Y-m-d')." ".$startDateTimeMin;
                        $query->andWhere('u.createdOn BETWEEN '."'".$dateEnd."' AND '".$dateStart."'");
                    break;
                case '2':
                        $query->andWhere('u.createdOn <= :dateRangeGreater')->setParameter('dateRangeGreater', $dateStart);
                    break;
            }
        }
        $applicantList = $query->getQuery()->getResult();
        return $applicantList;
    }

    

    /**
     * Function to get pending applicants for facilitator by date range
     * @param int $userId
     * @param int $rangeCase
     * @param int $dateRangeStart start date range
     * @param int $dateRangeEnd end date range
     * return array
     */    
    public function getFacilitatorApplicantsWithAssesorByDateRange($userId){
        $startDateTimeMin = '23:59:59.999999';
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')))." ".$startDateTimeMin;
        $courseStatus = array('2', '10', '11', '12', '13', '14'); // with assesor
        
        $fields = 'partial u.{id, courseCode, courseName, courseStatus, rtoDate, rtostatus, facilitatorstatus}';
        $query  = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('u')
            ->select($fields)         
            ->where(sprintf('u.%s = :%s ', 'facilitator', 'facilitator'))->setParameter('facilitator', $userId)
            ->andWhere('u.courseStatus IN (:courseStatus)')->setParameter('courseStatus', $courseStatus)
            ->andWhere('u.facilitatorDate <= :dateRangeGreater')->setParameter('dateRangeGreater', $dateStart);
        $applicantList = $query->getQuery()->getResult();
        return $applicantList;
    }

    public function getUserApplicantsWithRtoByDateRange($user){
        $userId = $user->getId();
        $userRole = $user->getRoles();
        $startDateTimeMin = '23:59:59.999999';
        
        if(in_array('ROLE_FACILITATOR', $userRole)) {
             $userDateField = 'facilitatorDate';
             $userRoleField = 'facilitator';
        } else {
             $userDateField = 'assessorDate';
             $userRoleField = 'assessor';
        }
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 12, date('Y')))." ".$startDateTimeMin;
        $courseStatus = array('15'); // with rto
        $fields = 'partial u.{id, courseCode, courseName, courseStatus, rtoDate, rtostatus, facilitatorstatus}';
        $query  = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('u')
            ->select($fields)
            ->where(sprintf('u.%s = :%s ', $userRoleField, $userRoleField))->setParameter($userRoleField, $userId)
            ->andWhere('u.courseStatus IN (:courseStatus)')->setParameter('courseStatus', $courseStatus)
            ->andWhere('u.'.$userDateField.' <= :dateRangeGreater')->setParameter('dateRangeGreater', $dateStart);
        $applicantList = $query->getQuery()->getResult();
        $query = $query->getQuery();
        return $applicantList;
    }
    
    /**
     * Function to get applicants list information
     * @param int $userId
     * @param string $userRole
     * @param int $status
     * @param int $page
     * @param string $searchName
     * @param string $searchQualification
     * @param string $startDate
     * @param string $endDate
     * @param string $searchTime
     * return array
     */
    public function getUserApplicantsListReports($userId, $userRole, $status, $page, $searchName = null, 
        $searchQualification = null, $startDate = null, $endDate = null, $searchTime = null)
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
        } elseif (in_array('ROLE_MANAGER', $userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        } elseif (in_array('ROLE_SUPERADMIN', $userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        }
        $fields = 'partial c.{id, courseCode, courseName, courseStatus, assessorstatus, facilitatorstatus, rtostatus,'
            . ' assessorDate, facilitatorDate, rtoDate}, partial u.{id, firstName, lastName}';
        if ($status == 3) {
            $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->createQueryBuilder('c')
                    ->select($fields)
                    ->join('c.user', 'u')
                    ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId);
            if ($userType == 'rto') {
                $res->andWhere("c.courseStatus = '0' OR c.courseStatus = '15' OR c.courseStatus = '16'");
            }
        } else {
            if ($status == 11) {
                $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->createQueryBuilder('c')
                    ->select($fields)
                    ->join('c.user', 'u')
                    ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
                    ->andWhere("c.assessorstatus = '1'");
            } else {
                $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                        ->createQueryBuilder('c')
                        ->select($fields)
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
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' "
                    . "OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                else
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' "
                    . "OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
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
                    $qualCondition .= "c.courseCode LIKE '%" . $searchQualificationarr[$i] . "%' "
                    . "OR c.courseName LIKE '%" . $searchQualificationarr[$i] . "%'";
                else
                    $qualCondition .= " OR c.courseCode LIKE '%" . $searchQualificationarr[$i] . "%'"
                    . " OR c.courseName LIKE '%" . $searchQualificationarr[$i] . "%'";
            }
            $res->andWhere($qualCondition);
        }
        if (!empty($startDate)) {
            $startDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')));
            $res->andWhere("c.createdOn BETWEEN '" . $startDate . " 00:00:00.000000' and '" . $endDate . " 23:59:59.999999'");
        }
        $res->orderBy('c.id', 'DESC');

        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        if($page){
            $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        }
        /* Pagination */
        $page = ($page) ? $page : '0';
        $applicantList = $res->getQuery()->getResult();

        return array('applicantList' => $applicantList, 'paginator' => $paginator, 'page' => $page);
    }
    
    

    /**
     * Function to add qualification remainder
     * @param int $userId
     * @param int $userCourseId
     * @param string $notes
     * @param string $remindDate
     */
    public function addQualificationReminder($userId, $userCourseId, $notes, $remindDate, $reminderType='', $reminderTypeId='')
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
        $reminderObj = new Reminder();
        $reminderObj->setCourse($courseObj);
        $reminderObj->setUser($userObj);
        $reminderObj->setDate($remindDate);
        $reminderObj->setMessage($notes);
        $reminderObj->setReminderType($reminderType);
        $reminderObj->setReminderTypeId($reminderTypeId);
        $reminderObj->setCompleted(0);
        $reminderObj->setCreatedby($this->currentUser);
        $this->em->persist($reminderObj);
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * Function to get pending applicants count
     * @param int $userId
     * @param string $userRole
     * @param int $applicantStatus
     * return integer
     */
    public function getPendingApplicantsCount($userId, $userRole, $applicantStatus)
    {
        $getCourseStatus = $this->getPendingApplicants($userId, $userRole, $applicantStatus);
        return count($getCourseStatus);
    }

     /**
     * Function to get pending applicants
     * @param int $userId
     * @param string $userRole
     * @param int $applicantStatus
     * return integer
     */
    public function getPendingApplicants($userId, $userRole, $applicantStatus)
    {
        $getCourseStatus = array();
        if (in_array('ROLE_ASSESSOR', $userRole) || in_array('ROLE_RTO', $userRole)) {
            if (in_array('ROLE_ASSESSOR', $userRole)) {
                $userType = 'assessor';
                $userStatus = 'assessorstatus';
                $result = array($userType => $userId, $userStatus => $applicantStatus,
                    'courseStatus' => array(2, 10, 11, 12, 13, 14));
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
        elseif (in_array('ROLE_MANAGER', $userRole)) {
            $qb = $this->em->getRepository('GqAusUserBundle:UserCourses')->createQueryBuilder('u');
            $qb->where(sprintf('u.%s = :%s', 'facilitator', 'facilitator'))->setParameter('facilitator', $userId);
            $qb->andWhere('u.courseStatus != 0');

            $getCourseStatus = $qb->getQuery()->getResult();
        }
        elseif (in_array('ROLE_SUPERADMIN', $userRole)) {
            $qb = $this->em->getRepository('GqAusUserBundle:UserCourses')->createQueryBuilder('u');
            $qb->where(sprintf('u.%s = :%s', 'facilitator', 'facilitator'))->setParameter('facilitator', $userId);
            $qb->andWhere('u.courseStatus != 0');

            $getCourseStatus = $qb->getQuery()->getResult();
        }
        return $getCourseStatus;
    }
	
	public function getCheckTodoApplicant($userId, $courseId)
    {          
        $qb = $this->em->getRepository('GqAusUserBundle:reminder')->createQueryBuilder('r');
        $qb->where(sprintf('r.%s = :%s', 'course', 'course'))->setParameter('course', $courseId);
        $qb->andWhere(sprintf('r.%s = :%s','user', 'user'))->setParameter('user', $userId);        
        $getTodoApplicantCount = $qb->getQuery()->getResult();         
        return count($getTodoApplicantCount);
    }	

     /**
     * Function to get applicants ready for rto approval
     * @param int $userId
     * return array $applicantList
     */
    public function getApplicantsReadyForRtoApproval($userId){
        $courseStatus = array('15'); // with rto
        $fields = 'partial u.{id, courseCode, courseName, courseStatus, rtoDate, assessorstatus, facilitatorstatus}';
        $query  = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('u')
            ->select($fields)         
            ->where(sprintf('u.%s = :%s ', 'rto', 'rto'))->setParameter('rto', $userId)
            ->andWhere('u.courseStatus IN (:courseStatus)')->setParameter('courseStatus', $courseStatus)
            ->andWhere('u.facilitatorstatus = 1 AND u.assessorstatus = 1');
            $getApplicants = $query->getQuery()->getResult();
        return $getApplicants;
    }
    
     /**
     * Function to get applicants ready for rto approval
     * @param int $userId
     * return array $applicantList
     */
    public function getLessDayApplicantsByRto($userId){
        $startDateTimeMin = '00:00:00.000000';
        $endDateTimeMin = '23:59:59.999999';
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')))." ".$startDateTimeMin;
        $dateEnd = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+3, date('Y')))." ".$endDateTimeMin;
        $courseStatus = array('15'); // with rto
       
        $fields = 'partial u.{id, courseCode, courseName, courseStatus, rtoDate, rtostatus, facilitatorstatus}';
        $query  = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('u')
            ->select($fields)
            ->where(sprintf('u.%s = :%s', 'rto', 'rto'))->setParameter('rto', $userId)
            ->andWhere('u.courseStatus IN (:courseStatus)')->setParameter('courseStatus', $courseStatus)
            ->andWhere('u.targetDate BETWEEN '."'".$dateStart."' AND '".$dateEnd."'");

        $rtoLessDayList = $query->getQuery()->getResult();
        return $rtoLessDayList;
    }

    /**
     * Function to get user dashboard info
     * @param object $user
     * return array
     */
    public function getUsersDashboardInfo($user){
        if (is_object($user) && count($user) > 0) {
            $userId = $user->getId();
            $userRole = $user->getRoles();

            $pendingApplicants = $this->getPendingApplicants($userId, $user->getRoles(), '0');
            $unReadMessagesCount = $this->getUnreadMessagesCount($userId);
            $unReadMessages = $this->getMyInboxNewMessages($userId); 
            $todaysReminders = $this->getTodaysReminders($user->getId());
            $todoReminders = $this->getTodoReminders($userId);
            $todoCompletedReminders = $this->getCompletedReminders($userId);
            $todoRemindersCount = count($todoReminders);
            $todoCompletedRemindersCount = count($todoCompletedReminders);
            $totalRemindersCount = $todoRemindersCount + $todoCompletedRemindersCount;

            if($todoRemindersCount > 0) {
                 $percentageForItem = $totalRemindersCount/$todoRemindersCount;
                 $percentage = ($todoCompletedRemindersCount/$totalRemindersCount)*100;
             } else {
                 $percentageForItem = 0;
                 $percentage = 100;
             }

            $dateRange['newApplicantList'] = $this->getUserApplicantsListReports($user->getId(), $user->getRoles(), $status='3', $page=0, $searchName = '', 
                    $searchQualification = '', $startDate = date('Y-m-d'), $endDate = date('Y-m-d'), $searchTime = null);
            
           if(is_array($unReadMessages)){
                foreach($unReadMessages as $key => $messages){
                    $classNameSpace = get_class($messages->getSent());
                    $classNameSpace = str_replace("GqAus\UserBundle\Entity\\", "", $classNameSpace);
                    $results[$classNameSpace][] = $messages;
                }
           }
            
           $usersDashboardInfo = array('todaysReminders' => $todaysReminders,
                'unReadMessagesCount' => $unReadMessagesCount,
                'pendingApplicantsCount' => count($pendingApplicants),
                'pendingApplicants' => $pendingApplicants,

                'newApplicantList' => $dateRange['newApplicantList']['applicantList'],
                'percentage' => $percentage,
                'todoReminders' => $todoReminders,
                'completedReminders' => $todoCompletedReminders,
                'todoRemindersCount' => $todoRemindersCount,
                'completedRemindersCount' => $todoCompletedRemindersCount,
                'totalRemindersCount' => $totalRemindersCount);

            if (in_array('ROLE_FACILITATOR', $userRole)){
                $assesorApplicants = $this->getFacilitatorApplicantsWithAssesorByDateRange($userId);
                $usersDashboardInfo['applicantsWithAssesor'] = $assesorApplicants;
                $dateRangeRecordsCount = $this->getFacilitatorPortfolioCounts($userId, $userRole);
                $usersDashboardInfo['dateRangeRecords'] = $dateRangeRecordsCount;
            }
           
            if (in_array('ROLE_FACILITATOR', $userRole) || in_array('ROLE_ASSESSOR', $userRole)) {
                $rtoApplicants = $this->getUserApplicantsWithRtoByDateRange($user);
                $usersDashboardInfo['applicantsWithRto'] = $rtoApplicants;
                $eightyDaysOlderApplicantList = $this->getUserApplicantsByRoleDateRange($userId, $userRole, '2', '80', '', true);
                $usersDashboardInfo['eightyDaysApplicantList'] = $eightyDaysOlderApplicantList;
                
                if(is_array($pendingApplicants)){
                    $userIds = ''; $courseUnit = '';
                     foreach($pendingApplicants as $key => $value){
                         $evidenceCompleteness = $this->getEvidenceCompleteness($value->getUser()->getId(), $value->getCourseCode());
                         if(str_replace('%', '', $evidenceCompleteness) > '80'){
                             $evidenceComp['eightyPercEvd'][] = $value;
                         }
                     }
                     $evidences = $this->getPendingApplicantEvidences($user);
                 }
                 $evidencesCount = (isset($evidences)) ? count($evidences) : 0;
                 $newEvidenceStartDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')));
                 $newEvidences = '';
                 if($evidencesCount > 0) {
                     foreach($evidences as $evidenceFile){
                         if($evidenceFile->getType() != 'text'){
                             $dateOfTheFile = date('Y-m-d', strtotime($evidenceFile->getCreated()));
                             if(strtotime($newEvidenceStartDate) <= strtotime($dateOfTheFile)){
                                 $newEvidences[] = $evidenceFile;
                             }
                         }
                     }
                 }
                $usersDashboardInfo['evidencesCount'] = $evidencesCount;
                $usersDashboardInfo['newEvidences'] = $newEvidences;
            }

            if (in_array('ROLE_RTO', $userRole)){
                $appReadyForApproval = $this->getApplicantsReadyForRtoApproval($userId);
                $fourDayLeftApplicants = $this->getLessDayApplicantsByRto($userId);
                $progressProfiles = $this->getUserApplicantsListReports($userId, $userRole, '3', 0);
                $rtoProgressAssesments = $progressProfiles['applicantList'];
                $usersDashboardInfo['rtoApproval'] = (isset($appReadyForApproval) && !empty($appReadyForApproval)) ? $appReadyForApproval : '';
                $usersDashboardInfo['rtoFourDaysList'] = (isset($fourDayLeftApplicants) && !empty($fourDayLeftApplicants)) ? $fourDayLeftApplicants : '';
                $usersDashboardInfo['rtoProgressList'] = (isset($rtoProgressAssesments) && !empty($rtoProgressAssesments)) ? $rtoProgressAssesments : '';
            }
            
           $usersDashboardInfo['facMsg'] = (isset($results) && isset($results['Facilitator'])) ? $results['Facilitator'] : '';
           $usersDashboardInfo['assMsg'] = (isset($results) && isset($results['Assessor'])) ? $results['Assessor'] : '';
           $usersDashboardInfo['rtoMsg'] = (isset($results) && isset($results['Rto'])) ? $results['Rto'] : '';
           $usersDashboardInfo['appMsg'] = (isset($results) && isset($results['Applicant'])) ? $results['Applicant'] : '';
           $usersDashboardInfo['eightyPercEvd'] = (isset($evidenceComp) && isset($evidenceComp['eightyPercEvd'])) ? $evidenceComp['eightyPercEvd'] : '';

           return $usersDashboardInfo;
        }
    }

    /**
     * Function to get pending applicant evidences
     * @param array $user
     * return array $evidences
     */
    public function getPendingApplicantEvidences($user)
    {
        $userId = $user->getId();     
        $qb = $this->em->createQueryBuilder()
            ->select('evd')
            ->from('GqAusUserBundle:UserCourses', 'uc')
            ->leftJoin('GqAusUserBundle:Evidence','evd','WITH','uc.user=evd.user and evd.course = uc.courseCode')
            ->leftJoin('GqAusUserBundle:UserCourseUnits', 'ucu','WITH','evd.user = ucu.user and evd.course = ucu.courseCode and evd.unit = ucu.unitId')
            ->where('uc.facilitator = :facilitator')
            ->andWhere('uc.courseStatus <> 0')
            ->andWhere('ucu.facilitatorstatus = 0')
            ->setParameter('facilitator', $userId);
            $evidences = $qb->getQuery()->getResult();

        return $evidences;
    }

    /**
     * Function to get todays reminders
     * @param int $userId
     * return array
     */
    public function getTodaysReminders($userId)
    {
        $date = date('Y-m-d');
        $fields = 'partial r.{id, completed, message, course}, partial u.{id, firstName, lastName}';
        $query = $this->em->getRepository('GqAusUserBundle:Reminder')
            ->createQueryBuilder('r')
            ->select($fields)
            ->leftJoin('r.createdby', 'u')
            ->where('r.user = :userId and r.completed = 0 and r.date LIKE :date')
            ->setParameter('userId', $userId)->setParameter('date', $date . '%')
            ->addOrderBy('r.date', 'ASC');
        $getReminders = $query->getQuery()->getResult();
        return $getReminders;
    }
    
    /**
     * Function to check reminder exists or not
     * @param int $userId
     * @param string $reminderTypeId
     * @param string $type null
     * return array
     */
    public function checkReminderExists($userId, $reminderTypeId, $type = '')
    {
        $parameters = array('user' => $userId, 'completed' => '0');
        if($type != ''){
            $parameters['reminderTypeId'] = $reminderTypeId;
            $parameters['reminderType'] = $type;
        } else {
            $parameters['course'] = $reminderTypeId;
        }

        $checkReminder = $this->em->getRepository('GqAusUserBundle:Reminder')->findBy($parameters);
        $remindersCount = count($checkReminder);
        if($remindersCount > 0) {
            $result = array('playlistIcon' => 'playlist_add_check',
                            'playlistIconClass' => 'disable', 
                            'calendarClass' => 'hide');
        } else {
            $result = array('playlistIcon' => 'playlist_add', 'playlistIconClass' => '', 'calendarClass' => '');
        }
        $result['parameters'] = $parameters;
        return $result;
    }

    /**
     * function to send external email
     * @param string $toEmail
     * @param string $subject
     * @param string $body
     * @param string $fromEmail
     * @param string $fromUserName
     * return integer
     */
    public function sendExternalEmail($toEmail, $subject, $body, $fromEmail = '', $fromUserName = '')
    {
        if ($toEmail != '' && $subject != '' && $body != '') {
            if ($fromEmail == '' && $fromUserName == '') {
                $fromEmail = $this->container->getParameter('fromEmailAddress');
                $fromUserName = 'Online RPL';
            }
            $emailContent = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom(array($fromEmail => $fromUserName))
                ->setTo($toEmail)
                ->setBody($body)
                ->setContentType('text/html');
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
     * @param int $id
     * @param int $flag
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
     * @param int $userId
     * @param string $courseCode
     * return string
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
                ->select('DISTINCT e.unit')
                ->where(sprintf('e.%s = :%s', 'user', 'user'))->setParameter('user', $userId)
                ->andWhere(sprintf('e.%s = :%s', 'course', 'course'))->setParameter('course', $courseCode)
                ->andWhere('e instance of GqAusUserBundle:Evidence\Text');
            $applicantList = $res->getQuery()->getResult();
            $evidenceCount = count($applicantList);
            $completeness = ($evidenceCount / $totalNoCourses) * 100;
        }
        return round($completeness) . '%';
    }
/**
     * Function to get Evidence Completeness
     * @param int $userId
     * @param string $courseCode
     * return string
     */
    public function getEvidenceCompletenessCount($userId, $courseCode = null)
    {
        $completeness = 0;
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'status' => '1'));
        $totalNoCourses = count($courseUnitObj);
        if ($totalNoCourses > 0) {
            $res = $this->em->getRepository('GqAusUserBundle:Evidence')
                ->createQueryBuilder('e')
                ->select('DISTINCT e.unit')
                ->where(sprintf('e.%s = :%s', 'user', 'user'))->setParameter('user', $userId)
                ->andWhere(sprintf('e.%s = :%s', 'course', 'course'))->setParameter('course', $courseCode)
                ->andWhere('e instance of GqAusUserBundle:Evidence\Text');
            $applicantList = $res->getQuery()->getResult();
            $evidenceCount = count($applicantList);
            $completeness = ($evidenceCount / $totalNoCourses) * 100;
        }
        return round($completeness);
    }
    /**
     * Function to fetch assessor other files
     * @param int $userId
     * @param string $type
     * return array
     */
    public function fetchOtherFiles($userId, $type = null)
    {
        $Otherfiles = $this->em->getRepository('GqAusUserBundle:OtherFiles');
        $params['assessor'] = $userId;
        if ($type) {
            $params['type'] = $type;
        }
        $files = $Otherfiles->findBy($params);
        return $files;
    }

    /**
     * Function to delete assessor other files
     * @param id $FileId
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
     * @param int $id
     * return string
     */
    public function getTimeRemaining($id)
    {
        $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->createQueryBuilder('c')
                ->select('DATE_DIFF(c.targetDate, c.createdOn) as diff')
                ->where(sprintf('c.%s = :%s', 'id', 'id'))->setParameter('id', $id);
        $applicantList = $res->getQuery()->getResult();
        /* $diff = (($applicantList[0]['diff']) / 7);
        if (is_float($diff)) {
            $diff = $diff + 1;
        }
        return floor($diff) . ' week(s)'; */
		return $applicantList[0]['diff'];
    }

    /**
     * Function to get unread messages count
     * @param int $userId
     * return string
     */
    public function getUnreadMessagesCount($userId)
    {
        $getMessages = $this->getUnreadMessages($userId);
        return count($getMessages);
    }

    /**
     * Function to get unread messages
     * @param int $userId
     * return array
     */
    public function getUnreadMessages($userId)
    {
        $getMessages = $this->em->getRepository('GqAusUserBundle:Message')->findBy(array('inbox' => $userId,
            'read' => '0', 'toStatus' => '0'));
        return $getMessages;
    }
    
    /**
     * Function to get inbox messages
     * @param int $userId
     * return array
     */
    public function getMyInboxNewMessages($userId){
        $endDateTimeMin = '00:00:00.000000';
        $startDateTimeMin = '23:59:59.999999';
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')))." ".$startDateTimeMin;
        $dateEnd = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')))." ".$endDateTimeMin;
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select('m')
            ->where(sprintf('m.%s = :%s', 'inbox', 'inbox'))->setParameter('inbox', $userId)
            ->andWhere('m.created BETWEEN '."'".$dateEnd."' AND '".$dateStart."'")
            ->addOrderBy('m.created', 'DESC');
        $messages = $query->getQuery()->getResult();
        return $messages;
    }


    /**
    * Function to get inbox messages
    * @param int $userId
    * @param int $page
    * return array
    */
   public function getMyInboxMessages($userId, $page)    
    {
        if ($page <= 0) {
            $page = 1;
        }        
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select('m')
            ->where(sprintf('m.%s = :%s', 'inbox', 'inbox'))->setParameter('inbox', $userId)
            ->andWhere(sprintf('m.%s = :%s', 'toStatus', 'toStatus'))->setParameter('toStatus', '0')            
            ->orWhere(sprintf('m.%s = :%s', 'sent', 'sent'))->setParameter('sent', $userId)
            ->andWhere(sprintf('m.%s = :%s', 'fromStatus', 'fromStatus'))->setParameter('fromStatus', '0')
            ->andWhere(sprintf('m.%s = :%s', 'toStatus', 'toStatus'))->setParameter('toStatus', '0')
            ->addOrderBy('m.created', 'DESC');
        $getMessages = $query->getQuery()->getResult();        
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($query, $page, $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator,'sentuserid' => $userId);
        
       // return array('messages' => $getMessages,'sentuserid' => $userId);
        
    }

    /**
     * Function to save the message
     * @param object $sentuser
     * @param object $curuser
     * @param array $msgdata
     */
    public function saveMessageData($sentuser, $curuser, $msgdata)
    {
        $msgObj = new Message();
        $msgObj->setInbox($sentuser);
        $msgObj->setSent($curuser);
        $msgObj->setSubject($msgdata['subject']);
        $msgObj->setMessage($msgdata['message']);
        $msgObj->setRead(0);
        $msgObj->setFromStatus(0);
        $msgObj->setToStatus(0);
        $msgObj->setReply(0);
        $msgObj->setunitID($msgdata['unitId']);
		$msgObj->setreplymid($msgdata['replymid']);
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to get sent messages
     * @param int $userId
     * @param int $page
     * return array
     */
    public function getMySentMessages($userId, $page)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select('m')
            ->where(sprintf('m.%s = :%s', 'sent', 'sent'))->setParameter('sent', $userId)
            ->andWhere(sprintf('m.%s = :%s', 'fromStatus', 'fromStatus'))->setParameter('fromStatus', '0')
            ->addOrderBy('m.created', 'DESC');
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($query, $page, $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator);
    }

    /**
     * Function to get trashed messages
     * @param int $userId
     * @param int $page
     * return array
     */
    public function getMyTrashMessages($userId, $page)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select('m');
        $query->andWhere(sprintf('m.%s = :%s AND m.%s = :%s', 'inbox', 'inbox', 'toStatus', 'toStatus'))
            ->setParameter('inbox', $userId)
            ->setParameter('toStatus', '1');
        $query->orWhere(sprintf('m.%s = :%s AND m.%s = :%s', 'sent', 'sent', 'fromStatus', 'fromStatus'))
            ->setParameter('sent', $userId)
            ->setParameter('fromStatus', '1')
            ->addOrderBy('m.created', 'DESC');
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($query, $page, $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator);
    }

    /**
     * Function to mark as read / unread
     * @param int $id
     * @param int $flag
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
     * @param int $id
     * @param int $flag
     * @param string $type
     */
    public function setUserDeleteStatus($id, $flag, $type)
    {
        $msgObj = $this->em->getRepository('GqAusUserBundle:Message')->find($id);
        switch ($type) {
            case 'to':
                $msgObj->setToStatus($flag);
                break;
            case 'from':
                $msgObj->setFromStatus($flag);
                break;
        }
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to delete messages from tash
     * @param int $userId
     * @param int $id
     * @param string $flag
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
     * @param int $mid
     * return array
     */
    public function getMessage($mid)
    {
        return $this->em->getRepository('GqAusUserBundle:Message')->find($mid);
    }
	
    /**
     * Function to get messages to view
     * @param int $mid
     * return array
     */
    public function getReplyMessages($mid)
    {
        $msgobj = $this->em->getRepository('GqAusUserBundle:Message')->find($mid); 
        $replymid = $msgobj->getreplymid();   
        if($replymid > 0) {
            $query = $this->em->getRepository('GqAusUserBundle:Message')
                ->createQueryBuilder('m')
                ->select('m')
                ->where(sprintf('m.%s = :%s', 'id', 'id'))->setParameter('id', $replymid)
                ->orWhere(sprintf('m.%s = :%s', 'replymid', 'replymid'))->setParameter('replymid', $replymid);
        } else {
            $query = $this->em->getRepository('GqAusUserBundle:Message')
                ->createQueryBuilder('m')
                ->select('m')
                ->where(sprintf('m.%s = :%s', 'id', 'id'))->setParameter('id', $mid);
        }        
        $getMessages = $query->getQuery()->getResult(); 
        return $getMessages; 
    }
        /**
     * Function to get inbox messages
     * @param int $userId
     * @param int $page
     * return array
     */
    public function getMyReplyMessages($replymid)
    {
    $getReplyId = $this->em->getRepository('GqAusUserBundle:Message')->findOneBy(array('id' => $replymid));
    $replymid = $getReplyId->getreplymid(); 
    $repMsgs = array();
    if($replymid != 0) {
        $repMsgs = $this->em->getRepository('GqAusUserBundle:Message')->findBy(array('replymid' => $replymid));
            return $repMsgs;
    }
    }
    /**
     * Check Messages Role wise Authentication
     * @param: $touserInfo and $fromuserInfo
     */
    public function checkMessage($touser){ 
        $response = 1;
        $fromuserInfo = $this->getCurrentUser();
        $touserInfo = $this->getRequestUser($touser);       
        $fromuserRole = $fromuserInfo->getRole(); 
        $touserRole = $touserInfo->getRole(); 
        if(($fromuserRole == 1 || $fromuserRole == 3 || $fromuserRole == 4) && $touserRole!='2')
        {
            $response = 0;
        }       
        return $response;
    }
     /* Display usernames in New message Role wise Authentication
     * @param: $userRole
     */
        public function getUsernamesbyRoles($options = array(),$userRole) {        
        $query = $this->em->getRepository('GqAusUserBundle:User')
            ->createQueryBuilder('u')
            ->select( "CONCAT( CONCAT(u.firstName, ' '), u.lastName)" );
        $nameCondition = "";
        if ($userRole == 'ROLE_APPLICANT' || $userRole == 'ROLE_ASSESSOR' ||$userRole == 'ROLE_RTO' ) {            
            $query->where('(u instance of GqAusUserBundle:Facilitator)');
            $nameCondition .= "u.firstName LIKE '%" . $options['keyword'] . "%' "
                        . "OR u.lastName LIKE '%" . $options['keyword'] . "%'";
            $query->andWhere($nameCondition);       
        }
        else if ($userRole == 'ROLE_FACILITATOR') {
            $query->where('(u instance of GqAusUserBundle:Applicant OR u instance '
                    . 'of GqAusUserBundle:Assessor OR u instance of GqAusUserBundle:Rto)');
            $nameCondition .= "u.firstName LIKE '%" . $options['keyword'] . "%' "
                        . "OR u.lastName LIKE '%" . $options['keyword'] . "%'";
            $query->andWhere($nameCondition);            
        }
            $getMessages = $query->getQuery()->getResult(); 
            $getMessages = array_map("unserialize", array_unique(array_map("serialize", $getMessages)));
            sort($getMessages);
            //echo "<pre>"; dump($getMessages); 
            return $getMessages;
        }	

    /**
     * Function to set the read messages status
     * @param int $mid
     */
    public function setReadViewStatus($mid)
    {
        $msgObj = $this->em->getRepository('GqAusUserBundle:Message')->find($mid);
        $msgObj->setRead('1');
        $this->em->persist($msgObj);
        $this->em->flush();
    }

    /**
     * Function to send message to inbox
     * @param int $toUserId
     * @param int $fromUserId
     * @param string $subject
     * @param string $message
     * @param string $unitId
     */
    public function sendMessagesInbox($toUserId, $fromUserId, $subject, $message, $unitId = '')
    {
        $inbox = $this->getUserInfo($toUserId);
        $sent = $this->getUserInfo($fromUserId);
        $msgInfo = array('subject' => $subject, 'message' => $message, 'unitId' => $unitId, 'replymid' => '');
        $this->saveMessageData($inbox, $sent, $msgInfo);
    }

    /**
     * Function to send message to inbox
     * @param string $image
     * return string
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
     * @param string $date
     * return string
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
            case 0: $word = 'Today';
                break;
            case 1: $word = 'Yesterday';
                break;
            case ($days >= 2 && $days <= 6):
                $word = sprintf("%d days ago", $days);
                break;
            case ($days >= 7 && $days < 14):
                $word = '1 week ago';
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
     * @param string $courseCode
     * @param int $applicantId
     */
    public function rtoApproveCertification($courseCode, $applicantId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->findOneBy(array('courseCode' => $courseCode, 'user' => $applicantId));
        if (!empty($courseObj)) {
            $courseObj->setCourseStatus('16');
            $courseObj->setRtostatus('1');
            $courseObj->setRtoDate(date('Y-m-d H:i:s'));
            $this->em->persist($courseObj);
            $this->em->flush();

            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#');
            $subReplace = array($courseObj->getCourseCode(), $courseObj->getCourseName());
            $messageSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('msg_rto_issue_certificate_sub'));
            $mailSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('mail_rto_issue_certificate_sub'));

            // finding and replacing the variables from message templates
            $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#fromUserName#');
            $facMsgReplace = array($courseObj->getFacilitator()->getUsername(), $courseObj->getCourseCode(),
                $courseObj->getCourseName(), $courseObj->getRto()->getUsername());
            $facMessageBody = str_replace($msgSearch, $facMsgReplace,
                $this->container->getParameter('msg_rto_issue_certificate_con'));
            $facMailBody = str_replace($msgSearch, $facMsgReplace,
                $this->container->getParameter('mail_rto_issue_certificate_con'));

            // send the external mail and internal message to facilitator
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            $this->sendExternalEmail($courseObj->getFacilitator()->getEmail(), $mailSubject, $facMailBody,
                $courseObj->getRto()->getEmail(), $courseObj->getRto()->getUsername());
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
            $this->sendMessagesInbox($courseObj->getFacilitator()->getId(), $courseObj->getRto()->getId(),
                $messageSubject, $facMessageBody, '');

            // send the external mail and internal message to applicant
            // re creating message data by replacing applicant values
            $aplMsgReplace = array($courseObj->getUser()->getUsername(), $courseObj->getCourseCode(),
                $courseObj->getCourseName(), $courseObj->getFacilitator()->getUsername());
            $aplMessageBody = str_replace($msgSearch, $aplMsgReplace,
                $this->container->getParameter('msg_rto_issue_certificate_con'));
            $aplMailBody = str_replace($msgSearch, $aplMsgReplace,
                $this->container->getParameter('mail_rto_issue_certificate_con'));
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            $this->sendExternalEmail($courseObj->getUser()->getEmail(), $mailSubject, $aplMailBody,
                $courseObj->getFacilitator()->getEmail(), $courseObj->getFacilitator()->getUsername());
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
            $this->sendMessagesInbox($courseObj->getUser()->getId(), $courseObj->getFacilitator()->getId(),
                $messageSubject, $aplMessageBody, '');
        }
    }

    /**
     * Function to save applicant data
     * @param object $request
     * return string
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
                $data['applicantStatus'] = '1';
                $user = $this->addPersonalProfile('ROLE_APPLICANT', $data);
                $message = 'User added successfully!';
                $emailFlag = 'U';
            } else {
                $data['applicantStatus'] = '0';
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

            // finding and replacing the variables from message templates
            $subSearch = array('#courseCode#', '#courseName#');
            $subReplace = array($courseData['courseCode'], $courseData['courseName']);

            // finding and replacing the variables from message templates
            $msgSearch = array('#firstName#', '#lastName#', '#courseCode#', '#courseName#',
                '#applicationUrl#', '#email#', '#password#');
            $msgReplace = array($data['firstname'], $data['lastname'], $courseData['courseCode'],
                $courseData['courseName'], $this->container->getParameter('applicationUrl'), $data['email'],
                $data['newpassword']);

            if ($emailFlag == 'U' && $emailCourseFlag == 'Q') {
                $mailSubject = str_replace($subSearch, $subReplace,
                    $this->container->getParameter('mail_add_user_course_sub'));
                $mailBody = str_replace($msgSearch, $msgReplace,
                    $this->container->getParameter('mail_add_user_course_con'));
            } elseif ($emailFlag == 'U') {
                $mailSubject = str_replace($subSearch, $subReplace,
                    $this->container->getParameter('mail_account_creation_sub'));
                $mailBody = str_replace($msgSearch, $msgReplace,
                    $this->container->getParameter('mail_account_creation_con'));
            } elseif ($emailCourseFlag == 'Q') {
                $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_add_course_sub'));
                $mailBody = str_replace($msgSearch, $msgReplace, $this->container->getParameter('mail_add_course_con'));
            }

            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            $this->sendExternalEmail($data['email'], $mailSubject, $mailBody,
                $this->container->getParameter('fromEmailAddress'), 
                $this->container->getParameter('default_from_username'));
        }
        echo $message;
        exit;
    }

    /**
     * Function to add user course
     * @param int $courseData
     * @param object $user
     * return array
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
     * @param string $courseCode
     * @param int $userId
     * return integer
     */
    public function checkUserCourseExist($courseCode, $userId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->findOneBy(array('courseCode' => $courseCode, 'user' => $userId));
        return count($courseObj);
    }

    /*
     * Function to set the assessor and rto to applicant profile
     * @param int $courseId
     * @param string $role
     * @param int $userId
     * return array
     */

    public function setRoleUsersForCourse($courseId, $role, $userId)
    {
        $course = $this->em->getRepository('GqAusUserBundle:UserCourses')->find($courseId);
        $user = $this->getUserInfo($userId);
        if ($role == Rto::ROLE) {
            $course->setRto($user);
        } else if ($role == Assessor::ROLE) {
            $course->setAssessor($user);
        } else if ($role == Facilitator::ROLE) {
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
     * @param string $role
     * return array
     */

    public function getUsers($role)
    {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare('SELECT id, first_name as firstname, last_name as lastname FROM user'
            . ' WHERE role_type = :role AND status = 1');
        $statement->bindValue('role', $role);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Function to send start competency conversation notification to applicant
     * @param string $courseCode
     * @param int $applicantId
     * @param int $assessorId
     * @param int $roomId
     */
    public function sendConversationMessage($courseCode, $applicantId, $assessorId, $roomId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->findOneBy(array('courseCode' => $courseCode, 'user' => $applicantId));
        $applicant = $this->getUserInfo($applicantId);
        $assessor = $this->getUserInfo($assessorId);

        // finding and replacing the variables from message templates
        $subSearch = array('#courseCode#', '#courseName#');
        $subReplace = array($courseObj->getCourseCode(), $courseObj->getCourseName());
        $messageSubject = str_replace($subSearch, $subReplace,
            $this->container->getParameter('msg_conversation_invitation_sub'));
        $mailSubject = str_replace($subSearch, $subReplace,
            $this->container->getParameter('mail_conversation_invitation_sub'));

        // finding and replacing the variables from message templates
        $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#applicationUrl#', '#roomId#', '#fromUserName#');
        $facMsgReplace = array($courseObj->getFacilitator()->getUsername(), $courseObj->getCourseCode(),
            $courseObj->getCourseName(), $this->container->getParameter('applicationUrl'), $roomId,
            $assessor->getUsername());
        $facMessageBody = str_replace($msgSearch, $facMsgReplace,
            $this->container->getParameter('msg_conversation_invitation_con'));
        $facMailBody = str_replace($msgSearch, $facMsgReplace,
            $this->container->getParameter('mail_conversation_invitation_con'));

        // send the external mail and internal message to facilitator
        /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
        /*$this->sendExternalEmail($courseObj->getFacilitator()->getEmail(), $mailSubject, $facMailBody,
            $assessor->getEmail(), $assessor->getUsername());*/
        /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
        $this->sendMessagesInbox($courseObj->getFacilitator()->getId(), $assessor->getId(), $messageSubject,
            $facMessageBody, '');

        // send the external mail and internal message to applicant
        // re creating message data by replacing facilitator values
        $aplMsgReplace = array($applicant->getUsername(), $courseObj->getCourseCode(), $courseObj->getCourseName(),
            $this->container->getParameter('applicationUrl'), $roomId, $courseObj->getFacilitator()->getUsername());
        $aplMessageBody = str_replace($msgSearch, $aplMsgReplace,
            $this->container->getParameter('msg_conversation_invitation_con'));
        $aplMailBody = str_replace($msgSearch, $aplMsgReplace,
            $this->container->getParameter('mail_conversation_invitation_con'));
        /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
      /*  $this->sendExternalEmail($applicant->getEmail(), $mailSubject, $aplMailBody,
            $courseObj->getFacilitator()->getEmail(), $courseObj->getFacilitator()->getUsername()); */
        /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
        $this->sendMessagesInbox($applicant->getId(), $courseObj->getFacilitator()->getId(), $messageSubject,
            $aplMessageBody, '');
    }

    /**
     * Function to get todo reminders
     * @param int $userId
     * return array
     */
    public function getTodoReminders($userId)
    {
        $todayTime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:00") );
       // dump($today_enddatetime); exit;
        $fields = 'partial r.{id, completed, message, date, course, reminderType, reminderTypeId}, partial u.{id, firstName, lastName}';
        $query = $this->em->getRepository('GqAusUserBundle:Reminder')
            ->createQueryBuilder('r')
            ->select($fields)
            ->leftJoin('r.createdby', 'u')
            ->where('r.user = :userId and r.completed = 0')->setParameter('userId', $userId)
            ->andWhere('r.date <= :todayTime')->setParameter('todayTime', $todayTime)
            ->addOrderBy('r.date', 'DESC');
        $getReminders = $query->getQuery()->getResult();
        return $getReminders;
    }

    /**
     * Function to get self assessment
     * @param int $userId
     * @param string $courseCode
     * @param string $UnitCode
     * return array
     */
    public function getSelfAssessmentFromUnit($userId, $courseCode, $unitCode){
        $connection = $this->em->getConnection();
        $statement = $connection->prepare('SELECT * FROM evidence as e,evidence_text as et WHERE e.user_id = :applicantId AND e.unit_code = :unitCode AND e.course_code = :courseCode AND e.type = :type AND e.id=et.id');
        $statement->bindValue('applicantId', $userId);
        $statement->bindValue('courseCode', $courseCode);
        $statement->bindValue('unitCode', $unitCode);
        $statement->bindValue('type', 'text');
        $statement->execute();
        $allRcrds = $statement->fetchAll();
        return $allRcrds;
    }    

    /**
     * Function to get completed reminders
     * @param int $userId
     * return array
     */
    public function getCompletedReminders($userId)
    {
        $todayTimeStart = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:01") );
        $todayTimeEnd = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 23:59:59") );
        $fields = 'partial r.{id, completed, message, date, course, reminderType, reminderTypeId}, partial u.{id, firstName, lastName}';
        $query = $this->em->getRepository('GqAusUserBundle:Reminder')
            ->createQueryBuilder('r')
            ->select($fields)
            ->leftJoin('r.createdby', 'u')
            ->where('r.user = :userId and r.completed = 1')->setParameter('userId', $userId)
            ->andWhere('r.completedDate > :todayTimeStart')->setParameter('todayTimeStart', $todayTimeStart)
            ->andWhere('r.completedDate < :todayTimeEnd')->setParameter('todayTimeEnd', $todayTimeEnd)
            ->addOrderBy('r.completedDate', 'desc');
        $getReminders = $query->getQuery()->getResult();

        $query = $query->getQuery();

        return $getReminders;
    }

    /**
     * Function to convert date time to words
     * @param string $date
     * @param string $tab
     * return string
     */
    public function toDoDateToWords($date, $tab)
    {

        $ts1 = strtotime(date('Y-m-d', strtotime($date)));
        $ts2 = strtotime(date('Y-m-d'));

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
                $word = date('h:i A', strtotime($date));
                break;
            case 1: $word = 'Tomorrow';
                break;
            case -1: $word = 'Yesterday';
                break;
            case ($days >= 2 && $days <= 6):
                $word = sprintf('%d days later', $days);
                break;
            case ($days >= -6 && $days <= -2):
                $word = substr(sprintf('%d days ago', $days), 1);
                break;
            case ($days >= 7 && $days < 14):
                $word = '1 week later';
                break;
            case ($days > -14 && $days <= -7):
                $word = '1 week ago';
                break;
            case ($days >= 14 && $days <= 365):
                $word = sprintf('%d weeks later', intval($days / 7));
                break;
            case ($days >= -365 && $days <= -14):
                $word = substr(sprintf('%d weeks ago', intval($days / 7)), 1);
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
     * @param int $applicantId
     * @param string $userRole
     * @param string $unitId
     * @param string $courseCode
     * return integer
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
     * @param int $applicantId
     * @param string $unitId
     * @param string $courseCode
     * return integer
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
     * @param string $unitId
     * @param int $toId
     * @param int $fromId
     * return array
     */
    public function getFacilitatorApplicantMessages($unitId, $toId, $fromId)
    {
        $query = $this->em->getRepository('GqAusUserBundle:Message')
            ->createQueryBuilder('m')
            ->select('m')
            ->where('m.unitID = :unitId')->setParameter('unitId', $unitId)
            ->andWhere('m.inbox = :toId and m.sent = :fromId or m.inbox = :fromId and m.sent = :toId')
            ->setParameter('toId', $toId)->setParameter('fromId', $fromId)
            ->addOrderBy('m.created', 'DESC');
        $messages = $query->getQuery()->getResult();
        return $messages;
    }

    /**
     * Function to get Id file by id
     * @param int $IdFileId
     * return array
     */
    public function getIdFileById($IdFileId)
    {
        $IdObj = $this->em->getRepository('GqAusUserBundle:UserIds');
        return $IdObj->find($IdFileId);
    }

    /**
     * Function to get managers pending applicants count
     * @param int $userId
     * @param string $userRole
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
     * @param int $userId
     * @param string $userTypeStatus
     * @param string $status
     * return integer
     */
    public function applicantsCount($userId, $userTypeStatus, $status)
    {
        $qb = $this->em->getRepository('GqAusUserBundle:UserCourses')->createQueryBuilder('c');
        switch ($userTypeStatus) {
            case 'facilitatorstatus':
                $qb->where(sprintf('c.%s != :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '0');
                break;
            case 'assessorstatus':
                $avals = array('2', '10', '11', '12', '13', '14');
                $qb->where('c.courseStatus IN (:ids)')->setParameter('ids', $avals);
                break;
            case 'rtostatus':
                $qb->where(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '15');
                break;
        }
        $getCourseStatus = $qb->getQuery()->getResult();
        return count($getCourseStatus);
    }

    /**
     * Function to manage users
     * @param int $userId
     * @param string $userRole
     * @param string $searchName
     * @param string $searchType
     * @param int $page
     * return array
     */
    public function manageUsers($userId, $userRole, $searchName = '', $searchType = '', $page = null)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $nameCondition = null;
        $fields = 'partial u.{id, firstName, lastName}';
        $res = $this->em->getRepository('GqAusUserBundle:User')
            ->createQueryBuilder('u')
            ->select($fields);
        if (!empty($searchType)) {
            switch ($searchType) {
                case 2:
                    $res->where('u instance of GqAusUserBundle:Facilitator');
                    break;
                case 3:
                    $res->where('u instance of GqAusUserBundle:Assessor');
                    break;
                case 4:
                    $res->where('u instance of GqAusUserBundle:Rto');
                    break;
                case 5:
                    $res->where('u instance of GqAusUserBundle:Manager');
                    break;
            }
        } else {
            if ($userRole == 'ROLE_SUPERADMIN') {
                $res->where('(u instance of GqAusUserBundle:Facilitator OR u instance '
                    . 'of GqAusUserBundle:Assessor OR u instance of GqAusUserBundle:Rto OR'
                    . ' u instance of GqAusUserBundle:Manager)');
            } else {
                $res->where('(u instance of GqAusUserBundle:Facilitator OR u instance '
                    . 'of GqAusUserBundle:Assessor OR u instance of GqAusUserBundle:Rto)');
            }
        }

        if (!empty($searchName)) {
            $searchNamearr = explode(" ", $searchName);
            for ($i = 0; $i < count($searchNamearr); $i++) {
                if ($i == 0) {
                    $nameCondition .= "u.firstName LIKE '%" . $searchNamearr[$i] . "%' "
                        . "OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
                } else {
                    $nameCondition .= " OR u.firstName LIKE '%" . $searchNamearr[$i] . "%' "
                        . "OR u.lastName LIKE '%" . $searchNamearr[$i] . "%'";
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
     * @param int $userId
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
        $statement = $connection->prepare("SELECT id, first_name as firstname, last_name as lastname, "
            . "role_type as roletype, CONCAT(first_name, ' ', last_name) as username FROM user WHERE"
            . " (role_type = :frole OR role_type = :arole) ORDER BY role_type");
        $statement->bindValue('frole', Facilitator::ROLE);
        $statement->bindValue('arole', Assessor::ROLE);
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }

    /**
     * Function to get qualification status
     * return array
     */
    public function getQualificationStatus()
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
     * function to filtering an array
     * @param array $array
     * @param string $index
     * @param string $value
     * return array
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
        $statusList = $this->getQualificationStatus();
        $status = $this->filterByValue($statusList, 'Aactive', 1);
        return $status;
    }

    /**
     * Function to delete users
     * @param int $deluserId
     * @param string $delUserRole
     * return integer
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
     * @param int $userId
     * @param string $delUserRole
     * return integer
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
                ->select('c.id')
                ->where(sprintf('c.%s = :%s', $fieldName, $fieldName))->setParameter($fieldName, $userId)
                ->andWhere('c.courseStatus != 0');
            $result = $res->getQuery()->getResult();
            return count($result);
        }
        return 0;
    }

    /**
     * Function to update users status
     * @param int $userId
     */
    public function updateUserStatus($userId)
    {
        $userObj = $this->em->getRepository('GqAusUserBundle:User')->find($userId);
        $userObj->setStatus(0);
        $this->em->persist($userObj);
        $this->em->flush();
    }

    /**
     * Function to add user profile
     * @param string $role
     * @param array $data
     * @param string $image
     * return array
     */
    public function addPersonalProfile($role, $data, $image = null)
    {
        switch ($role) {
            case 'ROLE_ASSESSOR':
                $userObj = new Assessor();
                break;
            case 'ROLE_FACILITATOR':
                $userObj = new Facilitator();
                break;
            case 'ROLE_MANAGER':
                $userObj = new Manager();
                break;
            case 'ROLE_APPLICANT':
                $userObj = new Applicant();
                break;
            case 'ROLE_RTO':
                $userObj = new Rto();
                break;
            default:
                $userObj = new Applicant();
                break;
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
        $userObj->setApplicantStatus($data['applicantStatus']);
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
        $userObj->setCrmId(isset($data['crmId']) ? trim($data['crmId']) : '');
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
     * @param array $data
     * @param object $userObj
     */
    public function saveUserAddress($data, $userObj)
    {
        $userAddressObj = new UserAddress();
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
     * @param string $emailId
     * retrun array
     */
    public function checkEmailExist($emailId)
    {
        return $this->em->getRepository('GqAusUserBundle:User')->findOneBy(array('email' => $emailId, 'status' => 1));
    }

    /**
     * Function to get CRM User id By Role
     * @param int $crmId
     * retrun array
     */
    public function getCrmUserId($crmId)
    {
        return $this->em->getRepository('GqAusUserBundle:User')->findOneBy(array('crmId' => trim($crmId), 'status' => 1));
    }

    /**
     * Function check emailId exist
     * @param string $emailId
     * retrun integer
     */
    public function emailExist($emailId)
    {
        $user = $this->em->getRepository('GqAusUserBundle:User')->findOneBy(array('email' => $emailId, 'status' => 1));
        dump($user);exit;
        return count($user);
    }

    /**
     * Function to get user assigned qualifications
     * @param int $userId
     * @param string $userType
     * return string
     */
    public function getUserAssignedQualifications($userId, $userType)
    {
        switch ($userType) {
            case '2':
                $fieldName = 'facilitator';
                break;
            case '3':
                $fieldName = 'assessor';
                break;
            case '4':
                $fieldName = 'rto';
                break;
        }
        $userCourses = $this->em->getRepository('GqAusUserBundle:UserCourses')->findBy(array($fieldName => $userId));
        $field = '<div class="gq-applicant-filter-wrap-select">
                    <select name="course_' . $userId . '" id="course_' . $userId . '" class="styled" style="width:200px;">
                            <option value="" selected="selected">Select Qualification</option>';
        if (!empty($userCourses)) {
            foreach ($userCourses as $courses) {
                $field .= '<option value="' . $courses->getId() . '">' . 
                    $courses->getCourseCode() . ' : ' . $courses->getCourseName() . '</option>';
            }
        }
        $field .= '</select>
                    </div><br/>';
        return $field;
    }

    /**
     * Function to update course status
     * @param string $courseStatus
     * @param string $courseCode
     * @param int $applicantId
     * @param string $userRole
     * return array
     */
    public function updateCourseStatus($courseStatus, $courseCode, $applicantId, $userRole)
    {
        $response = array();
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->findOneBy(array('courseCode' => $courseCode,
            'user' => $applicantId));
        if (!empty($courseObj)) {
            if (in_array('ROLE_ASSESSOR', $userRole)) {
                $asrReturnData = $this->assessorStatusChange($courseObj, $courseStatus);
                return $asrReturnData;
            } else {
                $facReturnData = $this->facilitatorStatusChange($courseObj, $courseStatus);
                return $facReturnData;
            }
        } else {
            $response['type'] = 'Error';
            $response['code'] = 0;
            $response['msg'] = 'Error in updating status.';
        }
        return $response;
    }

    /**
     * Function to change qualification status by assessor
     * @param object $courseObj
     * @param int $courseStatus
     * return array
     */
    public function assessorStatusChange($courseObj, $courseStatus)
    {
        $response = array();
        // if the assessor approves the qualification by updating the status
        if ($courseStatus == 3) {
            // checking whether the all units of this qualification has been approved or not
            $unitsApproval = $this->checkAllUnitsApprovalByRole($courseObj, 'assessorstatus');
            if ($unitsApproval == 0) { // if any unit pending approvals or any disapproved unit
                $response['type'] = 'Error';
                $response['code'] = 2;
                $response['msg'] = 'Please approve all the units before approving the qualification.';
                return $response;
            } else {
                $courseObj->setAssessorstatus('1');
                $courseObj->setAssessorDate(date('Y-m-d H:i:s'));
            }
        }
        $courseObj->setCourseStatus($courseStatus);
        $this->em->persist($courseObj);
        $this->em->flush();
        // get status list
        $statusList = $this->getQualificationStatus();

        // finding and replacing the variables from message templates
        $subSearch = array('#courseCode#', '#courseName#');
        $subReplace = array($courseObj->getCourseCode(), $courseObj->getCourseName());

        $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#status#', '#fromUserName#');
        $facMsgReplace = array($courseObj->getFacilitator()->getUsername(), $courseObj->getCourseCode(),
            $courseObj->getCourseName(), $statusList[$courseStatus]['status'], $courseObj->getAssessor()->getUsername());
        $aplMsgReplace = array($courseObj->getUser()->getUsername(), $courseObj->getCourseCode(),
            $courseObj->getCourseName(), $statusList[$courseStatus]['status'], $courseObj->getFacilitator()->getUsername());

        if ($courseStatus == 3) {
            $messageSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('msg_asr_approve_course_sub'));
            $mailSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('mail_asr_approve_course_sub'));
            $facMessageBody = str_replace($msgSearch, $facMsgReplace,
                $this->container->getParameter('msg_asr_approve_course_con'));
            $facMailBody = str_replace($msgSearch, $facMsgReplace,
                $this->container->getParameter('mail_asr_approve_course_con'));
            $aplMessageBody = str_replace($msgSearch, $aplMsgReplace,
                $this->container->getParameter('msg_asr_approve_course_con'));
            $aplMailBody = str_replace($msgSearch, $aplMsgReplace,
                $this->container->getParameter('mail_asr_approve_course_con'));
        } else {
            $messageSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('msg_portfolio_update_sub'));
            $mailSubject = str_replace($subSearch, $subReplace,
                $this->container->getParameter('mail_portfolio_update_sub'));
            $facMessageBody = str_replace($msgSearch, $facMsgReplace,
                $this->container->getParameter('msg_portfolio_update_con'));
            $facMailBody = str_replace($msgSearch, $facMsgReplace,
                $this->container->getParameter('mail_portfolio_update_con'));
            $aplMessageBody = str_replace($msgSearch, $aplMsgReplace,
                $this->container->getParameter('msg_portfolio_update_con'));
            $aplMailBody = str_replace($msgSearch, $aplMsgReplace,
                $this->container->getParameter('mail_portfolio_update_con'));
        }


        // send the external mail and internal message to facilitator
        /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
        $this->sendExternalEmail($courseObj->getFacilitator()->getEmail(), $mailSubject, $facMailBody,
            $courseObj->getAssessor()->getEmail(), $courseObj->getAssessor()->getUsername());
        /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
        $this->sendMessagesInbox($courseObj->getFacilitator()->getId(), $courseObj->getAssessor()->getId(),
            $messageSubject, $facMessageBody, '');

        // send the external mail and internal message to applicant
        // re creating message data by replacing facilitator values
        /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
        $this->sendExternalEmail($courseObj->getUser()->getEmail(), $mailSubject, $aplMailBody,
            $courseObj->getFacilitator()->getEmail(), $courseObj->getFacilitator()->getUsername());
        /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
        $this->sendMessagesInbox($courseObj->getUser()->getId(), $courseObj->getFacilitator()->getId(),
            $messageSubject, $aplMessageBody, '');

        // update the zoho api status
        //$zohoId = '696292000010172044';
        if ($courseObj->getZohoId() != '') {
            $zohoId = $courseObj->getZohoId();
            $zohoUpdateResponse = $this->updateZohoAPIStatus($zohoId, $statusList[$courseStatus]['status']);
            if ($zohoUpdateResponse['msg'] == 'Error') {
                $response = $zohoUpdateResponse;
                return $response;
            }
        }
        $response['type'] = 'Success';
        $response['code'] = 1;
        $response['msg'] = 'Status updated successfully.';
        return $response;
    }

    /**
     * Function to change qualification status by facilitator
     * @param object $courseObj
     * @param int $courseStatus
     * return array
     */
    public function facilitatorStatusChange($courseObj, $courseStatus)
    {
        $response = array();
        $toEmail = $toId = $roleMessageBody = $roleMailBody = '';

        // get status list
        $statusList = $this->getQualificationStatus();

        // finding and replacing the variables from message templates
        $subSearch = array('#courseCode#', '#courseName#');
        $subReplace = array($courseObj->getCourseCode(), $courseObj->getCourseName());
        $messageSubject = str_replace($subSearch, $subReplace,
            $this->container->getParameter('msg_portfolio_update_sub'));
        $mailSubject = str_replace($subSearch, $subReplace,
            $this->container->getParameter('mail_portfolio_update_sub'));

        // finding and replacing the variables from message templates
        $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#status#', '#fromUserName#');
        $aplMsgReplace = array($courseObj->getUser()->getUsername(),
            $courseObj->getCourseCode(), $courseObj->getCourseName(),
            $statusList[$courseStatus]['status'], $courseObj->getFacilitator()->getUsername());
        $aplMessageBody = str_replace($msgSearch, $aplMsgReplace,
            $this->container->getParameter('msg_portfolio_update_con'));
        $aplMailBody = str_replace($msgSearch, $aplMsgReplace,
            $this->container->getParameter('mail_portfolio_update_con'));

        $courseObj->setCourseStatus($courseStatus);
        switch ($courseStatus) {
            case 2:
                // checking whether the assessor is assigned or not
                $cAssessor = $courseObj->getAssessor();
                if (empty($cAssessor)) {
                    $response['type'] = 'Error';
                    $response['code'] = 6;
                    $response['msg'] = 'Please assign assessor!';
                } else if ($courseObj->getAssessorstatus() == 1) {
                    $response['type'] = 'Error';
                    $response['code'] = 8;
                    $response['msg'] = 'Assessor has already approved the qualification.';
                } else {
                    $courseObj->setFacilitatorstatus('1');
                    $courseObj->setFacilitatorDate(date('Y-m-d H:i:s'));
                    $toEmail = $courseObj->getAssessor()->getEmail();
                    $toId = $courseObj->getAssessor()->getId();
                    $messageSubject = str_replace($subSearch, $subReplace,
                        $this->container->getParameter('msg_portfolio_assessor_submitted_sub'));
                    $mailSubject = str_replace($subSearch, $subReplace,
                        $this->container->getParameter('mail_portfolio_assessor_submitted_sub'));
                    $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#role#', '#fromUserName#');
                    $aplMsgReplace = array($courseObj->getUser()->getUsername(), $courseObj->getCourseCode(),
                        $courseObj->getCourseName(), 'Assessor', $courseObj->getFacilitator()->getUsername());
                    $roleMsgReplace = array($courseObj->getAssessor()->getUsername(), $courseObj->getCourseCode(),
                        $courseObj->getCourseName(), 'you', $courseObj->getFacilitator()->getUsername());
                    $roleMessageBody = str_replace($msgSearch, $roleMsgReplace,
                        $this->container->getParameter('msg_portfolio_assessor_submitted_con'));
                    $roleMailBody = str_replace($msgSearch, $roleMsgReplace,
                        $this->container->getParameter('mail_portfolio_assessor_submitted_con'));
                    $aplMessageBody = str_replace($msgSearch, $aplMsgReplace,
                        $this->container->getParameter('msg_portfolio_assessor_submitted_con'));
                    $aplMailBody = str_replace($msgSearch, $aplMsgReplace,
                        $this->container->getParameter('mail_portfolio_assessor_submitted_con'));
                }
                break;
            case 11:
                // checking whether the assessor is assigned or not
                $cAssessor = $courseObj->getAssessor();
                if (!empty($cAssessor)) {
                    if ($courseObj->getAssessorstatus() == 1) {
                        $response['type'] = 'Error';
                        $response['code'] = 8;
                        $response['msg'] = 'Assessor has already approved the qualification.';
                    } else {
                         $toEmail = $courseObj->getAssessor()->getEmail();
                         $toId = $courseObj->getAssessor()->getId();
                         $roleMessageBody = str_replace($msgSearch, $aplMsgReplace,
                         $this->container->getParameter('msg_portfolio_update_con'));
                         $roleMailBody = str_replace($msgSearch, $aplMsgReplace,
                         $this->container->getParameter('mail_portfolio_update_con'));
                    }
                } else {
                    $response['type'] = 'Error';
                    $response['code'] = 6;
                    $response['msg'] = 'Please assign assessor!';
                }
                break;
            case 15:
                $cRto = $courseObj->getRto();
                // checking whether the assessor and rto approved the qualification or not
                if ($courseObj->getAssessorstatus() != 1) {
                    $response['type'] = 'Error';
                    $response['code'] = 4;
                    $response['msg'] = 'Assessor has not yet approved the qualification.';
                } else if (empty($cRto)) { // checking whether the rto is assigned or not
                    $response['type'] = 'Error';
                    $response['code'] = 7;
                    $response['msg'] = 'Please assign rto!';
                } else if ($courseObj->getRtostatus() == 1) {
                    $response['type'] = 'Error';
                    $response['code'] = 9;
                    $response['msg'] = 'RTO has already approved the qualification.';
                } else {
                    $courseObj->setFacilitatorstatus('1');
                    $courseObj->setFacilitatorDate(date('Y-m-d H:i:s'));
                    $toEmail = $courseObj->getRto()->getEmail();
                    $toId = $courseObj->getRto()->getId();
                    $messageSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('msg_portfolio_submitted_sub'));
                    $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_portfolio_submitted_sub'));
                    $msgSearch = array('#toUserName#', '#courseCode#', '#courseName#', '#role#', '#fromUserName#');
                    $aplMsgReplace = array($courseObj->getUser()->getUsername(), $courseObj->getCourseCode(), $courseObj->getCourseName(), 'RTO', $courseObj->getFacilitator()->getUsername());
                    $roleMsgReplace = array($courseObj->getRto()->getUsername(), $courseObj->getCourseCode(), $courseObj->getCourseName(), 'you', $courseObj->getFacilitator()->getUsername());
                    $roleMessageBody = str_replace($msgSearch, $roleMsgReplace, $this->container->getParameter('msg_portfolio_submitted_con'));
                    $roleMailBody = str_replace($msgSearch, $roleMsgReplace, $this->container->getParameter('mail_portfolio_submitted_con'));
                    $aplMessageBody = str_replace($msgSearch, $aplMsgReplace, $this->container->getParameter('msg_portfolio_submitted_con'));
                    $aplMailBody = str_replace($msgSearch, $aplMsgReplace, $this->container->getParameter('mail_portfolio_submitted_con'));
                }
                break;
            case 0:
                if ($courseObj->getAssessorstatus() == 1 && $courseObj->getRtostatus() == 1) {
                    $messageSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('msg_issue_certificate_sub'));
                    $mailSubject = str_replace($subSearch, $subReplace, $this->container->getParameter('mail_issue_certificate_sub'));
                    $aplMessageBody = str_replace($msgSearch, $aplMsgReplace, $this->container->getParameter('msg_issue_certificate_con'));
                    $aplMailBody = str_replace($msgSearch, $aplMsgReplace, $this->container->getParameter('mail_issue_certificate_con'));
                } elseif ($courseObj->getAssessorstatus() != 1 && $courseObj->getRtostatus() == 1) {
                    $response['type'] = 'Error';
                    $response['code'] = 3;
                    $response['msg'] = 'Assessor has not yet approved the qualification.';
                } elseif ($courseObj->getAssessorstatus() == 1 && $courseObj->getRtostatus() != 1) {
                    $response['type'] = 'Error';
                    $response['code'] = 10;
                    $response['msg'] = 'Rto has not yet approved the qualification.';
                } else {
                    $response['type'] = 'Error';
                    $response['code'] = 11;
                    $response['msg'] = 'Assessor and Rto has not yet approved the qualification.';
                }
                break;
        }
        if (count($response) > 0) {
            return $response;
        }
        $this->em->persist($courseObj);
        $this->em->flush();

        if ($toEmail != '' && $toId != '' && $roleMessageBody != '' && $roleMailBody != '') {
            // send the external mail and internal message to facilitator
            /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
            /* $this->sendExternalEmail($toEmail, $mailSubject, $roleMailBody, $courseObj->getFacilitator()->getEmail(),
                $courseObj->getFacilitator()->getUsername()); */
            /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
            $this->sendMessagesInbox($toId, $courseObj->getFacilitator()->getId(), $messageSubject, $roleMessageBody, '');
        }

        // send the external mail and internal message to applicant
        // re creating message data by replacing facilitator values
        /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
        /* $this->sendExternalEmail($courseObj->getUser()->getEmail(), $mailSubject, $aplMailBody,
            $courseObj->getFacilitator()->getEmail(), $courseObj->getFacilitator()->getUsername()); */
        /* send message inbox parameters $toUserId, $fromUserId, $subject, $message, $unitId */
        $this->sendMessagesInbox($courseObj->getUser()->getId(), $courseObj->getFacilitator()->getId(),
            $messageSubject, $aplMessageBody, '');

        // update the zoho api status
        //$zohoId = '696292000010172044';
        if ($courseObj->getZohoId() != '') {
            $zohoId = $courseObj->getZohoId();
            $zohoUpdateResponse = $this->updateZohoAPIStatus($zohoId, $statusList[$courseStatus]['status']);
            if ($zohoUpdateResponse['msg'] == 'Error') {
                $response = $zohoUpdateResponse;
                return $response;
            }
        }
        $response['type'] = 'Success';
        $response['code'] = 1;
        $response['msg'] = 'Status updated successfully.';
        return $response;
    }

    /**
     * Function to update qualification rto status
     * @param int $userId
     * @param int $roleId
     * @param string $userRole
     * @param string $courseCode
     * return integer
     */
    public function updateCourseRTOStatus($userId, $roleId, $userRole, $courseCode)
    {
        $rtoEnable = 0;
        if (in_array('ROLE_RTO', $userRole)) {
            $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('user' => $userId,
                'rto' => $roleId, 'courseCode' => $courseCode));
            if (!empty($courseObj)) {
                $rtoEnable = $this->checkAllUnitsApprovalByRole($courseObj, 'rtostatus');
            }
        }
        return $rtoEnable;
    }

    /**
     * Function to check assessor unit status
     * @param object $courseObj
     * @param string $roleStatus
     * return integer
     */
    public function checkAllUnitsApprovalByRole($courseObj, $roleStatus)
    {
        $roleApproval = 0;
        $courseUnitCheckObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')
            ->findOneBy(array('user' => $courseObj->getUser()->getId(),
            'courseCode' => $courseObj->getcourseCode(),
            $roleStatus => array('0', '2'),
            'status' => '1'));
        if (empty($courseUnitCheckObj) && (count($courseUnitCheckObj) == '0')) {
            $roleApproval = 1;
        }
        return $roleApproval;
    }

    /**
     * Function to update qualification status in zoho crom
     * @param string $zohoId
     * @param string $updatedStatus
     * return array
     */
    public function updateZohoAPIStatus($zohoId, $updatedStatus)
    {
        $response = array();
        $fieldsString = array('authtoken' => '7e32feeb048bdb5c679968c201833920', 'scope' => 'crmapi', 'id' => $zohoId,
            'xmlData' => '<Potentials><row no="1"><FL val="Portfolio Stage">' . $updatedStatus . '</FL></row></Potentials>');
        $request = $this->guzzleService->post('https://crm.zoho.com/crm/private/xml/Potentials/updateRecords', '', $fieldsString);
        $response = $request->send();
        $result = $response->xml();
        $responseData = json_decode(json_encode((array) $result), 1);
        if (array_key_exists('error', $responseData)) {
            $response['type'] = 'Error';
            $response['code'] = 5;
            $response['msg'] = $responseData['error']['message'];
        } else {
            $response['msg'] = 'Success';
        }
        return $response;

    }
/**
     * Function to get the core units & elective units from the course
     * @param array $units
     * @param string $cond
     * @param array $electiveUnitArr
     * return integer 
     */
    public function getCountUnits($units, $cond, $electiveUnitArr = '')
    {   
        $counter = 0;
        for($i = 0; $i < count($units); $i++) {
            if($cond == 'core' && $units[$i]['type'] == 'core'){
                $counter+=1;
            }
            if($cond == 'elective' && $units[$i]['type'] == 'elective' && array_key_exists($units[$i]['id'],$electiveUnitArr)){
                $counter+=1;
            }
        }
        return $counter;
    }
    /**
     * Function to get the days assessordate 
     * @param integer $userId
     * @param string  $courseCode
     * @param string $userRole
     * return string
     */
	public function getDaysRemainingFromRole($userId, $courseCode, $userRole)
    {          
	$courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('user' => $userId,'courseCode' => $courseCode));
        $createdDate = $courseObj->getCreatedOn();
        $targetDate = $courseObj->getTargetDate();
        $facDate =  $courseObj->getFacilitatorDate();
        $assDate =  $courseObj->getAssessorDate();
        $rtoDate =  $courseObj->getRtoDate();
        $facStatus =$courseObj->getFacilitatorstatus();
        $assStatus =$courseObj->getAssessorstatus();
        $rtoStatus =$courseObj->getRtostatus();
        $fecWorkSpan = $this->container->getParameter('fec_workspan');
        $assWorkSpan = $this->container->getParameter('ass_workspan');
        $rtoWorkSpan = $this->container->getParameter('rto_workspan');
        $currentDate = date('Y-m-d H:i:s');
        switch($userRole){
            case 'ROLE_FACILITATOR':
                  $diff = abs(strtotime($targetDate) - strtotime($currentDate));
                  $days = floor(($diff)/ (60*60*24));
                  $field = $fecWorkSpan;
                  break;
            case 'ROLE_ASSESSOR':
                  $field = $assWorkSpan;  
                  if($facStatus == 1):
                    $diff = abs(strtotime($currentDate) - strtotime($facDate));
                    $days = floor(($diff)/ (60*60*24));
                    $days = floor($assWorkSpan-$days);
                  else:
                      $days=0;
                  endif;
                  break;
            case 'ROLE_RTO':
            case 'ROLE_MANAGER':
            case 'ROLE_SUPERADMIN':
                  $field = $rtoWorkSpan;
                  if($facStatus == 1):
                    $diff = abs(strtotime($currentDate) - strtotime($assDate));
                    $days = floor(($diff)/ (60*60*24));
                    $days = floor($rtoWorkSpan-$days);
                  else:
                      $days=0;
                  endif;
                  break;           
        }
        if($days > 0 )
            $graph = round(($days*100)/($field));
        else
            $graph = 0;
       
        return $days."&&".$graph;
    }
     /**
     * Function to get the days assessordate 
     * @param integer $userId
     * @param string  $courseCode
     * @param string $userRole
     * return string
     */
	public function getDaysRemainingApplicant($userId, $courseCode, $userRole)
    {          
	$courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('user' => $userId,'courseCode' => $courseCode));
        $createdDate = $courseObj->getCreatedOn();
        $targetDate = $courseObj->getTargetDate();
        $facDate =  $courseObj->getFacilitatorDate();
        $assDate =  $courseObj->getAssessorDate();
        $rtoDate =  $courseObj->getRtoDate();
        $facStatus =$courseObj->getFacilitatorstatus();
        $assStatus =$courseObj->getAssessorstatus();
        $rtoStatus =$courseObj->getRtostatus();
        $fecWorkSpan = $this->container->getParameter('fec_workspan');
        $assWorkSpan = $this->container->getParameter('ass_workspan');
        $rtoWorkSpan = $this->container->getParameter('rto_workspan');
        $currentDate = date('Y-m-d H:i:s');
        
            $diff = abs(strtotime($targetDate) - strtotime($currentDate));
            $days = floor(($diff)/ (60*60*24));
            $field = 90;
            
        if($days > 0 )
            $graph = 90-$days;
        else
            $graph = 0;       
        return $days."&&".$graph;
    }
    /**
     * Function to get the Notes 
     * @param string $courseId 
     * @param integer $userId
     * return Array
     * 
     */
    public function getNotesFromUserAndCourse($courseId, $userId, $roleType){
        
        $connection = $this->em->getConnection();
        $statement = $connection->prepare('SELECT n.note,uc.user_id,n.created FROM note as n, user_course_units as uc WHERE uc.course_code = :courseCode AND uc.id = n.unit_id and uc.user_id = :userId and n.type = :roleType');
        $statement->bindValue('courseCode', $courseId);
        $statement->bindValue('userId', $userId);
        $statement->bindValue('roleType', $roleType);
        $statement->execute();
        $allRcrds = $statement->fetchAll();
        for($i=0; $i<count($allRcrds); $i++){
            $user = $this->getUserInfo($allRcrds[$i]['user_id']);
            $allRcrds[$i]['userImage'] = !empty($user) ? $this->userImage($user->getUserImage()) : '';
            $allRcrds[$i]['userName'] = !empty($user) ? $user->getUsername() : '';
        }
        return $allRcrds;
    }
	/**
     * Function to get the Evidences from Unit & course & userid wise 
     * @param integer $courseId 
     * @param integer $unitId
	 * @param integer userId
     * return Array
     */
    public function getEvidenceForUnit($courseId, $unitId, $userId){
        $connection = $this->em->getConnection();
        $statement = $connection->prepare('SELECT count(*) as noFiles FROM evidence WHERE user_id = :userId AND unit_code =:unitCode AND course_code = :courseCode');
        $statement->bindValue('userId', $userId);
        $statement->bindValue('unitCode', $unitId);
        $statement->bindValue('courseCode', $courseId);
        $statement->execute();
        return $statement->fetchAll();
    }
    /**
     * Function to get the FAQ     
     * return Array
     */
    public function getFaq()
    {
          $faq = $this->em->getRepository('GqAusUserBundle:Faq');        
          return $faq->findByStatus('1');
    }
	/** get Course count based on the unit
	 * @param integer $applicantId 
     * @param string $userRole
	 * @param string $courseCode
	 * @param string $type
     */
	public function getCourseCountStatusByRoleWise($applicantId, $userRole, $courseCode, $type)
    {
         switch ($userRole) {
            case 'ROLE_FACILITATOR':
                $field = 'facilitator_status';
                break;
            case 'ROLE_ASSESSOR':
                $field = 'assessor_status';
                break;
            case 'ROLE_RTO':
            case 'ROLE_MANAGER':
            case 'ROLE_SUPERADMIN':
                $field = 'rto_status';
                break;
        }
        $connection = $this->em->getConnection();
        $statement = $connection->prepare('SELECT * FROM user_course_units WHERE user_id = :applicantId AND course_code = :courseCode AND type = :type');
        $statement->bindValue('applicantId', $applicantId);
        $statement->bindValue('courseCode', $courseCode);
        $statement->bindValue('type', $type);
        $statement->execute();
        $allRcrds = $statement->fetchAll();
        $noOfNotRvdrcrds = 0;
        $noOfRvdRcrds = 0;
        foreach($allRcrds as $key=>$value){
            if($value[$field] == '0'){
                $noOfNotRvdrcrds++;
            }
            else{
                $noOfRvdRcrds++;
            }
        }
        $allRcrds['noOfNotRvdrcrds'] = $noOfNotRvdrcrds;
        $allRcrds['noOfRvdRcrds'] = $noOfRvdRcrds;
       
        return $allRcrds;
    }
    /* 
     * Function to get the tabs from userrole
     * @param string $userRole
     * return integer
     */
    public function separateTabsBasedOnroleWise($userRole)
    {
        switch ($userRole) {
            case 'ROLE_FACILITATOR':
                $colLg = '4';
                break;
            case 'ROLE_ASSESSOR':
                $colLg = '3';
                break;
            case 'ROLE_RTO':
                $colLg = '12';
                break;
            default :
                $colLg = '12';
                break;
        }
        return $colLg;
    }
    /*
     * Function to get unit status based on the user role,If the assessor don't have any status about unit, we need to pull the unit status from fecilitator
     * @param integer $status
     * @param integer $inloop
     * @param string $userRole
     * return string status
     */
    public function getStausByStatus($status, $inLoop, $userRole){
         switch ($userRole) {
             case 'ROLE_FACILITATOR':
                    if($status == 1)
                        return 'Satisfactory';
                    elseif($status == 2)
                        return 'Not Yet Satisfactory';
                    else
                        return '';
                   break;
             case 'ROLE_ASSESSOR';
                   if($status == 1)
                        return 'Competent';
                   elseif($status == 2)
                        return 'Not Yet Competent';
             case 'ROLE_RTO';
                    if($inLoop == 1 && $status == 1)
                        return 'Competent';
                    elseif($inLoop == 1 && $status == 2)
                        return 'Not Yet Competent';
                    elseif($inLoop == 0 && $status == 1)
                        return 'Competent';
                    elseif($inLoop == 0 && $status == 2)
                        return 'Not Yet Competent';
                    else
                        return '';
                    break;
              default:
                   return '';
                   break;
         }
    }
    /**
     * Function to get the notes based on course & roletype for portfolio details pages
     * @param integer $courseId
     * @param string $roleType
     */
    public function getNotesFromCourseIdOnly($courseId, $roleType)
    {
        $courseNotesObj = $this->em->getRepository('GqAusUserBundle:Note')->findBy(array('courseId' => $courseId, 'type' => $roleType));
        return $courseNotesObj;
    }
	/** 
     * Display usernames in New message Role wise Authentication
     * @param: $userRole
     */
    public function getUsersfromCourse($options = array(), $userRole, $facId, $assId, $rtoId, $curuserId) {     
        
        $query = $this->em->getRepository('GqAusUserBundle:User')
            ->createQueryBuilder('u')
            ->select( "CONCAT( CONCAT(u.firstName, ' '), u.lastName)" );
        $nameCondition = "";
        if ($userRole == 'ROLE_FACILITATOR') {
            $query->where('(u instance of GqAusUserBundle:Applicant OR u instance of GqAusUserBundle:Assessor OR u instance of GqAusUserBundle:Rto)');
            $query->andWhere("u.firstName LIKE '%" . $options['keyword'] . "%' OR u.lastName LIKE '%" . $options['keyword'] . "%'");
            $avals = array($curuserId, $assId, $rtoId);
            $query->andWhere('u.id IN (:ids)')->setParameter('ids', $avals);
            $getMessages = $query->getQuery()->getResult(); 
            
            $getMessages = array_map("unserialize", array_unique(array_map("serialize", $getMessages)));
            sort($getMessages);
        }
        return $getMessages;
    }


    /** 
     * Get unit type of unit code
     * @param: $unitType
     */
    public function getUserCourseUnitType($applicantId, $courseCode, $unitId) {
        $unitType = '';
        if($courseCode && $unitId){
            $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
            $userCourseUnits = $reposObj->findOneBy(array(
                'user' => $applicantId,
                'unitId' => $unitId,
                'courseCode' => $courseCode));
                $unitType = ($userCourseUnits) ? $userCourseUnits->getType() : '';
        }
        return $unitType;
    }
    /**
     * Function for get All facilitators
     * @param type $courseCode
     * @param type $userId
     * @return type
     */
    public function getFacilitaorInfo($courseCode , $userId)
    {
        $query  = $this->em->getRepository('GqAusUserBundle:UserCourses')
            ->createQueryBuilder('u')
            ->select('(u.facilitator)')            
            ->where('u.courseCode IN (:courseCode)')->setParameter('courseCode', $courseCode)
            ->andWhere('u.user IN (:user)')->setParameter('user', $userId);
        $faclist = $query->getQuery()->getResult();        
        return $faclist;
    }
    /**
     * Function to Update Facilitator
     * @param type $userId
     * @param type $courseCode
     * @param type $facilitator*
     */
    public function updateQualificationFacilitator($listId,$facilitator)
    {
        $user = $this->getUserInfo($facilitator);
        $remObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->find($listId);        
        $remObj->setFacilitator($user);
        $this->em->persist($remObj);
        $this->em->flush();
        
        return true;
 
    }
}