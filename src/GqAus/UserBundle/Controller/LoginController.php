<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;

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
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
        	$error = $request->attributes->get(
        			SecurityContext::AUTHENTICATION_ERROR
        	);
        } else {
        	$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        	$session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        $request->getSession()->invalidate();
        if (is_object($user) && count($user) > 0) {
            $role = $user->getRoles();   
            $session = $request->getSession();
            $session->set('user_id', $user->getId());
            if($role[0] == "ROLE_APPLICANT")
            { 
                $userProfilePercentage = $this->get('UserService')->getUserProfilePercentage($user);
                    return $this->redirect('enrolment');
//                if($userProfilePercentage < 100)
//                    return $this->redirect('qualifications');
//                else
//                    return $this->redirect('userprofile');
            }
            else{
                return $this->redirect('dashboard');
            }
        } else {

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
    	$request = $this->getRequest();
    	$session = $request->getSession();
    	$request->getSession()->invalidate();
    	// get the login error if there is one
    	$error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
    	$session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        $this->container->get('security.context')->setToken(NULL);
        $this->get('session')->set('muser', NULL);
        $this->get('session')->set('suser', NULL);
        return $this->redirect('login');
    }

}
