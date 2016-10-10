app.controller('InputFormController', ['$scope', '$state', 'API', function ($scope, $state, API) {

    $scope.showAlertModal = false;
    $scope.showCategoryModal = false;
    $scope.viewCategory = null;
    $scope.alert = null;
    
    var initialize = function () {
        $scope.categories = [];
        $scope.input = {};
        $scope.input.categories = [];
        $scope.disableAddFileButton = true;
        $scope.urlEntries = [null];
    };
    initialize();

    $scope.urlTyping = function (index, newtext) {
        if (!newtext || newtext.length < 4) {
            $scope.urlEntries[index] = null;
            $scope.disableAddFileButton = true;
        } else {
            $scope.urlEntries[index] = newtext;
            $scope.disableAddFileButton = false;
        }
    };

    $scope.addFileUrl = function () {
        var lastItem = $scope.urlEntries[$scope.urlEntries.length - 1];
        if (lastItem.length != null) {
            $scope.urlEntries.push(null);
            $scope.disableAddFileButton = true;
        }
    };

    $scope.toggleSelection = function (category) {
        var found = $scope.input.categories.indexOf(category.id);
        if (found == -1) {
            $scope.input.categories.push(category.id);
        } else {
            $scope.input.categories.splice(found, 1);
        }
    };

    API.category.getAll()
        .then(function (data) {
            $scope.categories = data.data.data;
        }, function (error) {
            $scope.showAlert("Error", error.message);
            console.log(error);
        });

    $scope.submit = function () {
        $scope.input.files = $scope.urlEntries;
        API.observation.create($scope.input)
            .then(function (data) {
                $scope.showAlert("Success", "The observation has been recorded");
                initialize();
            }, function (error) {
                $scope.showAlert("Error", error.message);
                console.log(error);
            });
    };
    
    $scope.showCategoryInfo = function(category){
        $scope.viewCategory = category;
        $scope.showCategoryModal = true;
    };
    
    $scope.hideCategoryModal = function() {
        $scope.showCategoryModal = false;
    };
    
    $scope.showAlert = function(header, body) {
        $scope.alert = {
            'header': header,
            'body': body
        };
        $scope.showAlertModal = true;
    };
    
    $scope.hideAlert = function() {
        $scope.showAlertModal = false;
    };

}]);