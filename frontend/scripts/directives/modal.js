app.directive('modal', function () {
    return {
        restrict: 'E',
        scope: false,
        transclude: true, // we want to insert custom content inside the directive
        link: function (scope, element, attrs) {
//            scope.hideModal = function () {
//                scope.show = false;
//            };
        },
        templateUrl: './html/directives/modal.html'
    };
});