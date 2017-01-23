$('.modal-dialog .upload-id-files p').on('click', function (e) {
    if (e.target !== e.currentTarget)
        return;
    $('.id-files-input').trigger('click');
});
var gqAus = angular.module("gqAus", ['ui.bootstrap', 's3Upload', 'underscore']);
gqAus.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
gqAus.controller('enrollmentCtlr', function ($scope, $window, $http, _) {
    $scope.IsLoaded = false;
    $scope.countries = $window.country_arr;
    $scope.AllStates = $window.s_a;
    $scope.states = [];
    $scope.disabilityAreasNumber = 0;
    $scope.forms = ['profile', 'language', 'schooling', 'employment', 'upload'];
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
    $scope.enrollment = {
        profile: {
            firstName: "",
            postalAddress: true,
            address: {},
            postal: {}
        },
        language: {
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
    var req = {
        method: 'POST',
        url: $window.base_url + "getDisabilityAndQualification",
        headers: {
            'Content-Type': "application/json"
        }
    };
    $http(req).then(function (data) {
        $scope.disabilityElement = data.data.disability;
        $scope.previousQualification = data.data.qualification;
        $scope.documentTypes = data.data.documentTypes;
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
            $("#formWizardCarousel").carousel(i);
        }
    };
    $scope.formSlideTo(0);
    $scope.proceedNext = function (key) {
        var form = $scope.forms[key];
        console.log($scope.enrollment[form]);
        $scope.completedForms[key] = true;
        $scope.formSlideTo(key + 1);
        var req = {
            method: 'POST',
            url: $window.base_url + "saveEnroll",
            headers: {
                'Content-Type': "application/json"
            },
            data: {data: $scope.enrollment[form], type: form}
        };
        $http(req).then(function (e) {
            $scope.completedForms[key] = true;
            $scope.formSlideTo(key + 1);
        }, function (error) {
            console.log(error);
        });
    };
    $scope.getEnrollment = function () {
        var req = {
            method: 'GET',
            url: $window.base_url + "getEnroll/" + $window.or_user_id,
            headers: {
                'Content-Type': "application/json"
            }
        };
        $http(req).then(function (e) {
            $scope.enrollment = angular.merge($scope.enrollment, e.data);
            for (var i = 0; i < 10; i++) {
                $scope.enrollment.employment.usiPart[i] = $scope.enrollment.employment.usi.charAt(i);
            }
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
    }
    $scope.$watch('enrollment.language.disabilityAreas', function (items) {
        var selectedItems = 0;
        angular.forEach(items, function (item) {
            selectedItems += item ? 1 : 0;
        });
        $scope.disabilityAreasNumber = selectedItems;
    }, true);
    $scope.$watch('enrollment.profile.postalAddress', function (newValues) {
        if (newValues == 1 || newValues == '')
            $scope.enrollment.profile.postal = {};
    });
    $scope.$watch('enrollment.language.disability', function (newValues) {
        if (newValues == 1 || newValues == '')
            $scope.enrollment.language.disabilityAreas = {};
    });

    $scope.$watch('enrollment.schooling.highest', function (newValues) {
        if (newValues == 'Never attended school' || newValues == '') {
            $scope.enrollment.schooling.selectYear = '';
            $scope.enrollment.schooling.stillseconday = '';
        }
    });


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
        
        if(angular.element("#uploadID").val() == ''){
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
        angular.forEach($scope.uploadRelation, function(val, key) {
            if(value = val){
                var k = key;
            }
          });
        $scope.uploadControl.cancel(k);
        $scope.enrollment.upload.uploadId.splice(value,1);
        $scope.$applyAsync(); 
    };
    $scope.progressbar = function (uploadingSize, uploadedSize, totalSize, fileNum) {
        var uploadIndex  = $scope.uploadRelation[fileNum];
        var completed = Math.floor((uploadedSize + uploadingSize)*100);
        if(completed> 100) completed = 100;
        $scope.enrollment.upload.uploadId[uploadIndex].percentageCompleted = completed;
        $scope.$applyAsync(); 
    };
    $scope.uploadcomplete = function (data,obj) {
        
        var uploadIndex = $scope.uploadRelation[obj.fileNum];
        $scope.enrollment.upload.uploadId[uploadIndex].status = 'completed';
        $scope.$applyAsync();
          
    };
    $scope.uploadfailed = function (msg) {
        $window.alert(msg); 
    };
    $scope.uploadstarted = function (file,fileNum,dataObj) {
        var index = $scope.enrollment.upload.uploadId.length;
        var uploadObj = {
            file:file,
            name:file.name,
            type:dataObj.type,
            percentageCompleted:0,
            status:'inprogress'
        };
        $scope.enrollment.upload.uploadId.push(uploadObj);
        var Obj = {};
        Obj[fileNum] = index;
        $scope.uploadRelation = angular.merge($scope.uploadRelation,Obj)
        $scope.$applyAsync(); 
         angular.element("#uploadID").val(null);
        $scope.enrollment.upload.type = "";
        $('#uploadIdFiles').modal('hide');
    };
    $scope.getTotalCompleted = function () {
        var total = 0;
        for (var i = 0; i < $scope.enrollment.upload.uploadId.length; i++) {
            if($scope.enrollment.upload.uploadId[i].status == 'completed'){
                total += $scope.enrollment.upload.uploadId[i].type.point;
            }
        }
        if(total>100) total = 100;
        return total;
    }
    $scope.getEnrollment();
});

gqAus.directive('datePicker', function () {
    var link = function (scope, element, attrs, ngModelCtrl) {

        $(element).datetimepicker({
            'format': 'DD/MM/YYYY',
            'maxDate': 'now'
        }).on('dp.change', function (ev) {
            ngModelCtrl.$modelValue = $(element).val();
            scope.ngModel = $(element).val();
            scope.$apply();
            $(element).change();
        });
    };
    return {
        require: 'ngModel',
        restrict: 'A',
        scope: {
            ngModel: '='
        },
        link: link
    }
});
gqAus.directive('usiInput', function () {
    var link = function (scope, element, attrs, ngModelCtrl) {

        USI_INPUT_UI.build();
        USI_INPUT_UI.input.on('keyup', function (event) {
            ngModelCtrl.$modelValue = $(element).val();
            scope.ngModel = $(element).val();
            scope.$apply();
            $(element).change();
        });
    };
    return {
        require: 'ngModel',
        restrict: 'A',
        scope: {
            ngModel: '='
        },
        link: link
    }
});
gqAus.directive('ngIntlTelInput', [
    function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            scope: {
                ngModel: '='
            },
            link: function (scope, elm, attr, ngModelCtrl) {
                scope.ngModel = scope.ngModel || '+61 ';
                var codes = scope.ngModel.split(" ");
                var countryCode = codes[0] || '+61';
//                var country;
//                 if (intlTelInputUtils === 'undefined')
//                    console.log('Phone Validation Library not added');
//                else {
//                    angular.forEach(values, function(value, key) {
//                        this.push(key + ': ' + value);
//                      }, log);
//
//                }
                var initialCountry = attr.initialCountry || 'au';
                $(elm).intlTelInput({
                    preferredCountries: [initialCountry]
                }).on("click", function (e, countryData) {
                    ngModelCtrl.$modelValue = $(elm).val();
                    scope.ngModel = $(elm).val();
                    scope.$apply();
                    $(elm).change();
                }).on("focus", function (e) {
                    ngModelCtrl.$modelValue = $(elm).val();
                    scope.ngModel = $(elm).val();
                    scope.$apply();
                    $(elm).change();
                }).on("blur", function (e) {
                    ngModelCtrl.$modelValue = $(elm).val();
                    scope.ngModel = $(elm).val();
                    scope.$apply();
                    $(elm).change();
                });
                scope.$watch(function () {
                    return ngModelCtrl.$modelValue;
                }, function (newValue) {
                    $(elm).keyup();
                });
            }
        };
    }]);
gqAus.directive('phoneformat', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attr, ctrl) {
            function validate(phoneInput) {
                phoneInput = phoneInput.trim();
                var phoneCodes = phoneInput.split(' ');
                if (intlTelInputUtils === 'undefined')
                    console.log('Phone Validation Library not added');
                else if (intlTelInputUtils.isValidNumber(phoneInput, phoneCodes[0])) {
                    ctrl.$setValidity('phoneformat', true);
                    return phoneInput;
                } else {
                    ctrl.$setValidity('phoneformat', false);
                    return false;

                }
            }
            scope.$watch(function () {
                return ctrl.$viewValue;
            }, validate);
        }
    }
});

