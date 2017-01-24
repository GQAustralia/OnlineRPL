<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller
{
    public function indexAction()
    {
        return $this->render('GqAusUserBundle:Overview:index.html.twig', []);
    }
}
