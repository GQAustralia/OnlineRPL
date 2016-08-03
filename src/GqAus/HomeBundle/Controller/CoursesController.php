<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\EvidenceForm;
use GqAus\UserBundle\Form\AssessmentForm;

class CoursesController extends Controller
{

    /**
     * Function for dashboard landing page
     * @param int $id
     * @param object $request
     * return array
     */
    public function indexAction($id, Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $courseService = $this->get('CoursesService');
        $results = $courseService->getCoursesInfo($id);
        $courseService->updateQualificationUnits($user->getId(), $id, $results);
        $getUnits = $courseService->getQualificationElectiveUnits($user->getId(), $id);
        $results['electiveUnits'] = $getUnits['courseUnits'];
        $results['electiveApprovedUnits'] = $getUnits['courseApprovedUnits'];
        $results['evidences'] = $user->getEvidences();
        $results['courseDetails'] = $courseService->getCourseDetails($id, $user->getId());
        $form = $this->createForm(new EvidenceForm(), array());
        $results['form'] = $form->createView();
        $assessmentForm = $this->createForm(new AssessmentForm(), array());
        $results['assessmentForm'] = $assessmentForm->createView();
        $results['statusList'] = $this->get('UserService')->getQualificationStatus();
        return $this->render('GqAusHomeBundle:Courses:qualifications.html.twig', $results);
    }

    /**
     * Function for qualifications list
     * return array
     */
    public function qualificationsAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $statusList = $this->get('UserService')->getQualificationStatus();       
        $userCourses = $user->getCourses();        
        foreach($userCourses as $coursearr){
            $id = $coursearr->getCourseCode();
            $courseService = $this->get('CoursesService');
            $results = $courseService->getCoursesInfo($id);
            $courseService->updateQualificationUnits($user->getId(), $id, $results);
            $getUnits = $courseService->getQualificationElectiveUnits($user->getId(), $id);
            $results['electiveUnits'] = $getUnits['courseUnits'];
            $results['electiveApprovedUnits'] = $getUnits['courseApprovedUnits'];
            $results['evidences'] = $user->getEvidences();
            $results['courseDetails'] = $courseService->getCourseDetails($id, $user->getId());
            $form = $this->createForm(new EvidenceForm(), array());
            $results['form'] = $form->createView();
            $assessmentForm = $this->createForm(new AssessmentForm(), array());
            $results['assessmentForm'] = $assessmentForm->createView();
        }      
        return $this->render('GqAusHomeBundle:Courses:qualifications.html.twig', 
            array('userCourses' => $user->getCourses(),
                'courseConditionStatus' => $user->getCourseConditionStatus(),
                'statusList' => $statusList,'results' => $results));
    }

    /**
     * Function to update status of unit electives
     * return int
     */
    public function updateUnitElectiveAction()
    {
        $userId = $this->getRequest()->get('userId');
        $unitId = $this->getRequest()->get('unitId');
        $courseCode = $this->getRequest()->get('courseCode');
        $getEvidences = $this->get('EvidenceService')->getUserUnitEvidences($userId, $unitId);       
        if (!empty($getEvidences)) {
            foreach ($getEvidences as $evidences) {
                $evidenceId = $evidences->getId();
                $evidenceType = $evidences->getType();
                $this->get('EvidenceService')->updateInactiveEvidence($evidenceId, $evidenceType);
            }
        }
        echo $this->get('CoursesService')->updateUnitElective($userId, $unitId, $courseCode);
        exit;
    }

    /**
     * Function to get unit Evidence
     * return string
     */
    public function getUnitEvidencesAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $results['unitevidences'] = $user->getEvidences();
        $results['unitCode'] = $this->getRequest()->get('unit');
        $results['delStatus'] = $this->getRequest()->get('delStatus');
        echo $template = $this->renderView('GqAusHomeBundle:Courses:unitevidence.html.twig', $results);
        exit;
    }

}
