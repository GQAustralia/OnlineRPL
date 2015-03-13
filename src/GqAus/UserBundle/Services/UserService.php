<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\User;
use GqAus\UserBundle\Entity\Applicant;
use GqAus\UserBundle\Entity\UserAddress;
use GqAus\UserBundle\Entity\UserCourses;

class UserService
{

    private $userId;
    private $repository;
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
     * Constructor
     */
    public function __construct($em, $container, $mailer)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->mailer = $mailer;
        $this->container = $container;
    }

    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }

    public function saveProfile()
    {
        $this->em->persist($this->currentUser);
        $this->em->flush();
    }

    public function savePersonalProfile($image)
    {
        if (!empty($image)) {
            $this->currentUser->setUserImage($image);
        }
        $this->em->persist($this->currentUser);
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
            $mailerInfo['body'] = "Dear " . $userName . ",\n We heard that you lost your password. Sorry about that! \n
            But don't worry! You can use the following link within the next 4 hours to reset your password
             <a href='" . $applicationUrl . "resetpassword/" . $token . "'>Click Here </a> \n
             If you don't use this link within 4 hours, it will expire. <br>To get a new password reset link, visit " . $applicationUrl . "forgotpassword
             \n Regards, \n OnlineRPL";

            $this->sendExternalEmail($mailerInfo);

            $message = 'A request for password reset is sent to this address.';
        } else {
            $message = 'There is no user with this email address. Please try again';
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
                    $message = 'Password changed successfully , please login';
                }
                $validRequest = 1;
            }
        }//if
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
        $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file); // simple file name validation
        $dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $path . $dl_file;

        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf":
                    header("Content-type: application/pdf");
                    header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\""); // use 'attachment' to force a file download
                    break;
                // add more headers for other content types here
                default;
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
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
            //$address = count($address);
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
            'unitId' => $result['unit']));
        $mailerInfo = array();
        $userName = $courseUnitObj->getUser()->getUsername();
        $mailerInfo['to'] = $courseUnitObj->getUser()->getEmail();
        $mailerInfo['inbox'] = $courseUnitObj->getUser()->getId();
        $mailerInfo['sent'] = $result['currentUserId'];
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
            $evidenceStatus = 'Disapproved';
            $mailerInfo['subject'] = 'Unit :' . $result['unitName'] . ' Status';
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $userName . ", \n Qualification : " . $result['courseName'] . " \n Unit : " . $result['unitName'] . " \n Evidences have been " . $evidenceStatus . " by " . $result['currentUserName'] . "
             \n Regards, \n OnlineRPL";
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);
        }
        return $result['status'];
    }

    /**
     * Function to get applicants list information
     * return $result array
     */
    public function getUserApplicantsList($userId, $userRole, $status, $page = null, $searchName = null, $searchTime = null)
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
        }
        if ($status == 2) {
            $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                            ->createQueryBuilder('c')
                            ->select("c, u")
                            ->join('c.user', 'u')
                            ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId);
        } else {
            $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                            ->createQueryBuilder('c')
                            ->select("c, u")
                            ->join('c.user', 'u')
                            ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
                            ->andWhere(sprintf('c.%s = :%s', $userStatus, $userStatus))->setParameter($userStatus, $status);
        }

        if ($userType == 'rto') {
            $res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '2');
            $res->andWhere(sprintf('c.%s = :%s', 'assessorstatus', 'assessorstatus'))->setParameter('assessorstatus', '1');
        }

        /* if (!empty($searchName)) {
          $res->andWhere(sprintf('u.%s LIKE :%s OR u.%s LIKE :%s', 'firstName', 'firstName', 'lastName', 'lastName'))
          ->setParameter('firstName', '%'.$searchName.'%')
          ->setParameter('lastName', '%'.$searchName.'%');
          } */

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
        $res->orderBy('c.id', 'DESC');
        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        /* Pagination */
        //$applicantList = $res->getQuery(); var_dump($applicantList); exit;
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
        } else {
            /* if($status == 2) {
              $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
              ->createQueryBuilder('c')
              ->select("c, u")
              ->join('c.user', 'u')
              ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
              ->andWhere("c.courseStatus = '2'");
              }
              else {
              $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
              ->createQueryBuilder('c')
              ->select("c, u")
              ->join('c.user', 'u')
              ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
              ->andWhere(sprintf('c.%s = :%s', $userStatus, $userStatus))->setParameter($userStatus, $status);
              } */
            $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                    ->createQueryBuilder('c')
                    ->select("c, u")
                    ->join('c.user', 'u')
                    ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
                    ->andWhere("c.courseStatus = '" . $status . "'");
        }

        if ($userType == 'rto') {
            //$res->andWhere(sprintf('c.%s = :%s', 'courseStatus', 'courseStatus'))->setParameter('courseStatus', '2');
            $res->andWhere("c.courseStatus = '0' OR c.courseStatus = '2'");
            $res->andWhere(sprintf('c.%s = :%s', 'assessorstatus', 'assessorstatus'))->setParameter('assessorstatus', '1');
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

            /* $res->andWhere(sprintf('c.%s LIKE :%s OR c.%s LIKE :%s', 'courseCode', 'courseCode', 'courseName', 'courseName'))
              ->setParameter('courseCode', '%'.$searchQualification.'%')
              ->setParameter('courseName', '%'.$searchQualification.'%'); */
        }
        if (!empty($startDate)) {
            $res->andWhere("c.createdOn between '" . $startDate . "' and '" . $endDate . "'");
        }
        $res->orderBy('c.id', 'DESC');
        /* Pagination */
        $paginator = new \GqAus\UserBundle\Lib\Paginator();
        $pagination = $paginator->paginate($res, $page, $this->container->getParameter('pagination_limit_page'));
        /* Pagination */

        //$applicantList = $res->getQuery(); var_dump($applicantList); exit;
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
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->find($userCourseId);
        if (empty($remindDate)) {
            $remindDate = date('d/m/Y');
        }
        $remindDate = date('Y-m-d', strtotime($remindDate));
        $reminderObj = new \GqAus\UserBundle\Entity\Reminder();
        $reminderObj->setCourse($courseObj);
        $reminderObj->setUser($userObj);
        $reminderObj->setDate($remindDate);
        $reminderObj->setMessage($notes);
        $reminderObj->setCompleted(0);
        $this->em->persist($reminderObj);
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * Function to update applicant qualification list
     */
    public function updateUserApplicantsList($userId, $userRole)
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
        $usercoures = $this->em->getRepository('GqAusUserBundle:UserCourses')->findBy(array($userType => $userId));
        if (!empty($usercoures)) {
            foreach ($usercoures as $course) {
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
                            $userStatus => '0',
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
                                $mailerInfo['sent'] = $course->getAssessor()->getId();
                                $mailerInfo['subject'] = "All evidences are enough competent in " . $course->getCourseCode() . " : " . $course->getCourseName();
                                $facilitatorName = $course->getFacilitator()->getUsername();
                                $mailerInfo['to'] = $course->getFacilitator()->getEmail();
                                $mailerInfo['inbox'] = $course->getFacilitator()->getId();
                                $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $facilitatorName . ", \n All the evidences for the Qualification : " . $course->getCourseCode() . " " . $course->getCourseName() . " are enough competent. \n Validated all the eviedences in the qualification.
                                 \n\n Regards, \n " . $course->getAssessor()->getUsername();
                                $this->sendExternalEmail($mailerInfo);
                                $this->sendMessagesInbox($mailerInfo);

                                $applicantName = $course->getUser()->getUsername();
                                $mailerInfo['to'] = $course->getUser()->getEmail();
                                $mailerInfo['inbox'] = $course->getUser()->getId();
                                $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $applicantName . ", \n All the evidences for the Qualification : " . $course->getCourseCode() . " " . $course->getCourseName() . " are enough competent. \n Validated all the eviedences in the qualification.
                                 \n\n Regards, \n " . $course->getAssessor()->getUsername();
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
            }//foreach
        }//if
        return $rtoEnable;
    }

    /**
     * Function to get pending applicants count
     * return $count string
     */
    public function getPendingapplicantsCount($userId, $userRole, $applicantStatus)
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
        $result = array($userType => $userId, $userStatus => $applicantStatus);
        if ($userType == 'rto') {
            $result['courseStatus'] = '2';
            $result['assessorstatus'] = '1';
        }
        $getCourseStatus = $this->em->getRepository('GqAusUserBundle:UserCourses')->findBy($result);
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
        $getReminders = $this->em->getRepository('GqAusUserBundle:Reminder')
                ->findBy(array('user' => $userId, 'completed' => '0', 'date' => $date));
        return $getReminders;
    }

    /**
     * function to send external email .
     *  @return string
     */
    public function sendExternalEmail($mailerInfo)
    {
        $from = $this->container->getParameter('fromEmailAddress');
        if (!empty($mailerInfo)) {
            $emailContent = \Swift_Message::newInstance()
                    ->setSubject($mailerInfo['subject'])
                    ->setFrom($from)
                    ->setTo($mailerInfo['to'])
                    ->setBody($mailerInfo['body'])
                    ->setContentType("text/html");
            $status = $this->mailer->send($emailContent);
        }
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
        $remObj->setCompletedDate(date('Y-m-d'));
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
                            ->andWhere(sprintf('e.%s = :%s', 'course', 'course'))->setParameter('course', $courseCode);
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
        //$date1 = '2015-02-01 20:12:10';
        ///$date2 = '2015-01-24 12:12:10';

        $ts1 = strtotime($date);
        $ts2 = time();

        $seconds_diff = $ts2 - $ts1;

        /* Get the difference between the current time 
          and the time given in days */
        $days = floor($seconds_diff / 3600 / 24);

        /* If some forward time is given return error */
        if ($days < 0) {
            return -1;
        }

        switch ($days) {
            case 0: $_word = "Today";
                break;
            case 1: $_word = "Yesterday";
                break;
            case ($days >= 2 && $days <= 6):
                $_word = sprintf("%d days ago", $days);
                break;
            case ($days >= 7 && $days < 14):
                $_word = "1 week ago";
                break;
            case ($days >= 14 && $days <= 365):
                $_word = sprintf("%d weeks ago", intval($days / 7));
                break;
            default : return date('d/m/Y', $ts1);
        }

        return $_word;
    }

    /**
     * Function to approve certification by rto
     */
    public function rtoApproveCertification($courseCode, $applicantId)
    {
        $courseObj = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
            'user' => $applicantId));
        if (!empty($courseObj)) {
            $courseObj->setCourseStatus('0');
            $courseObj->setRtoDate(date('Y-m-d H:i:s'));
            $this->em->persist($courseObj);
            $this->em->flush();

            $mailerInfo = array();
            $mailerInfo['sent'] = $courseObj->getRto()->getId();
            $mailerInfo['subject'] = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
            $facilitatorName = $courseObj->getFacilitator()->getUsername();
            $mailerInfo['to'] = $courseObj->getFacilitator()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $facilitatorName . ", \n All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent. \n Validated all the eviedences in the qualification and issued the certificate.
             \n\n Regards, \n " . $courseObj->getRto()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);

            $applicantName = $courseObj->getUser()->getUsername();
            $mailerInfo['to'] = $courseObj->getUser()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getUser()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $applicantName . ", \n All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent. \n Validated all the eviedences in the qualification and issued the certificate..
             \n\n Regards, \n " . $courseObj->getRto()->getUsername();
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
            $mailerInfo['sent'] = $courseObj->getFacilitator()->getId();
            $mailerInfo['subject'] = "All evidences are enough competent in " . $courseObj->getCourseCode() . " : " . $courseObj->getCourseName();
            $rtoName = $courseObj->getRto()->getUsername();
            $mailerInfo['to'] = $courseObj->getRto()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getRto()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $rtoName . ", \n All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent. \n Validated all the eviedences and moved portfolio to you.
             \n\n Regards, \n " . $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);

            $applicantName = $courseObj->getUser()->getUsername();
            $mailerInfo['to'] = $courseObj->getUser()->getEmail();
            $mailerInfo['inbox'] = $courseObj->getUser()->getId();
            $mailerInfo['message'] = $mailerInfo['body'] = "Dear " . $applicantName . ", \n All the evidences for the Qualification : " . $courseObj->getCourseCode() . " " . $courseObj->getCourseName() . " are enough competent. \n. Your portfolio has been submitted to RTO.
             \n\n Regards, \n " . $courseObj->getFacilitator()->getUsername();
            $this->sendExternalEmail($mailerInfo);
            $this->sendMessagesInbox($mailerInfo);
        }
    }

    public function saveApplicantData($request)
    {
        $user = new Applicant();
        $firstName = $request->get('firstname');
        $lastName = $request->get('lastname');
        $email = $request->get('email');
        $password = $request->get('password');
        $phone = $request->get('phone');
        $dateofbirth = $request->get('dateofbirth');
        $gender = $request->get('gender');
        $studentId = $request->get('studentId');
        $userImage = $request->get('userimage');
        $pwdToken = $request->get('pwdtoken');
        $tokenExpiry = $request->get('tokenexpiry');
        $tokenStatus = $request->get('tokenstatus');
        $courseConditionStatus = $request->get('courseconditionstatus');


        $user->setFirstName(isset($firstName) ? $firstName : '');
        $user->setLastName(isset($lastName) ? $lastName : '');
        $user->setEmail(isset($email) ? $email : '');
        $user->setPassword(isset($password) ? $password : '$2y$10$u9fhYXfZ/CHlGKrudvi3LO0Ap4yx6hIJjQZZ32DAK8C06iaLzu2Ue');
        $user->setPhone(isset($phone) ? $phone : '');
        $user->setDateOfBirth(isset($dateofbirth) ? $dateofbirth : '');
        $user->setGender(isset($gender) ? $gender : '');
        $user->setUniversalStudentIdentifier(isset($studentId) ? $studentId : '');
        $user->setUserImage(isset($userImage) ? $userImage : '');
        $user->setPasswordToken(isset($pwdToken) ? $pwdToken : '');
        $user->setTokenExpiry(isset($tokenExpiry) ? $tokenExpiry : '');
        $user->setTokenStatus(isset($tokenStatus) ? $tokenStatus : 1);
        $user->setCourseConditionStatus(isset($courseConditionStatus) ? $courseConditionStatus : 0);
        $this->em->persist($user);
        $this->em->flush();

        
        $address = $request->get('address');
        $pincode = $request->get('pincode');
        $addressObj = new UserAddress();
        $addressObj->setUser($user);
        $addressObj->setAddress(isset($address) ? $address : '');
        $addressObj->setPincode(isset($pincode) ? $pincode : '');
        $this->em->persist($addressObj);
        $this->em->flush();

        $userObj = $this->repository->find($user->getId());
        $userObj->setAddress($addressObj);
        $this->em->flush();

        $courseCode = $request->get('coursecode');
        $courseName = $request->get('coursename');
        $courseStatus = $request->get('coursestatus');
        $targetDate = $request->get('targetdate');
        $userCoursesObj = new UserCourses();
        $userCoursesObj->setUser($user);
        $userCoursesObj->setCourseCode(isset($courseCode) ? $courseCode : '');
        $userCoursesObj->setCourseName(isset($courseName) ? $courseName : '');
        $userCoursesObj->setCourseStatus(isset($courseStatus) ? $courseStatus : '');
        $userCoursesObj->setCreatedOn(time());
        $userCoursesObj->setFacilitator($user);
        $userCoursesObj->setAssessor($user);
        $userCoursesObj->setRto($user);
        $userCoursesObj->setFacilitatorstatus(0);
        $userCoursesObj->setAssessorstatus(0);
        $userCoursesObj->setRtostatus(0);
        $userCoursesObj->setTargetDate(isset($setTargetDate) ? $setTargetDate : '');

        $this->em->persist($userCoursesObj);
        $this->em->flush();


        echo $user->getId() . '<br/>' . $addressObj->getId() . '<br/>' . $userCoursesObj->getId();
        exit;
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
        }
        $this->em->persist($course);
        $this->em->flush();
        $this->em->clear();
        return "success";
    }
    
    /*
     * Get List Users of specific role
     */
    public function getUsers($role)
    {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("SELECT id, firstname, lastname FROM user WHERE roletype = :role");
        $statement->bindValue('role', $role);
        $statement->execute();
        return $statement->fetchAll();
    }

}
