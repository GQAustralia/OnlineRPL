
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
	
	$scope.focusSearch = function(){
		$scope.resetSearch();
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

		console.log($scope.applicantListTmp);
		console.log(($scope.currentPage-1)*$scope.itemsPerPage);
		$scope.applicantlist = $scope.applicantListTmp.slice(($scope.currentPage-1)*$scope.itemsPerPage, ($scope.itemsPerPage+($scope.currentPage-1)*$scope.itemsPerPage));
		console.log($scope.applicantlist);
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
});