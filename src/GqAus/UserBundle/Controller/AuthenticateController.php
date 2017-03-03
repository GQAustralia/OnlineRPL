<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class AuthenticateController extends Controller
{
    const COMPLETE_SET_PASSWORD_APP_STAT = 2;
    const COMPLETE_ON_BOARDING_APP_STAT = 3;

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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

        if ($user->getApplicantStatus() >= self::COMPLETE_ON_BOARDING_APP_STAT) {
            return $this->redirect('/login');
        }
        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {
            $token = new UsernamePasswordToken($user, null, "secured_area", $user->getRoles());
            $this->get("security.context")->setToken($token); //now the user is logged in
            //now dispatch the login event
            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }
        return $this->render('GqAusUserBundle:Auth:first_time_set_password/index.html.twig', ['user' => $user]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function firstTimeSetPasswordAjaxAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');
        $service = $this->get('SetNewUserPasswordService');
        $tokenId = $request->get('loginToken');
        $password = $request->get('password');

        if (!$tokenId || !$password) {
            return $response->error()->respondBadRequest('Missing Parameters.');
        }

        if (!$service->validateUserTokenAndUpdatePassword($tokenId, $password)) {
            return $response->error()->respondBadRequest('Invalid Token.');
        }
        
        return $response->fractal()->respondSuccess();
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

        if ($user->getApplicantStatus() == self::COMPLETE_ON_BOARDING_APP_STAT) {
            return $this->redirect('/login');
        }

        return $this->render('GqAusUserBundle:Auth:on_boarding/index.html.twig', [
            'loginToken' => $user->getLoginToken(),
            'firstName' => $user->getFirstName()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function acceptOnBoardingAjaxAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');
        $userService = $this->get('UserService');

        $user = $userService->findUserByLoginToken($request->get('loginToken'));

        if (!$user) {
            return $response->error()->respondBadRequest('Invalid Token.');
        }

        $userService->completeUserOnBoarding($request->get('loginToken'));

        return $response->fractal()->respondSuccess('User On Boarding Complete.');
    }

    /**
     * @param int $userId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
