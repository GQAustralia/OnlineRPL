gqAus.controller('messageCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter,  $timeout) {
	$rootScope.pageTitle ='GQ - RPL Qualification  - Applicant Qualification';
	$scope.status = '';
	$scope.statusText = '';
	$scope.applicantId = '';
	$scope.courseCode = '';	
	$scope.statusErrorText = '';
	$scope.updateStatus = function() {
		AjaxService.apiCall("updateCourseStatus", {'courseStatus': $scope.courseStatus, 'courseCode': $scope.courseCode, 'userId': $scope.applicantId}).then(function (data) {
			 console.log(data);
			 if (data.type == 'Success') {
				 $scope.statusErrorText = '';
				 $scope.statusText = data.courseStatusText;
				 $('#qualStatuses').modal('hide');
			 }
			 else {
				 $scope.statusErrorText = data.msg;
			 }
			 
	     }, function (error) {
	    	 console.log(error);
	     });
	}
	
});