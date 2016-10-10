app.directive('categoryModal', function () {
    return {
        restrict: 'E',
        scope: false,
        transclude: true,
        templateUrl: './html/directives/categoryModal.html'
    };
});