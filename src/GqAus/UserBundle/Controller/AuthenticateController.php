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
        $session_user = $this->get('security.context')->getToken()->getUser();
        $userObj = $this->get('UserService')->getUser($userId);
        $usernamePasswordToken = new UsernamePasswordToken($userObj, null, 'secured_area');
        $this->container->get('security.context')->setToken($usernamePasswordToken);
        $user_role = $this->get('security.context')->getToken()->getUser()->getRoleName();
        
        if ($userId != $session_user->getId()) {
            if ($session_user->getRoleName() == 'ROLE_SUPERADMIN' &&  $user_role == 'ROLE_MANAGER') {
                $this->get('session')->set('suser', $session_user->getId());
                return $this->redirect('/dashboard');
            }
            if ($user_role == 'ROLE_MANAGER' || $user_role == 'ROLE_SUPERADMIN') {
                return $this->redirect('/manageusers');
            } else {
                $this->get('session')->set('muser', $session_user->getId());
                return $this->redirect('/dashboard');
            }
        }
    }
}