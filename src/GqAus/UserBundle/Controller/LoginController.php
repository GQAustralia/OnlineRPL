<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller
{
    /**
     * login function.
     *  @return string
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(is_object($user) && count($user) > 0) {
            return $this->redirect('dashboard');
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
                'GqAusUserBundle:Login:index.html.twig',
                array(
                    'error'         => $error,
                )
            );
        }
    }
    
    /**
     * logout function.
     */
    public function logoutAction()
    {
        $this->container->get('security.context')->setToken(NULL);
        return $this->redirect('login');
    }
}
