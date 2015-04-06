<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\NotesForm;

class NotesController extends Controller
{

    /**
     * Function to add the notes
     */
    public function addNotesAction(Request $request)
    {
        $form = $this->createForm(new NotesForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            echo $result = $this->get('NotesService')->saveNotes($data);
        }
        exit;
    }

    /**
    * Function to get notes
    */
    public function getUnitNotesAction()
    {
        $unitId = $this->getRequest()->get('unitId');
        $userType = $this->getRequest()->get('userType');
        if (!empty($unitId) && !empty($userType)) {
          $results['notes'] = $this->get('NotesService')->getUnitNotes($unitId, $userType);
          echo $template = $this->renderView('GqAusUserBundle:Note:unitnotes.html.twig', $results);  
        } else {
          echo "Empty Unit Id";  
        }
        
        exit;
    }

    /**
     * Function to delete Evidence file
     *
    public function deleteNotesAction()
    {
        $evidenceId = $this->getRequest()->get('nid');
        $evidenceType = $this->getRequest()->get('ftype');
        $fileName = $this->get('EvidenceService')->deleteEvidence($evidenceId, $evidenceType);
        exit;
    }*/

    

}
