<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ProfileForm;
use GqAus\UserBundle\Form\IdFilesForm;
use GqAus\UserBundle\Form\ChangePasswordForm;

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
        $resetform = $this->createForm(new ChangePasswordForm(), array());
        $image = $user->getUserImage();
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request);
            //$userAddressForm->handleRequest($request);
            if ($userProfileForm->isValid()) {
                //$userService->saveProfile();
                $userService->savePersonalProfile($image);
                
                $request->getSession()->getFlashBag()->add(
                    'notice',
                    'Profile updated successfully!'
                );
            }
            
            $resetform->handleRequest($request);
            if ($resetform->isValid()) {
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
        if (empty($userImage)) {
            $userIdFiles = '';
        }

        return $this->render('GqAusUserBundle:User:profile.html.twig', array(
                    'form' => $userProfileForm->createView(),
                    'filesForm' => $idFilesForm->createView(),
                    'userImage' => $userImage,
                    'userIdFiles' => $userIdFiles,
                    'documentTypes' => $documentTypes,            
                    'changepwdForm' => $resetform->createView()
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
	
}
