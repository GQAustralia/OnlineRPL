<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller
{

    /**
     * Function to login to application based on user roles
     * return string
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $user = $this->get('security.context')->getToken()->getUser();
        if (is_object($user) && count($user) > 0) {            
            $role = $user->getRoles();
            $session = $request->getSession();
            $session->set('user_id', $user->getId());
            if($role[0] == "ROLE_APPLICANT")
            { 
                $userProfilePercentage = $this->get('UserService')->getUserProfilePercentage($user);
                if($userProfilePercentage < 100)
                    return $this->redirect('userprofile');
                else
                    return $this->redirect('qualifications');
            }
            else{
                return $this->redirect('dashboard');
            }
        } else {
            // get the login error if there is one
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR
                );
            } else {
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            }
            return $this->render(
                    'GqAusUserBundle:Login:index.html.twig', array(
                    'error' => $error,
                    )
            );
        }
    }

    /**
     * Function to logout from application
     * return string
     */
    public function logoutAction()
    {
        $this->container->get('security.context')->setToken(NULL);
        $this->get('session')->set('muser', NULL);
        $this->get('session')->set('suser', NULL);
        return $this->redirect('login');
    }

}
