var app = angular.module('app', ['ui.grid', 'ui.router']);

var prodURL = 'http://bgroff-pi2.dhcp.bsu.edu/backend/public';
var devURL = 'http://localhost:8888/IoTResearchFormSite/backend/public';

app.constant('config', {
    dev: true,
    url: devURL
});

app.run(function($rootScope, config) {
    $rootScope.config = config;
});


/* --- Routing --- */

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");

    $stateProvider
        .state('form', {
            url: '/',
            templateUrl: "html/form.html",
            controller: 'InputFormController',
            data: {}
        })
        .state('search', {
            url: "/search",
            templateUrl: "html/search.html",
            controller: 'SearchController',
            data: {}
        });
});