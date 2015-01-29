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

        $userImage = $user->getUserImage();
        if (empty($userImage)) {
            $userImage = 'profielicon.png';
        }
        
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
                    'matrixFiles' => $matrixFiles
        ));
    }    
    
    public function addIdFileAction(Request $request)
    {
        $form = $this->createForm(new IdFilesForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $url = $this->get('gq_aus_user.file_uploader')->uploadIdFiles($data);            
            $request->getSession()->getFlashBag()->add(
                'notice',
                'Files Uploaded Successfully!'
            );
            return $this->redirect('userprofile');
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
        $fullPath = $this->container->getParameter('amazon_s3_base_url').'2015-01-29-54c8f5e30df9c.jpg';
        if ($fd = fopen ($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
                
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose ($fd);
//        header("Content-type: application/pdf");
//        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download       
//        header("Content-length: $fsize");
//        header("Cache-control: private");
//        readfile($zipName);
    }
	
}
