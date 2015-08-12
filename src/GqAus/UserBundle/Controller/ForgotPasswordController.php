<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class ForgotPasswordController extends Controller
{

    /**
     * function to request for forgot password .
     *  @return string
     */
    public function indexAction()
    {
        $message = '';
        if ($this->getRequest()->getMethod() == 'POST') {
            $userService = $this->get('UserService');
            $email = $this->getRequest()->get('email');
            $message = $userService->forgotPasswordRequest($email);
        }
        return $this->render(
                        'GqAusUserBundle:Login:forgotpassword.html.twig', array('message' => $message));
    }

    /**
     * function to reset password.
     *  @return string
     */
    public function resetPasswordAction($token)
    {
        $method = $this->getRequest()->getMethod();
        $password = $this->getRequest()->get('password');
        $userService = $this->get('UserService');
        $result = $userService->resetPasswordRequest($token, $method, $password);
        return $this->render('GqAusUserBundle:Login:resetpassword.html.twig', $result);
    }

}
