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
     * @param object $request
     * return string
     */
    public function indexAction(Request $request)
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), $this->container->getParameter('tokbox_secret_key'));
        $session = $openTok->createSession(array('mediaMode' => MediaMode::ROUTED));
        $sessionId = $session->getSessionId();
        $token = $openTok->generateToken($sessionId, array('role' => Role::MODERATOR));
        $courseCode = $this->getRequest()->get('courseCode');
        $applicantId = $this->getRequest()->get('applicantId');;
        $userId = $request->getSession()->get('user_id');
        $room = $this->get('TokBox')->isRoomExists($userId, $applicantId);
        $roomId = $this->get('TokBox')->createRoom($sessionId, $userId, $applicantId);
        $encodedRoomId = base64_encode(base64_encode(base64_encode($roomId)));
        $this->get('UserService')->sendConversationMessage($courseCode, $applicantId, $userId, $encodedRoomId);
        return $this->render('GqAusUserBundle:Tokbox:index.html.twig', array(
                'apiKey' => $this->container->getParameter('tokbox_key'), 'sessionId' => $sessionId, 'token' => $token, 'roomId' => $encodedRoomId, 'courseCode' => $courseCode, 'applicantId' => $applicantId, 'userId' => $userId
        ));
       
    }

    /**
     * Function for subscriber to connect to tokbox
     * @param int $roomId
     * @param object $request
     * return string
     */
    public function subscriberAction($roomId, Request $request)
    {
        $roomId = base64_decode(base64_decode(base64_decode($roomId)));
        $room = $this->get('TokBox')->getRoom($roomId);
        $userId = $request->getSession()->get('user_id');
        if (base64_encode($room->getApplicant()) === base64_encode($userId)) {
            $openTok = new OpenTok($this->container->getParameter('tokbox_key'), 
                $this->container->getParameter('tokbox_secret_key'));
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
     * @param int $roomId
     * return string
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
     * @param int $archiveId
     * @param int $applicantId
     * @param string $unitCode
     * @param string $courseCode
     * return string
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
     * return string
     */
    public function historyAction()
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), 
            $this->container->getParameter('tokbox_secret_key'));
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
     * @param string $aid
     * return string
     */
    public function downloadAction($aid)
    {
        $openTok = new OpenTok($this->container->getParameter('tokbox_key'), 
            $this->container->getParameter('tokbox_secret_key'));
        $archive = $openTok->getArchive($aid);
        if ($archive->url) {
            return $this->redirect($archive->url);
        } else {
            return $this->redirect('https://s3.amazonaws.com/rpl-upload.com/45145502/' . $aid);
        }
    }

}
