<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GqAus\UserBundle\Form\NotesForm;
use GqAus\UserBundle\Entity\Facilitator;
use GqAus\UserBundle\Entity\Assessor;
use GqAus\UserBundle\Entity\Rto;
use GqAus\UserBundle\Entity\Manager;
use GqAus\UserBundle\Entity\Superadmin;

class ApplicantController extends Controller
{

    /**
     * Function to get applicant details page
     * @param string $qcode
     * @param int $uid
     * @param object $request
     * return string
     */
    public function detailsAction($qcode, $uid, Request $request)
    {
        $userService = $this->get('UserService');
        $coursesService = $this->get('CoursesService');
        $user = $userService->getUserInfo($uid);
        $results = $coursesService->getCoursesInfo($qcode);
       
        if (!empty($user) && isset($results['courseInfo']['id']) && isset($results['courseInfo']['Units'])) {
            $applicantInfo = $userService->getApplicantInfo($user, $qcode);
            $role = $this->get('security.context')->getToken()->getUser()->getRoles();
            if ($role[0] == Facilitator::ROLE_NAME || $role[0] == Manager::ROLE_NAME) {
                $results['rtos'] = $userService->getUsers(Rto::ROLE);
                $results['assessors'] = $userService->getUsers(Assessor::ROLE);
                if ($role[0] == Superadmin::ROLE_NAME || $role[0] == Manager::ROLE_NAME) {
                    $results['facilitators'] = $userService->getUsers(Facilitator::ROLE);
                }
            }
            $results['electiveUnits'] = $coursesService->getElectiveUnits($uid, $qcode);
            $results['courseCode'] = $qcode;
            // for getting the status list dropdown
            $results['statusList'] = array();
            $results['statusList'] = $userService->getQualificationStatus();
            if ($role[0] == Facilitator::ROLE_NAME || $role[0] == Assessor::ROLE_NAME) {
                $notesForm = $this->createForm(new NotesForm(), array());
                $results['notesForm'] = $notesForm->createView();
            }
			
            if ($role[0] == Facilitator::ROLE_NAME || $role[0] == Assessor::ROLE_NAME) {
                    $roleType = ($role[0] == Facilitator::ROLE_NAME) ? 'f' : 'a';
                    $results['notes'] = $userService->getNotesFromUserAndCourse($qcode, $uid, $roleType);
                    $results['notesFromCourse'] = $userService->getNotesFromCourseIdOnly($applicantInfo['coursePrimaryId'], $roleType);
            }
            $electiveUnitArr = $results['electiveUnits'];
            $results['coreUnitsCount'] = $userService->getCountUnits($results['courseInfo']['Units']['Unit'], 'core');
            $results['electiveUnitsCount'] = $userService->getCountUnits($results['courseInfo']['Units']['Unit'], 'elective', $electiveUnitArr);
            //$results['evidenceCompleteness'] = $userService->getEvidenceCompleteness($uid, $qcode);
            $results['evidenceCompleteness'] = $coursesService->getEvidenceByCourse($uid, $qcode);
            $results['facApplicantsCount'] = $this->get('UserService')->getPendingApplicantsCount($applicantInfo['facilitatorId'], array('ROLE_FACILITATOR'), '0');
            $results['assApplicantsCount'] = $this->get('UserService')->getPendingApplicantsCount($applicantInfo['assessorId'], array('ROLE_ASSESSOR'), '0');
            $results['currentIdPoints'] = $userService->getIdPoints($user);
            return $this->render('GqAusUserBundle:Applicant:details.html.twig', array_merge($results, $applicantInfo));
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
		
    }

    /**
     * Function to update user unit evidence status
     *  return string
     */
    public function setUserUnitEvidencesStatusAction()
    {
        $result = array();
        $userId = $this->getRequest()->get('userId');
        $result['userId'] = $userId;
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
        echo $userUnitEvStatus.= "&&" . $this->get('UserService')
            ->updateCourseRTOStatus($userId, $result['currentUserId'], $result['currentuserRole'], $result['courseCode']);
        exit;
    }

    /**
     * Function to add reminder/notes
     * return string
     */
    public function addReminderAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userCourseId = $this->getRequest()->get('userCourseId');
        $remindDate = $this->getRequest()->get('remindDate');
        $reminderType = $this->getRequest()->get('reminderType');
        $reminderTypeId = $this->getRequest()->get('reminderTypeId');
        if (empty($userCourseId)) {
            $userCourseId = $this->getRequest()->get('listId');
        }
        $remindDate = str_replace('/', '-', $remindDate);
        $remindDate = date('Y-m-d H:i:s', strtotime(strtoupper($remindDate)));
        $message = $this->getRequest()->get('message');
        echo $this->get('UserService')->addQualificationReminder($userId, $userCourseId, $message, $remindDate, $reminderType, $reminderTypeId);
        exit;
    }

