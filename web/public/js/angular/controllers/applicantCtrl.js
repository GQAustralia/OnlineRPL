
gqAus.controller('applicantCtrl', function($rootScope, $scope, AjaxService){

	$scope.applicantlist = '';
	
	$scope.getApplicants = function(tabStatus, page, srchStr){

		$scope.page = (page) ? page : 1;
		$scope.searchString = srchStr;
		$scope.tabstatus = tabStatus;
		AjaxService.apiCall("getapplicants", {filterbystatus: $scope.tabstatus, page: $scope.page, searchstring: $scope.searchString}).then(function (data) {		
			$scope.applicantlist = data.applicantList;
		}, function (error) {
			console.log(error);
		});
	}
	$scope.getApplicants('1');
});