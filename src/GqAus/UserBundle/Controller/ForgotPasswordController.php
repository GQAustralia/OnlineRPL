<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class ForgotPasswordController extends Controller
{

    /**
     * Function to request for forgot password
     * return string
     */
    public function indexAction()
    {
        $message = '';
        if ($this->getRequest()->getMethod() == 'POST') {
            $email = $this->getRequest()->get('email');
            $message = $this->get('UserService')->forgotPasswordRequest($email);
            $response['msg'] = $message;
            echo json_encode($response);
            exit;
        }
        
        return $this->render('GqAusUserBundle:Login:forgotpassword.html.twig', array('message' => $message));
    }

    /**
     * function to reset password.
     * @param string $token
     * return string
     */
    public function resetPasswordAction($token)
    {
        $method = $this->getRequest()->getMethod();
        $password = $this->getRequest()->get('password');
        $result = $this->get('UserService')->resetPasswordRequest($token, $method, $password);
        return $this->render('GqAusUserBundle:Login:resetpassword.html.twig', $result);
    }

}
