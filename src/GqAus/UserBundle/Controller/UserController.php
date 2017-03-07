<?php

namespace GqAus\UserBundle\Controller;

use GqAus\UserBundle\Form\ChangePasswordForm;
use GqAus\UserBundle\Form\IdFilesForm;
use GqAus\UserBundle\Form\MatrixForm;
use GqAus\UserBundle\Form\ProfileForm;
use GqAus\UserBundle\Form\QualificationForm;
use GqAus\UserBundle\Form\ReferenceForm;
use GqAus\UserBundle\Form\ResumeForm;
use GqAus\UserBundle\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * Function to edit user profile
     * @param object $request
     * return string
     */
    public function profileAction(Request $request)
    { 
        $applicantList = [];
        $session = $request->getSession();
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $session->set('user_id', $sessionUser->getId());
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser(); 
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        if ($userRole[0] != "ROLE_APPLICANT") {
            $applicantList['applicants'] = count($userService->getApplicantsHandled($user->getId()));
            $applicantList['qualifications'] = count($userService->getQualificationsHandled($user->getId()));
            $applicantList['completedQuals'] = count($userService->getCompletedQuals($user->getId()));
            $applicantList['unCompletedQuals'] = $applicantList['qualifications'] - $applicantList['completedQuals'] ;
        }
        
        return $this->render('GqAusUserBundle:User:profile.html.twig', array('user' => $user, 'applicantCount' => $applicantList));
    }

    /**
     * Function to add user Idfiles
     * @param object $request
     * return string
     */
    public function addIdFileAction(Request $request)
    {
    
        $form = $this->createForm(new IdFilesForm(), array());
        if ($request->isMethod('POST')) {           
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->uploadIdFiles($request);
            if ($result) {
                echo $result;
            }
            exit;
        }
    }
 /**
     * Function to add UserEnrollment Form
     * @param object $request
     * return string
     */
    public function addEnrollmentFormAction(Request $request)
    {
        if ($request->isMethod('POST')) {            
            $result = $this->get('gq_aus_user.file_uploader')->uploadEnrollmentForm($request);
            if ($result) {
                echo $result;
            }
            exit;
        }
    }
    /**
     * Function to delete Id files
     */
    public function deleteIdFilesAction()
    {
        $IdFileId = $this->getRequest()->get('fid');
        $IdFileType = $this->getRequest()->get('ftype');
        $fileName = $this->get('UserService')->deleteIdFiles($IdFileId, $IdFileType);
        $this->get('gq_aus_user.file_uploader')->delete($fileName);
        exit;
    }

    /**
     * Function to upload profile picture
     * @param object $request
     */
    public function uploadProfilePicAction(Request $request)
    {
        $userId = $this->getRequest()->get('userId');
       if ($request->isMethod('POST')) {
//            $form->bind($request);
//            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->uploadImgFiles($request->request);
             if ($result) {
                 $userService = $this->get('UserService');
                if ($userId != '0') {                    
                     $user = $userService->getUser($userId);
                     $user->setUserImage(str_replace('"', '', $result));
                     $userService->saveProfile();
                 }
                 echo $result;
                 }
            
        }
            exit;
        }
        
    
      /**
     * Function to verify correct password
     * @param object $request
     * return string
     */
    public function checkMyPasswordAction(Request $request)
    {
        if ($request->isMethod('POST')) {            
            $mypassword = $request->get("mypassword");
            $user = $this->get('security.context')->getToken()->getUser();            
            $curDbPassword = $user->getPassword();
             if (password_verify($mypassword, $curDbPassword)) {
                $status = 'success';
                echo json_encode(array('status'=>$status));
            } else {
                $status = 'fail';
                echo json_encode(array('status'=>$status));
            }
        }
        exit;
    }


    /**
     * Function to upload resume
     * @param object $request
     * return string
     */
    public function resumeAction(Request $request)
    {
        $form = $this->createForm(new resumeForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->resume($request->request);
            if ($result) {
                echo $result;
            }
            exit;
        }
    }

    /**
     * Function to upload qualification
     * @param object $request
     * return string
     */
    public function qualificationAction(Request $request)
    {
        $form = $this->createForm(new QualificationForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
            if ($result) {
                echo $result;
            }
            exit;
        }
    }

    /**
     * Function to upload reference
     * @param object $request
     * return string
     */
    public function referenceAction(Request $request)
    {
        $form = $this->createForm(new ReferenceForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
            if ($result) {
                echo $result;
            }
            exit;
        }
    }

    /**
     * Function to upload matrix
     * @param object $request
     * return string
     */
    public function matrixAction(Request $request)
    {        
        $proImg = $request->files->get('matrix');
        $data = array('browse' => $proImg['browse'],'type' => 'matrix');
        if ($request->isMethod('POST')) {    
            $result = $this->get('gq_aus_user.file_uploader')->resume($request->request);            
            if ($result) {
                echo $result;
            }
            exit;
        }
    }

    /**
     * Function to delete other files
     */
    public function deleteOtherFilesAction()
    {
        $fileId = $this->getRequest()->get('fid');
        $fileName = $this->get('UserService')->deleteOtherFiles($fileId);
        $this->get('gq_aus_user.file_uploader')->delete($fileName);
        exit;
    }

    /**
     * Function to download matrix
     * return string
     */
    public function downloadMatrixAction()
    {
        $file = "template.xls";
        return $this->get('UserService')->downloadCourseCondition(null, $file);
    }

    /**
     * Function to view assessor profile
     * @param int $uid
     * return string
     */
    public function assessorProfileAction($uid)
    {
        $userService = $this->get('UserService');
        $user = $userService->getUserInfo($uid);

        $resumeFiles = $userService->fetchOtherfiles($uid, 'resume');
        if (empty($resumeFiles)) {
            $resumeFiles = '';
        }

        $qualificationFiles = $userService->fetchOtherfiles($uid, 'qualification');
        if (empty($qualificationFiles)) {
            $qualificationFiles = '';
        }

        $referenceFiles = $userService->fetchOtherfiles($uid, 'reference');
        if (empty($referenceFiles)) {
            $referenceFiles = '';
        }

        $matrixFiles = $userService->fetchOtherfiles($uid, 'matrix');
        if (empty($matrixFiles)) {
            $matrixFiles = '';
        }

        $userImage = $userService->userImage($user->getUserImage());

        return $this->render('GqAusUserBundle:User:assessorProfile.html.twig', array(
                'userImage' => $userImage,
                'user' => $user,
                'resumeFiles' => $resumeFiles,
                'qualFiles' => $qualificationFiles,
                'referenceFiles' => $referenceFiles,
                'matrixFiles' => $matrixFiles)
        );
    }

    /**
     * Function to Zip all the assessor profile files
     * @param int $uid
     */
    public function downloadAssessorProfileAction($uid)
    {
        $files = array();
        $assessorFiles = $this->get('UserService')->fetchOtherfiles($uid);
        foreach ($assessorFiles as $assessorFile) {
            array_push($files, $this->container->getParameter('amazon_s3_base_url') . $assessorFile->getPath());
        }
        $zip = new \ZipArchive();
        $zipName = 'AssessorFiles-' . time() . '.zip';
        $zip->open($zipName, \ZipArchive::CREATE);
        foreach ($files as $f) {
            $zip->addFromString(basename($f), file_get_contents($f));
        }
        $zip->close();
        header('Content-Type', 'application/zip');
        header('Content-disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);
    }

    /**
     * Function to add new applicant
     * @param object $request
     */
    public function addApplicantAction(Request $request)
    {
        $this->get('UserService')->saveApplicantData($request);
    }

    /**
     * Function to get user Evidence
     * return string
     */
    public function getUserEvidencesAction()
    {
        $userId = $this->getRequest()->get('userId');
        $unitCode = $this->getRequest()->get('unit');
        if (!empty($userId)) {
            $user = $this->get('UserService')->getUserInfo($userId);
        } else {
            $user = $this->get('security.context')->getToken()->getUser();
        }
        $uniqueEvidences = array();
        $evidences = $user->getEvidences();
        /* if(!empty($evidences) && is_array($evidences)){ */
            foreach($evidences as $key => $evidence){
                $evdPath = (method_exists($evidence,'getName')) ?  $evidence->getPath() : $evidence->getContent();
                $uniqueEvidences[$evdPath][] = $evidence;
            }
        /* } */
        $results['evidences'] = $uniqueEvidences;
        $results['unitCode'] = $unitCode;
        echo $this->renderView('GqAusUserBundle:User:userevidence.html.twig', $results);
        exit;
    }

    /**
     * Function to view user id files
     * return string
     */
    public function viewUserIdFilesAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
            if ($userRole[0] == "ROLE_FACILITATOR") {
                $userId = $this->getRequest()->get('userId');
                if (!empty($userId)) {
                    $user = $this->get('UserService')->getUserInfo($userId);
                    $userImage = $this->get('UserService')->userImage($user->getUserImage());
                    $results['user'] = $user;
                    $results['userImage'] = $userImage;
                    $results['userIdFiles'] = $user->getIdfiles();
                    return $this->render('GqAusUserBundle:User:userIdFiles.html.twig', $results);
                }
            } else {
                return $this->render('GqAusUserBundle:Default:error.html.twig');
            }
        } else {
            return $this->redirect('dashboard');
        }
    }

    /**
     * Function to manage users
     * return string
     */
    public function manageusersAction()
    {
        $page = $this->get('request')->query->get('page', 1);
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $users = $this->get('UserService')->manageUsers($sessionUser->getId(),
        $sessionUser->getRoleName(), '', '', $page = null);
        $users['pageRequest'] = 'submit';
        $userroles = array();
        $qualificationStatus = array();
        $userroles = $this->get('UserService')->getUserByRole();
        $qualificationStatus = $this->get('UserService')->getQualificationStatus();
        $users['users'] = $userroles;
        $users['qualificationStatus'] = $qualificationStatus;
        return $this->render('GqAusUserBundle:User:manageusers.html.twig', $users);
    }

    /**
     * Function search users list
     * return string
     */
    public function searchUsersListAction()
    {
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $searchName = $this->getRequest()->get('searchName');
        $searchType = $this->getRequest()->get('userType');
        $page = $this->getRequest()->get('pagenum');
        if ($page == "") {
            $page = 1;
        }
        $results = $this->get('UserService')->manageUsers($sessionUser->getId(), $sessionUser->getRoleName(), 
            $searchName, $searchType, $page);
        $results['pageRequest'] = 'ajax';
        echo $this->renderView('GqAusUserBundle:User:usersList.html.twig', $results);
        exit;
    }

    /**
     * Function to delete users
     * return string
     */
    public function deleteUserAction()
    {
        $deluserId = $this->getRequest()->get('deluserId');
        $delUserRole = $this->getRequest()->get('delUserRole');
        echo $this->get('UserService')->deleteUser($deluserId, $delUserRole);
        exit;
    }

    /**
     * Function to edit user
     * @param object $request
     * return string
     */
    public function editUserAction(Request $request)
    {
        $uId = $request->get('uId');
        $userService = $this->get('UserService');
        if (!empty($uId)) {
            $user = $userService->getUser($uId);
        }
        $user->setContactPhone(null);
        $user->setCeophone(null);
        $userPhone = str_replace('-', '', $user->getPhone());
        $user->setPhone($userPhone);

        $userProfileForm = $this->createForm(new ProfileForm(), $user);
        $userRole = $user->getRoleName();
        $userProfileForm->remove('gender');
        //$userProfileForm->remove('userImage');
        if ($userRole == 'ROLE_ASSESSOR' || $userRole == 'ROLE_FACILITATOR' || $userRole == 'ROLE_RTO' ||
            $userRole == 'ROLE_MANAGER' || $userRole == 'ROLE_SUPERADMIN') {
            $userProfileForm->remove('dateOfBirth');
            $userProfileForm->remove('universalStudentIdentifier');
            $userProfileForm->remove('gender');
        }
        if ($userRole == 'ROLE_ASSESSOR' || $userRole == 'ROLE_FACILITATOR' || $userRole == 'ROLE_APPLICANT' ||
            $userRole == 'ROLE_MANAGER' || $userRole == 'ROLE_SUPERADMIN') {
            $userProfileForm->remove('contactname');
            $userProfileForm->remove('contactemail');
            $userProfileForm->remove('contactphone');
        }
        if ($userRole != 'ROLE_RTO') {
            $userProfileForm->remove('ceoname');
            $userProfileForm->remove('ceoemail');
            $userProfileForm->remove('ceophone');
        }
//        if ($userRole != 'ROLE_FACILITATOR') {
//            $userProfileForm->remove('crmId');
//        }
        $userProfileForm->remove('crmId');
        $userProfileForm->remove('userImage');
        $resetForm = $this->createForm(new ChangePasswordForm(), array());
        $image = $user->getUserImage();
        $userEmail = $user->getEmail(); 
        if ($request->isMethod('POST')) {
//            echo "hello"; exit;
            $userProfileForm->handleRequest($request);
            //var_dump($userProfileForm->isValid()); exit;
            if ($userProfileForm->isValid()) {
                $userService->savePersonalProfile($user, $image);
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Profile updated successfully!'
                );
                return $this->redirect('/manageusers');
            }

            $resetForm->handleRequest($request);
            if ($resetForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $curDbPassword = $user->getPassword();
                $pwdarr = $request->get('password');
                $newpassword = $pwdarr['newpassword'];
                $password = password_hash($newpassword, PASSWORD_BCRYPT);
                $user->setPassword($password);
                $user->setTokenStatus('0');
                $em->persist($user);
                $em->flush();
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Password updated successfully!'
                );
                return $this->redirect('/manageusers');
            }
        }
        $userImage = $user->getUserImage();

        //echo "3 hello"; exit;
        $tab = '';
        $httpRef = $this->get('request')->server->get('HTTP_REFERER');
        if (!empty($httpRef)) {
            $httpRef = basename($httpRef);
            $tab = $this->getRequest()->get('tab');
        }

        return $this->render('GqAusUserBundle:User:userprofile.html.twig', array(
                'form' => $userProfileForm->createView(),
                'userImage' => $userImage,
                'changepwdForm' => $resetForm->createView(),
                'tab' => $tab,
                'userId' => $uId,
                'userEmail' => $userEmail,
                'userRole' => $userRole
        ));
    }

    /**
     * Function to add user
     * @param object $request
     * return string
     */
    public function addUserAction(Request $request)
    {
        $roleType = $request->get("roleType");
        $userProfileForm = $this->createForm(new UserForm());
        $fromUser = $this->get('security.context')->getToken()->getUser();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoleName();
        switch ($roleType) {
            case 2:
                $userRole = 'ROLE_FACILITATOR';
                break;
            case 3:
                $userRole = 'ROLE_ASSESSOR';
                break;
            case 4:
                $userRole = 'ROLE_RTO';
                break;
            case 5:
                $userRole = 'ROLE_MANAGER';
                break;
        }

        if ($userRole == 'ROLE_ASSESSOR' || $userRole == 'ROLE_FACILITATOR' || $userRole == 'ROLE_RTO' ||
            $userRole == 'ROLE_MANAGER' || $userRole == 'ROLE_SUPERADMIN') {
            $userProfileForm->remove('dateOfBirth');
            $userProfileForm->remove('universalStudentIdentifier');
            $userProfileForm->remove('gender');
        }
        if ($userRole == 'ROLE_ASSESSOR' || $userRole == 'ROLE_FACILITATOR' || $userRole == 'ROLE_APPLICANT' ||
            $userRole == 'ROLE_MANAGER' || $userRole == 'ROLE_SUPERADMIN') {
            $userProfileForm->remove('contactname');
            $userProfileForm->remove('contactemail');
            $userProfileForm->remove('contactphone');
        }

        if ($userRole != 'ROLE_RTO') {
            $userProfileForm->remove('ceoname');
            $userProfileForm->remove('ceoemail');
            $userProfileForm->remove('ceophone');
        }
        /*if ($userRole != 'ROLE_FACILITATOR') {
            $userProfileForm->remove('crmId');
        }*/
        $userProfileForm->remove('userImage');
        $userProfileForm->remove('crmId');
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request); 
            if ($userProfileForm->isValid()) {
                $image = $request->get('hdn-img');
                $this->get('UserService')->addPersonalProfile($userRole, $request->get('userprofile'), $image);
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Profile added successfully!'
                );
                
                $userInfo = $request->get('userprofile');
                $username = $userInfo['firstname'].' '.$userInfo['lastname'];
                $userEmail = $userInfo['email'];
                $userPassWord = $userInfo['newpassword'];
                $conSearch = array('#toUserName#', '#applicationUrl#','#userEmail#','#userPassWord#');
                $conReplace = array($username, $this->container->getParameter('applicationUrl'),$userEmail,$userPassWord);
                $userSubject = $this->container->getParameter('mail_user_creation_sub');
                $userMessage = str_replace($conSearch, $conReplace,
                    $this->container->getParameter('mail_user_creation_con'));
                $userMsgdata = array('subject' => $userSubject, 'message' => $userMessage, 'unitId' => '0', 'replymid' => '0');
                
                $this->get('UserService')->sendExternalEmail($userEmail, $userSubject, $userMessage, $fromUser->getEmail(), $fromUser->getUsername());
                
                return $this->redirect('/manageusers');
            }
        }
        $tab = '';
        $httpRef = $this->get('request')->server->get('HTTP_REFERER');
        if (!empty($httpRef)) {
            $httpRef = basename($httpRef);
            $tab = $this->getRequest()->get('tab');
        }
        
        return $this->render('GqAusUserBundle:User:add_user_byrole.html.twig', array(
                'form' => $userProfileForm->createView(),
                'userImage' => '',
                'tab' => $tab,
                'userId' => '',
                'userRole' => $userRole
        ));
    }

    /**
     * Function to email exist
     * return integer
     */
    function checkEmailExistAction()
    {
        $emailId = $this->getRequest()->get('emailId');
        echo $this->get('UserService')->emailExist($emailId);
        exit;
    }
    /**
     * Function to display FAQ
     * return array
     */
    function feedbackAction()
    {
             return $this->render('GqAusUserBundle:feedback:feedback.html.twig');
    }
    
       /**
     * Function to display FAQ
     * return array
     */
    function faqAction()
    {
         $faq = $this->get('UserService')->getFaq();        
         return $this->render('GqAusUserBundle:Faq:faq.html.twig',array('faq' => $faq));

    }
    
    /**
     * Function to get the Candidate Profile For Facilitator & Assessor & Rto
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function candidateProfileAction(Request $request)
    {
        $userId =  $request->get('userId');
        $courseCode = $request->get('courseCode');
        $userService = $this->get('UserService');
        
        $loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $checkStatus = $userService->getHaveAccessPage($loggedinUserId, $userId, $courseCode, $userRole);
        if(!$checkStatus)
            return $this->render('GqAusUserBundle:Default:error.html.twig');
        
        $user = $userService->getUserInfo($userId);
        if(empty($user->getPhone())){
            $user->setPhone(null);
        }else{
            $userPhone = str_replace('-', '', $user->getPhone());
            $user->setPhone($userPhone);
        }
        if(empty($user->getContactPhone()))  $user->setContactPhone(null);
        if(empty($user->getCeophone()))  $user->setCeophone(null);
        $currentIdPoints = $userService->getIdPoints($user);
        $userProfilePercentage = $userService->getUserProfilePercentage($user);
        $documentTypes = $userService->getDocumentTypes();
        $userProfileForm = $this->createForm(new ProfileForm(), $user);
        $userIdFiles = $user->getIdfiles();
        
        
        return $this->render('GqAusUserBundle:User:candidateProfile.html.twig', array(
                'user' => $user,
                'userProfilePercentage' => $userProfilePercentage,
                'currentIdPoints' => $currentIdPoints,
                'documentTypes' => $documentTypes,
                'userIdFiles' => $userIdFiles,
                'courseCode' => $courseCode,
                'userId' => $userId
        ));
    }
     /* Function to update the user profile from popup.
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    function updateprofileAjaxAction(Request $request){
        
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $phone = $request->get('phone');
        
        $street_name = $request->get('street_name');
        $street_number = $request->get('street_number');
        $postcode = $request->get('postcode');
        $suburb = $request->get('suburb');
        $city = $request->get('city');
        $state = $request->get('state');
        $country = $request->get('country');
        $postal = $request->get('postal');
        $contactname = $request->get('contactname');
        $contactphone = $request->get('contactphone');
              
        // User object
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPhone($phone);
        $user->setContactName($contactname);
        $user->setContactPhone($contactphone);
        $image = $user->getUserImage();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoleName();
        // User Address object
        if($userRole != 'ROLE_FACILITATOR')
        {
            
            $userAddress = $user->getAddress();

            $userAddress->setPincode($postcode);
            $userAddress->setCity($city);
            $userAddress->setState($state);
            $userAddress->setCountry($country);
            $userAddress->setPostal($postal);
            $userAddress->setSuburb($suburb);
            $userAddress->setAddress($street_name);
            $userAddress->setArea($street_number);
            $user->setAddress($userAddress);
        }
        //Saving to profile
        $success = $userService->savePersonalProfile($user, $image, $userRole);
        if(!$success)
        {
            $status = 'false';
            $message = 'Error please try again';
             
        }
        else
        {
            $status = 'true';
            $message = 'Profile successfully updated';
        }
        echo json_encode(array('status'=>$status,'message'=>$message));
        exit;
    }
    
    
    
     function updatepasswordAjaxAction(Request $request){
        
        $newpassword = $request->get('password_newpassword');

        // User object
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        $password = password_hash($newpassword, PASSWORD_BCRYPT);
        $user->getFirstName();
        $user->getLastName();
        $user->getPhone();
        $user->setPassword($password);
        $image = $user->getUserImage();
        
        //Saving to profile
        $userService->savePersonalProfile($user, $image);
        exit;
    }
    function updateNewPasswordAjaxAction(Request $request){
        $newpassword = $request->get('new-password');       
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        $password = password_hash($newpassword, PASSWORD_BCRYPT);
        $user->getFirstName();
        $user->getLastName();
        $user->getPhone();
        $user->setPassword($password);
        $user->setApplicantStatus('2');
        $image = $user->getUserImage();
        
        //Saving to profile
        $userService->savePersonalProfile($user, $image);
        exit;
    }
    function updateNewUserAjaxAction(Request $requset)
    {
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        $user->setApplicantStatus('0');
         $image = $user->getUserImage();
         $userService->savePersonalProfile($user, $image);
        exit;
    }
     function updateNewUserPasswordAjaxAction(){  
        $newpassword = $_POST['pwd']; 
        $logintoken = $_POST['tokenid'];
        $userService = $this->get('UserService');
        $userInfo = $userService->updateNewUserPassword($newpassword, $logintoken); 
        if($userInfo > 0) {
            $user = $userService->getUserInfo($userInfo);
            echo $userInfo."@".$user->getApplicantStatus();
        }
        else {
            echo '0';
        }
        exit;
    }
    function updateNewUserAjaxStatusAction(){  
        $logintoken = $_POST['tokenid'];        
        $userService = $this->get('UserService');
        $userInfo = $userService->updateNewUserPasswordStatus($logintoken);
        exit;
    }

    /*
     * User Logs List
     */
    function userslogAction()
    {
        $page = $this->get('request')->query->get('page', 1);
        $userLog = $this->get('UserService')->getUsersLog($page = null);
        $userLog['pageRequest'] = 'submit';
        return $this->render('GqAusUserBundle:User:userslog.html.twig', $userLog);
    }
    
    /**
     * Function search users list
     * return string
     */
    public function searchLogListAction()
    {
        $filterByDate = $this->getRequest()->get('filterByDate');
        $searchName = $this->getRequest()->get('searchName');
        $filterByRole = $this->getRequest()->get('filterByRole');        
        $filterByAction = $this->getRequest()->get('filterByAction');
        
        $page = $this->getRequest()->get('pagenum');
        if ($page == "") {
            $page = 1;
        }
        $userLog = $this->get('UserService')->getUsersLog($page, $filterByDate, $searchName, $filterByRole, $filterByAction);
        $userLog['pageRequest'] = 'ajax';
        echo $this->render('GqAusUserBundle:User:loglist.html.twig', $userLog);
        exit;
    }
    
    /**
     * Function to username exist
     * return integer
     */
    function checkUserNameExistAction()
    { 
        $username = $this->getRequest()->get('username'); 
        $messageService = $this->get('UserService');
        $userrole = $messageService->getCurrentUser()->getRoles();
        $userId = $messageService->getCurrentUser()->getId();
        $rows = $messageService->checkUsernamesbyRoles(array('keyword' => $username),$userrole[0],$userId);        
        echo count($rows);
        exit;
    }
    /**
     * Function to get userName is exists or not
     * return integer
     */
    function checkUserNameExistOrNotAction(){
        $username = $this->getRequest()->get('username'); 
        $nameCondition="";
        $query = $this->getDoctrine()->getRepository('GqAusUserBundle:User')
                ->createQueryBuilder('u')
                ->select('u');
        $searchIn = $query->expr()->concat('u.firstName', $query->expr()->concat($query->expr()->literal(' '), 'u.lastName'));
        $nameCondition .= $searchIn."='".$username."'" ;
        $query->Where($nameCondition);
        $user = $query->getQuery()->getResult(); 
        if ($user) 
            $touser = $user[0]->getId();
        else
            $touser = 0;
        echo $touser;
        exit;
    }
    /**
     * Function to retrieve the adress field for user profile page
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function addressByFieldAction(Request $request)
    {
        $term = strtolower($_GET["term"]);
        $highlightedId = strtolower($_GET["highlightedId"]);
        $results = array();
        $rows = $this->get('UserService')->getAddressesFromTable(array('term' => $term), array('highlightedId'=> $highlightedId));   
        $json_array = array();                
        if (is_array($rows))
        {
            foreach ($rows as $row)
            {
                array_push($json_array, $row['address']);
            }
        }               
        echo json_encode($json_array);
        exit;
    }
    /**
     * Function to sent mail to the site admin 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function sentFeedBackMailAction(Request $request) {
        
        $results = [];
        $user = $this->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        if ($request->isMethod('POST') && $userId != '') {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content)) {
                $params = json_decode($content, true); // 2nd param to get as array
                $feedBackType = $params['feedBackType'];
                $detFeedBack  = $params['detFeedBack'];
                $applicantId  = $params["userId"];   
                $results = $this->get('UserService')->sentEmailForFeedBack($feedBackType, $detFeedBack, $applicantId);
            }
        }

        return new JsonResponse($results);
    }
}
