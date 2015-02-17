<?php

namespace GqAus\UserBundle\Controller;

use OpenTok\MediaMode;
use OpenTok\OpenTok;
use OpenTok\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TokboxController extends Controller
{
   /**
    * Function to connect tokbox
    * return $result array
    */
    public function indexAction(Request $request)
    {
        $openTok = new OpenTok(45145502, '5aaa4525592d0b4ed9685f67f6d8ed438a8a5812');
        $session = $openTok->createSession(array( 'mediaMode' => MediaMode::ROUTED ));
        $sessionId = $session->getSessionId();
        $token = $session->generateToken(array(
            'role'       => Role::PUBLISHER,
            'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
            'data'       => 'name=Prashu'
        ));
        
        $sessionPHP = $request->getSession();
        $sessionPHP->set('tok_session_id', $sessionId);
        $sessionPHP->set('tok_token_id', $sessionId);
        
        return $this->render('GqAusUserBundle:Tokbox:index.html.twig', array(
                    'apiKey' => 45145502,
                    'sessionId' => $sessionId,
                    'token' => $token
        ));
    }
    
    
   /**
    * Function to connect tokbox
    * return $result array
    */
    public function subscriberAction(Request $request)
    {
        $sessionPHP = $request->getSession();
        $sessionId = $sessionPHP->get('tok_session_id');
        $token = $sessionPHP->get('tok_token_id');
        return $this->render('GqAusUserBundle:Tokbox:subscriber.html.twig', array(
                    'apiKey' => 45145502,
                    'sessionId' => $sessionId,
                    'token' => $token
        ));
    }
}
