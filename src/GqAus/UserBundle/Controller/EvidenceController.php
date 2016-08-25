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
     * @param object $request
     * return string
     */
    public function addAction(Request $request)
    {

        error_reporting(0);
        $form = $this->createForm(new EvidenceForm(), array());
        if ($request->isMethod('POST')) {
            //$fileNames = $this->get('gq_aus_user.file_uploader')->process($data['file']);
            echo $this->get('EvidenceService')->saveS3ToEvidence($request->request);
            exit;
        }
    }

    /**
     * Function to display all the Evidences
     * @param integer $request
     * return string
     */
    public function viewAction(Request $request)
    {
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $user = $this->get('security.context')->getToken()->getUser();

        $evidences = array();
        $evidences = $this->get('UserService')->getPendingApplicantEvidences($user);

        $formattedEvidences = $evidenceTypeCount = $mappedEvidence = $unMappedEvidences = $mappedToMultipleUnit = $mappedToOneUnit = $mappingCount = array();
        foreach($evidences as $key => $evidence){
            $evdPath = (method_exists($evidence,'getName')) ?  $evidence->getPath() : $evidence->getContent();
            $evidenceTypeCount[$evidence->getType()][] = $evdPath;
            if($evidence->getUnit())
                $mappedEvidence[$evdPath][] = $evidence->getUnit();
            else
                $unMappedEvidences[$evdPath][] = $evidence->getId();
            
            $formattedEvidences[$evdPath][] = $evidence;
        }

        foreach($mappedEvidence as $mKey => $mappedEvd){
            if(count($mappedEvd) > 1)
                $mappedToMultipleUnit[] = $mKey;
            else if(count($mappedEvd) == 1)
                $mappedToOneUnit[] = $mKey;
        }
        
        $evdMapping['unMappedEvidences'] = $unMappedEvidences;
        $evdMapping['mappedToOneUnit'] = $mappedToOneUnit;
        $evdMapping['mappedToMultipleUnit'] = $mappedToMultipleUnit;
        $evdMapping['typeCount'] = $evidenceTypeCount;

        return $this->render('GqAusUserBundle:Evidence:view.html.twig', array('evidences' => $formattedEvidences, 'evdMapping' => $evdMapping));
    }

    /**
     * Function to save the existing Evidence
     * @param integer $request
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
     * @param string $request
     * return string
     */
    public function editTitleAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $title = $request->get('title');
            $id = $request->get('id');
            $this->get('EvidenceService')->updateEvidence($id, $title);
            echo "success";
        }
        exit;
    }

    /**
     * Function to zip
     * @param object $request
     */
    public function zipAction(Request $request)
    {
        $files = array();
        $evidences = $this->get('EvidenceService')->currentUser->getEvidences();
        foreach ($evidences as $evidence) {
            array_push($files, $this->container->getParameter('amazon_s3_base_url') . $evidence->getPath());
        }
        $zip = new \ZipArchive();
        $zipName = 'Documents-' . time() . '.zip';
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
     * @param object $request
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

    /**
     * Function to update s3 jobid once its completed
     * @param object $request
     * return string
     */
    public function updateSthreeJobIdAction($jobId, Request $request)
    {
        $result = $this->get('EvidenceService')->updateSthreeJobId($jobId);
        echo json_encode($result);
        exit;
    }
}