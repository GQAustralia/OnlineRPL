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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveLangEnrollAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        //$userId = 52;
        if ($request->isMethod('POST')) {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->updateLangEnroll($userId, $params);
            return new JsonResponse(array( 'data' => $op ));
        } 
    }
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveSchEnrollAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST')) {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->updateSchEnroll($userId, $params);
            return new JsonResponse(array( 'data' => $op ));
        } 
    }
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveEmpEnrollAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST')) {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->updateEmpEnroll($userId, $params);
            return new JsonResponse(array( 'data' => $op ));
        } 
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
        return new JsonResponse($enrollment);
    }
}
