<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ProfileForm;
use GqAus\UserBundle\Form\IdFilesForm;
use GqAus\UserBundle\Form\ChangePasswordForm;
use GqAus\UserBundle\Form\ResumeForm;
use GqAus\UserBundle\Form\QualificationForm;
use GqAus\UserBundle\Form\ReferenceForm;
use GqAus\UserBundle\Form\MatrixForm;

class UserController extends Controller
{
    public function profileAction(Request $request)
    {        
        $session = $request->getSession();
        $session_user = $this->get('security.context')->getToken()->getUser();
        $session->set('user_id', $session_user->getId());
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        $userProfileForm = $this->createForm(new ProfileForm(), $user);

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
                //$userService->saveProfile();
                $userService->savePersonalProfile($image);
                
                $request->getSession()->getFlashBag()->add(
                    'notice',
                    'Profile updated successfully!'
                );
            }
            
            $resetForm->handleRequest($request);
            if ($resetForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $cur_db_password = $user->getPassword();
                $pwdarr = $request->get('password');
                $oldpassword = $pwdarr['oldpassword'];
                $newpassword = $pwdarr['newpassword'];
                $confirmnewpassword = $pwdarr['confirmnewpassword'];
                if($newpassword==$confirmnewpassword) {
                    if (password_verify($oldpassword, $cur_db_password)) {
                        $password = password_hash($newpassword, PASSWORD_BCRYPT);
                        $user->setPassword($password);
                        $user->setTokenStatus('0');
                        $em->persist($user);
                        $em->flush();
                        $request->getSession()->getFlashBag()->add(
                            'notice',
                            'Password updated successfully!'
                        );
                    }
                    else {
                        $request->getSession()->getFlashBag()->add(
                            'errornotice',
                            'Current Password is not correct!'
                        );
                    }
                }
                else
                {
                    $request->getSession()->getFlashBag()->add(
                        'errornotice',
                        'New Password and Confirm Password does not match'
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
    
    public function addIdFileAction(Request $request)
    {
        $form = $this->createForm(new IdFilesForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->uploadIdFiles($data);            
            if($result){
                echo $result;
            }
            exit;
        }
    }
    
    public function deleteIdFilesAction()
    {
        $IdFileId = $this->getRequest()->get('fid');
        $IdFileType = $this->getRequest()->get('ftype');
        $fileName = $this->get('UserService')->deleteIdFiles($IdFileId, $IdFileType);
        $this->get('gq_aus_user.file_uploader')->delete($fileName);
        exit;
    }
    
    public function uploadProfilePicAction(Request $request)
    {
        $folderPath = $this->get('kernel')->getRootDir().'/../web/public/uploads/';
        $proImg = $request->files->get('file');
        $profilePic = $proImg->getClientOriginalName();
        $profilePic = time()."-".$profilePic;
        if($proImg->getClientOriginalName()!="")
        {
            $proImg->move($folderPath, $profilePic);
            $userService = $this->get('UserService');
            $user = $userService->getCurrentUser();
            $user->setUserImage($profilePic);
            $userService->saveProfile();
            echo $profilePic;
        }
        else
            echo "error";
        exit;
    }
    
    public function checkMyPasswordAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $mypassword = $request->get("mypassword");
            $userService = $this->get('UserService');
            $user = $userService->getCurrentUser();
            $cur_db_password = $user->getPassword();
            if (password_verify($mypassword, $cur_db_password)) {
                echo "success";
            }
            else {
                echo "fail";
            }
        }
        exit;
    }    
    
    public function resumeAction(Request $request)
    {
        $form = $this->createForm(new resumeForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData(); 
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
            if($result){
                echo $result;
            }
            exit;
        }
    }    
        
    
    public function qualificationAction(Request $request)
    {
        $form = $this->createForm(new QualificationForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
            if($result){
                echo $result;
            }
            exit;
        }
    }   
        
    
    public function referenceAction(Request $request)
    {
        $form = $this->createForm(new ReferenceForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
            if($result){
                echo $result;
            }
            exit;
        }
    }  
        
    
    public function matrixAction(Request $request)
    {
        $form = $this->createForm(new MatrixForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $result = $this->get('gq_aus_user.file_uploader')->resume($data);
            if($result){
                echo $result;
            }
            exit;
        }
    }
    
    public function deleteOtherFilesAction()
    {
        $FileId = $this->getRequest()->get('fid');
        $fileName = $this->get('UserService')->deleteOtherFiles($FileId);
        $this->get('gq_aus_user.file_uploader')->delete($fileName);
        exit;
    }
    
    public function downloadMatrixAction()
    {   
        $file = "template.xls";
        return $this->get('UserService')->downloadCourseCondition(nulll, $file);
    }
    
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
    */
    public function downloadAssessorProfileAction($uid)
    {
        $files = array();
        $userService = $this->get('UserService');
        $assessorFiles = $userService->fetchOtherfiles($uid);
        foreach ($assessorFiles as $assessorFile) {
            array_push($files, $this->container->getParameter('amazon_s3_base_url').$assessorFile->getPath());
        }
        $zip = new \ZipArchive();
        $zipName = 'AssessorFiles-'.time().".zip";
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
