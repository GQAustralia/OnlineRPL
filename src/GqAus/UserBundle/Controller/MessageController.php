<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ComposeMessageForm;
use Symfony\Component\HttpFoundation\Response;
use \DateTime;

class MessageController extends Controller
{
    /**
     * Function to view all inbox messages
     * @param object $request
     * return string
     */
    public function viewAction(Request $request, $mid=null)
    {
        
        $messageService = $this->get('UserService');
        $loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
        $userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
        $userid = $messageService->getCurrentUser()->getId();        
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getMyInboxMessages($userid, $page);      
        $result['unreadcount'] = $messageService->getUnreadMessagesCount($userid);       
        $now = new DateTime('now');
        $result['today'] = $now->format('Y-m-d');
        // removing caching
        $response = new Response( );
        $response->headers->set("Cache-Control", "no-store");
        $response->headers->set("Pragma", "no-cache");
        $response->headers->set("Expires", "-1");
        $response->send();
        $newmid = $mid;
        $result['curuser'] = $userid;
        /*View Message Code -- msgcode*/
        if(isset($mid) && $mid!="")
        {
            $messageService = $this->get('UserService');
            $unreadcount = $messageService->getUnreadMessagesCount($userid);
            // getting the last route to check whether it is coming from inbox or sent ot tash
            //look for the referer route
            //For reply mails thread
            $replyId = $this->getRequest()->get('reply_id');
            if($mid != 'compose' && $mid != 'usernamesbyRoles'){
                
                $checkStatus = $messageService->getMessagesAccessPage($loggedinUserId, $mid);
                if($checkStatus == 0)
                    return $this->render('GqAusUserBundle:Default:error.html.twig');
            }
            if(($mid !="compose" && $mid !="usernamesbyRoles")  ||  $replyId != "") {
               if($replyId != "") {
                    $newmid = $mid;
                    $mid = $replyId;
                }
                $messageService->setReadViewStatus($mid);
                $referer = $this->getRequest()->headers->get('referer');
                $path = $this->container->getParameter('applicationUrl');
                $lastPath = str_replace($path, '', $referer); 
                if ($lastPath != '') {                    
                    $lastPath = explode('/', $lastPath);
                    // updating the readstatus if it is from inbox
                    if ($lastPath[0] == 'messages') {
                        $messageService->setReadViewStatus($mid);
                    }
                }
                $messages = $messageService->getReplyMessages($mid); 
                $replymsgarr = array();
                $i = 0;
                foreach($messages as $message) {
                    $msgUser = $message->getSent()->getId(); // from user
                    $touser = $message->getInbox()->getId(); // to user
                    $toStatus = $message->getToStatus();
                    $fromStatus = $message->getFromStatus(); 
                    $created = $message->getCreated(); 
                    if ($userid == $msgUser) {
                        $userName = $message->getInbox()->getUserName();
                        $from = ' from me';
                        if ($userid == $message->getInbox()->getId()) {
                            $from = ' to me';
                        }
                    } else {
                        $userName = $message->getSent()->getUserName();
                        $from = ' to me';
                    }
                    $content = nl2br($message->getMessage());
                    $fromUser = $messageService->getRequestUser($msgUser); 
                    $toUser = $messageService->getRequestUser($touser);
                    $replymsgarr[$i]['userImage'] = $fromUser->getUserImage();
                    $replymsgarr[$i]['fromUserImage'] = $fromUser->getUserImage();
                    $replymsgarr[$i]['toUserImage'] = $toUser->getUserImage();
                    $replymsgarr[$i]['toUserId'] = $toUser->getId();
                    $replymsgarr[$i]['fromUserId'] = $fromUser->getId();
                    $replymsgarr[$i]['fromUserName'] = $fromUser->getUserName();               
                    if($replymsgarr[$i]['fromUserImage'] == "" || $replymsgarr[$i]['toUserImage'] == "")
                    {
                        $replymsgarr[$i]['fromUserImage'] = "no-image.png";
                        $replymsgarr[$i]['toUserImage'] = "no-image.png";
                    }
                    $replymsgarr[$i]['unreadcount'] = $unreadcount;
                    $replymsgarr[$i]['message'] = $message;
                    $replymsgarr[$i]['content'] = $content;
                    $replymsgarr[$i]['userName'] = $userName;
                    $replymsgarr[$i]['from'] = $from;
                    $replymsgarr[$i]['created'] = $created;                    
                    $i++;
                }
                $result['toUserVal']=$toUser->getId();
                $result['msgID'] = $mid;
                $result['replymsgarr'] = $replymsgarr;                
                if($replyId == "")
                    return $this->render('GqAusUserBundle:Message:view.html.twig', $result);
            }
            //to new message
            if($newmid == "compose") {
                   
                $replyId = $this->getRequest()->get('reply_id');
                //if replyid is there 
                if ($replyId) {

                    $message = $messageService->getMessage($replyId);
                    $newDateCreated = date('d/m/Y', strtotime($message->getCreated()));
                    $repSub = "Re: " . $message->getSubject();
                    if ($messageService->getCurrentUser()->getId() != $message->getSent()->getId()) {
                        $repuser = $message->getSent()->getEmail();
                        $repUserName = $message->getSent()->getUsername();
                    } else {
                        $repuser = $message->getInbox()->getEmail();
                        $repUserName = $message->getInbox()->getUsername();
                    }
                    $unitId = '';
                    if ($message->getUnitID() != '' || $message->getUnitID() > 0) {
                        $unitId = $message->getUnitID();
                    }
                    $fromUser = $messageService->getRequestUser($message->getSent()->getId());  
                    $toUser = $messageService->getRequestUser($message->getInbox()->getId()); 
                    $result['userImage'] = $fromUser->getUserImage();
                    $result['toUserImage'] = $toUser->getUserImage();
                    $result['created'] = $message->getCreated();
                    $result['msgType'] = 'reply';
                    $result['user'] = $repuser;
                    $result['userName'] = $repUserName;
                    $result['unitId'] = $unitId;
                    $result['sub'] = $repSub;
                    $result['replymid'] = $replyId;                   
                }
                else {
                    //For new amessages
                    $result['replymid'] = "";
                    $result['msgType'] = "new";
                }                
                $composeform = $this->createForm(new ComposeMessageForm(), array());
                $result['composemsgForm'] = $composeform->createView(); 
                $composeformMobile = $this->createForm(new ComposeMessageForm(), array());
                $result['composeformMobile'] = $composeformMobile->createView(); 
                
                return $this->render('GqAusUserBundle:Message:view.html.twig', $result);
            }
            //to show Role against users suggest box
            if($newmid == "usernamesbyRoles") {
                $messageService = $this->get('UserService');
                $userrole = $messageService->getCurrentUser()->getRoles();
                $msgUserId = $messageService->getCurrentUser()->getId();
                $term = strtolower($_GET["term"]);
                $results = array();
                $rows = $messageService->getUsernamesbyRoles(array('keyword' => $term),$userrole[0],$msgUserId);               
                $json_array = array();                
                if (is_array($rows))
                {
                    foreach ($rows as $row)
                    {
                        array_push($json_array, $row[1]);
                    }
                }               
                echo json_encode($json_array);
                exit;
            }
        }
        else
        {
            $result['msgType'] = "";
            return $this->render('GqAusUserBundle:Message:view.html.twig', $result);
        }
        /*View Message*/
        
    }

