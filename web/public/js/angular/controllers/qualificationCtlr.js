gqAus.controller('qualificationCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter) {
    $scope.IsLoaded = false;
    $scope.unitsFetched = false;
    $scope.pageStats = {
       evidenceEdit:false,
       evidenceView:'card',
       libraryView:'card',
       evidenceFiles:{},
       isLibrary:false
    };
    $scope.electiveUnits = [];
    $scope.allElectiveUnits = [];
    $scope.selectedElectiveUnits = [];
    $scope.coreUnits = [];
    $scope.allCoreUnits = [];
    $scope.selectedCoreUnits = [];
    $scope.requiredElective = 0;
    $scope.unitDetails = {};
    $scope.userElectiveUnits = [];
    $scope.userCoreUnits = [];
    $scope.electiveUploadSelected = false;
    $scope.is_open = false;
    $scope.selectedUnit = 0;
    $scope.uploadAdditional = {};
    $scope.uploadControl = {};
    $scope.unitEvidences = [];
    $scope.allEvidences = [];
    $scope.evidenceView = {};
    $scope.uploadInProgress = {
        uploads: [],
        category: {},
        libraryFiles:{}
    };
    $scope.userId = $window.or_user_id || 0;
    $scope.uploadDetails = {
        maxUploadedSize: 0,
        totalUploadedSize: 0,
        evidenceCategories: []
    };
    $scope.details = {
        title: "",
        detailsType: ""
    };
    $scope.unitStatusArr = {
        'elective': {
            'all': [],
            'Not yet started': [],
            'Submitted': [],
            'Satisfactory': [],
            'Not yet satisfactory': [],
            'Competent': [],
            'Not yet competent': []
        },
        'core': {
            'all': [],
            'Not yet started': [],
            'Submitted': [],
            'Satisfactory': [],
            'Not yet satisfactory': [],
            'Competent': [],
            'Not yet competent': []
        }
    };

    $scope.unitStatus = '';
    $scope.selectedUnitObj = [];
    $scope.selfAssessment = {};
    $scope.notes = {};
    $scope.role = 'candidate';
    
    
    $scope.addRemoveUnit = function (unit) {

        var obj = _.where($scope.selectedElectiveUnits, unit);
        if (_.isEmpty(obj)) {
            if ($scope.selectedElectiveUnits.length == $scope.requiredElective)
                return false;
            $scope.selectedElectiveUnits.push(unit);
        } else {
            $scope.selectedElectiveUnits = _.without($scope.selectedElectiveUnits, unit);
        }
    };

    $scope.isSelected = function (unit) {
        return !_.isEmpty(_.where($scope.selectedElectiveUnits, unit));
    };

    $scope.isSubmitted = function (unit) {
    	if ($scope.qualificationPage == ''){
    		return $scope.selectedUnitObj.isSubmitted === 1;
    	}
        var $obj;
        if ($scope.qualificationPage == 'elective')
            $obj = unit && _.where($scope.selectedElectiveUnits, unit) || _.where($scope.selectedElectiveUnits, {id: $scope.selectedUnit});
        else
            $obj = unit && _.where($scope.selectedCoreUnits, unit) || _.where($scope.selectedCoreUnits, {id: $scope.selectedUnit});
        return !_.isEmpty($obj) && ($obj[0].isSubmitted === 1);
    };

    $scope.getUnits = function () {
        AjaxService.apiCall("units/getUnits", {"courseCode": $scope.courseCode}).then(function (data) {
            console.log(data);
            $scope.electiveUnits = data.Units.Elective;
            $scope.coreUnits = data.Units.Core.unit;
            $scope.requiredElective = data.Units.Elective.validation.requirement;
            $scope.IsLoaded = true;
            $scope.unitsFetched = true;
            angular.forEach($scope.electiveUnits.groups, function (value, key) {
                angular.forEach(value.unit, function (val, index) {
                    $scope.allElectiveUnits.push(val);
                });
            });
            angular.forEach($scope.coreUnits, function (val, index) {
                $scope.allCoreUnits.push(val);
            });
            $scope.userSelectedSync();
        }, function (error) {
            console.log(error);
        });
        $scope.getUserUnits();
    };

    $scope.getUserUnits = function () {

        AjaxService.apiCall("units/getUserUnits", {"courseCode": $scope.courseCode}).then(function (data) {
            $scope.userElectiveUnits = data.elective;
            $scope.userCoreUnits = data.core;

        }, function (error) {
            console.log(error);
        });
    };

    $scope.getUnitDetails = function (unitCode) {
        $scope.unitDetails[unitCode] = {
            "elements": "Loading elements .....",
            "evidence_guide": "Loading evidence guide .....",
            "skills_and_knowledge": "Loading skilss and knowledge ....."
        };
        AjaxService.apiCall("units/getUnitDetails", {"unitCode": unitCode}).then(function (data) {
            $scope.unitDetails[unitCode] = data;
        }, function (error) {
            console.log(error);
        });
    };

    $scope.doneSelecting = function () {
        AjaxService.apiCall("units/updateSelectedElectiveUnits", {"units": $scope.selectedElectiveUnits, "courseCode": $scope.courseCode}).then(function (data) {
            $scope.getUserUnits();
            $scope.electiveUploadSelected = true;
            $scope.getUploadDetails();

        }, function (error) {
            console.log(error);
        });
    };

    $scope.userSelectedSync = function () {
        $scope.selectedElectiveUnits = [];
        angular.forEach($scope.userElectiveUnits, function (val, index) {
            if (val.electiveStatus == 1) {
                var $obj = _.where($scope.allElectiveUnits, {"id": val.unitId});
                if (!_.isEmpty($obj)) {
                    var $evedenceObject = $obj[0];
                    $evedenceObject.facilitatorStatus = val.facilitatorStatus
                    $evedenceObject.assessorStatus = val.assessorStatus
                    $evedenceObject.rtoStatus = val.rtoStatus
                    $evedenceObject.status = val.status
                    $evedenceObject.electiveStatus = val.electiveStatus
                    $evedenceObject.isSubmitted = val.isSubmitted
                    $evedenceObject.statusText = val.statusText;
                    $scope.selectedElectiveUnits.push($evedenceObject);
                    $scope.unitStatusArr['elective']['all'].push({'id': $evedenceObject.id});
                    if ($evedenceObject.statusText === '' || $evedenceObject.statusText === '0')
                        $scope.unitStatusArr['elective']['Not yet started'].push({'id': $evedenceObject.id});
                    else
                        $scope.unitStatusArr['elective'][$evedenceObject.statusText].push({'id': $evedenceObject.id});
                }

            }
        });

        angular.forEach($scope.userCoreUnits, function (val, index) {
                var $obj = _.where($scope.allCoreUnits, {"id": val.unitId});
                if (!_.isEmpty($obj)) {
                    var $coreObject = $obj[0];
                    $coreObject.facilitatorStatus = val.facilitatorStatus
                    $coreObject.assessorStatus = val.assessorStatus
                    $coreObject.rtoStatus = val.rtoStatus
                    $coreObject.status = val.status
                    $coreObject.electiveStatus = val.electiveStatus
                    $coreObject.isSubmitted = val.isSubmitted
                    $coreObject.statusText = val.statusText;
                    $scope.selectedCoreUnits.push($coreObject)
                    $scope.unitStatusArr['core']['all'].push({'id': $coreObject.id});
                    if ($coreObject.statusText === '' || $coreObject.statusText === '0')
                        $scope.unitStatusArr['core']['Not yet started'].push({'id': $coreObject.id});
                    else
                        $scope.unitStatusArr['core'][$coreObject.statusText].push({'id': $coreObject.id});
                }

        });
        
        if ($scope.selectedElectiveUnits.length == $scope.requiredElective && ($scope.unitsFetched)) {
            $scope.electiveUploadSelected = true;

        }
    };
    $scope.showUnitUpload = function (unit) {
        $scope.is_open = true;
        $scope.selectedUnit = unit.id;
        $scope.getUnitDetails(unit.id);
        $scope.unitEvidences = [];
        $scope.getUnitEvidences(unit.id);
        getNotes($scope.selectedUnit, $scope.courseCode);
    };

    $scope.show_details = function (detailsType, title) {
        $scope.details.title = title;
        $scope.details.detailsType = detailsType;
        $('#elementsPerformanceCriteria').modal('show');
    };

    $scope.downloadElective = function (details) {
        return $window.xepOnline.Formatter.Format('detailsElective', {render: 'download', filename: details.title,
            cssStyle: [{fontSize: '12px'}]});
        //$window.location.href = '/units/downloadSelectedElectiveUnits/'+ $scope.selectedElective + '/' + details.detailsType;
    };

    $scope.printElective = function () {
        var printContents = document.getElementById('detailsElective').innerHTML;
        var popupWin = window.open('', '_blank', 'width=500,height=500');
        popupWin.document.open();
        popupWin.document.write('<html><head></head><body>' + printContents + '</body></html>');
        popupWin.document.close(); // necessary for IE >= 10
        popupWin.focus(); // necessary for IE >= 10*/

        popupWin.print();
        popupWin.close();
    };

    $scope.getUploadDetails = function () {
        AjaxService.apiCall("units/getUploadDetails", {}).then(function (data) {
            $scope.uploadDetails.maxUploadedSize = data.maxUploadSize;
            $scope.uploadDetails.totalUploadedSize = data.totalUploadSize;
            $scope.uploadDetails.evidenceCategories = data.evidenceCategory;

        }, function (error) {
            console.log(error);
        });
        $scope.getEvidenceLibrary();
    };

    $scope.getUnitEvidences = function (unitCode) {
        AjaxService.apiCall("units/getEvidencesByUnit", {"unitCode": unitCode, "courseCode": $scope.courseCode}).then(function (data) {
            if ($scope.selectedUnit === unitCode) $scope.unitEvidences = data;
            var $obj = _.where($scope.unitEvidences,{type:"text"});
            $scope.selfAssessment = $obj[0]||{};
            $scope.selfAssessment.modified = angular.copy($scope.selfAssessment.content);
        }, function (error) {
            console.log(error);
        });
    };

    // Upload Evidence Functions 
    $scope.uploadIds = function () {

        if (_.isEmpty($scope.uploadInProgress.category)) {
            $window.alert('Select evidence category');
            return;
        }

        var keys = [];
        _.each($scope.uploadInProgress.libraryFiles, function (val, key) {
            if (val) {
                keys.push(key);
            }
        });

        if (angular.element("#uploadID").val() == '' && keys.length === 0 ) {
            $window.alert('Select evidence files');
            return;
        }
        if(keys.length > 0){
            $scope.uploadInProgress.libraryFiles = [];
            AjaxService.apiCall("units/copyEvidences", {evidenceIds: keys, courseCode: $scope.courseCode, unitCode: $scope.selectedUnit,category:$scope.uploadInProgress.category.id}).then(function (data) {
                $scope.getUnitEvidences($scope.selectedUnit);
                $scope.getUploadDetails();
                
            }, function (error) {
                console.log(error);
            });
            $scope.closeUploadModal();
        }else{
             var additionalObj = {
            category: $scope.uploadInProgress.category.id,
            userId: $scope.userId,
            unitCode: $scope.selectedUnit,
            courseCode: $scope.courseCode
        };
        $scope.uploadControl.start(additionalObj);
        $('#uploadIdFiles').modal('hide');
        }
       
    };
    $scope.cancelUpload = function (value) {
        $scope.uploadControl.cancel(value);
        $scope.uploadInProgress.uploads.splice(value, 1);
        $scope.$applyAsync();
    };

    $scope.getEvidenceLibrary = function(){
        AjaxService.apiCall("units/getEvidenceLibrary", {}).then(function (data) {
           $scope.allEvidences = data;
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.removeUpload = function (index) {
//        AjaxService.apiCall("removeUserIds",{id:$scope.enrollment.upload.uploadId[index].id}).then(function (data) {
//            $scope.uploadInProgress.uploads.splice(index, 1);
//            $scope.$applyAsync();
//        }, function (error) {
//            console.log(error);
//        });

    };
    $scope.progressbar = function (uploadingSize, uploadedSize, totalSize, fileNum) {
        var uploadIndex = _.findIndex($scope.uploadInProgress.uploads, {fileNum: fileNum});
        var completed = Math.floor((uploadedSize + uploadingSize) * 100);
        if (completed > 100)
            completed = 100;
        $scope.uploadInProgress.uploads[uploadIndex].percentageCompleted = completed;
        $scope.$applyAsync();
    };
    $scope.uploadcomplete = function (data, obj) {
        var uploadIndex = _.findIndex($scope.uploadInProgress.uploads, {fileNum: obj.fileNum});
        $scope.uploadInProgress.uploads[uploadIndex].path = data.fileName;
        $scope.uploadInProgress.uploads[uploadIndex].jobId = data.jobId;
        var uploadedObj = $scope.uploadInProgress.uploads[uploadIndex];
        AjaxService.apiCall("addEvidences",uploadedObj).then(function (data) {
            if (data.uploadId !== '') {
                $scope.getUnitEvidences(uploadedObj.unitCode);
                $scope.uploadInProgress.uploads =  _.without($scope.uploadInProgress.uploads, uploadedObj);
                //$scope.uploadInProgress.uploads.splice(uploadIndex, 1);
                $scope.getUploadDetails();
                $scope.$applyAsync();
            } else {
                var index = _.indexOf($scope.uploadInProgress.uploads, uploadedObj);
                $scope.enrollment.upload.uploadId[index].status = 'failed';
            }

        }, function (error) {
            console.log(error);
        });
    };
    $scope.uploadfailed = function (msg) {
        $window.alert(msg);
    };
    $scope.uploadstarted = function (file, fileNum, dataObj) {
        var index = $scope.uploadInProgress.uploads.length;
        var uploadObj = {
            file: file,
            fileNum: fileNum,
            name: file.name,
            category: dataObj.category,
            type: file.type,
            size: file.size,
            percentageCompleted: 0,
            status: 'inprogress',
            courseCode: dataObj.courseCode,
            unitCode: dataObj.unitCode
        };
        $scope.uploadInProgress.uploads.push(uploadObj);
        $scope.$applyAsync();
        //angular.element("#uploadID").val(null);
        $scope.uploadEvidenceCategory = {};
        $('#uploadEvidence').modal('hide');
    };

    $scope.closeUploadModal = function () {
        angular.element("#uploadID").val(null);
        $scope.uploadEvidenceCategory = {};
        $('#uploadEvidence').modal('hide');
    };

    $scope.showEvidenceModal = function (evidence) {
        $scope.evidenceView = {};
        $scope.evidenceView = evidence;
        $('#filePreview').modal('show');
    };

    $scope.reSelectEvidenceUnit = function () {
        $scope.electiveUploadSelected = false;
    };

    $scope.deSelectEvidences = function () {
        var deSelectArr = []
        angular.forEach($scope.selectedElectiveUnits, function (val, index) {
            if (val.isSubmitted !== 1)
                deSelectArr.push(val)
        });
        $scope.selectedElectiveUnits = _.difference($scope.selectedElectiveUnits, deSelectArr);
    };

    $scope.percentElectiveSubmitted = function () {
        var totalSubmmited = 0
        angular.forEach($scope.selectedElectiveUnits, function (val, index) {
            if (val.isSubmitted === 1)
                totalSubmmited++;
        });
        return Math.round((totalSubmmited / $scope.selectedElectiveUnits.length) * 100)
    };

    $scope.percentCoreSubmitted = function () {
        var totalSubmmited = 0
        angular.forEach($scope.selectedCoreUnits, function (val, index) {
            if (val.isSubmitted === 1)
                totalSubmmited++;
        });
        return Math.round((totalSubmmited / $scope.selectedCoreUnits.length) * 100)
    };
    
    $scope.getStatusText = function (unitId) {
        var $obj;
        if ($scope.qualificationPage === 'elective')
            $obj = _.where($scope.allElectiveUnits, {"id": unitId});
        else
            $obj = _.where($scope.allCoreUnits, {"id": unitId});
        if (!_.isEmpty($obj)) {
            return $obj[0].statusText;
        }
        return '';
    };
    

    $scope.getStatusClass = function (statusText) {
        var cls = 'label-warning'
        switch (statusText) {
            case 'Submitted':
                cls = 'label-warning';
                break;
            case 'Satisfactory':
                cls = 'label-default'
                break;
            case 'Not yet satisfactory':
            case 'Not yet competent':
                cls = 'label-danger';
                break;
            case 'Competent':
                cls = 'label-success';
                break;
            default:
                cls = 'label-warning';
        }
        return cls;
    };

    $scope.closeSelected = function () {
        $scope.is_open = false;
        $scope.selectedUnit = '';
    };

    $scope.submitUnit = function () {
        $('#submitUnitConfirmation').modal('hide');
        AjaxService.apiCall("submitUnitForReview", {"unitCode": $scope.selectedUnit, "courseCode": $scope.courseCode}).then(function (data) {
            if (data.success) {
                $scope.getUserUnits();
                $window.alert(data.success);
            }
            if (data.error) {
                $window.alert(data.error);
            }
        }, function (error) {
            console.log(error);
        });
    };

    $scope.setElectiveFilter = function (filterType) {
        $scope.unitStatusArr['elective'].selectedFilter = filterType;
        var arr = $filter('inArrayFilter')($filter('inArrayFilter')($scope.allElectiveUnits, $scope.selectedElectiveUnits, 'id'), $scope.unitStatusArr['elective'][$scope.unitStatusArr['elective'].selectedFilter], 'id');
        var $obj = _.where(arr, {"id": $scope.selectedUnit});
        if (!_.isEmpty($obj)) {
            $scope.is_open = true;
            return;
        }
        $scope.is_open = false;
    };
    $scope.setCoreFilter = function (filterType) {
        $scope.unitStatusArr['core'].selectedFilter = filterType;
        var arr = $filter('inArrayFilter')($scope.allCoreUnits, $scope.unitStatusArr['core'][$scope.unitStatusArr['core'].selectedFilter], 'id');
        var $obj = _.where(arr, {"id": $scope.selectedUnit});
        if (!_.isEmpty($obj)) {
            $scope.is_open = true;
            return;
        }
        $scope.is_open = false;
    };
    
    $scope.submitConfirm = function() {
        $('#submitUnitConfirmation').modal('show');
    };
    
    $scope.openUnitDetails = function() {
    	window.open('/qualification/unitDetails/'+ $scope.selectedUnit+'/'+$scope.courseCode+'/'+$scope.applicantId); 
    };
    
    $scope.showUnitUploadById = function (id) {
        $scope.selectedUnit = id;
        $scope.getUnitDetails(id);
        $scope.unitEvidences = [];
        $scope.getUnitEvidences(id);
    };
    
    
    $scope.getUnitInfo = function() {
    	 AjaxService.apiCall("qualification/getUnitInfo", {"unitCode": $scope.selectedUnit, "courseCode": $scope.courseCode}).then(function (data) {
    		 $scope.unitStatus = data.statusText;
    		 $scope.selectedUnitObj = data;
         }, function (error) {
             console.log(error);
         });
    };
    
    $scope.saveSelfAssessmentNotes = function() {
    	var uploadedObj = {
    			'self_assessment' : $scope.selfAssessment.modified,
    			'courseCode' : $scope.courseCode,
    			'unitCode' : $scope.selectedUnit,
    			'self_assessment_id' : $scope.selfAssessment.id||null
    	};
        AjaxService.apiCall("addEvidences",uploadedObj).then(function (data) {
            if (data.uploadId !== '') {
                $scope.getUnitEvidences(uploadedObj.unitCode);
                _.without($scope.uploadInProgress.uploads, uploadedObj)
                //$scope.uploadInProgress.uploads.splice(uploadIndex, 1);
                $scope.getUploadDetails();
                $scope.$applyAsync();
            }

        }, function (error) {
            console.log(error);
        });
    };
  
     $scope.deleteEvidence = function (evidence) {
        var ids = [];
        if (evidence === undefined) {
            var keys = [];
            _.each($scope.pageStats.evidenceFiles, function (val, key) {
                if (val) {
                    keys.push(key);
                }
            });
            ids = keys;
            $scope.pageStats.evidenceFiles = [];
        } else {
            ids.push(evidence.id);
        }
        $scope.unitEvidences = _.filter($scope.unitEvidences, function(evi){ return !_.contains(ids, evi.id); });
        AjaxService.apiCall("units/deleteEvidences", {evidences:ids}).then(function (data) {
            $scope.getUnitEvidences($scope.selectedUnit);
        }, function (error) {
            console.log(error);
        });
    };  
    
    $scope.initUnitDetailsPage = function(unitCode) {
    	$scope.selectedUnit = unitCode;
    	$scope.getUploadDetails();
    	$scope.showUnitUploadById($scope.selectedUnit);
    	$scope.getUnitInfo();
    	getNotes($scope.selectedUnit, $scope.courseCode, $scope.applicantId);
    }
    
    var getNotes = function(selectedUnit, courseCode, applicantId) {
    	
    	AjaxService.apiCall("units/getNotes", {"unitCode": $scope.selectedUnit, "courseCode": $scope.courseCode, "userId": $scope.applicantId}).then(function (data) {
    		$scope.notes = data;
        }, function (error) {
            console.log(error);
        });
    }
    
    $scope.saveNotes = function (newNotes) {
    	if (newNotes != '') {
	    	 AjaxService.apiCall("units/saveNotes", {"unitCode": $scope.selectedUnit, "courseCode": $scope.courseCode, "note":newNotes}).then(function (data) {
	    		 if (data != 'error') {
	    			 $scope.notes = data;
	    		 }
	         }, function (error) {
	             console.log(error);
	         });
    	}
    }
    
    
    
    $scope.acknowledgeNote = function (noteId) {
    	AjaxService.apiCall("units/acknowledgeNote", {"unitCode": $scope.selectedUnit, "courseCode": $scope.courseCode, "noteId": noteId}).then(function (data) {
    		if (data != 'error') {
   			 $scope.notes = data;
   		 }
        }, function (error) {
            console.log(error);
        });
    }
    // Watchers
    $scope.$watch('qualificationPage', function (newValues) {
        if (newValues !== '') {
            $scope.IsLoaded = false;
            if (newValues === "qualification") {
                $rootScope.pageTitle = "GQ - Recognition of Prior Learning Qualification";
                $scope.IsLoaded = true;
            } else {
                if (newValues === "core")
                    $rootScope.pageTitle = "GQ - Recognition of Prior Learning Core unit";
                if (newValues === "elective")
                    $rootScope.pageTitle = "GQ - Recognition of Prior Learning Elective unit";
                if (newValues === '') 
                	$rootScope.pageTitle = "GQ - Recognition of Prior Learning Unit Details";
                $scope.getUploadDetails();
                $scope.closeSelected();
                ($scope.unitsFetched == false) ? $scope.getUnits() : $scope.IsLoaded = true;
            }

        }
    });

    $scope.$watch('userElectiveUnits', function (newValues) {
        $scope.userSelectedSync();
    });
    
    $scope.$watch('pageStats.isLibrary', function (newValues) {
        if(newValues===false){
            $scope.uploadInProgress.libraryFiles = {}
        }
    });

});
