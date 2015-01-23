<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QualificationController extends Controller
{
    /**
    * Function to get unit Evidence
    * return $result array
    */
    public function getUnitEvidencesAction()
    {
        $userId = $this->getRequest()->get('userId');
        $results['unitCode'] = $this->getRequest()->get('unit');
        if (!empty($userId)) {
            $user = $this->get('UserService')->getUserInfo($userId);
            $results['unitStatus'] = $this->get('CoursesService')->getUnitStatus($userId, $results['unitCode']);
        } else {
            $user = $this->get('security.context')->getToken()->getUser();
        }
        $results['unitevidences'] = $user->getEvidences();        
        echo $template = $this->renderView('GqAusUserBundle:Qualification:unitevidence.html.twig', $results); exit;
    }
}
