app.directive('alertModal', function () {
    return {
        restrict: 'E',
        scope: false,
        transclude: true,
        templateUrl: './html/directives/alertModal.html'
    };
});