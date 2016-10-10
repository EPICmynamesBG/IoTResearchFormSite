app.controller('InputFormController', ['$scope', '$state', 'API', function ($scope, $state, API) {

    $scope.showAlertModal = false;
    $scope.showCategoryModal = false;
    $scope.viewCategory = null;
    $scope.alert = null;
    $scope.loading = false;


    var loadData = function () {
        $scope.loading = true;
        var prom1 = new Promise(function (resolve, reject) {
            API.category.getAll()
                .then(function (data) {
                    $scope.categories = data.data.data;
                    resolve(data.data.data);
                }, function (error) {
                    reject(error);
                });
        });
        var prom2 = new Promise(function (resolve, reject) {
            API.user.getAll()
                .then(function (data) {
                    $scope.userList = data.data.data;
                    resolve(data.data.data);
                }, function (error) {
                    reject(error);
                });
        });
        var prom3 = new Promise(function (resolve, reject) {
            API.device.getAll()
                .then(function (data) {
                    $scope.deviceList = data.data.data;
                    resolve(data.data.data);
                }, function (error) {
                    reject(error);
                });
        });
        var prom4 = new Promise(function (resolve, reject) {
            API.tool.getAll()
                .then(function (data) {
                    console.log(data);
                    $scope.toolList = data.data.data;
                    console.log($scope.toolList);
                    resolve(data.data.data);
                }, function (error) {
                    reject(error);
                });
        });

        var promArr = [prom1, prom2, prom3, prom4];
        Promise.all(promArr).then(values => {
            console.log("Success");
            $scope.loading = false;
            $scope.$apply();
            $('select').material_select();
        }, reason => {
            console.log(reason);
            $scope.loading = false;
            $scope.$apply();
            $('select').material_select();
        });
    }

    var initialize = function () {
        $scope.categories = [];
        $scope.input = {};
        $scope.input.categories = [];
        $scope.disableAddFileButton = true;
        $scope.urlEntries = [null];
        $scope.userList = [];
        $scope.deviceList = [];
        $scope.toolList = [];
        $scope.selectUser1 = "";
        $scope.selectUser2 = "";
        $scope.selectDevice = "";
        $scope.selectTool = "";
        loadData();
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

    $scope.submit = function () {
        $scope.input.files = $scope.urlEntries;
        if ($scope.selectUser1) {
            $scope.input.user_1 = $scope.selectUser1;
        }
        if ($scope.selectUser2) {
            $scope.input.user_2 = $scope.selectUser2;
        }
        if ($scope.selectDevice) {
            $scope.input.device = $scope.selectDevice;
        }
        if ($scope.selectTool) {
            $scope.input.tool = $scope.selectTool;
        }

        $scope.loading = true;
        API.observation.create($scope.input)
            .then(function (data) {
                $scope.showAlert("Success", "The observation has been recorded");
                initialize();
            }, function (error) {
                $scope.showAlert("Error", error.data.msg);
                console.log(error);
                $scope.loading = false;
            });
    };

    $scope.showCategoryInfo = function (category) {
        $scope.viewCategory = category;
        $scope.showCategoryModal = true;
    };

    $scope.hideCategoryModal = function () {
        $scope.showCategoryModal = false;
    };

    $scope.showAlert = function (header, body) {
        $scope.alert = {
            'header': header,
            'body': body
        };
        $scope.showAlertModal = true;
    };

    $scope.hideAlert = function () {
        $scope.showAlertModal = false;
    };

}]);