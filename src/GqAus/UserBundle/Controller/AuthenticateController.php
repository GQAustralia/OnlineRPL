<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthenticateController extends Controller
{
    const COMPLETE_SET_PASSWORD_APP_STAT = 2;
    const COMPLETE_ON_BOARDING_APP_STAT = 3;

    function validateUserAction(Request $request)
    {
        $loginToken = $request->get('loginToken');
        $userService = $this->get('UserService');
        $user = $userService->findUserByLoginToken($loginToken);

        /**
         * @todo should go to a 404 page
         */
        if (!$user) {
            return $this->render('GqAusUserBundle:Auth:first_time_set_password/index.html.twig');
        }

        if ($user->getApplicantStatus() == SELF::COMPLETE_SET_PASSWORD_APP_STAT) {
            return $this->redirect('/onBoarding/' . $loginToken);
        }

        if ($user->getApplicantStatus() == self::COMPLETE_ON_BOARDING_APP_STAT) {
            return $this->redirect('/login');
        }

        return $this->render('GqAusUserBundle:Auth:first_time_set_password/index.html.twig', ['user' => $user]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onBoardingAction(Request $request)
    {
        $userService = $this->get('UserService');
        $user = $userService->findUserByLoginToken($request->get('loginToken'));

        return $this->render('GqAusUserBundle:Auth:on_boarding/index.html.twig', ['tokenId' => $user->getLoginToken()]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    function firstTimePasswordLoginAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');
        $service = $this->get('SetNewUserPasswordService');
        $tokenId = $request->get('tokenId');
        $password = $request->get('newPassword');

        if (!$tokenId || !$password) {
            return $response->error()->respondBadRequest('Missing Parameters.');
        }

        if (!$service->validateUserTokenAndUpdatePassword($tokenId, $password)) {
            return $response->error()->respondBadRequest('Invalid Token.');
        }

        return $response->fractal()->respondSuccess();
    }

    public function acceptOnBoardingAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');
        $service = $this->get('UserService');

        $service->completeUserOnBoarding($request->get('tokenId'));

        return $response->fractal()->respondSuccess('User On Boarding Complete.');
    }

    /**
     * Function to login as user
     * @param int $userId
     * return string
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
