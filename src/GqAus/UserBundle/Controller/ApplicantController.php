<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicantController extends Controller
{
   /**
    * Function to get applicant details page
    * return $result array
    */
    public function detailsAction($qcode, $uid, Request $request)
    {
        $user = $this->get('UserService')->getUserInfo($uid);
        $results = $this->get('CoursesService')->getCoursesInfo($qcode);
        if (!empty($user) && isset($results['courseInfo']['id'])) {
            $applicantInfo = $this->get('UserService')->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
            return $this->render('GqAusUserBundle:Applicant:details.html.twig', array_merge($results, $applicantInfo));
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
    }
    
    /**
    * Function to update user unit evidence status
    * return $result array
    */
    public function setUserUnitEvidencesStatusAction()
    {
        $userId = $this->getRequest()->get('userId');
        $unit = $this->getRequest()->get('unit');
        $status = $this->getRequest()->get('status');
        $userRole = $this->getRequest()->get('userRole');
        $currentUserName = $this->get('security.context')->getToken()->getUser()->getUserName();
        echo $this->get('UserService')->updateApplicantEvidences($userId, $unit, $userRole, $status, $currentUserName);
        exit;
    }
    
    /**
    * Function to get applicant details page
    * return $result array
    */
    public function downloadAction($qcode, $uid)
    {
        $user = $this->get('UserService')->getUserInfo($uid);
        $evidenceObj = $this->get('EvidenceService');
        $results = $this->get('CoursesService')->getCoursesInfo($qcode);
        $courseEvidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);        
        
        foreach ($courseEvidences as $value) {
            $unitsIds[] = $value->getUnit(); 
        }
        $i = 0;
        foreach ($results['courseInfo']['Units']['Unit'] as $unit){
            if(in_array($unit['id'], $unitsIds)) {               
                $evidences = $evidenceObj->getUserUnitEvidences($uid, $unit['id']);
                foreach ($evidences as $evidence) {
                    $results['courseInfo']['Units']['Unit'][$i]['path'] = $evidence->getPath();                
                    $results['courseInfo']['Units']['Unit'][$i]['pathName']= $evidence->getName();
                }
            } else {
                $results['courseInfo']['Units']['Unit'][$i]['path'] = '';
                $results['courseInfo']['Units']['Unit'][$i]['pathName'] = '';
            }
            $i++;
        }
        if (!empty($user) && isset($results['courseInfo']['id'])) {            
            $applicantInfo = $this->get('UserService')->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
            $html = $this->renderView('GqAusUserBundle:Applicant:download.html.twig', array_merge($results, $applicantInfo));
            
            $fileName = $user->getUserName().'_'.$results['courseInfo']['name'];
            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'.pdf"'
                    )
            );
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }   
    }
    
    /**
    * Function to Zip all the Evidences files of one course to specific user
    */
    public function zipAction($qcode, $uid)
    {
        $files = array();
        $evidenceObj = $this->get('EvidenceService');
        $evidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);
        foreach ($evidences as $evidence) {
            array_push($files, $this->container->getParameter('amazon_s3_base_url').$evidence->getPath());
        }
        $zip = new \ZipArchive();
        $zipName = 'Documents-'.time().".zip";
        $zip->open($zipName,  \ZipArchive::CREATE);
        foreach ($files as $f) {
            $zip->addFromString(basename($f),  file_get_contents($f)); 
        }
        $zip->close();
        //session_write_close();
        header('Content-Type', 'application/zip');
        header('Content-disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);
    }
}
