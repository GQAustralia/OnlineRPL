<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        $show_splash_screen = 1;

        if ($user->getApplicantStatus() >= $userService::COMPLETE_GOOD_JOB_WELCOME_SPLASH_SCREEN_APP_STAT) {
        			$show_splash_screen = 0;
        }
        $userService->completeOverview($user->getId());
        if (is_object($user) && count($user) > 0) {
            return $this->render('GqAusUserBundle:Overview:index.html.twig', array('show_splash_screen' => $show_splash_screen));
        }

        return $this->redirect('login');
    }
}
