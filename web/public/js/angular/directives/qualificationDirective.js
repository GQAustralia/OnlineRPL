gqAus.directive('autoExpand', function ($window) {
    var link = function (scope, element, attrs, ngModelCtrl) {
        $window.autosize($(element));        
    };
    return {
        //require: 'ngModel',
        restrict: 'A',
//        scope: {
//            ngModel: '='
//        },
        link: link
    }
});
gqAus.directive('gqAudio', function ($timeout) {
    var i = 0;
    var link = function (scope, element, attrs) {    
        scope.datapath = attrs.datapath;
        scope.i = i++;
        scope.$watch(function () {
            return attrs.datapath;
        }, function (value) {
            $timeout(function () {
                var audio = document.getElementById('gq-audio');
                 var sources = audio.getElementsByTagName('source');
                sources[0].src = attrs.datapath;
                audio.load();
            }, 0, false);
        });
    };
    return {
        //require: 'datapath',
        restrict: 'E',
        scope: false,
        replace: true,
        template: '<audio id="gq-audio" style="width: 100%;" controls="true" autostart="0"><source src="" ng-src="" type="audio/mpeg"></audio>',
        link: link
    }
});
gqAus.directive('gqVideo', function ($timeout) {
    var k = 0;
    var link = function (scope, element, attrs) {
        scope.datapath = attrs.datapath;
        scope.datatype = attrs.datatype;
        scope.k = k++;
        scope.$watch(function () {
            return attrs.datapath;
        }, function (value) {
            $timeout(function () {
                var video = document.getElementById('gq-video');
                var sources = video.getElementsByTagName('source');
                sources[0].src = attrs.datapath;
                video.load();
            }, 0, false);
        });



    };
    return {
        //require: 'ngModel',
        restrict: 'E',
        scope: false,
        replace: true,
        template: '<video id="gq-video" width="100%" controls autostart="0"><source src="" type="{[{datatype}]}">Your browser does not support HTML5 video.</video>',
        link: link
    }
});