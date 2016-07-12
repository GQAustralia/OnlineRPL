<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ProfileForm;
use GqAus\UserBundle\Form\UserForm;
use GqAus\UserBundle\Form\IdFilesForm;
use GqAus\UserBundle\Form\ChangePasswordForm;
use GqAus\UserBundle\Form\ResumeForm;
use GqAus\UserBundle\Form\QualificationForm;
use GqAus\UserBundle\Form\ReferenceForm;
use GqAus\UserBundle\Form\MatrixForm;

class UserController extends Controller
{

    /**
     * Function to edit user profile
     * @param object $request
     * return string
     */
    public function profileAction(Request $request)
    {
        $session = $request->getSession();
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $session->set('user_id', $sessionUser->getId());
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        $userProfileForm = $this->createForm(new ProfileForm(), $user);
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoleName();
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

        if ($userRole != 'ROLE_FACILITATOR') {
            $userProfileForm->remove('crmId');
        }

        $documentTypes = $userService->getDocumentTypes();
        $idFilesForm = $this->createForm(new IdFilesForm(), $documentTypes);
        $resetForm = $this->createForm(new ChangePasswordForm(), array());
        $resumeForm = $this->createForm(new ResumeForm(), array());
        $qualificationForm = $this->createForm(new QualificationForm(), array());
        $referenceForm = $this->createForm(new ReferenceForm(), array());
        $matrixForm = $this->createForm(new MatrixForm(), array());
        $image = $user->getUserImage();
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request);
            if ($userProfileForm->isValid()) {
                $userService->savePersonalProfile($user, $image);
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Profile updated successfully!'
                );
            }
            $resetForm->handleRequest($request);
            if ($resetForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $curDbPassword = $user->getPassword();
                $pwdarr = $request->get('password');
                $oldpassword = $pwdarr['oldpassword'];
                $newpassword = $pwdarr['newpassword'];
                $confirmnewpassword = $pwdarr['confirmnewpassword'];
                if ($newpassword == $confirmnewpassword) {
                    if (password_verify($oldpassword, $curDbPassword)) {
                        $password = password_hash($newpassword, PASSWORD_BCRYPT);
                        $user->setPassword($password);
                        $user->setTokenStatus('0');
                        $em->persist($user);
                        $em->flush();
                        $request->getSession()->getFlashBag()->add(
                            'notice', 'Password updated successfully!'
                        );
                    } else {
                        $request->getSession()->getFlashBag()->add(
                            'errornotice', 'Current Password is not correct!'
                        );
                    }
                } else {
                    $request->getSession()->getFlashBag()->add(
                        'errornotice', 'New Password and Confirm Password does not match'
                    );
                }
            }
        }

        $userImage = $userService->userImage($user->getUserImage());

        $userIdFiles = $user->getIdfiles();
        if (empty($userIdFiles)) {
            $userIdFiles = '';
        }

        $resumeFiles = $userService->fetchOtherfiles($user->getId(), 'resume');
        if (empty($resumeFiles)) {
            $resumeFiles = '';
        }

        $qualificationFiles = $userService->fetchOtherfiles($user->getId(), 'qualification');
        if (empty($qualificationFiles)) {
            $qualificationFiles = '';
        }

        $referenceFiles = $userService->fetchOtherfiles($user->getId(), 'reference');
        if (empty($referenceFiles)) {
            $referenceFiles = '';
        }

        $matrixFiles = $userService->fetchOtherfiles($user->getId(), 'matrix');
        if (empty($matrixFiles)) {
            $matrixFiles = '';
        }

        $tab = '';
        $httpRef = $this->get('request')->server->get('HTTP_REFERER');
        if (!empty($httpRef)) {
            $httpRef = basename($httpRef);
            $tab = $this->getRequest()->get('tab');
        }

        return $this->render('GqAusUserBundle:User:profile.html.twig', array(
                'form' => $userProfileForm->createView(),
                'filesForm' => $idFilesForm->createView(),
                'userImage' => $userImage,
                'userIdFiles' => $userIdFiles,
                'documentTypes' => $documentTypes,
                'changepwdForm' => $resetForm->createView(),
                'resumeForm' => $resumeForm->createView(),
                'qualificationForm' => $qualificationForm->createView(),
                'referenceForm' => $referenceForm->createView(),
                'matrixForm' => $matrixForm->createView(),
                'resumeFiles' => $resumeFiles,
                'qualFiles' => $qualificationFiles,
                'referenceFiles' => $referenceFiles,
                'matrixFiles' => $matrixFiles,
                'tab' => $tab
        ));
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
            $result = $this->get('gq_aus_user.file_uploader')->uploadIdFiles($data);
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
        $folderPath = $this->get('kernel')->getRootDir() . '/../web/public/uploads/';
        $proImg = $request->files->get('file');
        $profilePic = $proImg->getClientOriginalName();
        $profilePic = time() . '-' . $profilePic;
        if ($proImg->getClientOriginalName() != "") {
            $proImg->move($folderPath, $profilePic);
            $userService = $this->get('UserService');
            if ($userId != '0') {
                $user = $userService->getUser($userId);
                $user->setUserImage($profilePic);
                $userService->saveProfile();
            }
            echo $profilePic;
        } else
            echo 'error';
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
            $user = $this->get('UserService')->getCurrentUser();
            $curDbPassword = $user->getPassword();
            if (password_verify($mypassword, $curDbPassword)) {
                echo 'success';
            } else {
                echo 'fail';
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
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
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
        $form = $this->createForm(new MatrixForm(), array());
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
        if (!empty($userId)) {
            $user = $this->get('UserService')->getUserInfo($userId);
        } else {
            $user = $this->get('security.context')->getToken()->getUser();
        }
        $results['evidences'] = $user->getEvidences();
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
        $userProfileForm = $this->createForm(new ProfileForm(), $user);
        $userRole = $user->getRoleName();

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
        if ($userRole != 'ROLE_FACILITATOR') {
            $userProfileForm->remove('crmId');
        }

        $resetForm = $this->createForm(new ChangePasswordForm(), array());
        $image = $user->getUserImage();
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request);
            if ($userProfileForm->isValid()) {
                $userService->savePersonalProfile($user, $image);
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Profile updated successfully!'
                );
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
            }
        }
        $userImage = $userService->userImage($user->getUserImage());
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
        if ($userRole != 'ROLE_FACILITATOR') {
            $userProfileForm->remove('crmId');
        }
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request);
            if ($userProfileForm->isValid()) {
                $image = $request->get('hdn-img');
                $this->get('UserService')->addPersonalProfile($userRole, $request->get('userprofile'), $image);
                $request->getSession()->getFlashBag()->add(
                    'notice', 'Profile added successfully!'
                );
                return $this->redirect('/manageusers');
            }
        }
        $tab = '';
        $httpRef = $this->get('request')->server->get('HTTP_REFERER');
        if (!empty($httpRef)) {
            $httpRef = basename($httpRef);
            $tab = $this->getRequest()->get('tab');
        }

        return $this->render('GqAusUserBundle:User:addprofile.html.twig', array(
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
    function faqAction()
    {
         $faq = $this->get('UserService')->getFaq();        
         return $this->render('GqAusUserBundle:Faq:faq.html.twig',array('faq' => $faq));
    }

}
