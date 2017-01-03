  var gqAus = angular.module("gqAus", []);
         
         gqAus.controller('enrollmentCtlr', function($scope,$window) {
            $scope.enrollment = {
                profile:{
                    firstName: "Samir"
                },
                language:{},
                schooling:{},
                employment:{},
                upload:{}
            };
         });