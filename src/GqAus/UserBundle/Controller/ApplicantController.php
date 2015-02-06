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
        $result = array();
        $result['userId'] = $this->getRequest()->get('userId');
        $result['unit'] = $this->getRequest()->get('unit');
        $result['status'] = $this->getRequest()->get('status');
        $result['userRole'] = $this->getRequest()->get('userRole');
        $result['currentUserName'] = $this->get('security.context')->getToken()->getUser()->getUserName();
        $result['currentUserId'] = $this->get('security.context')->getToken()->getUser()->getId();
        $result['currentuserRole'] = $this->get('security.context')->getToken()->getUser()->getRoles();
        $result['courseName'] = $this->getRequest()->get('courseName');
        $result['unitName'] = $this->getRequest()->get('unitName');
        echo $this->get('UserService')->updateApplicantEvidences($result);
        $this->get('UserService')->updateUserApplicantsList($result['currentUserId'], $result['currentuserRole']);
        exit;
    }
    
    /**
    * Function to add reminder/notes
    */
    public function addReminderAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userCourseId = $this->getRequest()->get('userCourseId');
        $remindDate = $this->getRequest()->get('remindDate');
        $message = $this->getRequest()->get('message');
        echo $status = $this->get('UserService')->addQualificationReminder($userId, $userCourseId, $message, $remindDate);
        exit;
    }

    /**
    * Function list applicants list
    * return $result array
    */
    public function applicantsListAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        /*$this->get('UserService')->updateUserApplicantsList($userId, $userRole);*/
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '0');
        $results['pageRequest'] = 'submit';
        return $this->render('GqAusUserBundle:Applicant:list.html.twig', $results);
    }

    /**
    * Function search applicants list
    * return $result array
    */
    public function searchApplicantsListAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $searchName = $this->getRequest()->get('searchName');
        $searchTime = $this->getRequest()->get('searchTime');
        $status = $this->getRequest()->get('status');
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, $status, $searchName, $searchTime);
        $results['pageRequest'] = 'ajax'; 
        echo $this->renderView('GqAusUserBundle:Applicant:applicants.html.twig', $results); exit;
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
        $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
        $unitsIds = array();
        foreach ($courseEvidences as $value) {
            $unitsIds[] = $value->getUnit(); 
        }
        $i = 0;
        foreach ($results['courseInfo']['Units']['Unit'] as $unit){
            if(in_array($unit['id'], $unitsIds)) {               
                $evidences = $evidenceObj->getUserUnitEvidences($uid, $unit['id']);
                foreach ($evidences as $evidence) {
                    if ($evidence->getType() !== 'text') {
                        $results['courseInfo']['Units']['Unit'][$i]['path'] = $evidence->getPath();
                        $results['courseInfo']['Units']['Unit'][$i]['pathName'] = $evidence->getName();
                    } else {
                        $results['courseInfo']['Units']['Unit'][$i]['path'] = '';
                        $results['courseInfo']['Units']['Unit'][$i]['pathName'] = '';
                    }
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
        $user = $this->get('UserService')->getUserInfo($uid);
        $evidenceObj = $this->get('EvidenceService');
        $evidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);
        if (count($evidences) > 0) {
            foreach ($evidences as $evidence) {
                if ($evidence->getType() !== 'text')
                    array_push($files, $this->container->getParameter('amazon_s3_base_url') . $evidence->getPath());
            }
            if (count($files) === 0) {
                echo "<script>alert('No files to download');window.close();</script>"; exit;
            }
            $zip = new \ZipArchive();
            $zipName = 'downloads/' . $user->getUserName() . '-' . time() . ".zip";
            $zip->open($zipName, \ZipArchive::CREATE);
            foreach ($files as $f) {
                $zip->addFromString(basename($f), file_get_contents($f));
            }
            $zip->close();
            //session_write_close();
            header('Content-Type', 'application/zip');
            header('Content-disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);
        } else {            
            echo "<script>alert('No files to download');window.close();</script>"; exit;
        }
    }
    
    /**
    * Function to approve certification by rto user
    */
    public function approveCertificationAction()
    {
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');
        $results = $this->get('UserService')->rtoApproveCertification($courseCode, $applicantId); exit;
    }
}
