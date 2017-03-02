var gqAus = angular.module("gqAus", ['ui.bootstrap', 's3Upload', 'underscore', 'ui.select', 'ngSanitize', 'angularUtils.directives.dirPagination']);
gqAus.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});