gqAus.directive('dateValidator', function () {
    return {
        require: 'ngModel',
        link: function (scope, elem, attr, ngModel) {

            function validate(value) {
                if (value !== undefined && value != null) {
                    ngModel.$setValidity('badDate', true);
                    if (value instanceof Date) {
                        var d = Date.parse(value);
                        // it is a date
                        if (isNaN(d)) {
                            ngModel.$setValidity('badDate', false);
                        }
                    } else {
                        var myPattern = new RegExp(/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/);
                        if (value != '' && !myPattern.test(value)) {
                            ngModel.$setValidity('badDate', false);
                        }
                    }
                }
            }

            scope.$watch(function () {
                return ngModel.$viewValue;
            }, validate);
        }
    };
});
gqAus.filter('rangefromyear', function () {
    return function (input, min) {
        min = parseInt(min);
        var datetime = new Date();
        var max = parseInt(datetime.getFullYear());
        for (var i = max; i >= min; i--)
            input.push(i);
        return input;
    };
});
function enrollmentAutocomplete() {
    var x = setInterval(function () {
        if (angular && angular.element(document.getElementById('enrollmentCtlr')) && angular.element(document.getElementById('enrollmentCtlr')).scope()) {
            clearInterval(x);
            angular.element(document.getElementById('enrollmentCtlr')).scope().mapAddress();
        }
    }, 10);

}
