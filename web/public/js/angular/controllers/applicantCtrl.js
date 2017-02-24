
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

	$scope.sortApplicants = function(soryBy){

		$scope.currentPage = 1;
		var applicantData = [];
		var list = '';

		angular.forEach($scope.applicantListTmp, function(filterObj , filterIndex) {
			
			angular.forEach(filterObj.course, function(courseObj, courseKey) {

				var applicant = {};
				applicant.firstName = filterObj.firstName;
				applicant.lastName = filterObj.lastName;
				applicant.userImage = filterObj.userImage;
				applicant.userId = filterObj.userId;
				applicant.courseCode = courseObj.courseCode;
				applicant.courseName = courseObj.courseName;
				applicant.courseStatus = courseObj.courseStatus;
				applicant.courseStatusId = courseObj.courseStatusId;
				applicant.leftdays = courseObj.leftdays;
				applicant.percentage = courseObj.percentage;
				applicant.percent = courseObj.percentage.replace('%','');
				applicant.courseId = courseObj.courseId;
				applicant.course = {courseKey: courseObj};
				applicantData.push(applicant);
			})
		})

		$scope.currentSortTab = soryBy;
		switch(soryBy)
		{
			case 'applicant':
				list = _.sortBy(applicantData, function(o) {
					return o.firstName.toLowerCase();
				});
				$scope.orderBy = ($scope.appSort == undefined ) ? $scope.appSort = 'ASC' : ($scope.appSort == 'ASC') ? $scope.appSort = 'DESC' : ($scope.appSort == 'DESC') ? $scope.appSort = 'ASC' : $scope.appSort = 'ASC';
				break;

			case 'days':
				list = _.sortBy(applicantData, function(o) {
					return parseInt(o.leftdays, 10);
				});
				$scope.orderBy = ($scope.daysSort == undefined ) ? $scope.daysSort = 'ASC' : ($scope.daysSort == 'ASC') ? $scope.daysSort = 'DESC' : ($scope.daysSort == 'DESC') ? $scope.daysSort = 'ASC' : $scope.daysSort = 'ASC';
				break;

			case 'qual':
				list = _.sortBy(applicantData, function(o) {
					return o.courseName.toLowerCase();
				});
				$scope.orderBy = ($scope.qualSort == undefined ) ? $scope.qualSort = 'ASC' : ($scope.qualSort == 'ASC') ? $scope.qualSort = 'DESC' : ($scope.qualSort == 'DESC') ? $scope.qualSort = 'ASC' : $scope.qualSort = 'ASC';
				break;

			case 'status':
				list = _.sortBy(applicantData, function(o) {
					return parseInt(o.courseStatusId, 10);
				});
				$scope.orderBy = ($scope.statSort == undefined ) ? $scope.statSort = 'ASC' : ($scope.statSort == 'ASC') ? $scope.statSort = 'DESC' : ($scope.statSort == 'DESC') ? $scope.statSort = 'ASC' : $scope.statSort = 'ASC';
				break;

			case 'percent':
				list = _.sortBy(applicantData, function(o) {
					return parseInt(o.percent, 10);
				});
				$scope.orderBy = ($scope.perSort == undefined ) ? $scope.perSort = 'ASC' : ($scope.perSort == 'ASC') ? $scope.perSort = 'DESC' : ($scope.perSort == 'DESC') ? $scope.perSort = 'ASC' : $scope.perSort = 'ASC';
				break;
		}

		if($scope.orderBy == 'DESC'){
			list = list.reverse();
		}

		$scope.applicantListTmp = list;
		$scope.showPaginatedList();
		$scope.paginationLinksArr = range();
	}
});