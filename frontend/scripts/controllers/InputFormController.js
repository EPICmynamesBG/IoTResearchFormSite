app.controller('InputFormController', ['$scope', '$state', 'API', function ($scope, $state, API) {

    $scope.categories = [];

    console.log(API);
    API.category.getAll()
        .then(function (data) {
            $scope.categories = data.data.data;
        }, function (error) {
            console.log(error);
        });

}]);