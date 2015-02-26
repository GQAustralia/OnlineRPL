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
}
