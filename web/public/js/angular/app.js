var gqAus = angular.module("gqAus", ['ui.bootstrap', 's3Upload', 'underscore', 'ui.select', 'ngSanitize']);
gqAus.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});