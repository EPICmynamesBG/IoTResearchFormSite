app.directive('modal', function () {
    return {
        restrict: 'E',
        scope: false,
        transclude: true,
        templateUrl: './html/directives/modal.html'
    };
});