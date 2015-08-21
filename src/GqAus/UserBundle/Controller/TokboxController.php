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
     */
    public function indexAction(Request $request)
    {
        if ($this->getRequest()->get('unitCode')) {
            $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
            $session = $openTok->createSession(array('mediaMode' => MediaMode::ROUTED));
            $sessionId = $session->getSessionId();
            $token = $openTok->generateToken($sessionId, array(
                'role' => Role::MODERATOR
            ));
            $userId = $request->getSession()->get('user_id');
            $applicantId = $this->getRequest()->get('applicantId');
            $room = $this->get('TokBox')->isRoomExists($userId, $applicantId);
            $roomId = $this->get('TokBox')->createRoom($sessionId, $userId, $applicantId);
            $encodedRoomId = base64_encode(base64_encode(base64_encode($roomId)));
            $this->get('UserService')->sendConversationMessage($this->getRequest()->get('courseCode'), $applicantId, $userId, $encodedRoomId);
            return $this->render('GqAusUserBundle:Tokbox:index.html.twig', array(
                    'apiKey' => $this->container->getParameter('tokbox_key'),
                    'sessionId' => $sessionId,
                    'token' => $token,
                    'roomId' => $encodedRoomId,
                    'unitCode' => $this->getRequest()->get('unitCode'),
                    'courseCode' => $this->getRequest()->get('courseCode'),
                    'applicantId' => $applicantId,
                    'userId' => $userId
            ));
        } else {
            return $this->redirect('dashboard');
        }
    }

    /**
     * Function for subscriber to connect to tokbox
     */
    public function subscriberAction($roomId, Request $request)
    {
        $roomId = base64_decode(base64_decode(base64_decode($roomId)));
        $room = $this->get('TokBox')->getRoom($roomId);
        $userId = $request->getSession()->get('user_id');
        if (base64_encode($room->getApplicant()) === base64_encode($userId)) {
            $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
            $token = $openTok->generateToken($room->getSession(), array(
                'role' => Role::MODERATOR
            ));
            return $this->render('GqAusUserBundle:Tokbox:subscriber.html.twig', array(
                    'apiKey' => $this->container->getParameter('tokbox_key'),
                    'sessionId' => $room->getSession(),
                    'token' => $token
            ));
        } else {
            return $this->redirect('dashboard');
        }
    }

    /**
     * Function to start archive the conversation
     */
    public function startAction($roomId)
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
        $roomId = base64_decode(base64_decode(base64_decode($roomId)));
        $sessionId = $this->get('TokBox')->updateRoom($roomId, 1);
        $archive = $openTok->startArchive($sessionId, 'PHP Archiving Sample App');
        $response = new Response( );
        $response->headers->set('Content-Type', 'application/json');
        echo $archive->toJson();
        exit;
    }

    /**
     * Function to stop the archiving conversation
     */
    public function stopAction($archiveId, $applicantId, $unitCode, $courseCode)
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
        $archive = $openTok->stopArchive($archiveId);
        $result = $this->get('EvidenceService')->saveRecord($archiveId, $applicantId, $unitCode, $courseCode);
        $response = new Response( );
        $response->headers->set('Content-Type', 'application/json');
        echo $archive->toJson();
        exit;
    }

    /**
     * Function to list all the archived conversations
     */
    public function historyAction()
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
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
                'showPrevious' => $page > 1 ? '/history?page=' . ($page - 1) : null,
                'showNext' => $archives->totalCount() > $offset + 5 ? '/history?page=' . ($page + 1) : null
        ));
    }

    /**
     * Function to download the archived conversation
     */
    public function downloadAction($aid)
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
        $archive = $openTok->getArchive($aid);
        if ($archive->url) {
            return $this->redirect($archive->url);
        } else {
            return $this->redirect('https://s3.amazonaws.com/rpl-upload.com/45145502/' . $aid);
        }
    }

}
