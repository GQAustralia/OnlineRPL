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
        $messages = $messageService->getmyinboxMessages($userid);
        return $this->render(
                'GqAusUserBundle:Message:view.html.twig',
                array('messages'  => $messages,'unreadcount' => $unreadcount)
        );
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
        $messages = $messageService->getmySentMessages($userid);
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        return $this->render(
            'GqAusUserBundle:Message:sent.html.twig',array('messages'  => $messages,'unreadcount' => $unreadcount));
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
        $messages = $messageService->getmyTrashMessages($userid);
        return $this->render(
            'GqAusUserBundle:Message:trash.html.twig', array('messages'  => $messages,'unreadcount' => $unreadcount)
        );
    }
    
}