    /**
     * Function list applicants list
     * return array
     */
    public function applicantsListAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
		$pendingApplicantsCount = $this->get('UserService')->getPendingApplicantsCount($userId, $userRole, '0');
        $page = $this->get('request')->query->get('page', 1);
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, '0', $page);
        $results['pageRequest'] = 'submit';
        $results['status'] = 0;
		$results['pendingApplicantsCount']=$pendingApplicantsCount;
        $users = array();
        if ($userRole[0] == Superadmin::ROLE_NAME || $userRole[0] == Manager::ROLE_NAME) {
                    $results['facilitators'] = $this->get('UserService')->getUsers(Facilitator::ROLE);                   
                }
        $qualificationStatus = array();
       //if ($userRole[0] == 'ROLE_MANAGER' || $userRole[0] == 'ROLE_SUPERADMIN') {
            $users = $this->get('UserService')->getUserByRole();
            $qualificationStatus = $this->get('UserService')->getQualificationStatus();
        //}
        $results['users'] = $users;
        $results['qualificationStatus'] = $qualificationStatus;
       // dump( $results['facilitators']);
        return $this->render('GqAusUserBundle:Applicant:list.html.twig', $results);
    }

    /**
     * Function search applicants list
     * return string
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
        if ($page == '') {
            $page = 1;
        }         
        $results = $this->get('UserService')->getUserApplicantsList($userId, $userRole, $status, $page, 
            $searchName, $searchTime, $filterByUser, $filterByStatus);
            if ($userRole[0] == Superadmin::ROLE_NAME || $userRole[0] == Manager::ROLE_NAME) {
                    $results['facilitators'] = $this->get('UserService')->getUsers(Facilitator::ROLE);                    
                }        
		$qualificationStatus = $this->get('UserService')->getQualificationStatus();

		$results['qualificationStatus'] = $qualificationStatus;       

        $results['pageRequest'] = 'ajax';
        $results['status'] = $status;        
        echo $this->renderView('GqAusUserBundle:Applicant:applicants.html.twig', $results);
        exit;
    }

    /**
     * Function search complete applicants list
     * return string
     */
    public function searchApplicantsListReportsAction()
    {
        $searchName = $this->getRequest()->get('searchName');
        $searchAge = $this->getRequest()->get('searchAge');
        $searchRoleId = $this->getRequest()->get('searchRoleId');
        $page = $this->getRequest()->get('pagenum');
        if ($page == '') {
            $page = 1;
        }
        $results = $this->get('UserService')->getFacApplicantsListReports($page, $searchName, $searchAge, $searchRoleId);
        $results['pageRequest'] = 'ajax';
        echo $this->renderView('GqAusUserBundle:Reports:ajax-applicants.html.twig', $results);
        exit;
    }

    /**
     * Function to get applicant details page
     * @param string $qcode
     * @param int $uid
     * return string
     */
    public function downloadAction($qcode, $uid)
    {
        error_reporting(0);
        $user = $this->get('UserService')->getUserInfo($uid);
        $evidenceObj = $this->get('EvidenceService');
        $results = $this->get('CoursesService')->getCoursesInfo($qcode);
        $courseEvidences = $evidenceObj->getUserCourseEvidences($uid, $qcode);
        $unitsIds = array();
        foreach ($courseEvidences as $value) {
            $unitsIds[] = $value->getUnit();
        }
        $i = 0;
        foreach ($results['courseInfo']['Units']['Unit'] as $unit) {
            $results['courseInfo']['Units']['Unit'][$i]['name'] = 
                preg_replace('/[^A-Za-z0-9\-]/', ' ', $results['courseInfo']['Units']['Unit'][$i]['name']);
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
            $results['user'] = $user;
            $results['userIdFiles'] = $user->getIdfiles();
            $applicantInfo = $this->get('UserService')->getApplicantInfo($user, $qcode);
            $results['electiveUnits'] = $this->get('CoursesService')->getElectiveUnits($uid, $qcode);
            $results['projectPath'] = $this->get('kernel')->getRootDir() . '/../';
            $content = $this->renderView('GqAusUserBundle:Applicant:download.html.twig', array_merge($results, $applicantInfo));
            $fileTemp = $this->get('kernel')->getRootDir() . '/logs/temp_' . time() . '.pdf';
            $outputFileName = str_replace(" ", "-", $user->getUserName()) . '_' .str_replace(' ', '-', $results['courseInfo']['name']) . '_' . time() . '.pdf';
            /* $html2pdf = $this->get('html2pdf_factory')->create('P', 'A4', 'en', true, 'UTF-8', array(10, 15, 10, 15));
            $html2pdf->setDefaultFont('OpenSans'); */
            $html2pdf = $this->get('white_october.tcpdf')->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $html2pdf->setFontSubsetting(true);
            $html2pdf->SetFont('helvetica', '', 10, '', true);
            $html2pdf->startPageGroup();
            $html2pdf->AddPage();
            $vuehtml = $this->getRequest()->get('vuehtml');
            $html2pdf->writeHTML($content, isset($vuehtml));
            $html2pdf->Output($fileTemp, 'F');
            $response = new Response( );
            $response->headers->set("Content-type", 'application/pdf');
            $response->headers->set("Content-Disposition", "attachment; filename=$outputFileName");
            $response->send();
            $response->setContent(readfile("$fileTemp"));
            unlink($fileTemp);
            return $response;
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
    }

    /**
     * Function to Zip all the Evidences files of one course to specific user
     * @param string $qcode
     * @param int $uid
     * return string
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
            $zipName = str_replace(' ', '-', $user->getUserName()) . '-' . time() . '.zip';
            $zip->open($zipName, \ZipArchive::CREATE);
            $fileFlag = 0;
            foreach ($evidences as $evidence) {
                if ($evidence->getType() !== 'text') {
                    $fileFlag = 1;
                    $unitCode = $evidence->getUnit();
                    if (!is_dir($unitCode)) {
                        $zip->addEmptyDir($unitCode);
                    }
                    $nfname = $unitCode . '/' . $evidence->getName();
                    $fname = $this->container->getParameter('amazon_s3_base_url') . $evidence->getPath();
                    $zip->addFromString($nfname, file_get_contents($fname));
                }
            }
            $zip->close();

            if ($fileFlag == 0) {
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
     * @param int $evidenceId
     * return string
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
     * Function to approve the all units from RTO
     */
    public function approveAllUnitsFromRTOAction()
    {
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');
        $results = $this->get('UserService')->approveAllUnitsFromRTO($courseCode, $applicantId);
        echo json_encode($results);
        exit;        
    }

    /**
     * Function to view reports
     * return string
     */
    public function reportsAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        if ($userRole[0] != 'ROLE_ASSESSOR') {
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
     * return array
     */
    public function setRoleUsersAction()
    {
        $courseId = $this->getRequest()->get('courseId');
        $userId = $this->getRequest()->get('roleuserId');
        $roleid = $this->getRequest()->get('roleid');
        $result = $this->get('UserService')->setRoleUsersForCourse($courseId, $roleid, $userId);
        echo json_encode($result);
        exit;
    }

    /**
     * Function to view Id file
     * @param int $idFileId
     * return string
     */
    public function viewIdFileAction($idFileId)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($idFileId > 0) {
                $idFileData = $this->get('UserService')->getIdFileById($idFileId);
                if (count($idFileData) > 0) {
                    $results = array();
                    $results['path'] = $idFileData->getPath();
                    return $this->render('GqAusUserBundle:Evidence:view-evidence.html.twig', $results);
                }
            }
        } else {
            return $this->redirect('dashboard');
        }
    }

    /**
     * Function to update course status
     * return array
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

    
    /**
     * Function to get applicant details page
     * @param string $qcode
     * @param int $uid
     * @param object $request
     * return string
     */
    public function courseunitDetailsAction($qcode,$unitcode, $uid, Request $request)
    {
        $userService = $this->get('UserService');
        $coursesService = $this->get('CoursesService');
        $evidenceService = $this->get('EvidenceService');
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $user = $userService->getUserInfo($uid);
        
        $results = $coursesService->getUnitInfo($unitcode);
          
        if (!empty($user) && isset($results['unitInfo']['code'])) {
            $applicantInfo = $userService->getApplicantInfo($user, $qcode);
            
            $role = $this->get('security.context')->getToken()->getUser()->getRoles();
            if ($role[0] == Facilitator::ROLE_NAME || $role[0] == Manager::ROLE_NAME) {
                $results['rtos'] = $userService->getUsers(Rto::ROLE);
                $results['assessors'] = $userService->getUsers(Assessor::ROLE);
                if ($role[0] == Superadmin::ROLE_NAME || $role[0] == Manager::ROLE_NAME) {
                    $results['facilitators'] = $userService->getUsers(Facilitator::ROLE);
                }
            }
            $results['courseDetails'] = $coursesService->getCourseDetails($qcode, $uid);
            $results['courseCode'] = $qcode;
            $results['unitCode'] = $results['unitInfo']['code'];
            $results['unitName'] =$results['unitInfo']['title'];
            $results['evidenceGuide'] = $results['unitInfo']['evidence_guide'];
            $results['skillsKnowledge'] = $results['unitInfo']['skills_and_knowledge'];
            $results['elements'] = $results['unitInfo']['elements'];
            $results['unitStatus'] = $coursesService->getUnitStatus($uid, $unitcode,$qcode);
            $results['evidences'] = $evidenceService->getUserUnitEvidences($uid, $unitcode);
            $results['evidenceCount'] = count($evidenceService->getUserUnitEvidences($uid, $unitcode));
            $results['selfAssessmentText'] = $evidenceService->getSelfAssessmentFromUnit($uid, $qcode, $unitcode);
          
            if ($userRole[0] == "ROLE_APPLICANT")
                return $this->render('GqAusHomeBundle:Courses:unitevidence.html.twig', array_merge($results, $applicantInfo));
            else
                return $this->render('GqAusUserBundle:Applicant:unitdetails.html.twig', array_merge($results, $applicantInfo));
        } else {
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        }
    }
    
     /**
     * Function to pendingApplicant count     
     * return int
     */
    public function pendingApplicantCountAction()
    {
        
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $pendingApplicantsCount = $this->get('UserService')->getPendingApplicantsCount($userId, $userRole, '0');
        echo $pendingApplicantsCount;
        exit;
    }
    /**
     * Function to get unreadApplicant count
     * return int
     */
    public function unreadApplicantCountAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $unreadApplicantsCount = $this->get('UserService')->getUnreadApplicantsCount($userId, $userRole, '0');
        echo $unreadApplicantsCount;
        exit;
    }

    /**
     * Function to insert record into messsage table when the facilitlaor has clicked on not satisafactory button
     *  return string
     */
    public function sendMsgtoApplicantAction()
    {
        $userService = $this->get('UserService');
        $userId = $this->getRequest()->get('userId');
        $fromUser = $userId;
        $fromUser = $userService->getUserInfo($fromUser);
        $curuser = $userService->getCurrentUser();
        $unitId = $this->getRequest()->get('unitId');
        $subject = $this->getRequest()->get('subject');
        $message = $this->getRequest()->get('message');
        $msgdata = array('subject' => $subject, 'message' => $message, 'unitId' => $unitId, 'replymid' => '0');
        $userUnitEvStatus = $userService->saveMessageData($fromUser,$curuser,$msgdata);
        echo json_encode($userUnitEvStatus);
        exit;
    } 
    
    /**
     * Function to Update Facilitator in Manager Portfolio
     */    
    public function updateFacilitatorAction(Request $request)
    {
        $listId = $this->getRequest()->get('listId');        
        $facilitator = $this->getRequest()->get('facilitator');
        $updateFacVal = $this->get('UserService')->updateQualificationFacilitator($listId,$facilitator);
        if($updateFacVal)
        {
            $status = 'true';
            $message = 'updated successfully';
        }
        else
        {
            $status = 'false';
            $message = 'Error while updating..';
        }
        $response = array('status' =>$status,'message' => $message);
        echo json_encode($response);
        exit;
    }
}
