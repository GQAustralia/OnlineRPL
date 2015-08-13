<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\EvidenceForm;
use GqAus\UserBundle\Form\AssessmentForm;

class EvidenceController extends Controller
{

    /**
     * Function to add the Evidence
     * return string
     */
    public function addAction(Request $request)
    {
        error_reporting(0);
        $form = $this->createForm(new EvidenceForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            $fileNames = $this->get('gq_aus_user.file_uploader')->process($data['file']);
            echo $result = $this->get('EvidenceService')->saveEvidence($fileNames, $data);
            exit;
        }
    }

    /**
     * Function to display all the Evidences
     * return array
     */
    public function viewAction(Request $request)
    {
        $evidenceService = $this->get('EvidenceService');
        $evidences = $evidenceService->getCurrentUser()->getEvidences();
        return $this->render('GqAusUserBundle:Evidence:view.html.twig', array('evidences' => $evidences));
    }

    /**
     * Function to save the existing Evidence
     * return string
     */
    public function saveExistingEvidenceAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            echo $result = $this->get('EvidenceService')->saveExistingEvidence($request);
            exit;
        } else {
            echo 'no post';
            exit;
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
     * return string
     */
    public function editTitleAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $title = $request->get('title');
            $id = $request->get('id');
            $evidenceService = $this->get('EvidenceService');
            $evidenceService->updateEvidence($id, $title);
            echo "success";
        }
        exit;
    }

    /**
     * Function to display all the Evidences
     */
    public function zipAction(Request $request)
    {
        $files = array();
        $evidenceService = $this->get('EvidenceService');
        $evidences = $evidenceService->getCurrentUser()->getEvidences();
        foreach ($evidences as $evidence) {
            array_push($files, $this->container->getParameter('amazon_s3_base_url') . $evidence->getPath());
        }
        $zip = new \ZipArchive();
        $zipName = 'Documents-' . time() . ".zip";
        $zip->open($zipName, \ZipArchive::CREATE);
        foreach ($files as $f) {
            $zip->addFromString(basename($f), file_get_contents($f));
        }
        $zip->close();
        header('Content-Type', 'application/zip');
        header('Content-disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);
    }

    /**
     * Function to add the Evidence Self Assessment
     * return string
     */
    public function addEvidenceAssessmentAction(Request $request)
    {
        $form = $this->createForm(new AssessmentForm(), array());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
            echo $result = $this->get('EvidenceService')->saveEvidenceAssessment($data);
            exit;
        }
        exit;
    }

}
