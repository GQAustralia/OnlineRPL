<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $currentIdPoints = 100;
        $maximumPoints = 100;
        $profileCompleteness = 0;
        if(is_object($user) && count($user) > 0) {
            
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
           return $this->render('GqAusHomeBundle:Default:index.html.twig', array('profileCompleteness' => $percentage, 
                                                                            'userImage' => $userImage,
                                                                            'currentIdPoints' => $currentIdPoints,
                                                                            'userCourses' => $userCourses));
        }
    }
}
