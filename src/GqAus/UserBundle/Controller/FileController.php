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
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $user = $this->get('security.context')->getToken()->getUser();
        $userCourses = $user->getCourses();
        $evidences = $this->get('EvidenceService')->currentUser->getEvidences();       
        $formattedEvidences = $evidenceTypeCount = $mappedEvidence = $unMappedEvidences = $mappedToMultipleUnit = $mappedToOneUnit = $mappingCount = array();
        if(!empty($evidences)){
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
            
        $form = $this->createForm(new FileForm(), array());
        $fileForm = $form->createView();

        }
        return $this->render('GqAusUserBundle:File:view.html.twig', array('evidences' => $formattedEvidences, 'evdMapping' => $evdMapping, 'courses' => $userCourses, 'form' => $fileForm));
    }
}

