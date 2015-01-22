<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApplicantController extends Controller
{
   /**
    * Function to get applicant details page
    * return $result array
    */
	public function detailsAction($qcode, $uid, Request $request)
    {
		$user = $this->get('UserService')->getUserInfo($uid);
		$results = $this->get('CoursesService')->getCoursesInfo($qcode);
		if (!empty($user) && isset($results['courseInfo']['id'])) {
			$applicantInfo = $this->get('UserService')->getApplicantInfo($user);
			return $this->render('GqAusUserBundle:Applicant:details.html.twig', array_merge($results, $applicantInfo));
		} else {
			return $this->render('GqAusUserBundle:Default:error.html.twig');
		}
    }
	
	/**
    * Function to update user unit evidence status
    * return $result array
    */
	public function setUserUnitEvidencesStatusAction()
	{
		$userId = $this->getRequest()->get('userId');
		$unit = $this->getRequest()->get('unit');
		$status = $this->getRequest()->get('status');
		echo $status = $this->get('UserService')->updateApplicantEvidences($userId, $unit, $status);
		exit;
	}
}
