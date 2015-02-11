<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;

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
            $mailerInfo['body'] = "Dear ".$userName.",\n We heard that you lost your password. Sorry about that! \n
            But don't worry! You can use the following link within the next 4 hours to reset your password
             <a href='".$applicationUrl."resetpassword/".$token."'>Click Here </a> \n
             If you don't use this link within 4 hours, it will expire. <br>To get a new password reset link, visit ".$applicationUrl."forgotpassword
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
                if($method == 'POST') {                    
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
        if($user){
            $this->updateCourseConditionStatus($user);
        }
        
        ignore_user_abort(true);
        $path = "../template/"; // change the path to fit your websites document structure
        $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file); // simple file name validation
        $dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $path.$dl_file;

        if ($fd = fopen ($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf":
                header("Content-type: application/pdf");
                header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
                break;
                // add more headers for other content types here
                default;
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
                break;
            }
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose ($fd);
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
        if(is_object($user) && count($user) > 0) {
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
        return array_sum($points); exit;
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
        if(is_object($user) && count($user) > 0) {
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
        $percentage = ($profileCompleteness*$maximumPoints)/100;
        return $percentage = $percentage.'%';
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
        } else if($result['status'] == '0') {
            $evidenceStatus = 'Disapproved';
        }
        $mailerInfo['subject'] = 'Unit :'.$result['unitName'].' Status';
        $mailerInfo['message'] = $mailerInfo['body'] = "Dear ".$userName.", \n Qualification : ".$result['courseName']." \n Unit : ".$result['unitName']." \n Evidences have been ".$evidenceStatus." by ".$result['currentUserName']."
         \n Regards, \n OnlineRPL";
        $this->sendExternalEmail($mailerInfo);
        $this->sendMessagesInbox($mailerInfo);
        return $result['status'];
    }
    
    /**
    * Function to get applicants list information
    * return $result array
    */
    public function getUserApplicantsList($userId, $userRole, $status, $searchName = null, $searchTime = null)
    {
        if (in_array('ROLE_ASSESSOR',$userRole)) {
            $userType = 'assessor';
            $userStatus = 'assessorstatus';
        } elseif (in_array('ROLE_FACILITATOR',$userRole)) {
            $userType = 'facilitator';
            $userStatus = 'facilitatorstatus';
        } elseif (in_array('ROLE_RTO',$userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        }
        $res = $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->createQueryBuilder('c')
                ->select("c, u")
                ->join('c.user', 'u')
                ->where(sprintf('c.%s = :%s', $userType, $userType))->setParameter($userType, $userId)
                ->andWhere(sprintf('c.%s = :%s', $userStatus, $userStatus))->setParameter($userStatus, $status);
        
        if ($userType == 'rto') {
            $res->andWhere(sprintf('c.%s = :%s', 'assessorstatus', 'assessorstatus'))->setParameter('assessorstatus', '1');
        }

        if (!empty($searchName)) {
            $res->andWhere(sprintf('u.%s LIKE :%s OR u.%s LIKE :%s', 'firstName', 'firstName', 'lastName', 'lastName'))
            ->setParameter('firstName', '%'.$searchName.'%')
            ->setParameter('lastName', '%'.$searchName.'%');
        }
        
        if (!empty($searchTime)) {
            $searchTime = $searchTime * 7;
            $searchTime1 = $searchTime - 6;
            $res->andWhere("DATE_DIFF(c.targetDate, c.createdOn) >= ".$searchTime1);
            $res->andWhere("DATE_DIFF(c.targetDate, c.createdOn) <= ".$searchTime);
        }
        //$applicantList = $res->getQuery(); var_dump($applicantList); exit;
        $applicantList = $res->getQuery()->getResult();
        return array('applicantList' => $applicantList);
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
        $remindDate = date('Y-m-d',strtotime($remindDate));
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
        if (in_array('ROLE_ASSESSOR',$userRole)) {
            $userType = 'assessor';
            $userStatus = 'assessorstatus';
        } elseif (in_array('ROLE_FACILITATOR',$userRole)) {
            $userType = 'facilitator';
            $userStatus = 'facilitatorstatus';
        } elseif (in_array('ROLE_RTO',$userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        }
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
                            if ($userType == 'facilitator') {
                                $course->setFacilitatorstatus('1');
                            } elseif ($userType == 'assessor') {
                                $course->setAssessorstatus('1');
                            } elseif ($userType == 'rto') {
                                $course->setRtostatus('1');
                                //$course->setCourseStatus('1');
                            }
                             $this->em->persist($course);
                             $this->em->flush();
                        }//if
                        
                    }//if
                }//if
            }//foreach
        }//if
    }
    
    /**
    * Function to get pending applicants count
    * return $count string
    */
    public function getPendingapplicantsCount($userId, $userRole, $applicantStatus)
    {
        if (in_array('ROLE_ASSESSOR',$userRole)) {
            $userType = 'assessor';
            $userStatus = 'assessorstatus';
        } elseif (in_array('ROLE_FACILITATOR',$userRole)) {
            $userType = 'facilitator';
            $userStatus = 'facilitatorstatus';
        } elseif (in_array('ROLE_RTO',$userRole)) {
            $userType = 'rto';
            $userStatus = 'rtostatus';
        }
        $result = array($userType => $userId, $userStatus => $applicantStatus);
        if ($userType == 'rto') {
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
        if(is_object($user) && count($user) > 0) {
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
    public function updateReminderStatus($id,$flag)
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
            $completeness = ($evidenceCount/$totalNoCourses) * 100;
        }
        return round($completeness).'%';
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
        $diff = (($applicantList[0]['diff'])/7);
        if (is_float($diff)) {
            $diff = $diff + 1;
        }
        return floor($diff).' week(s)';
    }
    
    /**
    * Function to get unread messages count
    * return void
    */
    public function getUnreadMessagesCount($userId)
    {
        $getMessages = $this->em->getRepository('GqAusUserBundle:Message')->findBy(array('inbox' => $userId,
                               'read' => '0','toStatus' => '0'));
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
        $pagination = $paginator->paginate($query, $page,  $this->container->getParameter('pagination_limit_page'));
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
        $this->em->clear();
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
        $pagination = $paginator->paginate($query, $page,  $this->container->getParameter('pagination_limit_page'));
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
        $pagination = $paginator->paginate($query, $page,  $this->container->getParameter('pagination_limit_page'));
        return array('messages' => $pagination, 'paginator' => $paginator);
    }
    
    /**
    * Function to mark as read / unread
    */
    public function markReadStatus($id,$flag)
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
        } elseif($type == 'from') {
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
            } elseif(($userId == $sent) && ($fromStatus == '1')) {
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
        $userImage = $path.'public/uploads/'.$image;
        if (empty($image)) {
            $userImage = $path.'public/images/profielicon.png';
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
        $applicantCoures = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $courseCode,
                                                                                         'user' => $applicantId));
        if (!empty($applicantCoures)) {
            $applicantCoures->setCourseStatus('0');
            $this->em->persist($applicantCoures);
            $this->em->flush();
        }
    }

}