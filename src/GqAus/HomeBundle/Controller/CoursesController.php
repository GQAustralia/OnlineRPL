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
        $courseService->updateQualificationUnits($user->getId(), $id, $results);
        $getUnits = $courseService->getQualificationElectiveUnits($user->getId(), $id);
        $results['electiveUnits'] = $getUnits['courseUnits'];
        $results['electiveApprovedUnits'] = $getUnits['courseApprovedUnits'];
        $results['evidences'] = $user->getEvidences();        
        $results['courseDetails'] = $courseService->getCourseDetails($id, $user->getId());
        $form = $this->createForm(new EvidenceForm(), array());
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
        
        $getEvidences = $this->get('EvidenceService')->getUserUnitEvidences($userId, $unitId);        
        if (!empty($getEvidences)) {
            foreach ($getEvidences as $evidences) {
                $evidenceId = $evidences->getId();
                $evidenceType = $evidences->getType();
                $this->get('EvidenceService')->updateInactiveEvidence($evidenceId, $evidenceType);
                /*if ($evidenceType != 'text') {
                    $this->get('gq_aus_user.file_uploader')->delete($fileName);
                }*/
            }
        }
        echo $results = $courseService->updateUnitElective($userId, $unitId, $courseCode);
        exit;
    }
    
    /**
    * Function to get unit Evidence
    * return $result array
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
