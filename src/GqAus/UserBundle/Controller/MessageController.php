<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GqAus\UserBundle\Form\ComposeMessageForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        
    				$result = array();
    				$user = $this->get('security.context')->getToken()->getUser();
    				$userRole = $user->getRoles();
    				$result['role'] = $userRole[0];
    				
    				$userService = $this->get('UserService');
    				$result['to_users'] = $userService->getUsernamesbyRoles(array(), $userRole[0], $user->getId());
    				$loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
    				$loggedinUserRole = $this->get('security.context')->getToken()->getUser()->getRoles();
    				$result['coursesList'] = $userService->getUserCoursesByIDAndRole($loggedinUserId, $loggedinUserRole[0]);
    				
        /*View Message */
        return $this->render('GqAusUserBundle:Message:view.html.twig', $result);
    }

    /**
     * Function viewMsgThread to retrive the message thread based on message id
     * @param unknown $mid
     */
    public function viewMsgThreadAction($mid, Request $request) {
    			
    				
    				$userService = $this->get('UserService');
    				
    				$content = $this->get("request")->getContent();
    				$params = json_decode($content, true); // 2nd param to get as array
    				$type = strtolower($params['type']);
    				
    				$viewMsgobj['messages'][] = $userService->em->getRepository('GqAusUserBundle:Message')->find($mid);
    				
    				$messages['messages'] = $userService->getReplyMessages($mid);
    				$messageThread = $this->messageObjectToArray($messages, $type);
    				
    				$messageThread['view_message'] = $this->messageObjectToArray($viewMsgobj, $type);
    				
    				$loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
    				$courseDetails = $userService->getUserCourses($loggedinUserId);
    				$messageThread['userCourses'] = $this->courseObjToArray($courseDetails);
    				return new JsonResponse($messageThread);
    }
    
    public function getCoursesByUserAction() {
    	
    				$userService = $this->get('UserService');
			    	$content = $this->get("request")->getContent();
			    	$params = json_decode($content, true); // 2nd param to get as array
			    	$toUser = $params['userId'];
			    	$toUserRole = $params['toUserRole'];
			    	$loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
			    	$loggedinUserRole = $this->get('security.context')->getToken()->getUser()->getRoles();
			    	$courseDetails['courses'] = $userService->getUserCoursesByIDAndRole($loggedinUserId, $loggedinUserRole[0], $toUser, $toUserRole);

			    	return new JsonResponse($courseDetails);
    }
    
    /**
     * 
     * @param Object $courseDetails
     * @return Array:couses
     */
    private function courseObjToArray($courseDetails) {
    				$coursesArr = [];
    				foreach ($courseDetails as $course) {
    								$courseArr = [];
    								$courseArr['courseCode'] = $course->getCourseCode();
    								$courseArr['courseName'] = $course->getCourseName();
    								array_push($coursesArr,$courseArr);
    				}
    				return $coursesArr;
    }
    
    /**
     * Function to retrieve all messages based on type
     * @param object $request
     * return string
     */
    public function getMessagesAction(Request $request)
    {
    				$result = [];
			    	$userService = $this->get('UserService');
			    	$loggedinUserId = $this->get('security.context')->getToken()->getUser()->getId();
			    	$userRole = $this->get('security.context')->getToken()->getUser()->getRoles();
			    	$userid = $userService->getCurrentUser()->getId();
			    	
			    	$content = $this->get("request")->getContent();
			    	$params = json_decode($content, true); // 2nd param to get as array
			    	$type = strtolower($params['type']);
			    	$page = $params['page'];
			    	$searchCourseCode = $params['searchCourseCode'];
			    	$unreadcount = 0;
			    	
			    	switch (strtolower($type)){
							    	case 'all':
										    		$results = $userService->getMyInboxMessages($userid, $page, $searchCourseCode);
										    		$unreadcount = $userService->getUnreadMessagesCount($userid);
																break;
							    	case 'sent':
							    					$results = $userService->getMySentMessages($userid, $page, $searchCourseCode);
							    					break;
							    	case 'applicant':
							    	case 'assessor':
							    	case 'rto' :
							    					$results = $userService->getMessagesByRole($userid, $page, $type, $searchCourseCode);
							    					break;
							    	case 'draft':
							    	case 'flagged':
							    	case 'messages':
							    	case 'system':
							    	default:
							    					$results = $userService->getMessages($userid, $page, $type, $searchCourseCode);
			    	}
    				
    				$result = $this->messageObjectToArray($results, $type);
    				$result['unreadcount'] = $unreadcount;
    				//dump($result);exit;
    				return new JsonResponse($result);
    }
    
    
    /**
     * 
     * 
     * @param Object $messagesObj
     * @return multitype:multitype:number  unknown multitype:NULL
     */
    private function messageObjectToArray($messagesObj, $type='') {
    	$messagesArr = [];
    	$messagesArr['messages'] = array();
    	//dump($messagesObj['messages']);exit;
    	if (!empty($messagesObj['messages'])) {
			    		foreach ($messagesObj['messages'] as $msgObj) {
						    			$messageArr = [];
						    			$messageArr['subject'] = $msgObj->getSubject();
						    			$messageArr['message'] = $msgObj->getMessage();
						    			$messageArr['stippedMessage'] = strip_tags($msgObj->getMessage());
						    			$messageArr['created'] = array('date' => date('d/m/Y', strtotime($msgObj->getCreated())), 'time' => date('g:i A', strtotime($msgObj->getCreated())));
						    			$messageArr['read'] = $msgObj->getRead();
						    			$messageArr['toStatus'] = $msgObj->getToStatus();
						    			$messageArr['fromStatus'] = $msgObj->getFromStatus();
						    			$messageArr['reply'] = $msgObj->getReply();
						    			$messageArr['id'] = $msgObj->getId();
						    			$messageArr['unitID'] = $msgObj->getunitID();
						    			$messageArr['replymid'] = $msgObj->getreplymid();
						    			
						    			$messageArr['flagged'] = $msgObj->getFlagged();
						    			$messageArr['is_new'] = $msgObj->getNew();
						    			$messageArr['systemGenerated'] = $msgObj->getSystemGenerated();
						    			$messageArr['courseCode'] = $msgObj->getCourseCode();
						    			
						    			if (!empty($msgObj->getSent())) {
						    							$role = '';
						    							if ($msgObj->getSent()->getRoles()[0] == 'ROLE_FACILITATOR' ) {
						    											$role = 'Account Manager';
						    							}
						    							
						    							if ($msgObj->getSent()->getRoles()[0] == 'ROLE_MANAGER' ) {
						    								$role = 'Supervisor';
						    							}
						    							if ($type == 'sent' || $type == 'draft') {
						    											
									    								if ($msgObj->getInbox()->getRoles()[0] == 'ROLE_FACILITATOR' ) {
									    									$role = 'Account Manager';
									    								}
									    								 
									    								if ($msgObj->getInbox()->getRoles()[0] == 'ROLE_MANAGER' ) {
									    									$role = 'Supervisor';
									    								}

						    											$messageArr['msgFrm'] = array('name' => $msgObj->getInbox()->getFirstName().' '.$msgObj->getInbox()->getLastName(), 
																										    																	'userImage' => $msgObj->getInbox()->getUserImage(), 
																										    																	'id' => $msgObj->getInbox()->getId(),
						    																																					'role' => $role
						    							);
						    							}
						    							else {
									    								
										    								if ($msgObj->getSent()->getRoles()[0] == 'ROLE_FACILITATOR' ) {
										    									$role = 'Account Manager';
										    								}
										    								 
										    								if ($msgObj->getSent()->getRoles()[0] == 'ROLE_MANAGER' ) {
										    									$role = 'Supervisor';
										    								}
						    								
						    												$messageArr['msgFrm'] = array('name' => $msgObj->getSent()->getFirstName().' '.$msgObj->getSent()->getLastName(),
									    										'userImage' => $msgObj->getSent()->getUserImage(),
									    										'id' => $msgObj->getSent()->getId(),
									    										'role' => $role);
									    										 
						    							}
						    			}
						    			array_push($messagesArr['messages'],$messageArr);
						    			//$messagesArr['messages']['message_'.trim($msgObj->getId())] =  $messageArr;
			    		}
    	}
    	if (isset($messagesObj['sentuserid'])) {
    					$messagesArr['sentuserid'] = $messagesObj['sentuserid'];
    	}
    	//dump($messagesObj);exit;
    	if (isset($messagesObj['paginator'])) {
    		$messagesArr['paginator'] = array('count' => $messagesObj['paginator']->getCount(),
    				'currentPage' => $messagesObj['paginator']->getCurrentPage(),
    				'pageLimit' => $this->container->getParameter('pagination_limit_page'),
    				'totalPages' => $messagesObj['paginator']->getTotalPages());
    	}
    	else {
    		$messagesArr['paginator'] = array('count' => 0,
    				'currentPage' => 1,
    				'totalPages' => 0);
    	}
    	

    	return $messagesArr;
    }
    
    
    /**
     * Function to mark as read / unread
     * @param object $request
     * return int
     */
    public function saveFlaggedAction(Request $request)
    {
    	$content = $this->get("request")->getContent();
    	$params = json_decode($content, true); // 2nd param to get as array
    	$msgIds = $params['msgIds'];
    	$isFlagged = $params['is_flagged'];

    	$userService = $this->get('UserService');
    	$userService->saveFlagged($msgIds, $isFlagged);
    	return new JsonResponse();
    }
    
    
    /**
     * 
     * @param Request $request
     */
    public function updateMsgAction(Request $request)
    {
			    	$content = $this->get("request")->getContent();
			    	$params = json_decode($content, true); // 2nd param to get as array
			    	$msgIds = $params['msgIds'];
			    	$field = $params['field'];
			    	$value = $params['value'];
			    	
			    	$userService = $this->get('UserService');

			    	$userService->updateMsg($msgIds, $field, $value);
			    	return new JsonResponse();
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
												
        				$replymid = 0;
        				$content = $this->get("request")->getContent();
        				$params = json_decode($content, true);
            $userService = $this->get('UserService');
            $curuser = $userService->getCurrentUser();
            if (isset($params['replymid'])) {
            				$replymid = $params['replymid'];
            }
            $to = $params['to_user']; 
            $subject = $params['subject']; 
            
            if (isset($params['replyMsg'])) {
            				$message = $params['replyMsg'];
            }
            
            if (isset($params['message'])) {
            	$message = $params['message'];
            }
            
            $unitId = '';
            if (isset($params['unitId'])) {
                    $unitId = $params['unitId'];
            }
            
            $courseCode = '';
            if (isset($params['courseCode'])) {
            	$courseCode = $params['courseCode'];
            }
            

                $user = $this->getDoctrine()
                ->getRepository('GqAusUserBundle:User')
                ->findOneBy(array('id' => $to));
                if ($user)
                	$touser = $user->getId();
               // echo "<pre>"; dump($user); exit;
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
                            'message' => $message, 'unitId' => $unitId, 'replymid' => $replymid, 'courseCode' => $courseCode, 'flagged' => 0);
																								
                        $type = $params['type'];
                        if ($type == 'draft') {
                        				$msgdata['draft'] = 1;
                        				$msgdata['new'] = 0;
                        }
                        else {
                        				$msgdata['new'] = 1;
                        				$msgdata['draft'] = 0;
                        }
                        
                        if (isset($params['id'])) {
                        				$msgdata['id'] = $params['id'];
                        }
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
                        if($sentuser->getRole() == '5' && $msgdata['draft'] != 1)
                        {
                            $userService->sendExternalEmail($sentuser->getEmail(), $mailSubject,
                            $mailBody, $curuser->getEmail(), $curuser->getUsername());
                        }

                        $userService->saveMessageData($sentuser, $curuser, $msgdata);

                        
                            $msg_status = $this->container->getParameter('message_succ');
                            $status = 'sucess';
                        
                    }
                    else
                    {
                    				$msg_status = $this->container->getParameter('user_authorize');
                    				$status = 'error';
                    }
                }
                else {
                					$msg_status = $this->container->getParameter('no_user_found');
                					$status = 'error';
                        
                }
            //return $this->redirect('messages');
            return new JsonResponse(array('status' => $status, 'msg_status' => $msg_status));
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
