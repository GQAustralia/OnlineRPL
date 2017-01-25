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

        if (is_object($user) && count($user) > 0) {
            return $this->render('GqAusUserBundle:Overview:index.html.twig');
        }

        return $this->redirect('login');
    }
}
