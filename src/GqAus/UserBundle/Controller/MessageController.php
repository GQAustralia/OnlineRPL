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
        $now = new DateTime('now');
        $result['today'] = $now->format('Y-m-d');
        return $this->render(
                        'GqAusUserBundle:Message:view.html.twig', $result);
    }

    /**
     * Function to save the message
     * return response
     */
    public function composeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userService = $this->get('UserService');
        $curuser = $userService->getCurrentUser();
        $unreadcount = $userService->getUnreadMessagesCount($curuser->getId());
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
                    $sentuser = $userService->getUserInfo($touser);
                    $msgdata = array("subject" => $subject,
                        "message" => $message);
                    $userService->saveMessageData($sentuser, $curuser, $msgdata);
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
        $newMsg = "true";
        $repMessage = $repSub = $repuser = '';
        $coursename = $request->get("course-name");
        $coursecode = $request->get("course-code");
        if ($coursename != "" && $coursecode != "") {
            $userid = $request->get("userid");
            $unitname = $request->get("unit-name");
            $unitcode = $request->get("unit-code");
            $evidenceUser = $userService->getUserInfo($userid);
            $repuser = $evidenceUser->getEmail();
            $repSub =  $coursecode . " ". $coursename;
            $repMessage = "Course details : " . $coursecode . " ". $coursename . "\n";
            if ($unitname != "" && $unitcode != "") {
                $repMessage .= "Unit details : " . $unitcode . " " . $unitname;
                $repSub .=  " - " . $unitcode . " " . $unitname;
            }
            $newMsg = "false";
        }
        $replyId = $this->getRequest()->get('reply_id');
        if ($replyId) {
            $message = $userService->getMessage($replyId);
            $repMessage = "\n\n\n\n";
            $newDateCreated = date("d/m/Y", strtotime($message->getCreated()));
            $repMessage .= "Received on :" . $newDateCreated . ", sent from :" . $message->getSent()->getUserName() . "\n";
            $repMessage .= "Subject :" . $message->getSubject() . "\n";
            $repMessage .= "Message :\n" . $message->getmessage();
            $repSub = "Re: " . $message->getSubject();
            $repuser = $message->getSent()->getEmail();
            $newMsg = "false";
        }
        /* Compose Action End */
        return $this->render(
                        'GqAusUserBundle:Message:compose.html.twig', array(
                    'composemsgForm' => $composeform->createView(),
                    'unreadcount' => $unreadcount,
                    'repMessage' => $repMessage,
                    'sub' => $repSub,
                    'user' => $repuser,
                    'newMsg' => $newMsg
                        )
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
        $now = new DateTime('now');
        $result['today'] = $now->format('Y-m-d');
        return $this->render('GqAusUserBundle:Message:sent.html.twig', $result);
    }

    /**
     * Function to view all trashed messages
     * return response
     */
    public function trashAction(Request $request) {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getmyTrashMessages($userid, $page);
        $result['unreadcount'] = $unreadcount;
        $result['userid'] = $userid;
        $now = new DateTime('now');
        $result['today'] = $now->format('Y-m-d');
        return $this->render('GqAusUserBundle:Message:trash.html.twig', $result);
    }

    public function draftAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $messages = $messageService->getCurrentUser()->getInboxMessages();
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        return $this->render(
                        'GqAusUserBundle:Message:draft.html.twig', array('unreadcount' => $unreadcount));
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
        foreach ($checkedMessages as $cm) {
            $messageService->markReadStatus($cm, $readStatus);
        }
        echo $messageService->getUnreadMessagesCount($userid) . "&&success";
        exit;
    }

    /**
     * Function to trash messages.
     */
    public function deleteFromUserAction(Request $request)
    {
        $type = $request->get("type");
        $checkedMessages = json_decode(stripslashes($request->get("checkedMessages")));
        $messageService = $this->get('UserService');
        foreach ($checkedMessages as $cm) {
            $messageService->setUserDeleteStatus($cm, 1, $type);
        }
        echo "success";
        exit;
    }

    /**
     * Function to view message
     */
    public function viewMessageAction($mid)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        $messageService->setReadViewStatus($mid);
        $message = $messageService->getMessage($mid);
        $msgUser = $message->getSent()->getId(); // from user
        $touser = $message->getInbox()->getId(); // to user
        $toStatus = $message->getToStatus();
        $fromStatus = $message->getFromStatus();
        $msgDetails = array(
                        'fromUser'  => $msgUser,
                        'toUser'    => $touser,
                        'toStatus'  => $toStatus,
                        'fromStatus'=> $fromStatus,
                        'curUser'   => $userid
                        );
        if ($userid == $msgUser) {
            $userName= $message->getInbox()->getUserName(); 
            $from = " from me";
            if ($userid == $message->getInbox()->getId()) {
               $from = " to me"; 
            }
        } else {
            $userName = $message->getSent()->getUserName(); 
            $from = " to me";
            
        }
        $content = nl2br($message->getMessage());
        return $this->render(
                'GqAusUserBundle:Message:message.html.twig',
                array(
                    'unreadcount' => $unreadcount,
                    "message" => $message,
                    'content' => $content,
                    'userName' => $userName,
                    'from' => $from,
                    'msgDetails' => $msgDetails 
                )
        );
    }

    /**
     * Function to delete messages from tash
     */
    public function deleteFromTrashAction(Request $request)
    {
        $checkedMessages = json_decode(stripslashes($request->get("checkedMessages")));
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        foreach ($checkedMessages as $cm) {
            $messageService->setToUserDeleteFromTrash($userid, $cm, 2);
        }
        echo "success";
        exit;
    }

    /**
     * Function to unread count
     * return response
     */
    public function unreadAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        echo $unreadcount;
        exit;
    }   
    

}
