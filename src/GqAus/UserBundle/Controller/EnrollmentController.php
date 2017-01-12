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
    public function saveProEnrollAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        if ($request->isMethod('POST')) {
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }
            $op = $this->get('UserService')->updateProEnroll($userId, $params);
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
    public function getProEnrollAction($userId){
        $response = $this->get('UserService')->getProEnroll($userId);
        echo json_encode($response);
        exit;
    }
    /**
     * 
     * @param type $userId
     * return jsonarray
     */
    public function getLangEnrollAction($userId){
        $response = $this->get('UserService')->getLangEnroll($userId);
        echo json_encode($response);
        exit;
    }
    /**
     * @param type $userId
     * return jsonarray* 
     */
    public function getSchEnrollAction($userId){
        $response = $this->get('UserService')->getSchEnroll($userId);
        echo json_encode($response);
        exit;
    }
    /**
     * @param type $userId
     * return jsonarray 
     */
    public function getEmpEnrollAction($userId){
        $response = $this->get('UserService')->getEmpEnroll($userId);
        echo json_encode($response);
        exit;
    }
}
