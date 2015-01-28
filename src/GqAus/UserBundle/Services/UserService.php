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
    private $messageHelperService;
    
    /**
     * Constructor
     */
    public function __construct($em, $container, $messageHelperService)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->messageHelperService = $messageHelperService;
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
            $mailerInfo['body'] = "Dear ".$userName.",<br><br> We heard that you lost your password. Sorry about that! <br>
            But don't worry! You can use the following link within the next 4 hours to reset your password
             <a href='".$applicationUrl."resetpassword/".$token."'>Click Here </a><br>
             If you don't use this link within 4 hours, it will expire. <br>To get a new password reset link, visit ".$applicationUrl."forgotpassword
             <br><br> Regards,<br>OnlineRPL";
            
            $this->messageHelperService->sendExternalEmail($mailerInfo);
                
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
    public function downloadCourseCondition($user, $file)
    {
        $this->updateCourseConditionStatus($user);
        
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
                        'userImage' => $user->getUserImage(),
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
           $address = count($address);
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
           
           if (!empty($address)) {
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
        $results['userImage'] = $user->getUserImage();
        $results['userName'] = $user->getUsername();
        $otheruser = $this->em->getRepository('GqAusUserBundle:UserCourses')->findOneBy(array('courseCode' => $qcode,
                                                                                         'user' => $user->getId()));
        if (!empty($otheruser)) {
            $assessor = $this->getUserInfo($otheruser->getAssessor());
            $results['assessorName'] = !empty($assessor) ? $assessor->getUsername() : '';
            $rto = $this->getUserInfo($otheruser->getRto());
            $results['rtoName'] = !empty($rto) ? $rto->getUsername() : '';
            $facilitator = $this->getUserInfo($otheruser->getFacilitator());
            $results['facilitatorName'] = !empty($rto) ? $facilitator->getUsername() : '';
        }
        return $results;
    }
    
    /**
    * Function to update applicant evidences information
    * return $result array
    */
    public function updateApplicantEvidences($userId, $unit, $userRole, $status, $currentUserName)
    {
        $courseUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findOneBy(array('user' => $userId,
                                                                                        'unitId' => $unit));
        $mailerInfo = array();
        $userName = $courseUnitObj->getUser()->getUsername();
        $mailerInfo['to'] = $courseUnitObj->getUser()->getEmail();
        if ($userRole == 'ROLE_FACILITATOR') {
            $courseUnitObj->setFacilitatorstatus($status);
        } elseif ($userRole == 'ROLE_ASSESSOR') {
            $courseUnitObj->setAssessorstatus($status);
        } elseif ($userRole == 'ROLE_RTO') {
            $courseUnitObj->setRtostatus($status);
        }
        $this->em->persist($courseUnitObj);
        $this->em->flush();
        
        if ($status == '1') {
            $evidenceStatus = 'Approved';
        } else if($status == '0') {
            $evidenceStatus = 'Disapproved';
        }
        $mailerInfo['subject'] = 'User Unit Status';
        $mailerInfo['body'] = "Dear ".$userName.",<br><br> Unit : ".$unit." evidences is been ".$evidenceStatus." by ".$currentUserName."
         <br><br> Regards,<br>OnlineRPL";
         
        //$this->messageHelperService->sendExternalEmail($mailerInfo);
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
    
}