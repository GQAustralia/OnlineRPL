<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\EvidenceForm;

class EvidenceController extends Controller
{
    
    public function addAction(Request $request)
    {
        //$session = $request->getSession();
        //$session_user = $this->get('security.context')->getToken()->getUser();
        //$session->set('user_id', $session_user->getId());
        
        $form = $this->createForm(new EvidenceForm(), array());

        if ($request->isMethod('POST')) {
            $form->bind($request);
                $data = $form->getData();
                $fileNames = $this->get('gq_aus_user.file_uploader')->process($data['file']);
                $result = $this->get('EvidenceService')->saveEvidence($fileNames, $data['hid_unit']);
                echo "<pre>"; print_r($fileNames); exit;
        }

        /*return $this->render(
            'GqAusUserBundle:Evidence:index.html.twig',
            array('form'  => $form->createView())
        );*/
    }
    
    
    public function viewAction(Request $request)
    { 
        $evidenceService = $this->get('EvidenceService');
        $evidences = $evidenceService->getCurrentUser()->getEvidences();        
         return $this->render(
            'GqAusUserBundle:Evidence:view.html.twig',
            array('evidences'  => $evidences)
        );
        
    }
}
