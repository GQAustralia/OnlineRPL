<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ProfileForm;
use GqAus\UserBundle\Form\AddressForm;

class UserController extends Controller
{
    public function profileAction(Request $request)
    {        
        $userService = $this->get('UserService');
        $user = $userService->getCurrentUser();
        $session = $request->getSession();
        
        $userProfileForm = $this->createForm(new ProfileForm(), $user);
        
                
        if ($request->isMethod('POST')) {
            $userProfileForm->handleRequest($request);
            //$userAddressForm->handleRequest($request);
            if ($userProfileForm->isValid()) {
                $userService->saveProfile();
            }
        }       
       
        $userImage = $user->getUserImage();
        if (empty($userImage)) {
             $userImage = 'profielicon.png';
        }
        //echo "<pre>"; print_r($userProfileForm->createView()); exit;
       return $this->render('GqAusUserBundle:User:profile.html.twig', array(
                    'form' => $userProfileForm->createView(),
                    'userImage' => $userImage
        ));
    }
}
