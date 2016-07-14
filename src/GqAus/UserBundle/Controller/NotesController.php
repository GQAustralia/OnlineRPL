<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\NotesForm;

class NotesController extends Controller
{

    /**
     * Function to add the notes
     * @param object $request
     * return string
     */
    public function addNotesAction(Request $request)
    {
        $form = $this->createForm(new NotesForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $data['session_user_id'] = $this->get('security.context')->getToken()->getUser()->getId();
            $data['session_user_role'] = $this->get('security.context')->getToken()->getUser()->getRoleName();
            $data['session_user_email'] = $this->get('security.context')->getToken()->getUser()->getEmail();
            $data['session_user_name'] = $this->get('security.context')->getToken()->getUser()->getUsername();
			$data['unit_notes'] = $this->getRequest()->get('noteMsg');
            $data['unit_note_type'] = $this->getRequest()->get('noteType');
            $data['course_id'] = $this->getRequest()->get('courseId');
            echo $this->get('NotesService')->saveNotes($data);
        }
        exit;
    }

    /**
     * Function to get notes
     * return string
     */
    public function getUnitNotesAction()
    {
        $unitId = $this->getRequest()->get('unitId');
        $userType = $this->getRequest()->get('userType');
        if (!empty($unitId) && !empty($userType)) {
            $results['notes'] = $this->get('NotesService')->getUnitNotes($unitId, $userType);
            echo $template = $this->renderView('GqAusUserBundle:Note:unitnotes.html.twig', $results);
        } else {
            echo 'Empty Unit Id';
        }
        exit;
    }

}
