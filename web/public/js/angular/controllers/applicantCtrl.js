
gqAus.controller('applicantCtrl', function($rootScope, $scope, AjaxService){
	
	$scope.loading = false;
	$scope.applicantlist = [];
	$scope.searchApplicant = '';
	$scope.activeTab = 'incomplete';
	$scope.minlength = 2;
	$scope.tabstat = 1;
	
	$scope.itemsPerPage = 4;
	$scope.currentPage = 1;
	$scope.paginationLinksArr = [];
	$scope.applicantListTmp = [];
	
	$scope.greeting = 'Hello, World!';
    $scope.showGreeting = false;
	
	$scope.getApplicants = function(tabStatus, srchStr){
		$scope.loading = false;
		$scope.applicantlist = [];
		$scope.applicantListTmp = [];
		$scope.page = 1;
		$scope.searchString = (srchStr) ? srchStr : '';
		$scope.tabstat = (tabStatus == 'incomplete') ? 1 : 0 ;

		AjaxService.apiCall("getapplicants", {filterbystatus: $scope.tabstat, searchstring: $scope.searchString}).then(function (data) {

			$scope.applicantListTmp = _.toArray(data.applicantList);
			$scope.pageCount = Math.ceil($scope.applicantListTmp.length/$scope.itemsPerPage);
			$scope.showPaginatedList();
			$scope.paginationLinksArr = range();
			$scope.loading = true;

		}, function (error) {
			console.log(error);
		});
	}

	$scope.searchApplicants = function(){
		
        if ($scope.searchApplicant.length >= $scope.minlength) {
			$scope.getApplicants($scope.activeTab, $scope.searchApplicant);
        } else {
			$scope.getApplicants($scope.activeTab);
		}
	}

	$scope.resetSearch = function(){
		$scope.searchApplicant = '';
	}

	$scope.resetPagination = function(){
		$scope.currentPage = 1;
	}

	$scope.focusSearch = function(){
		$scope.resetSearch();
		$scope.resetPagination();
		$('#searchApplicants').focus();
	}

	$scope.getApplicants('incomplete', '');
	
	$scope.prevPage = function() {
		if ($scope.currentPage > 1) {
			$scope.currentPage--;
		}
	};

	$scope.prevPageDisabled = function() {
		return $scope.currentPage === 1 ? "disabled" : "";
	};

	$scope.nextPage = function() {
		if ($scope.currentPage < $scope.pageCount) {
			$scope.currentPage++;
		}
	};

	$scope.nextPageDisabled = function() {
		return $scope.currentPage === $scope.pageCount ? "disabled" : "";
	};

	$scope.showPaginatedList = function(pageNum='') {
		$scope.loading = false;
		if (pageNum != '') {
			$scope.currentPage = pageNum;
		}

		$scope.applicantlist = $scope.applicantListTmp.slice(($scope.currentPage-1)*$scope.itemsPerPage, ($scope.itemsPerPage+($scope.currentPage-1)*$scope.itemsPerPage));

		$scope.pageTotalCount = $scope.itemsPerPage * $scope.currentPage;
		$scope.applicantViewCount = ( $scope.pageTotalCount > $scope.applicantListTmp.length) ? $scope.applicantListTmp.length : (($scope.pageTotalCount <= 0) ? $scope.itemsPerPage : $scope.pageTotalCount);
		$scope.loading = true;
	}

	var range = function() {
		var linkStartNum = $scope.currentPage - 2;
		var linkEndNum = $scope.currentPage + 2;
		
		if (linkStartNum <= 0) {
			linkEndNum = (linkEndNum - linkStartNum) +1;
			linkStartNum = 1;
			
		}
		
		if (linkEndNum > $scope.pageCount) {
			linkEndNum = $scope.pageCount;
		}
		return _.range(linkStartNum, linkEndNum+1);	
	}
	
	
	$scope.addreminder = function(courseId){
		var remindDate = '';
		var remContent = '';
		remContent = $('#remcontent-'+courseId).val();
		var today = new Date();
		remindDate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

		if($('#datetodb')){
			remindDate = $('#datetodb').val();
		}

		console.log('remContent :: '+remContent);
		console.log('datetodb :: '+remindDate);

		AjaxService.apiCall("addReminder", {message: remContent, userCourseId: courseId, remindDate: remindDate}).then(function (data) {
			$scope.showSuccessMessage();
			return false;
		}, function (error) {
			console.log(error);
		});
	}
	
	$scope.showSuccessMessage = function() {
       $scope.msg="hi";
       $scope.showGreeting = true;
       $timeout(function(){
          $scope.showGreeting = false;
       }, 500);
    };
});

/* $('body').on('click', '.btn-add-task', function(){
	console.log('inside');
}); */