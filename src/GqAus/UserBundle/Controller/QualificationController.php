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
		if (!empty($userId)) {
			$userService = $this->get('UserService');
			$user = $userService->getUserInfo($userId);
		} else {
			$user = $this->get('security.context')->getToken()->getUser();
		}
		$role = $user->getRoles();
		$results['userRole'] = $role[0];
		$results['unitevidences'] = $user->getEvidences();
		$results['unitCode'] = $this->getRequest()->get('unit');
		echo $template = $this->renderView('GqAusUserBundle:Qualification:unitevidence.html.twig', $results);
		exit;
    }
}
