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
                    if(newValue === '') {
                        $(elm).val(countryCode);
                    }
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
