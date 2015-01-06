<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
    * Function for dashboard landing page
    * params -
    * return $result array
    */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
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
           
           return $this->render('GqAusHomeBundle:Default:index.html.twig', array('profileCompleteness' => $percentage, 
                                                                            'userImage' => $userImage,
                                                                            'currentIdPoints' => $currentIdPoints,
                                                                            'userCourses' => $userCourses,
                                                                            'courseConditionStatus' => $courseConditionStatus));
        }
    }
    
    /**
    * function to download related file
    * params $file string
    */
    public function downloadAction($file)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $userService->updateCourseConditionStatus($user);

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
        exit;
    }
}
