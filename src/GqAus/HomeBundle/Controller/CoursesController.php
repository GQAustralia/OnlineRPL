<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\EvidenceForm;

class CoursesController extends Controller
{
    /**
    * Function for dashboard landing page
    * params $id
    * return $result array
    */
    public function indexAction($id, Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $courseService = $this->get('CoursesService');
        $results = $courseService->getCoursesInfo($id);
        $results['electiveUnits'] = $courseService->getElectiveUnits($user->getId(), $id);
        $form = $this->createForm(new EvidenceForm(), array());
		if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                echo "<pre>"; print_r($data); exit;
                $fileNames = $this->get('gq_aus_user.file_uploader')->process($data['file']);
                $result = $this->get('EvidenceService')->saveEvidence($fileNames, $data['unit']);
                echo "<pre>"; print_r($fileNames); exit;
            }
        }
        $results['form'] = $form->createView();
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
    
    /**
    * Function to update status of unit electives
    * return $result array
    */
    public function updateUnitElectiveAction()
    {
        $userId = $this->getRequest()->get('userId');
        $unitId = $this->getRequest()->get('unitId');
        $courseCode = $this->getRequest()->get('courseCode');
        $courseService = $this->get('CoursesService');
        echo $results = $courseService->updateUnitElective($userId, $unitId, $courseCode);
        exit;
        
    }
    
    /**
    * Function to add Evidence of unit electives
    * return $result array
    */
    public function addEvidenceAction()
    {
        echo '<pre>'; print_r($_FILES); print_r($_REQUEST); exit;
    }
}
