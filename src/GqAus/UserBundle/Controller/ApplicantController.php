<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GqAus\UserBundle\Form\NotesForm;

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
            $role = $this->get('security.context')->getToken()->getUser()->getRoles();
            if ($role[0] == \GqAus\UserBundle\Entity\Facilitator::ROLE_NAME || $role[0] == \GqAus\UserBundle\Entity\Manager::ROLE_NAME) {
                $results['rtos'] = $userService->getUsers(\GqAus\UserBundle\Entity\Rto::ROLE);
                $results['assessors'] = $userService->getUsers(\GqAus\UserBundle\Entity\Assessor::ROLE);
                if ($role[0] == \GqAus\UserBundle\Entity\Superadmin::ROLE_NAME || $role[0] == \GqAus\UserBundle\Entity\Manager::ROLE_NAME) {
                    $results['facilitators'] = $userService->getUsers(\GqAus\UserBundle\Entity\Facilitator::ROLE);
                }
            }
            $results['electiveUnits'] = $coursesService->getElectiveUnits($uid, $qcode);
            $results['courseCode'] = $qcode;
            // for getting the status list dropdown
            $results['statusList'] = array();
            $results['statusList'] = $userService->getqualificationStatus();
            
            if ($role[0] == \GqAus\UserBundle\Entity\Facilitator::ROLE_NAME || $role[0] == \GqAus\UserBundle\Entity\Assessor::ROLE_NAME ) {
                $notesForm = $this->createForm(new NotesForm(), array());
                $results['notesForm'] = $notesForm->createView();
            }
            
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
        $result['courseCode'] = $this->getRequest()->get('courseCode');
        $result['unitName'] = $this->getRequest()->get('unitName');
        $userUnitEvStatus = $this->get('UserService')->updateApplicantEvidences($result);
        echo $userUnitEvStatus.= "&&" . $this->get('UserService')->updateCourseRTOStatus($result['currentUserId'], $result['currentuserRole'], $result['courseCode']);
        /*echo $userUnitEvStatus.= "&&" . $this->get('UserService')->updateUserApplicantsList($result['currentUserId'], $result['currentuserRole'], $result['courseCode']);*/
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
        if (empty($userCourseId)) {
            $userId = $this->getRequest()->get('listId');
        }
        /*$remDate = explode("/", $remindDate);
        $remindDate = $remDate[2] . "-" . $remDate[1] . "-" . $remDate[0];*/
        $remindDate = str_replace('/', '-', $remindDate);
        $remindDate = date("Y-m-d H:i:s", strtotime(strtoupper($remindDate)));
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
        /* $this->get('UserService')->updateUserApplicantsList($userId, $userRole); */
        $page = $this->get('request')->query->get('page', 1);
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '0', $page);
        $results['pageRequest'] = 'submit';
        $results['status'] = 0;
        $users = array();
        $qualificationStatus = array();
        if ($userRole[0] == 'ROLE_MANAGER' || $userRole[0] == 'ROLE_SUPERADMIN') {
            $users = $this->get('UserService')->getUserByRole();
            $qualificationStatus = $this->get('UserService')->getqualificationStatus();
        }
        $results['users'] = $users;
        $results['qualificationStatus'] = $qualificationStatus;
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
        $filterByUser = $this->getRequest()->get('filterByUser');
        $filterByStatus = $this->getRequest()->get('filterByStatus');
        $status = $this->getRequest()->get('status');
        $page = $this->getRequest()->get('pagenum');
        if ($page == "")
            $page = 1;
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, $status, $page, $searchName, $searchTime, $filterByUser, $filterByStatus);
        $results['pageRequest'] = 'ajax';
        $results['status'] = $status;
        echo $this->renderView('GqAusUserBundle:Applicant:applicants.html.twig', $results);
        exit;
    }

    /**
     * Function search complete applicants list
     * return $result array
     */
    public function searchApplicantsListReportsAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $searchName = trim($this->getRequest()->get('searchName'), " ");
        $searchTime = $this->getRequest()->get('searchTime');
        $searchQualification = trim($this->getRequest()->get('searchQualification'), " ");
        $searchDateRange = $this->getRequest()->get('searchDateRange');
        $searchDates = explode("-", $searchDateRange);
        $startDate = $searchDates[0];
        $endDate = $searchDates[1];
        $startDatearr = explode("/", $startDate);
        $startDate = trim($startDatearr[2], " ") . "-" . $startDatearr[1] . "-" . $startDatearr[0];
        $endDatearr = explode("/", $endDate);
        $endDate = $endDatearr[2] . "-" . $endDatearr[1] . "-" . trim($endDatearr[0], " ");
        $status = $this->getRequest()->get('status');
        $page = $this->getRequest()->get('pagenum');
        if ($page == "")
            $page = 1;
        //$page = $this->get('request')->query->get('page', 1);
        $results = $this->get('UserService')->getUserApplicantsListReports($userId, $userRole, $status, $page, $searchName, $searchQualification, $startDate, $endDate, $searchTime);
        $results['pageRequest'] = 'ajax';
        echo $this->renderView('GqAusUserBundle:Reports:ajax-applicants.html.twig', $results);
        exit;
    }

    /**
     * Function to get applicant details page
     * return $result array
     */
    public function downloadAction($qcode, $uid)
    {
        error_reporting(0);
        $user = $this->get('UserService')->getUserInfo($uid);
        $evidenceObj = $this->get('EvidenceService');
        $results = $this->get('CoursesService')->getCoursesInfo($qcode);
        $courseEvidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);
        //$results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
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
                        $unitEvidencs[$j]['id'] = $evidence->getId();
                        $unitEvidencs[$j]['path'] = $evidence->getPath();
                        $unitEvidencs[$j]['pathName'] = $evidence->getName();
                        $unitEvidencs[$j]['type'] = $evidence->getType();
                    } else {
                        $unitEvidencs[$j]['id'] = $evidence->getId();
                        $unitEvidencs[$j]['content'] = $evidence->getContent();
                        $unitEvidencs[$j]['type'] = $evidence->getType();
                    }
                    $j++;
                }
                $results['courseInfo']['Units']['Unit'][$i]['unitEvidences'] = $unitEvidencs;
            } else
                $results['courseInfo']['Units']['Unit'][$i]['unitEvidences'] = '';
            $i++;
        }
        if (!empty($user) && isset($results['courseInfo']['id'])) {
            $results["user"] = $user;
            $results["userIdFiles"] = $user->getIdfiles();
            $applicantInfo = $this->get('UserService')->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
            $results['projectPath'] = $this->get('kernel')->getRootDir() . '/../';
            $content = $this->renderView('GqAusUserBundle:Applicant:download.html.twig', array_merge($results, $applicantInfo));
            $fileTemp = 'temp_'.time().'.pdf';
            $outputFileName = str_replace(" ", "-", $user->getUserName()) . '_' . str_replace(" ", "-", $results['courseInfo']['name']).'_'.time().'.pdf';
            
            $html2pdf = $this->get('html2pdf_factory')->create('P', 'A4', 'en', true, 'UTF-8', array(10, 15, 10, 15));
            $html2pdf->setDefaultFont('OpenSans');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output($fileTemp,'F');            
            
            //return $this->redirectToRoute('mergePDFAction', array('userDataPDF'=> $fileTemp, 'outputFileName' =>$outputFileName ));
            $response = new Response( );
            $response->headers->set( "Content-type", 'application/pdf' );
            $response->headers->set( "Content-Disposition", "attachment; filename=$outputFileName" );
            $response->send( );
            $response->setContent( readfile( "$fileTemp" ) );
            unlink($fileTemp);
            return $response;
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
    }

    /**
     * Function to Zip all the Evidences files of one course to specific user
     */
    public function zipAction($qcode, $uid)
    {
        error_reporting(0);
        $user = $this->get('UserService')->getUserInfo($uid);
        $fileUploderService = $this->get('gq_aus_user.file_uploader');
        $evidenceObj = $this->get('EvidenceService');
        $evidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);
        if (count($evidences) > 0) {
            $zip = new \ZipArchive();
            $zipName = str_replace(" ", "-",$user->getUserName()) . '-' . time() . ".zip";
            $zip->open($zipName, \ZipArchive::CREATE);
            $fileFlag = 0;
            foreach ($evidences as $evidence) {
                if ($evidence->getType() !== 'text') {
                    $fileFlag = 1;
                    $unitCode = $evidence->getUnit();
                   if ( !is_dir($unitCode) )
                    {
                      $zip->addEmptyDir($unitCode);  
                    }
                    $nfname = $unitCode.'/'.$evidence->getName();
                    $fname = $this->container->getParameter('amazon_s3_base_url') . $evidence->getPath();
                    $zip->addFromString($nfname, file_get_contents($fname));
                }
                
            }
            $zip->close();
            
            if ( $fileFlag == 0 ) {
                echo "<script>alert('No files to download');window.close();</script>";
                exit;
            }
            $response = new Response( );
            $response->headers->set("Content-type", 'application/zip');
            $response->headers->set("Content-Disposition", "attachment; filename=$zipName");
            $response->headers->set("Content-length", filesize("$zipName"));
            $response->headers->set("Pragma", "no-cache");
            $response->headers->set("Expires", "0");
            $response->send();

            $response->setContent(readfile("$zipName"));

            return $response;
        } else {
            echo "<script>alert('No files to download');window.close();</script>";
            exit;
        }
    }

    /**
     * Function to view evidence
     * return $result array
     */
    public function viewEvidenceAction($evidenceId)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($evidenceId > 0) {
                $evidenceObj = $this->get('EvidenceService');
                $evidences = $evidenceObj->getEvidenceById($evidenceId);
                if (count($evidences) > 0) {
                    $results = array();
                    if ($evidences->getType() !== 'text') {
                        $results['userId'] = $evidences->getUser();
                        $results['id'] = $evidences->getId();
                        $results['path'] = $evidences->getPath();
                        $results['pathName'] = $evidences->getName();
                    }
                    return $this->render('GqAusUserBundle:Evidence:view-evidence.html.twig', $results);
                }
            }
        } else {
            return $this->redirect('dashboard');
            //throw $this->createAccessDeniedException();    
        }
    }

    /**
     * Function to approve certification by rto user
     */
    public function approveCertificationAction()
    {
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');
        $results = $this->get('UserService')->rtoApproveCertification($courseCode, $applicantId);
        exit;
    }

    /**
     * Function to approve for rto user
     */
    public function approveForRTOAction()
    {
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');
        $results = $this->get('UserService')->approveForRTOCertification($courseCode, $applicantId);
        exit;
    }

    /**
     * Function to view reports
     */
    public function reportsAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        if ($userRole[0] != "ROLE_ASSESSOR") {
            /* $this->get('UserService')->updateUserApplicantsList($userId, $userRole); */
            $page = $this->get('request')->query->get('page', 1);
            $results = $this->get('UserService')->getUserApplicantsListReports($userId, $userRole, '3', $page);
            $results['pageRequest'] = 'submit';
            return $this->render('GqAusUserBundle:Reports:list.html.twig', $results);
        } else {
            return $this->redirect('dashboard');
        }
    }

    /**
     * Function to set assessor and rto by facilitator for applicant profile
     */
    public function setRoleUsersAction()
    {
        $courseId = $this->getRequest()->get('courseId');
        $userId = $this->getRequest()->get('roleuserId');
        $roleid = $this->getRequest()->get('roleid');
        $result = $this->get('UserService')->setRoleUsersForCourse($courseId, $roleid, $userId);
        $result;
        exit;
    }
    
    /**
    * Function to view Id file
    * return $result array
    */
    public function viewIdFileAction($idFileId)
    {        
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ( $idFileId > 0 ) {
                $userObj = $this->get('UserService');
                $idFileData = $userObj->getIdFileById($idFileId);
                if ( count($idFileData) > 0 ) { 
                    $results = array();                                           
                    $results['path'] = $idFileData->getPath();
                    return $this->render('GqAusUserBundle:Evidence:view-evidence.html.twig', $results); 
                }
            }
        } else {
            return $this->redirect('dashboard');
            //throw $this->createAccessDeniedException();    
        }
    }
    
    /**
     * Function to update course status
     */
    public function updateCourseStatusAction()
    {
        $courseStatus = $this->getRequest()->get('courseStatus');
        $courseCode = $this->getRequest()->get('courseCode');        
        $applicantId = $this->getRequest()->get('userId');
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $result = $this->get('UserService')->updateCourseStatus($courseStatus, $courseCode, $applicantId, $userRole);
        echo json_encode($result);
        exit;
    }

}
