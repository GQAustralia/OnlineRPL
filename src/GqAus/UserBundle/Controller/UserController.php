<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ProfileForm;
use GqAus\UserBundle\Form\IdFilesForm;

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
		$image = $user->getUserImage();
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request);
            //$userAddressForm->handleRequest($request);
            if ($userProfileForm->isValid()) {
                //$userService->saveProfile();
				$userService->savePersonalProfile($image);
            }
            $request->getSession()->getFlashBag()->add(
                'notice',
                'Profile updated successfully!'
            );

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
                    'documentTypes' => $documentTypes
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
	
}
