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
        $userService = $this->get('UserService');
        $coursesService = $this->get('CoursesService');
        $user = $userService->getUserInfo($uid);
        $results = $coursesService->getCoursesInfo($qcode);
        if (!empty($user) && isset($results['courseInfo']['id'])) {
            $applicantInfo = $userService->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $coursesService->getElectiveUnits($uid, $qcode);
            $results['courseCode'] = $qcode;
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
        $remDate = explode("/",$remindDate);
        $remindDate = $remDate[2]."-".$remDate[1]."-".$remDate[0];
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
        $page = $this->get('request')->query->get('page', 1);
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '0', $page);
        $results['pageRequest'] = 'submit';
        $results['status'] = 0;
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
        $page = $this->getRequest()->get('pagenum');
        if($page == "")
            $page=1;
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, $status, $page, $searchName, $searchTime);
        $results['pageRequest'] = 'ajax';
        $results['status'] = $status; 
        echo $this->renderView('GqAusUserBundle:Applicant:applicants.html.twig', $results); exit;
    }
    
    /**
    * Function search complete applicants list
    * return $result array
    */
    public function searchApplicantsListReportsAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $searchName = trim($this->getRequest()->get('searchName')," ");
        $searchTime = $this->getRequest()->get('searchTime');
        $searchQualification = trim($this->getRequest()->get('searchQualification')," ");
        $searchDateRange = $this->getRequest()->get('searchDateRange');
        $searchDates = explode("-",$searchDateRange);
        $startDate = $searchDates[0];
        $endDate = $searchDates[1];
        $startDatearr = explode("/",$startDate);
        $startDate = trim($startDatearr[2]," ")."-".$startDatearr[1]."-".$startDatearr[0]; 
        $endDatearr = explode("/",$endDate);
        $endDate = $endDatearr[2]."-".$endDatearr[1]."-".trim($endDatearr[0]," ");
        $status = $this->getRequest()->get('status');
        $page = $this->getRequest()->get('pagenum');
        if($page == "")
            $page=1;
        //$page = $this->get('request')->query->get('page', 1);
        $results = $this->get('UserService')->getUserApplicantsListReports($userId, $userRole, $status, $page, $searchName, $searchQualification, $startDate, $endDate, $searchTime);
        $results['pageRequest'] = 'ajax'; 
        echo $this->renderView('GqAusUserBundle:Reports:ajax-applicants.html.twig', $results); exit;
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
        foreach ($results['courseInfo']['Units']['Unit'] as $unit) {
            $results['courseInfo']['Units']['Unit'][$i]['name'] = preg_replace('/[^A-Za-z0-9\-]/', ' ', $results['courseInfo']['Units']['Unit'][$i]['name']);
            if (in_array($unit['id'], $unitsIds)) {
                $evidences = $evidenceObj->getUserUnitEvidences($uid, $unit['id']);
                $j = 0;
                $unitEvidencs = array();
                foreach ($evidences as $evidence) {
                    if ($evidence->getType() !== 'text') {
                        $unitEvidencs[$j]['path'] = $evidence->getPath();
                        $unitEvidencs[$j]['pathName'] = $evidence->getPath();
                    }
                    $j++;
                }
                $results['courseInfo']['Units']['Unit'][$i]['unitEvidences'] = $unitEvidencs;
            } else
                $results['courseInfo']['Units']['Unit'][$i]['unitEvidences'] = '';
            $i++;
        }
        if (!empty($user) && isset($results['courseInfo']['id'])) {
            $applicantInfo = $this->get('UserService')->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
            $html = $this->renderView('GqAusUserBundle:Applicant:download.html.twig', array_merge($results, $applicantInfo));

            $fileName = $user->getUserName() . '_' . $results['courseInfo']['name'];
            return new Response(
                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '.pdf"'
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
        $fileUploderService = $this->get('gq_aus_user.file_uploader');
        $evidenceObj = $this->get('EvidenceService');
        $evidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);
        if (count($evidences) > 0) {
            foreach ($evidences as $evidence) {
                $fileName = $evidence->getPath();
                if ($fileName) {
                    //if ($fileUploderService->fileExists($fileName)) {
                        array_push($files, $this->container->getParameter('amazon_s3_base_url') . $fileName);
                    //}
                }
            }
            if (count($files) === 0) {
                echo "<script>alert('No files to download');window.close();</script>";
                exit;
            }
            $zip = new \ZipArchive();
            $zipName = $user->getUserName() . '-' . time() . ".zip";
            $zip->open($zipName, \ZipArchive::CREATE);
            foreach ($files as $f) {
                $zip->addFromString(basename($f), file_get_contents($f));
            }
            $zip->close();
            
            $response = new Response( );
            $response->headers->set( "Content-type", 'application/zip' );
            $response->headers->set( "Content-Disposition", "attachment; filename=$zipName" );
            $response->headers->set( "Content-length", filesize( "$zipName" ) );
            $response->headers->set( "Pragma", "no-cache" );
            $response->headers->set( "Expires", "0" );
            $response->send( );

            $response->setContent( readfile( "$zipName" ) );

            return $response;        } else {
            echo "<script>alert('No files to download');window.close();</script>";
            exit;
        }
    }
    
    /**
    * Function to approve certification by rto user
    */
    public function approveCertificationAction() {
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');
        $results = $this->get('UserService')->rtoApproveCertification($courseCode, $applicantId); exit;
    }
    
    /**
    * Function to approve for rto user
    */
    public function approveForRTOAction() {
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');
        $results = $this->get('UserService')->approveForRTOCertification($courseCode, $applicantId); exit;
    }
    
    /**
    * Function to view reports
    */
    public function reportsAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        if($userRole[0]!="ROLE_ASSESSOR") {
            /*$this->get('UserService')->updateUserApplicantsList($userId, $userRole);*/
            $page = $this->get('request')->query->get('page', 1);
            $results = $this->get('UserService')->getUserApplicantsListReports($userId, $userRole, '2', $page);
            $results['pageRequest'] = 'submit';
            return $this->render('GqAusUserBundle:Reports:list.html.twig', $results);
        }
        else {
            return $this->redirect('dashboard');
        }
    }
}
