<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;

class LoginController extends Controller
{
    const ROLE_APPLICANT = 'ROLE_APPLICANT';
    const ROLE_MANAGER = 'ROLE_MANAGER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_FACILITATOR = 'ROLE_FACILITATOR';

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');

        if (is_object($user) && count($user) > 0) {

            $request->getSession()->set('user_id', $user->getId());
            $userRole = $user->getRoles()[0];

            if ($userRole == self::ROLE_APPLICANT) {

                if ($user->getApplicantStatus() < $userService::COMPLETE_ENROLMENT) {
                    return $this->redirect('enrolment');
                }

                if ($user->getApplicantStatus() == $userService::COMPLETE_ENROLMENT) {
                    $userService->completeOverview($user->getId());
                    return $this->redirect('overview');
                }

                return $this->redirect('overview');
            }

            if($userRole == self::ROLE_FACILITATOR) {
                return $this->redirect('account-manager-dashboard');
            }

            return $this->redirect('dashboard');
        }

        $error = $this->getLoginError($request);
        $request->getSession()->invalidate();

        return $this->render('GqAusUserBundle:Login:index.html.twig', ['error' => $error]);
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

    /**
     * @param Request $request
     *
     * @return mixed
     */
    private function getLoginError(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
            $request->getSession()->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $error;
    }
}
