<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\FileForm;

class FileController extends Controller
{
    /**
     * Function to display all the Evidences
     * @param integer $request
     * return string
     */
    public function viewAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();

        $evidenceService = $this->get('EvidenceService');
        if (in_array('ROLE_APPLICANT', $userRole)) {
            $userCourses = $user->getCourses();
            $evidences = $evidenceService->currentUser->getEvidences();
        } else {
            $userId = $request->get('userId');
            $toViewUser = $evidenceService->userService->getUserInfo($userId);
            $userCourses = $toViewUser->getCourses();
            $evidences = $toViewUser->getEvidences();
            //$evidences = array();
        }
        $formattedEvd = $evidenceService->formatEvidencesListToDisplay($evidences);
        return $this->render('GqAusUserBundle:File:view.html.twig', array('evidences' => $formattedEvd['formattedEvidences'], 'evdMapping' => $formattedEvd['evdMapping'], 'courses' => $userCourses));
    }
}