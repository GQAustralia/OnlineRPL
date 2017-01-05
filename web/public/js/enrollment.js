var gqAus = angular.module("gqAus", ['ui.bootstrap']);
gqAus.controller('enrollmentCtlr', function ($scope, $window) {
    $scope.enrollment = {
        profile: {
            firstName: "Samir"
        },
        language: {},
        schooling: {},
        employment: {},
        upload: {}
    };

    $scope.validateSteps = function (form, index) {

    };
});

gqAus.directive('datePicker', function () {
    var link = function (scope, element, attrs, ngModelCtrl) {

        $(element).datetimepicker({
            'format': 'DD/MM/YYYY'
        }).on('dp.change', function (ev) {
            ngModelCtrl.$modelValue = $(element).val();
            scope.ngModel = $(element).val();
            scope.$apply();
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
        }).on("click", function(e, countryData) {
              ngModelCtrl.$modelValue = $(elm).val();
            scope.ngModel = $(elm).val();
            scope.$apply();
          }).on("focus", function(e) {
              ngModelCtrl.$modelValue = $(elm).val();
            scope.ngModel = $(elm).val();
            scope.$apply();
          }).on("blur", function(e) {
              ngModelCtrl.$modelValue = $(elm).val();
            scope.ngModel = $(elm).val();
            scope.$apply();
          });
         
        }
      };
    }]);