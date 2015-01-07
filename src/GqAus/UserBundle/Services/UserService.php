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
            $to = 'swetha.kolluru@valuelabs.net';
            $subject = 'Request for Password Reset';
            $applicationUrl = $this->container->getParameter('applicationUrl');
            $body = "Dear ".$userName.",<br><br> We heard that you lost your password. Sorry about that! <br>
            But don't worry! You can use the following link within the next 4 hours to reset your password
             <a href='".$applicationUrl."resetpassword/".$token."'>Click Here </a><br>
             If you don't use this link within 4 hours, it will expire. <br>To get a new password reset link, visit ".$applicationUrl."forgotpassword
             <br><br> Regards,<br>OnlineRPL";
             
            $emailContent = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('swetha.kolluru@valuelabs.net')
                ->setTo($to)
                ->setBody($body)
                ->setContentType("text/html");                
                $status = $this->mailer->send($emailContent);
                
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
     * function to update course condition status.
     *  @return array
     */
    public function updateCourseConditionStatus($user, $file)
    {
        $user->setCourseConditionStatus('1');
        $this->em->persist($user);
        $this->em->flush();
        
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
     * function to get dashboard information.
     *  @return array
     */
    public function getDashboardInfo($user)
    {
        $currentIdPoints = 100;
        $maximumPoints = 100;
        $profileCompleteness = 0;
        if(is_object($user) && count($user) > 0) {
           $userId = $user->getId();
           $firstName = $user->getFirstName();
           $lastName = $user->getLastName();
           $email = $user->getEmail();
           $phone = $user->getPhone();
           $userImage = $user->getUserImage();
           $address = $user->getAddress();
           $address = count($address);
           if (!empty($firstName)) {
                $profileCompleteness += 15;
           }
           if (!empty($lastName)) {
                $profileCompleteness += 15;
           }
           if (!empty($email)) {
                $profileCompleteness += 15;
           }
           if (!empty($phone)) {
                $profileCompleteness += 15;
           }
           if (!empty($address)) {
                $profileCompleteness += 40;
           }
           if (empty($userImage)) {
                $userImage = 'profielicon.png';
           }
           $percentage = ($profileCompleteness*$maximumPoints)/100;
           $percentage = $percentage.'%';
           $userCourses = $user->getCourses();
           $courseConditionStatus = $user->getCourseConditionStatus();
           return array('profileCompleteness' => $percentage, 
                        'userImage' => $userImage,                                                                            'currentIdPoints' => $currentIdPoints,
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
}