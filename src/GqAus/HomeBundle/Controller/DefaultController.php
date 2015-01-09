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
        $userService = $this->get('UserService');
        $results = $userService->getDashboardInfo($user);
        return $this->render('GqAusHomeBundle:Default:index.html.twig', $results);
    }
    
    /**
    * function to download related file
    * params $file string
    */
    public function downloadAction($file)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $userService->downloadCourseCondition($user, $file);
        exit;
    }
    
    /**
    * function to update Condition status
    */
    public function updateConditionAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $userService->updateCourseConditionStatus($user);
        exit;
    }
}
