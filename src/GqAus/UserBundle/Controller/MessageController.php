<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ComposeMessageForm;
use \DateTime;

class MessageController extends Controller
{
    /**
    * Function to view all inbox messages
    * return response
    */
    public function viewAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getmyinboxMessages($userid, $page);
        $result['unreadcount'] = $unreadcount;
        return $this->render(
                'GqAusUserBundle:Message:view.html.twig',$result);
    }
    
    /**
    * Function to save the message
    * return response
    */
    public function composeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $messageService = $this->get('UserService');
        $messages = $messageService->getCurrentUser()->getInboxMessages();
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        $composeform = $this->createForm(new ComposeMessageForm(), array());
        /* Compose Action Start */
        if ($request->isMethod('POST')) {
            $composeform->handleRequest($request);
            if ($composeform->isValid()) {
                $composearr = $request->get('compose');
                $to = $composearr['to'];
                $subject = $composearr['subject'];
                $message = $composearr['message'];
                $user = $this->getDoctrine()
                        ->getRepository('GqAusUserBundle:User')
                        ->findOneBy(array('email' => $to));
                if ($user) {
                    $touser = $user->getId();
                    $curuser = $messageService->getCurrentUser();
                    $user = $messageService->getCurrentUser();
                    $sentuser = $messageService->getUserInfo($touser);
                    $msgdata = array("subject" => $subject,
                        "message" => $message);
                    $messageService->saveMessageData($sentuser, $curuser, $msgdata);
                    $request->getSession()->getFlashBag()->add(
                            'msgnotice', 'Message sent successfully!'
                    );
                    return $this->redirect('messages');
                } else {
                    $request->getSession()->getFlashBag()->add(
                            'errornotice', 'User not existed'
                    );
                }
            }
        }
        /* Compose Action End */
        return $this->render(
                    'GqAusUserBundle:Message:compose.html.twig',
                    array('composemsgForm' => $composeform->createView(),
                    'unreadcount' => $unreadcount)
        );
    }
    
    /**
    * Function to view all sent messages
    * return response
    */
    public function sentAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getmySentMessages($userid, $page);
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        $result['unreadcount'] = $unreadcount;
        return $this->render('GqAusUserBundle:Message:sent.html.twig', $result);
    }
    
    /**
    * Function to view all trashed messages
    * return response
    */
    public function trashAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getmyTrashMessages($userid, $page);
        $result['unreadcount'] = $unreadcount;
        return $this->render('GqAusUserBundle:Message:trash.html.twig', $result);
    }
    
    public function draftAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $messages = $messageService->getCurrentUser()->getInboxMessages();
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        return $this->render(
            'GqAusUserBundle:Message:draft.html.twig',array('unreadcount' => $unreadcount));
    }
    
    /**
    * Function to mark as read / unread
    */
    public function markAsReadAction(Request $request)
    {
        $readStatus = $request->get("readStatus");
        $checkedMessages = json_decode(stripslashes($request->get("checkedMessages")));
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        foreach($checkedMessages as $cm) {
            $messageService->markReadStatus($cm, $readStatus);
        }
        echo $messageService->getUnreadMessagesCount($userid)."&&success"; exit;
    }
    
    /**
    * Function to trash messages.
    */
    public function deleteFromUserAction(Request $request)
    {
        $type = $request->get("type");
        $checkedMessages = json_decode(stripslashes($request->get("checkedMessages")));
        $messageService = $this->get('UserService');
        foreach($checkedMessages as $cm) {
            $messageService->setUserDeleteStatus($cm, 1, $type);
        }
        echo "success"; exit;
    }
  
    /**
    * Function to delete messages from tash
    */
    public function deleteFromTrashAction(Request $request)
    {
        $checkedMessages = json_decode(stripslashes($request->get("checkedMessages")));
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        foreach($checkedMessages as $cm) {
            $messageService->setToUserDeleteFromTrash($userid, $cm, 2);
        }
        echo "success"; exit;
    }
}
