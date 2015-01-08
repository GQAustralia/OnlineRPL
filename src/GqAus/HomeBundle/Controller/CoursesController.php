<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoursesController extends Controller
{
    /**
    * Function for dashboard landing page
    * params $id
    * return $result array
    */
    public function indexAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $courseService = $this->get('CoursesService');
        $results = $courseService->getCoursesInfo($id);
        return $this->render('GqAusHomeBundle:Courses:index.html.twig', $results);
    }
    
    /**
    * Function for qualifications list
    * return $result array
    */
    public function qualificationsAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userCourses = $user->getCourses();
        $courseConditionStatus = $user->getCourseConditionStatus();
        return $this->render('GqAusHomeBundle:Courses:qualifications.html.twig', array('userCourses' => $userCourses,
                                                                        'courseConditionStatus' => $courseConditionStatus));
    }    
}
