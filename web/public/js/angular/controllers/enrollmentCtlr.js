$('.modal-dialog .upload-id-files p').on('click', function (e) {
    if (e.target !== e.currentTarget)
        return;
    $('.id-files-input').trigger('click');
});
gqAus.controller('enrollmentCtlr', function ($rootScope, $scope, $window, _, AjaxService) {
    $scope.IsLoaded = false;
    $scope.countries = $window.country_arr;
    $scope.AllStates = $window.s_a;
    $scope.states = [];
    $scope.disabilityAreasNumber = 0;
    $scope.forms = ['profile', 'language', 'schooling', 'employment', 'upload'];
    $scope.titles = ['Your Profile', 'Language and Diversity', 'Schooling and Achievements', 'Employment  and USI', 'Upload ID files'];
    $scope.activeForm = 0;
    $scope.completedForms = [false, false, false, false, false];
    $scope.evidenceFirst = true;
    $scope.disabilityElement = [];
    $scope.previousQualification = [];
    $scope.documentTypes = [];
    $scope.uploadAdditional = {};
    $scope.uploadControl = {};
    $scope.uploadRelation = {};
    $scope.userId = $window.or_user_id || 0;
    $rootScope.pageTitle = 'Enrolment - Your Profile';
    $scope.noQualification = '';
    $scope.enrollment = {
        profile: {
            firstName: "",
            postalAddress: true,
            address: {
                country: "Australia"
            },
            postal: {
                country: "Australia"
            }
        },
        language: {
            country: 'Australia',
            disabilityAreas: {}
        },
        schooling: {
            highest: "",
            qualifications: {}
        },
        employment: {
            category: 'Full-time employee',
            studyreason: 'To get a job',
            basedinaustralia: '',
            internationalstudent: '',
            haveusi: '',
            applyusi: '',
            usi: '',
            usiPart: []
        },
        upload: {
            uploadId: [],
            type: ''
        }
    };
    AjaxService.apiCall("getDisabilityAndQualification").then(function (data) {
        $scope.disabilityElement = data.disability;
        $scope.previousQualification = data.qualification;
        $scope.documentTypes = data.documentTypes;
        angular.forEach(data.qualification, function (value, key) {
            if(value.name === 'No, I have not completed any qualifications') {
                $scope.noQualification = value.id;
            }
        });
    }, function (error) {
        console.log(error);
    });
    $scope.formSlideTo = function (index) {
        var slideFlag = true;
        for (var i = 0; i < index; i++) {
            if ($scope.completedForms[i] == false)
                slideFlag = false;
        }
        if(slideFlag === true){ 
        $scope.activeForm = index;
        $rootScope.pageTitle = 'Enrolment - '+$scope.titles[index];
        $("#formWizardCarousel").carousel(i);
        }
    };
    $scope.formSlideTo(0);
    $scope.proceedNext = function (key) {
        var form = $scope.forms[key];
        AjaxService.apiCall('saveEnroll', {data: $scope.enrollment[form], type: form}).then(function (success) {
            $scope.completedForms[key] = true;
            $scope.formSlideTo(key + 1);
        }, function (error) {
            console.log(error);
        });
    };
    $scope.getEnrollment = function () {
        AjaxService.apiCall("getEnroll/" + $window.or_user_id).then(function (data) {
            $scope.enrollment = angular.merge($scope.enrollment, data);
            for (var i = 0; i < 10; i++) {
                $scope.enrollment.employment.usiPart[i] = $scope.enrollment.employment.usi.charAt(i);
            }
            var formKey = 0;
            angular.forEach($scope.forms, function (value, key) {
                var $obj = data[value];
                if(value === 'upload') {
                    $obj = data['upload']['uploadId']
                }
                if(_.isEmpty($obj) === false){
                  $scope.completedForms[key] = true;
                  formKey = key;
                }
            });
            $scope.formSlideTo(formKey);
            if(!$scope.enrollment.profile.homeTelNumber) $scope.enrollment.profile.homeTelNumber = '+61 ';
            if(!$scope.enrollment.profile.workTelNumber) $scope.enrollment.profile.workTelNumber = '+61 ';
            if(!$scope.enrollment.profile.mobileNumber) $scope.enrollment.profile.mobileNumber = '+61 ';
            $scope.IsLoaded = true;
        }, function (error) {
            console.log(error);
        });
    };

    $scope.resetEnrollDepends = function (enroll) {
        var arr = ['basedinaustralia', 'internationalstudent', 'haveusi', 'applyusi', 'usi'];
        var modelIndex = arr.indexOf(enroll);
        for (var i = modelIndex + 1; i < arr.length; i++) {
            $scope.enrollment.employment[arr[i]] = '';
        }
        $scope.enrollment.employment.usiPart = [];
    };
    
    $scope.qualificationChanged = function(qualification){
        if(qualification.id == $scope.noQualification && $scope.enrollment.schooling.qualifications[qualification.id] == true) {
            $scope.enrollment.schooling.qualifications = {};
            $scope.enrollment.schooling.qualifications[qualification.id] = true;  
        }else{
            var key = $scope.noQualification;
            $scope.enrollment.schooling.qualifications[key] = false
        }
    };
    $scope.$watch('enrollment.language.disabilityAreas', function (items) {
        var selectedItems = 0;
        angular.forEach(items, function (item) {
            selectedItems += item ? 1 : 0;
        });
        $scope.disabilityAreasNumber = selectedItems;
    }, true);
    $scope.$watch('enrollment.profile.postalAddress', function (newValues) {
        if (newValues == 1 || newValues == '')
            $scope.enrollment.profile.postal = {
                country: "Australia"
            };
    });
//    $scope.$watch('enrollment.language.disability', function (newValues) {
//        if (newValues == 1 || newValues == '')
//            $scope.enrollment.language.disabilityAreas = {};
//    });

    $scope.$watch('enrollment.schooling.highest', function (newValues) {
        if (newValues == 'Never attended school' || newValues == '') {
            $scope.enrollment.schooling.selectYear = '';
            $scope.enrollment.schooling.stillseconday = '';
        }
    });

    $scope.selectDisability = function() {
        $scope.enrollment.language.disabilityAreas = {};
    };
    
    $scope.selectState = function (country) {
        var index = $scope.countries.indexOf(country); // 1
        if (index === -1)
            return [];

        return $window.s_a[index + 1].split("|");
    };
    $scope.mapAddress = function () {
        var autocomplete, autocomplete_postal;
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'long_name',
            country: 'long_name',
            postal_code: 'short_name'
        };
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['address']}
        );

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', function () {
            $scope.fillInAddress(autocomplete, '')
        });

        autocomplete_postal = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_postal')),
                {types: ['address']}
        );

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete_postal.addListener('place_changed', function () {
            $scope.fillInAddress(autocomplete_postal, '_postal')
        });
        $scope.fillInAddress = function (autocomplete, unique) {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            for (var component in componentForm) {
                if (!!document.getElementById(component + unique)) {
                    if (unique !== '') {
                        $scope.enrollment.profile.postal[component] = '';
                    } else {
                        $scope.enrollment.profile.address[component] = '';
                    }
                    document.getElementById(component + unique).disabled = false;
                }
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (addressType == 'administrative_area_level_1') {
                    var val = place.address_components[i][componentForm[addressType]];
                    if (unique !== '') {
                        $scope.enrollment.profile.postal.state = val;
                    } else {
                        $scope.enrollment.profile.address.state = val;
                    }
                }
                if (componentForm[addressType] && document.getElementById(addressType + unique)) {
                    var val = place.address_components[i][componentForm[addressType]];
                    if (unique !== '') {
                        $scope.enrollment.profile.postal[addressType] = val;
                    } else {
                        $scope.enrollment.profile.address[addressType] = val;
                    }

                }
            }

            $scope.$apply();

        };
    };
    $scope.uploadIds = function () {

        for (var i = 0; i < $scope.enrollment.upload.uploadId.length; i++) {
            if ($scope.enrollment.upload.type.id === $scope.enrollment.upload.uploadId[i].type.id) {
                $window.alert('Duplicate Document Id');
                return;
            }
        }
        if ($scope.enrollment.upload.type === '') {
            $window.alert('Select Document Type');
            return;
        }

        if (angular.element("#uploadID").val() == '') {
            $window.alert('Select Upload Id');
            return;
        }
        var additionalObj = {
            type: $scope.enrollment.upload.type,
            userId: $scope.userId
        };
        $scope.uploadControl.start(additionalObj);
        $('#uploadIdFiles').modal('hide');
    };
    $scope.cancelUpload = function (value) {
        var k;
        angular.forEach($scope.uploadRelation, function (val, key) {
            if (value = val) {
                k = key;
            }
        });
        $scope.uploadControl.cancel(k);
        $scope.enrollment.upload.uploadId.splice(value, 1);
        $scope.$applyAsync();
    };

    $scope.removeUpload = function (index) {
        AjaxService.apiCall("removeUserIds",{id:$scope.enrollment.upload.uploadId[index].id}).then(function (data) {
            $scope.enrollment.upload.uploadId.splice(index, 1);
            $scope.$applyAsync();
        }, function (error) {
            console.log(error);
        });

    };
    $scope.progressbar = function (uploadingSize, uploadedSize, totalSize, fileNum) {
        var uploadIndex = $scope.uploadRelation[fileNum];
        var completed = Math.floor((uploadedSize + uploadingSize) * 100);
        if (completed > 100)
            completed = 100;
        $scope.enrollment.upload.uploadId[uploadIndex].percentageCompleted = completed;
        $scope.$applyAsync();
    };
    $scope.uploadcomplete = function (data, obj) {
        var uploadIndex = $scope.uploadRelation[obj.fileNum];
        AjaxService.apiCall("saveUpload", $scope.enrollment.upload.uploadId[uploadIndex]).then(function (data) {
            if(data.uploadId !=='') {
               $scope.enrollment.upload.uploadId[uploadIndex].id = data.uploadId;
                $scope.enrollment.upload.uploadId[uploadIndex].status = 'completed';
                $scope.$applyAsync(); 
            }else{
                $scope.enrollment.upload.uploadId[uploadIndex].status = 'failed';
            }
            
        }, function (error) {
            console.log(error);
        });
    };
    $scope.uploadfailed = function (msg) {
        $window.alert(msg);
    };
    $scope.uploadstarted = function (file, fileNum, dataObj) {
        var index = $scope.enrollment.upload.uploadId.length;
        var uploadObj = {
            file: file,
            name: file.name,
            type: dataObj.type,
            percentageCompleted: 0,
            status: 'inprogress'
        };
        $scope.enrollment.upload.uploadId.push(uploadObj);
        var Obj = {};
        Obj[fileNum] = index;
        $scope.uploadRelation = angular.merge($scope.uploadRelation, Obj)
        $scope.$applyAsync();
        angular.element("#uploadID").val(null);
        $scope.enrollment.upload.type = "";
        $('#uploadIdFiles').modal('hide');
    };
    $scope.getTotalCompleted = function () {
        var total = 0;
        for (var i = 0; i < $scope.enrollment.upload.uploadId.length; i++) {
            if ($scope.enrollment.upload.uploadId[i].status == 'completed') {
                total += $scope.enrollment.upload.uploadId[i].type.point;
            }
        }
        if (total > 100)
            total = 100;
        return total;
    };
    $scope.closeUploadModal = function() {
        angular.element("#uploadID").val(null);
        $scope.enrollment.upload.type = "";
        $('#uploadIdFiles').modal('hide');
    };
    
    $scope.isUploadInProgress = function() {
        var total = 0;
        for (var i = 0; i < $scope.enrollment.upload.uploadId.length; i++) {
            if ($scope.enrollment.upload.uploadId[i].status == 'inprogress') {
                return true;
            }
        }
        return false;
    };
    
    $scope.submitEnrolment = function() {
        AjaxService.apiCall('setEnrollmentComplete').then(function (success) {
            $window.location.href = '/overview';
        }, function (error) {
            console.log(error);
        });
        
    };
    $scope.getEnrollment();
});


function enrollmentAutocomplete() {
    var x = setInterval(function () {
        if (angular && angular.element(document.getElementById('enrollmentCtlr')) && angular.element(document.getElementById('enrollmentCtlr')).scope()) {
            clearInterval(x);
            angular.element(document.getElementById('enrollmentCtlr')).scope().mapAddress();
        }
    }, 10);

}
