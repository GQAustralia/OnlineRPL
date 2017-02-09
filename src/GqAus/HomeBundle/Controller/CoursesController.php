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
    	$userService = $this->get('UserService');
    	$checkStatus = $userService->getHaveAccessPage($user->getId(), $user->getId(), $id, $user->getRoles());
    	if(!$checkStatus)
    		return $this->render('GqAusUserBundle:Default:error.html.twig');
       
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
    public function submitUnitForReviewAction(Request $request)
    {
        $results = [];
        $user = $this->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        if ($request->isMethod('POST') && $userId != '') {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content)) {
                $params = json_decode($content, true); // 2nd param to get as array
                $unitCode = $params['unitCode'];
                $courseCode = $params['courseCode'];
                $checkEvidenceforAvail = $this->get('EvidenceService')->getUserUnitwiseEvidences($userId, $unitCode,$courseCode);
                $countEvidences = count($checkEvidenceforAvail);
                if ($countEvidences == 0) {
                    $results['error'] = "Please upload some evidences";
                } else {
                    $data = array('unitCode' => $unitCode, 'courseCode' => $courseCode);

                    $results = $this->get('EvidenceService')->unitSubmit($data);
                }
            }
        }

        return new JsonResponse($results);
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
    
    private function unitObjectToArray($userCourseUnits) {
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
            $userService = $this->get('UserService');
            foreach ($userCourseUnits as $units) {
                $unit = [];
                $unit['id'] = $units->getId();
                $unit['unitId'] = $units->getUnitId();
                $unit['userId'] = $units->getUser()->getId();
                $unit['courseCode'] = $units->getCourseCode();
                $unit['type'] = $units->getType();
                $unit['facilitatorStatus'] = $units->getFacilitatorstatus();
                $unit['assessorStatus'] = $units->getAssessorstatus();
                $unit['rtoStatus'] = $units->getRtostatus();
                $unit['status'] = $units->getStatus();
                $unit['electiveStatus'] = $units->getElectiveStatus();
                $unit['isSubmitted'] = $units->getIssubmitted();
                $unit['statusText'] = $userService->getStausByStatus($unit['status'], $unit['userId'], $unit['unitId'], $unit['courseCode'], $units->getUser()->getRoles()[0]);
                $courseUnits[trim($units->getUnitId())] =  $unit;    
            }
        } 
        
        return $courseUnits;
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
                    $results['elective'] = $this->unitObjectToArray($courseService->getUserCourseUnits($userId,$courseCode,'elective'));
                    $results['core'] = $this->unitObjectToArray($courseService->getUserCourseUnits($userId,$courseCode,'core'));
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
     * @param Symfony\Component\HttpFoundation\Request
     * return Json
     */
    
    public function updateSelectedElectiveUnitsAction(Request $request) {
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
                $courseService->resetUnitElectives($userId,$courseCode);
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
    /**
     * Function to download unit Details by type
     * @param $unitId
     * @param $detailsType
     * return null
     */
    public function downloadSelectedElectiveUnitsAction($unitId,$detailsType)
    {
        $courseService = $this->get('CoursesService');
        $results = $courseService->fetchUnitRequest($unitId);
        $title = '';
        $details = '';
        switch($detailsType){
            case 'elements':
                $title = 'Elements and performance criteria';
                $details = $results['elements'];
                break;
            case 'evidence_guide':
                $title = 'Evidence Guide and Range Statement';
                $details = $results['evidence_guide'];
                break;
            case 'skills_and_knowledge':
                $title = 'Evidence Guide and Range Statement';
                $details = $results['skills_and_knowledge'];
                break;
            default:
                $title = 'Details';
                $details = $results['elements'].' '. $results['evidence_guide'].' '.$results['skills_and_knowledge'];
                break;
        }
        $fileTemp = $this->get('kernel')->getRootDir() . '/logs/temp_' . time() . '.pdf';
        $outputFileName = str_replace(" ", "-", $results['title']). ' - '. $results['code'] . '_' . time() . '.pdf';
        $html2pdf = $this->get('html2pdf_factory')->create('P', 'A4', 'en', true, 'UTF-8', array(10, 15, 10, 15));
        $html2pdf->writeHTML($details);
        $html2pdf->Output($outputFileName,  'D');
       exit();
    }
    
    public function getUploadDetailsAction(Request $request) {
       $results = [];
       $user = $this->get('security.context')->getToken()->getUser();
       $userId = $user->getId();
        if ($request->isMethod('POST') && $userId != '') {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $courseService = $this->get('CoursesService');
                $results = $courseService->getUploadDetails($userId);
                
            }
        }
        
        return new JsonResponse($results);        
    }
    
    /**
     * Function to get unit Evidence
     * return string
     */
    public function getEvidencesByUnitAction(Request $request)
    {
        $results = [];
       $user = $this->get('security.context')->getToken()->getUser();
       $userId = $user->getId();
        if ($request->isMethod('POST') && $userId != '') {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $unitCode = $params['unitCode'];
                $courseCode = $params['courseCode'];
                
                $courseService = $this->get('CoursesService');
                $results = $courseService->getEvidencesByUnit($userId,$unitCode,$courseCode);
                
            }
        }
        
        return new JsonResponse($results);     
        
    }
    
    /**
     * Function to Save unit Evidence
     * return string
     */
    public function saveUnitEvidencesAction(Request $request)
    {
       $results = [];
       $user = $this->get('security.context')->getToken()->getUser();
       $userId = $user->getId();
        if ($request->isMethod('POST') && $userId != '') {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $unitCode = $params['unitCode'];
                $courseCode = $params['courseCode'];
                $category = $params['courseCode'];
                
                $courseService = $this->get('CoursesService');
                $results = $courseService->getEvidencesByUnit($userId,$unitCode,$courseCode);
                
            }
        }
        
        return new JsonResponse($results);     
        
    }
}
