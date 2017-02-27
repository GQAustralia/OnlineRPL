gqAus.controller('messageCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter,  $timeout) {
    $scope.IsLoaded = false; 
    $scope.role = '';
    $scope.messages = {};
    $scope.paginator = [];
    $scope.paginator.currentPage = 1;
    $scope.paginator.display = '';
    $scope.unreadCnt = 0;
    $scope.msgType = 'all';
    $scope.msgText = 'Inbox';
    $scope.selectedMsgIdArr = [];
    $scope.viewMsgThread = false;
    $scope.replyMsg = '';
    $scope.hideReplyButton = false;
    $scope.showComposeMsg = false;
    $scope.newMsg = {};
    $scope.messageSegregationArr = {
             'ROLE_APPLICANT' : ['Mesages', 'System'],
             'ROLE_FACILITATOR' : ['Applicant', 'Assessor', 'RTO'],
             'ROLE_ASSESSOR' : ['Account Manager'],
             'ROLE_RTO' : ['Account Manager'],
    };
    
    $rootScope.pageTitle = "GQ - Recognition of Prior Learning - Messages";
    $scope.searchCourseCode = '';
    $scope.newMsgCourseObj = {};
    
    
    
    $scope.getMessages = function () {
    	console.log($scope.searchCourseCode);
    	$scope.newMsg = {};
    	console.log(($scope.paginator.currentPage));
    	$scope.messages = {};
    	$scope.viewMsgThread = false;
    	$scope.IsLoaded = false; 
        AjaxService.apiCall("getMessages", {"type": $scope.msgType, "page": $scope.paginator.currentPage, 'searchCourseCode': $scope.searchCourseCode}).then(function (data) {
        	
        	//$scope.messages = data.messages;
        	angular.forEach(data.messages, function(msgObj, key) {
            	
        		$scope.messages['msg_'+msgObj.id] = msgObj;
        		
        	});
        	console.log($scope.messages);
        	$scope.paginator = data.paginator;
        	if ($scope.msgType == 'all') {
        		$scope.unreadCnt = data.unreadcount;
        	}
        	var recordsto = (($scope.paginator.currentPage)*$scope.paginator.pageLimit);
        	
        	if ((($scope.paginator.currentPage)*$scope.paginator.pageLimit) > $scope.paginator.count) {
        		recordsto = $scope.paginator.count;
        	}
        	$scope.paginator.display = (($scope.paginator.currentPage-1)*$scope.paginator.pageLimit)+1+' -'+recordsto+'  of '+$scope.paginator.count;
            $scope.IsLoaded = true; 
            if ($scope.msgType != 'sent') {
	            newMsgsArr = [];
	            
	            angular.forEach($scope.messages, function(msgObj, key) {
	            	
	            	if (msgObj.is_new == 1) {
	            		newMsgsArr.push(msgObj.id);
	            	}
	        		
	        	});
	            
	            $timeout(
	            		function(){
	            			if (newMsgsArr.length > 0) {
			            		updateMsg(newMsgsArr, 'new', '0');
			            		angular.forEach($scope.messages, function(msgObj, key) {
			                    	if ($scope.messages[key].is_new != undefined) {
			                    		$scope.messages[key].is_new = 0;
			                    	}
			                	});
	            			}
	            		}
	            		, 3000);
            }
            
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.displayMsg = function(msgId, readstatus){
    	
    	
    	if (readstatus == 0 && $scope.msgType != 'draft' && $scope.msgType != 'sent' && $scope.msgType != 'flagged') {
    		console.log('update read msg');
	    	updateMsg({msgId}, 'read', '1');
	    	//$scope.messages[msgId].read = 0;
	    	if($scope.unreadCnt > 0) {
	    		$scope.unreadCnt = $scope.unreadCnt - 1;
	    	}
    	}
    	AjaxService.apiCall("viewMsgThread/"+msgId, {'type': $scope.msgType}).then(function (data) {
    		if ($scope.msgType != 'draft') {
				 $scope.messageThread = data.messages;
				 $scope.messageThread.viewMsg = data.view_message.messages[0];
				 $scope.messageThread.userCourses = data.userCourses;
				 $scope.viewMsgThread = true;
			     $scope.hideReplyButton = false;
    		}
    		else {
    			console.log(data.messages);
    			$scope.newMsg = data.messages[0];
    			$scope.newMsg.id = data.messages[0].id;
    			$scope.newMsg.to_user = data.messages[0].msgFrm.id;
    			$scope.newMsg.userName = data.messages[0].msgFrm.name;
    			//$scope.newMsg.
    			console.log($scope.newMsg);
    			$scope.showComposeMsg =  true;
    		}
	     }, function (error) {
	    	 console.log(error);
	     });
    }
    
    var updateMsg = function(MsgIds, field, value) {
    	
    	AjaxService.apiCall("updateMsg", {"msgIds": MsgIds, "field": field, 'value': value}).then(function (data) {
			 
	     }, function (error) {
	    	 console.log(error);
	     });
    }
    
    $scope.saveMsg = function(type) {
    	
    	//New messages save/draft
    	if ($scope.showComposeMsg) {
    		if ($scope.newMsg.message != undefined && $scope.newMsg.message.replace(/^\s+|\s+$/gm,'') != '') {
    			$scope.newMsg.type = type;
	    		AjaxService.apiCall("saveMessage", $scope.newMsg).then(function (data) {
		    		if (data.status == 'sucess') {
		    			$scope.showComposeMsg = false;
		    			$scope.newMsg = {};
		    			$scope.newMsgCourseObj = {};
		    			$scope.getMessages();
		    		}
		    		
			     }, function (error) {
			    	 console.log(error);
			     });
    		}
    	}
    	else {
	    	if ($scope.replyMsg.replace(/^\s+|\s+$/gm,'') != '') {
	    		
	    		var replyMid = $scope.messageThread.viewMsg.replymid;
	    		console.log($scope.messageThread.viewMsg.id);
	    		if (replyMid == 0 && type == 'reply') {
	    			replyMid = $scope.messageThread.viewMsg.id;
	    		}
	    		
		    	var messageObj = {
		    		'replyMsg' : $scope.replyMsg, 
		    		'to_user' : $scope.messageThread.viewMsg.msgFrm.id,
		    		'subject' : $scope.messageThread.viewMsg.subject,
		    		'replymid' : replyMid, 
		    		'type' : type
		    	}
		    	
		    	AjaxService.apiCall("saveMessage", messageObj).then(function (data) {
		    		if (data.status == 'sucess') {
		    			
		    			$scope.hideReplyButton = false;
		    			$scope.viewMsgThread = false;
		    			$scope.replyMsg = '';
		    		}
		    		
			     }, function (error) {
			    	 console.log(error);
			     });
	    	}
	    }
    	
    }
    
    $scope.unreadMsgs = function(){
    	updateMsg($scope.selectedMsgIdArr, 'read', '0');
    	angular.forEach($scope.selectedMsgIdArr, function(msgId, key) {
    		$scope.messages['msg_'+msgId].read = 0;
    		$scope.unreadCnt = $scope.unreadCnt + 1;
    	});
    	
    	$("input[type=checkbox]").prop("checked", false);
    	$scope.selectedMsgIdArr = [];
    	
    }
    
    $scope.prev = function () {
    	console.log($scope.paginator.currentPage);
    	if ($scope.paginator.currentPage > 1) {
    		$scope.paginator.currentPage = $scope.paginator.currentPage-1;
    		$scope.getMessages();
    	}
    }
    
    $scope.next= function () {
    	console.log($scope.paginator.currentPage);
    	if ($scope.paginator.currentPage < $scope.paginator.totalPages) {
    		$scope.paginator.currentPage = $scope.paginator.currentPage+1;
    		$scope.getMessages();
    	}
    }
    $scope.flaggMultipleMsgs = function () {
    	AjaxService.apiCall("saveFlagged", {"msgIds": $scope.selectedMsgIdArr, "is_flagged": 1}).then(function (data) {
			 
	     }, function (error) {
	    	 console.log(error);
	     });
    	
    	angular.forEach($scope.selectedMsgIdArr, function(msgId, key) {
    		$scope.messages['msg_'+msgId].flagged = 1;
    	});
    	$scope.selectedMsgIdArr = [];
    	$("input[type=checkbox]").prop("checked", false);
    	
    }
    
    $scope.flaggMsg = function (msgId, oldFlagStatus) {

    	if (oldFlagStatus == 0) {
    		newFlagStatus = 1;
    	}
    	else {
    		newFlagStatus = 0;
    	}
    
		 AjaxService.apiCall("saveFlagged", {"msgIds": {msgId}, "is_flagged": newFlagStatus}).then(function (data) {
			 
	     }, function (error) {
	    	 console.log(error);
	     });
		 $scope.messages['msg_'+msgId].flagged = newFlagStatus;
    }
    
    $scope.selectMsg = function(msgId) {
    	var index = $scope.selectedMsgIdArr.indexOf(msgId);
    	
    	if (index < 0) {
    		$scope.selectedMsgIdArr.push(msgId);
    	}
    	else {
    		$scope.selectedMsgIdArr.splice(index, 1);  
    	}
    	console.log($scope.selectedMsgIdArr);
    }
    
    $scope.setMessageType = function(messageText) {
    	$scope.msgType = messageText;
        $scope.msgText = messageText;
    }
    
    $scope.showReplyMsg = function(msgId, msgReadStatus) {
    	
    	$scope.displayMsg(msgId, msgReadStatus);
    	console.log($scope.hideReplyButton);
    	$scope.hideReplyButton = true;
    	console.log($scope.hideReplyButton);
    }
    
    
    $scope.getCourses = function(userName) {
    	console.log(userName);
    	if (userName == '' || userName == undefined) { $scope.newMsg.to_user =''; return true }; 
    	var option =  $("datalist[id=names]").find("[value='" + userName + "']");

    	if (option.length > 0) {
    		$scope.newMsgCourseObj = {};
    		if ($scope.msgType != 'draft') {
    			$scope.newMsg.courseCode = '';
    		}
    		$scope.newMsg.to_user = option.data("id");
    		var to_user_role = option.data("role");
	    	console.log( $scope.newMsg.to_user);
	    	AjaxService.apiCall("getCoursesByUser", {'userId': $scope.newMsg.to_user, 'toUserRole': to_user_role}).then(function (data) {
	    		$scope.newMsgCourseObj = data.courses;
		     }, function (error) {
		    	 console.log(error);
		     });
    	}
    }

    
    $scope.$watch('newMsg.userName', function (newValue) {
    	$scope.getCourses(newValue);
    });
});
