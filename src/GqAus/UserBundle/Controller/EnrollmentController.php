<?php
namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    /**
     * 
     * @param \GqAus\UserBundle\Controller\Request $request
     */
    public function saveEnrollmentAction(Request $request)
    {
        $userId =  $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST')) {      
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            echo $this->get('UserService')->updateUserProfile($userId, $params);
        }
    }

}
