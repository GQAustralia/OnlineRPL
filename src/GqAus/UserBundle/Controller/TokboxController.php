<?php

namespace GqAus\UserBundle\Controller;

use OpenTok\MediaMode;
use OpenTok\OpenTok;
use OpenTok\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokboxController extends Controller
{
   /**
    * Function to create a video conversation
    * return $result array
    */
    public function indexAction(Request $request)
    {
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');
        $session = $openTok->createSession(array('mediaMode' => MediaMode::ROUTED));
        $sessionId = $session->getSessionId();
        $token = $openTok->generateToken($sessionId, array(
            'role' => Role::MODERATOR
        ));
        $tokBox = $this->get('TokBox');
        $roomId = $tokBox->createRoom($sessionId, 3);

        return $this->render('GqAusUserBundle:Tokbox:index.html.twig', array(
                    'apiKey' => 45145502,
                    'sessionId' => $sessionId,
                    'token' => $token,
                    'roomId' => base64_encode(base64_encode(base64_encode($roomId)))
        ));
    }
    
    
   /**
    * Function to connect tokbox
    * return $result array
    */
    public function subscriberAction($rid)
    {
        $roomId = base64_decode(base64_decode(base64_decode($rid)));
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');        
        $tokBox = $this->get('TokBox');
        $sessionId = $tokBox->updateRoom($roomId, 1);
//        $token = $openTok->generateToken($sessionId, array(
//            'data' => 'User2'
//        ));
        
        $token = $openTok->generateToken($sessionId, array(
            'role' => Role::MODERATOR
        ));
        return $this->render('GqAusUserBundle:Tokbox:subscriber.html.twig', array(
                    'apiKey' => 45145502,
                    'sessionId' => $sessionId,
                    'token' => $token
        ));
    }    
    
   /**
    * Function to start archive the conversation
    * return string
    */
    public function startAction($rid)
    { 
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');
        $roomId = base64_decode(base64_decode(base64_decode($rid)));$tokBox = $this->get('TokBox');
        $sessionId = $tokBox->updateRoom($roomId, 1);
        $archive = $openTok->startArchive($sessionId, "PHP Archiving Sample App");
        $response = new Response( );
        $response->headers->set('Content-Type', 'application/json');
        echo $archive->toJson(); exit;
    }  
    
   /**
    * Function to stop the archiving conversation
    * return string
    */
    public function stopAction($aid)
    {
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');
        $archive = $openTok->stopArchive($aid);
        $response = new Response( );
        $response->headers->set('Content-Type', 'application/json');
        echo $archive->toJson(); exit;
    }  
    
   /**
    * Function to list all the archived conversations
    * return string
    */
    public function historyAction()
    {
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');
//        $archive = $openTok->stopArchive($aid);
//        $response = new Response( );
//        $response->headers->set('Content-Type', 'application/json');
//        echo $archive->toJson(); exit;
        
        $page = intval($this->getRequest()->get('page'));
        if (empty($page)) {
            $page = 1;
        }

        $offset = ($page - 1) * 5;

        $archives = $openTok->listArchives($offset, 5);
        
        $toArray = function($archive) {
          return $archive->toArray();
        };
        return $this->render('GqAusUserBundle:Tokbox:history.html.twig', array(
            'archives' => array_map($toArray, $archives->getItems()),
            'showPrevious' => $page > 1 ? '/history?page='.($page-1) : null,
            'showNext' => $archives->totalCount() > $offset + 5 ? '/history?page='.($page+1) : null
        ));
    } 
    
   /**
    * Function to download the archived conversation
    * return string
    */
    public function downloadAction($aid)
    {
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');
        $archive = $openTok->getArchive($aid);
//        $filename = $archive->url;
//        $response = new Response();
//        $response->headers->set('Content-type', 'application/octect-stream');
//        $response->headers->set('Content-Length', filesize($filename));
//        $response->headers->set('Content-Transfer-Encoding', 'binary');
//        $response->setContent(readfile($filename));
//        return $response;
        return $this->redirect($archive->url);
    }  
}
