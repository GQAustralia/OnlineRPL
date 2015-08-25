<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QualificationController extends Controller
{

    /**
     * Function to get unit Evidence
     * return string
     */
    public function getUnitEvidencesAction()
    {
        $userId = $this->getRequest()->get('userId');
        $courseCode = $this->getRequest()->get('course_code');
        $results['unitCode'] = $this->getRequest()->get('unit');
        $results['course_code'] = $courseCode;
        if (!empty($userId)) {
            $user = $this->get('UserService')->getUserInfo($userId);
            $results['unitStatus'] = $this->get('CoursesService')->getUnitStatus($userId, $results['unitCode'],
                $results['course_code']);
            // for getting assigned assessor
            $courseObj = $this->get('CoursesService')->getCourseDetails($courseCode, $userId);
            if ($courseObj) {
                $cAssessor = $courseObj->getAssessor();
                if (!empty($cAssessor)) {
                    $results['courseAssessor'] = $courseObj->getAssessor();
                }
            }
        } else {
            $user = $this->get('security.context')->getToken()->getUser();
        }
        $results['delStatus'] = $this->getRequest()->get('delStatus');
        $results['unittitle'] = $this->getRequest()->get('unittitle');
        $results['course_name'] = $this->getRequest()->get('course_name');
        $results['userId'] = $userId;
        $results['unitevidences'] = $user->getEvidences();
        echo $template = $this->renderView('GqAusUserBundle:Qualification:unitevidence.html.twig', $results);
        exit;
    }

}