    /**
     * Function to save the message
     * @param object $request
     * return string
     */
    public function composeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userService = $this->get('UserService');
        $curuser = $userService->getCurrentUser();
        $unreadcount = $userService->getUnreadMessagesCount($curuser->getId());
        $composeform = $this->createForm(new ComposeMessageForm(), array());
        $newMsg = 'true';
        $repMessage = $repSub = $repuser = $repUserName = '';
        $coursename = $request->get('course-name');
        $coursecode = $request->get('course-code');
        if ($coursename != '' && $coursecode != '') {
            $userid = $request->get('userid');
            $unitname = $request->get('unit-name');
            $unitcode = $request->get('unit-code');
            $unitId = $request->get('unit-id');
            $evidenceUser = $userService->getUserInfo($userid);
            $repuser = $evidenceUser->getEmail();
            $repUserName = $evidenceUser->getUsername();
            if ($request->get('message_to_user')) {
                $courseDetails = $this->get('CoursesService')->getCourseDetails($coursecode, $userid);
                $toRoleUser = ($courseDetails->getFacilitator()->getID() === $curuser->getId()) ?
                    $courseDetails->getAssessor() : $courseDetails->getFacilitator();
                $evidenceUser = $userService->getUserInfo($toRoleUser);
                $repuser = $evidenceUser->getEmail();
                $repUserName = $evidenceUser->getUsername();
            }
            $repSub = $coursecode . ' ' . $coursename;
            $repMessage = 'Course details : ' . $coursecode . ' ' . $coursename . "\n";
            if ($unitname != '' && $unitcode != '') {
                $repMessage .= 'Unit details : ' . $unitcode . ' ' . $unitname;
                $repSub .= ' - ' . $unitcode . ' ' . $unitname;
            }
            $newMsg = 'false';
        }
        $replyId = $this->getRequest()->get('reply_id');
        if ($replyId) {
            $message = $userService->getMessage($replyId);
            $repMessage = "\n\n\n\n";
            $newDateCreated = date('d/m/Y', strtotime($message->getCreated()));
            $repMessage .= "Received on :" . $newDateCreated . ", sent from :" . $message->getSent()->getUserName() . "\n";
            $repMessage .= "Subject :" . $message->getSubject() . "\n";
            $repMessage .= "Message :\n" . $message->getmessage();
            $repSub = "Re: " . $message->getSubject();
            if ($curuser->getId() != $message->getSent()->getId()) {
                $repuser = $message->getSent()->getEmail();
                $repUserName = $message->getSent()->getUsername();
            } else {
                $repuser = $message->getInbox()->getEmail();
                $repUserName = $message->getInbox()->getUsername();
            }
            $unitId = '';
            if ($message->getUnitID() != '' || $message->getUnitID() > 0) {
                $unitId = $message->getUnitID();
            }
            $newMsg = 'false';
        }
        /* Compose Action End */
        return $this->render('GqAusUserBundle:Message:compose.html.twig', array(
                'composemsgForm' => $composeform->createView(),
                'unreadcount' => $unreadcount,
                'repMessage' => strip_tags($repMessage),
                'sub' => $repSub,
                'user' => $repuser,
                'userName' => $repUserName,
                'newMsg' => $newMsg,
                'unitId' => $unitId)
        );
    }

    /**
     * Function to save composed message
     * @param object $request
     * return string
     */
    public function saveMessageAction(Request $request)
    {         
        if ($request->isMethod('POST')) {            
            $userService = $this->get('UserService');
            $curuser = $userService->getCurrentUser();
            $composeform = $this->createForm(new ComposeMessageForm(), array());
            $composeform->handleRequest($request);
            $replymid = $this->getRequest()->get('replymid');
            if ($composeform->isValid()) {
                $composearr = $request->get('compose'); 
                if($composearr['to'] == "")
                   $to = $composearr['toUserName'];
                else
                   $to = $composearr['to'];
                $subject = $composearr['subject'];
                $message = $composearr['message'];
                $unitId = '';
                if (isset($composearr['unitId'])) {
                    $unitId = $composearr['unitId'];
                }
                if(isset($replymid) && $replymid != "" && $replymid != 0)
                {
                    $user = $this->getDoctrine()
                        ->getRepository('GqAusUserBundle:User')
                        ->findOneBy(array('email' => $to));                                 
                    if ($user) 
                        $touser = $user->getId();
                }
                else {
                    $nameCondition="";
                    $query = $this->getDoctrine()->getRepository('GqAusUserBundle:User')
                            ->createQueryBuilder('u')
                            ->select('u');
                    $searchIn = $query->expr()->concat('u.firstName', $query->expr()->concat($query->expr()->literal(' '), 'u.lastName'));
                    $nameCondition .= $searchIn."='".$to."'" ;
                    $query->Where($nameCondition);
                    $user = $query->getQuery()->getResult(); 
                    if ($user) 
                        $touser = $user[0]->getId();
                }
                //echo "<pre>"; dump($user); exit;
                if ($user) {
                    $msgRespose = $userService->checkMessage($touser,$curuser->getId());
                    if($msgRespose == 1)
                    {
                        $sentuser = $userService->getUserInfo($touser);
                        if(isset($replymid) && $replymid != "" && $replymid != 0)
                        {
                            $getReplyId = $this->getDoctrine()
                                        ->getRepository('GqAusUserBundle:Message')
                                        ->findOneBy(array('id' => $replymid));
                            $newreplymid = $getReplyId->getreplymid();
                            if($newreplymid == 0)
                                $replymid = $replymid;
                            else
                                $replymid = $newreplymid;
                        }

                        $msgdata = array('subject' => $subject,
                            'message' => $message, 'unitId' => $unitId, 'replymid' => $replymid);

                        // for sending external mail
                        $mailSubject = str_replace('#messageSubject#', $subject,
                            $this->container->getParameter('mail_notification_sub'));

                        // finding and replacing the variables from message templates
                        $search = array('#toUserName#', '#applicationUrl#', '#fromUserName#');
                        $replace = array($sentuser->getUsername(),
                            $this->container->getParameter('applicationUrl'), $curuser->getUsername());
                        $mailBody = str_replace($search, $replace, $this->container->getParameter('mail_notification_con'));
                        // dump($sentuser->getEmail(),$mailSubject,$mailBody,$sentuser->getRole());exit;
                        /* send external mail parameters toEmail, subject, body, fromEmail, fromUserName */
                        if($sentuser->getRole() == '5')
                        {
                            $userService->sendExternalEmail($sentuser->getEmail(), $mailSubject,
                            $mailBody, $curuser->getEmail(), $curuser->getUsername());
                        }

                        $userService->saveMessageData($sentuser, $curuser, $msgdata);

                        $request->getSession()->getFlashBag()->add(
                            'msgnotice', $this->container->getParameter('message_succ')
                        );
                    }
                    else
                    {
                        $request->getSession()->getFlashBag()->add(
                            'errornotice', $this->container->getParameter('user_authorize')
                        );
                    }
                }
                else {

                        $request->getSession()->getFlashBag()->add(
                            'errornotice', $this->container->getParameter('no_user_found')
                        );
                }
            }
            return $this->redirect('messages');
        }
    }

    /**
     * Function to view all sent messages
     * @param object $request
     * return string
     */
    public function sentAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getMySentMessages($userid, $page);
        $result['unreadcount'] = $messageService->getUnreadMessagesCount($userid);
        $now = new DateTime('now');
        $result['today'] = $now->format('Y-m-d');
        return $this->render('GqAusUserBundle:Message:sent.html.twig', $result);
    }

    /**
     * Function to view all trashed messages
     * @param object $request
     * return string
     */
    public function trashAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $page = $this->get('request')->query->get('page', 1);
        $result = $messageService->getMyTrashMessages($userid, $page);
        $result['unreadcount'] = $messageService->getUnreadMessagesCount($userid);
        $result['userid'] = $userid;
        $now = new DateTime('now');
        $result['today'] = $now->format('Y-m-d');
        return $this->render('GqAusUserBundle:Message:trash.html.twig', $result);
    }

    /**
     * Function to draft message
     * @param object $request
     * return string
     */
    public function draftAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $messages = $messageService->getCurrentUser()->getInboxMessages();
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        return $this->render('GqAusUserBundle:Message:draft.html.twig', array('unreadcount' => $unreadcount));
    }

    /**
     * Function to mark as read / unread
     * @param object $request
     * return int
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
     * @param object $request
     * return string
     */
    public function deleteFromUserAction(Request $request)
    {
        $type = $request->get('type');
        $checkedMessages = json_decode(stripslashes($request->get('checkedMessages')));
        $messageService = $this->get('UserService');
        foreach ($checkedMessages as $cm) {
            $messageService->setUserDeleteStatus($cm, 1, $type);
        }
        echo 'success';
        exit;
    }

    /**
     * Function to view message
     * @param int $mid
     * return string
     */
    public function viewMessageAction($mid)
    { 
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);      
        // getting the last route to check whether it is coming from inbox or sent ot tash
        //look for the referer route
        $referer = $this->getRequest()->headers->get('referer');
        $path = $this->container->getParameter('applicationUrl');
        $lastPath = str_replace($path, '', $referer);
        if ($lastPath != '') {
            $lastPath = explode('?', $lastPath);
            // updating the readstatus if it is from inbox
            if ($lastPath[0] == 'messages') {
                $messageService->setReadViewStatus($mid);
            }
        }
        $message = $messageService->getMessage($mid);
        $msgUser = $message->getSent()->getId(); // from user
        $touser = $message->getInbox()->getId(); // to user
        $toStatus = $message->getToStatus();
        $fromStatus = $message->getFromStatus();
        $msgDetails = array(
            'fromUser' => $msgUser,
            'toUser' => $touser,
            'toStatus' => $toStatus,
            'fromStatus' => $fromStatus,
            'curUser' => $userid,
            'replymid' => $replymid
        );
        if ($userid == $msgUser) {
            $userName = $message->getInbox()->getUserName();
            $from = ' from me';
            if ($userid == $message->getInbox()->getId()) {
                $from = ' to me';
            }
        } else {
            $userName = $message->getSent()->getUserName();
            $from = ' to me';
        }
        $content = nl2br($message->getMessage());
        return $this->render(
                'GqAusUserBundle:Message:message.html.twig', array(
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
     * @param object $request
     * return string
     */
    public function deleteFromTrashAction(Request $request)
    {
        $checkedMessages = json_decode(stripslashes($request->get('checkedMessages')));
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        foreach ($checkedMessages as $cm) {
            $messageService->setToUserDeleteFromTrash($userid, $cm, 2);
        }
        echo 'success';
        exit;
    }

    /**
     * Function to unread count
     * @param object $request
     * return int
     */
    public function unreadAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        echo $unreadcount;
        exit;
    }

    /**
     * Function to view applicant and facilitator messages to assessor
     * @param object $request
     * return string
     */
    public function facilitatorApplicantAction(Request $request)
    {
        $unitId = $this->getRequest()->get('unitId');
        $userId = $this->getRequest()->get('userId');
        $courseCode = $this->getRequest()->get('courseCode');
        if (!empty($unitId) && !empty($userId) && !empty($courseCode)) {
            $courseData = $this->get('CoursesService')->getCourseDetails($courseCode, $userId);
            $applicantId = $courseData->getUser()->getId();
            $facilitatorId = $courseData->getFacilitator()->getId();
            $results['messages'] = $this->get('UserService')
                ->getFacilitatorApplicantMessages($unitId, $applicantId, $facilitatorId);
            echo $this->renderView('GqAusUserBundle:Message:facilitatorApplicant.html.twig', $results);
        } else {
            echo 'Empty Unit Id';
        }
        exit;
    }
    /** Function to give reply messages
     * @param object $request
     * return int*/
   public function replyMessagesAction(Request $request)
    {
        $messageService = $this->get('UserService');
        $userid = $messageService->getCurrentUser()->getId();
        $unreadcount = $messageService->getUnreadMessagesCount($userid);
        echo $unreadcount;
        exit;
    }
    /**
     * Function to get the users
	 * @param object $request
     * 
     */
    public function usersFromCourseAction(Request $request){
        $userService = $this->get('UserService');
        $userrole = $userService->getCurrentUser()->getRoles();
        $term = strtolower($_GET["term"]);
        $facId = $request->query->get('facId');
        $assId = $request->query->get('accId');
        $rtoId = $request->query->get('rtoId');
        $curUserId = $request->query->get('curuserId');
        $results = array();
        $rows = $userService->getUsersFromCourse(array('keyword' => $term), $userrole[0], $facId, $assId, $rtoId, $curUserId);
        $json_array = array();
        foreach ($rows as $row)
        {
            array_push($json_array, $row[1]);
        }
        echo json_encode($json_array);
        exit;
    }
    /**
	 * Function to get the users
     * @param object $request
     */
    public function searchUsersListFromAction(Request $request){
        $to = $this->getRequest()->get('name');
        $nameCondition="";
        $query = $this->getDoctrine()->getRepository('GqAusUserBundle:User')
        ->createQueryBuilder('u')
        ->select('u');
        $searchIn = $query->expr()->concat('u.firstName', $query->expr()->concat($query->expr()->literal(' '), 'u.lastName'));
        $nameCondition .= $searchIn."='".$to."'" ;
        $query->Where($nameCondition);
        $user = $query->getQuery()->getResult(); 
        if ($user) 
            echo $touser = $user[0]->getId();
        exit;
    }

}
