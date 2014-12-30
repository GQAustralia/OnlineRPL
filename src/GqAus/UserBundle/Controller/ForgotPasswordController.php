<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;


class ForgotPasswordController extends Controller
{
    /**
     * function to request for forgot password .
     *  @return string
     */
    public function indexAction()
    {
        $message = '';
        if($this->getRequest()->getMethod() == 'POST') {
            $email = $this->getRequest()->get('email');
            $user = $this->getDoctrine()->getRepository('GqAusUserBundle:User')->findOneBy(array('email' => $email));
            if (!empty($user)) {
            
                $token = uniqid();
                $nowtime = date('Y-m-d h:i:s');
                $tokenExpiryDate = date('Y-m-d H:i:s', strtotime($nowtime . ' + 4 hours'));
                $user->setPasswordToken($token);
                $user->setTokenStatus('1');
                $user->setTokenExpiry($tokenExpiryDate);
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
                
                $userName = $user->getUsername();
                $to = 'swetha.kolluru@valuelabs.net';
                $subject = 'Request for Password Reset';
                $applicationUrl = $this->container->getParameter('applicationUrl');
                $body = "Dear ".$userName.",<br><br> Please click on the link to reset your password!
                 <a href='".$applicationUrl."resetpassword/".$token."'>Click Here </a>
                 <br><br> Regards,<br>OnlineRPL";
                 
                $emailContent = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom('swetha.kolluru@valuelabs.net')
                    ->setTo($to)
                    ->setBody($body)
                    ->setContentType("text/html");
                    $this->get('mailer')->send($emailContent);
                    
                $message = 'A request for password reset is sent to this address.';
            } else {
                $message = 'There is no user with this email address. Please try again';
            }
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
        $validRequest = 0;
        $message = '';
        $user = $this->getDoctrine()->getRepository('GqAusUserBundle:User')->findOneBy(array('passwordToken' => $token,
        'tokenStatus' => 1));
        if (!empty($user)) {
            $tokenExpiry = $user->getTokenExpiry();
            if ($tokenExpiry > date('Y-m-d h:i:s')) {
                if($this->getRequest()->getMethod() == 'POST') {
                    $password = $this->getRequest()->get('password');
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $user->setPassword($password);
                    $user->setTokenStatus('0');
                    $this->getDoctrine()->getManager()->persist($user);
                    $this->getDoctrine()->getManager()->flush();
                    $message = 'Password changed successfully , please login';
                }
                $validRequest = 1;
            }
        }
        return $this->render(
            'GqAusUserBundle:Login:resetpassword.html.twig', array('message' => $message, 'validRequest' => $validRequest));
    }
}
