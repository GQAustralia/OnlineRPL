<?php
namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EnrollmentController extends Controller
{

    /**
     * 
     * @return type
     */
    public function enrollmentAction()
    {
       return $this->render('GqAusUserBundle:Enrollment:index.html.twig', array(
                // ...
        ));
    }

}
