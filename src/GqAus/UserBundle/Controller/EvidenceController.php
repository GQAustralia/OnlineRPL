<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\EvidenceForm;

class EvidenceController extends Controller
{
    
    /**
    * Function to add the Evidence
    */
    public function addAction(Request $request)
    {        
        $form = $this->createForm(new EvidenceForm(), array());

        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $fileNames = $this->get('gq_aus_user.file_uploader')->process($data['file']);
            echo $result = $this->get('EvidenceService')->saveEvidence($fileNames, $data); exit;
            ///$referer = $request->headers->get('referer');
            //return $this->redirect($referer);
        }
    }
    
    /**
    * Function to display all the Evidences
    */
    public function viewAction(Request $request)
    { 
        $evidenceService = $this->get('EvidenceService');
        $evidences = $evidenceService->getCurrentUser()->getEvidences();
         return $this->render(
            'GqAusUserBundle:Evidence:view.html.twig',
            array('evidences'  => $evidences)
        );
    }
    
    /**
    * Function to save the existing Evidence
    */
    public function saveExistingEvidenceAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $result = $this->get('EvidenceService')->saveExistingEvidence($request); exit;
            //$referer = $request->headers->get('referer');
            //return $this->redirect($referer);
        }
    }
    
    /**
    * Function to delete Evidence file
    */
    public function deleteFileAction()
    {
        $evidenceId = $this->getRequest()->get('fid');
        $evidenceType = $this->getRequest()->get('ftype');
        $fileName = $this->get('EvidenceService')->deleteEvidence($evidenceId, $evidenceType);
        if ($evidenceType != 'text') {
            $this->get('gq_aus_user.file_uploader')->delete($fileName);
        }
        exit;
    }
    
    /**
    * Function to update Evidence Title
    */
    public function editTitleAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $title = $request->get('title');
            $id = $request->get('id');
            $evidenceService = $this->get('EvidenceService');
            $evidenceService->updateEvidence($id,$title);
            echo "success";
        }
        exit;
    }
}
