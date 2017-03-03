<?php
namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class EnrollmentController extends Controller
{

    /**
     * 
     * @return type
     */
    public function enrollmentAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userService = $this->get('UserService');
        
        if ($user->getApplicantStatus() == $userService::COMPLETE_ENROLMENT) {
                return $this->redirect('overview');
            }
       return $this->render('GqAusUserBundle:Enrollment:index.html.twig', array(
                // ...
        ));
    }
    /**
     * 
     * @param \GqAus\UserBundle\Controller\Request $request
     */
    public function saveEnrollAction(Request $request)
    {
        //$userId = 59;
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST')) {
            $params = array();
            $type = "";
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                $type = $params['type'];
            }
            switch($type){
               case 'profile':
                  $op = $this->get('UserService')->updateProEnroll($userId, $params);
                   break;
               case 'language':
                   $op = $this->get('UserService')->updateLangEnroll($userId, $params);
                   break;
               case 'schooling':
                   $op = $this->get('UserService')->updateSchEnroll($userId, $params);
                   break;
               case 'employment':
                   $op = $this->get('UserService')->updateEmpEnroll($userId, $params);
                   break;
               case 'upload':
                   $op = '';
                   break;
               default:
                   $op = 'No Action Selected';
            }
            
            return new JsonResponse(array( 'data' => $op ));
        }        
    }
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function saveUploadAction(Request $request){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $uploadId = '';
        if ($request->isMethod('POST')) {
            $params = array();
            $type = "";
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->updateUploadEnroll($userId, $params);
            $uploadId = $op->getId();
        }
        return new JsonResponse(array( 'uploadId' => $uploadId ));
    }
    /**
     * 
     * @param type $userId
     * return $array
     */
    public function getEnrollAction($userId){
        $enrollment = [];
        $enrollment['profile'] = $this->get('UserService')->getProEnroll($userId);
        $enrollment['language'] = $this->get('UserService')->getLangEnroll($userId);
        $enrollment['schooling'] = $this->get('UserService')->getSchEnroll($userId);
        $enrollment['employment'] = $this->get('UserService')->getEmpEnroll($userId);
        $enrollment['upload']['uploadId'] = $this->get('UserService')->getUploadFiles($userId);
        return new JsonResponse($enrollment);
    }
    
    /**
     * 
     * @param type $userId
     * return $array
     */
    public function getDisabilityAndQualificationAction(){
        $enrollment = [];
        $enrollment['disability'] = $this->get('UserService')->getDisabilityElements();
        $enrollment['qualification'] = $this->get('UserService')->getPreviousQualifications();
        $documentTypesArr= $this->get('UserService')->getDocumentTypes();
            $enrollment['documentTypes'] = [];
        foreach ($documentTypesArr as $key=>$documentTypes){
            $enrollment['documentTypes'][$key]['id'] = $documentTypes->getId();
            $enrollment['documentTypes'][$key]['type'] = $documentTypes->getType();
            $enrollment['documentTypes'][$key]['point'] = $documentTypes->getPoints();
            $enrollment['documentTypes'][$key]['pointDisplay'] = $documentTypes->getPoints() . ' Point Ids';
        }
        return new JsonResponse($enrollment);
    }
    
     /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function removeUserIdsAction(Request $request)
    {
         $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST') && $userId) {
            $params = array();
            $type = "";
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->removeIdFile($params['id']);
        }
        return new JsonResponse(array( 'data' => $op ));
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    
    public function setEnrollmentCompleteAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST') && $userId) {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->setEnrollmentComplete($userId);
        }
        return new JsonResponse(array( 'data' => $op ));
    }
    
    public function usiDownloadAction()
    {
        header("Content-Type: application/octet-stream");
        $file = $this->get('kernel')->getRootDir().'/../web/public/files/USI_Form.pdf';
        header("Content-Disposition: attachment; filename=" . urlencode('USI_Form.pdf'));   
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Description: File Transfer");            
        header("Content-Length: " . filesize($file));
        flush(); // this doesn't really matter.
        $fp = fopen($file, "r");
        while (!feof($fp))
        {
            echo fread($fp, 65536);
            flush(); // this is essential for large downloads
        } 
        fclose($fp); 
    }
}
