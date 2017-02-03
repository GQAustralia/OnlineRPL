<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\EvidenceForm;
use GqAus\UserBundle\Form\AssessmentForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class CoursesController extends Controller
{

    /**
     * Function for dashboard landing page
     * @param int $id
     * @param String $page
     * @param object $request
     * return array
     */
    public function indexAction($id, $page = 'qualification', Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $courseService = $this->get('CoursesService');
        $results = $courseService->getCoursesInfo($id);
        $courseService->updateQualificationUnits($user->getId(), $id, $results);
       // $getUnits = $courseService->getQualificationElectiveUnits($user->getId(), $id);
        $results['packagerulesInfo'] = $courseService->getPackagerulesInfo($id);
        //$results['electiveUnits'] = $getUnits['courseUnits'];
       // $results['electiveApprovedUnits'] = $getUnits['courseApprovedUnits'];
        //$results['evidences'] = $user->getEvidences();
        $results['courseDetails'] = $courseService->getCourseDetails($id, $user->getId());
       /* $form = $this->createForm(new EvidenceForm(), array());
        $results['form'] = $form->createView();
        $assessmentForm = $this->createForm(new AssessmentForm(), array());
        $results['assessmentForm'] = $assessmentForm->createView();*/
        $results['statusList'] = $this->get('UserService')->getQualificationStatus();
        $results['qualificationPage'] = $page;
//print_r($results['courseDetails']);
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
        $userId = $this->getRequest()->get('userId');
        $userCourses = $user->getCourses();
        
        if(!empty($userCourses))
        {
            $courseService = $this->get('CoursesService');
            $rtoService = $this->get('RtoService');
            foreach($userCourses as $coursearr){
                $id = $coursearr->getCourseCode();
                
                $results = $courseService->getCoursesInfo($id);
                $results['packagerulesInfo'] = $courseService->getPackagerulesInfo($id);
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
        }
        else{
            $results = '';
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
    /**
     * Function to Submit Unit for Review
     * return string
     */
    public function submitUnitForReviewAction()
    {
        
        $userId = $this->getRequest()->get('userId');
        $unitId = $this->getRequest()->get('unitId');
        $courseCode = $this->getRequest()->get('courseCode');
        $selfAssNotes = $this->getRequest()->get('selfAssNotes');
        $selfAssId = $this->getRequest()->get('selfAssId');

        $checkEvidenceforAvail = $this->get('EvidenceService')->getUserUnitwiseEvidences($userId, $unitId,$courseCode);
        $countEvidences = count($checkEvidenceforAvail);
       // $data = array('self_assessment'=>$selfAssNotes,'hid_unit_assess'=>$unitId,'hid_course_assess'=>$courseCode,'setAssessment' => '1');
        
        if($countEvidences == 0 )
        {
            echo "2&&" . $unitId;
        }
        else
        {
            if($selfAssNotes == "" || $countEvidences == 0)
            {
                echo "3&&" . $unitId;
            }
            else
            {
                $data = array('self_assessment'=>$selfAssNotes,'hid_unit_assess'=>$unitId,'hid_course_assess'=>$courseCode,'setAssessment' => '1','selfAssId' => $selfAssId);
                if($selfAssId !='')
                    echo $result = $this->get('EvidenceService')->updateEvidenceAssessment($data);
                else
                    echo $result = $this->get('EvidenceService')->saveEvidenceAssessment($data);
            }
        }
        exit;
    }
    
    /**
     * Function to get Elective Units
     * @param object $request
     * return Json
     */
    
    public function getUnitsAction(Request $request)
    {
        $results = [];
        if ($request->isMethod('POST')) {
            $params = array();
            $type = "";
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $id = $params['courseCode'];
                if($id != ''){
                    $user = $this->get('security.context')->getToken()->getUser();
                    $statusList = $this->get('UserService')->getQualificationStatus();
                    $courseService = $this->get('CoursesService');
                    $results = $courseService->fetchCourseRequest($id);
//                    foreach($results['Units']['Elective']['groups'] as $key=>$group){
//                        foreach($group['unit'] as $index=>$elective){
//                            $results['Units']['Elective']['groups'][$key]['unit'][$index]['details'] = $courseService->fetchUnitRequest($elective['id']);
//                        }
//                    }
                    $results['statusList'] = $statusList;
//                    $courseService->updateQualificationUnits($user->getId(), $id, $results);
//                    $getUnits = $courseService->getQualificationElectiveUnits($user->getId(), $id);
//                    $results['packagerulesInfo'] = $courseService->getPackagerulesInfo($id);
//                    $results['electiveUnits'] = $getUnits['courseUnits'];
//                    $results['electiveApprovedUnits'] = $getUnits['courseApprovedUnits'];
//                    $results['evidences'] = $user->getEvidences();
//                    $results['courseDetails'] = $courseService->getCourseDetails($id, $user->getId());
//                    $results['statusList'] = $this->get('UserService')->getQualificationStatus();
                }
               
            }
        }
        
       
        //var_dump($results);
        //exit();
        return new JsonResponse($results);
        
    }

    /**
     * Function to get the unit details
     * @param  Symfony\Component\HttpFoundation\Request
     * return Json
     */
    
    
    public function getUserUnitsAction(Request $request) {
         $results = [
             'elective' => [],
             'core' => []
         ];
         $user = $this->get('security.context')->getToken()->getUser();
        if ($request->isMethod('POST')) {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $courseCode = $params['courseCode'];
                $userId = $user->getId();
                if($userId != '' && $courseCode != ''){
                    $courseService = $this->get('CoursesService');
                    $results['elective'] = $courseService->getUserCourseUnits($userId,$courseCode,'elective');
                    $results['core'] = $courseService->getUserCourseUnits($userId,$courseCode,'core');
                }
               
            }
        }
        
       
        //var_dump($results);
        //exit();
        return new JsonResponse($results);
    }
     /**
     * Function to get the unit details
      * @param  object $request
     * return Json
     */
    
    public function getUnitDetailsAction(Request $request) 
    {
        $results = [];
        if ($request->isMethod('POST')) {
            $params = array();
            $type = "";
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $id = $params['unitCode'];
                if($id != ''){
                    $user = $this->get('security.context')->getToken()->getUser();
                    $courseService = $this->get('CoursesService');
                    $results = $courseService->fetchUnitRequest($id);
                }
               
            }
        }
        
        return new JsonResponse($results);
    }
    
    /**
     * Function to update the selected Units
     * @param 
     * return Json
     */
    
    public function updateSelectedElectiveUnitsAction() {
       $results = [];
       $user = $this->get('security.context')->getToken()->getUser();
       $userId = $user->getId();
        if ($request->isMethod('POST') && $userId != '') {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $units = $params['units'];
                $courseCode = $params['courseCode'];
                $courseService = $this->get('CoursesService');
                $courseService->resetUnitElectives();
                foreach($units as $unit) {
                     $results = $courseService->updateUnitElective($userId,$unit['id'],$courseCode);
                }
                
               
            }
        }
        
        return new JsonResponse($results); 
    }
    /**
     * Function to update elective Units file
     * return Json
     */
    
    public function uploadElectiveUnitsAction()
    {
        
    }
    
    /**
     * Function to update Self Assessment 
     * return json
     */
    
    public function updateSelfAssessmentAction()
    {
        
    }  


}
