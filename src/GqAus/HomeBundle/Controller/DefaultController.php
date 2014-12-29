<?php

namespace GqAus\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GqAusHomeBundle:Default:index.html.twig');
    }
}
