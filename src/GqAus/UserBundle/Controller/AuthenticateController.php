<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthenticateController extends Controller
{

    /**
     * Function to login as user
     * return $result array
     */
    public function userLoginAction($userId)
    {
        $sessionUser = $this->get('security.context')->getToken()->getUser();
        $userObj = $this->get('UserService')->getUser($userId);
        $usernamePasswordToken = new UsernamePasswordToken($userObj, null, 'secured_area');
        $this->container->get('security.context')->setToken($usernamePasswordToken);
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoleName();

        if ($userId != $sessionUser->getId()) {
            if ($sessionUser->getRoleName() == 'ROLE_SUPERADMIN' && $userRole == 'ROLE_MANAGER') {
                $this->get('session')->set('suser', $sessionUser->getId());
                return $this->redirect('/dashboard');
            }
            if ($userRole == 'ROLE_MANAGER' || $userRole == 'ROLE_SUPERADMIN') {
                return $this->redirect('/manageusers');
            } else {
                $this->get('session')->set('muser', $sessionUser->getId());
                return $this->redirect('/dashboard');
            }
        }
    }

}
