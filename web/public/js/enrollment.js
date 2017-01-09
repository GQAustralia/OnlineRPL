var gqAus = angular.module("gqAus", ['ui.bootstrap']);
gqAus.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
gqAus.controller('enrollmentCtlr', function ($scope, $window, $http) {
    $scope.countries = $window.country_arr;
    $scope.AllStates = $window.s_a;
    $scope.states = [];
    $scope.disabilityAreasNumber = 0;
    $scope.enrollment = {
        profile: {
            firstName: "",
            postalAddress: true,
            address: {},
            postal: {}
        },
        language: {
            disabilityAres: {
                brain : false,
                deaf : false,
                intellectual : false,
                learning : false,
                medical : false,
                mental : false,
                other : false,
                physical : false,
                vision : false
            }
        },
        schooling: {
            highest: "Year 12 or equivalent",
            qualifications: {
                advancedDiploma : false,
                bachelor : false,
                certificateI : false,
                certificateII : false,
                diploma : false,
                noQualification : false,
                otherCertificate : false,
                technician : false,
                trade : false
            }
        },
        employment: {
            category : 'Full-time employee',
            studyreason: 'To get a job',
            basedinaustralia: '',
            internationalstudent : '',
            haveusi : '',
            applyusi : '',
            usi:{
            }
        },
        upload: {}
    };

    $scope.validateSteps = function (form, index) {

    };
    $scope.proceedNext = function (key) {
        console.log($scope.enrollment[key]);
        var req = {
            method: 'POST',
            url: $window.base_url+"saveEnrollment",
            headers: {
                'Content-Type': "application/json"
            },
            data: {data: $scope.enrollment[key],type:key}
        };
        $http(req).then(function(e) {
            console.log(e);
        }, function(error) {
            console.log(error);
        });
    };
    
     $scope.$watch('enrollment.language.disabilityAreas', function(items){
        var selectedItems = 0;
        angular.forEach(items, function(item){
          selectedItems += item ? 1 : 0;
        });
        $scope.disabilityAreasNumber = selectedItems;
      }, true); 
      $scope.$watch('enrollment.profile.postalAddress', function(items){
        $scope.enrollment.profile.postal = {};
      }, true); 
//      $scope.$watch('enrollment.profile.postalAddress', function(items){
//        $scope.enrollment.profile.postal = {};
//      }, true);
//      $scope.$watch('enrollment.lanuage.enrollment.language.disability', function(items){
//        $scope.enrollment.profile.disabilityAreas = {};
//      }, true);
//      $scope.$watch('enrollment.lanuage.enrollment.language.disability', function(items){
//        $scope.profile.disabilityAreas = {};
//      }, true);
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

        }
    }
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
gqAus.directive('ngIntlTelInput', [
    function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            scope: {
                ngModel: '='
            },
            link: function (scope, elm, attr, ngModelCtrl) {
                scope.ngModel = '+61 ';
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

function enrollmentAutocomplete() {
    var x = setInterval(function () {
        if (angular && angular.element(document.getElementById('enrollmentCtlr')) && angular.element(document.getElementById('enrollmentCtlr')).scope()) {
            clearInterval(x);
            angular.element(document.getElementById('enrollmentCtlr')).scope().mapAddress();
        }
    }, 10);

}
