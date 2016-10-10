app.controller('SearchController', ['$scope', '$state', 'API', function ($scope, $state, API) {

    $scope.observations = [];
    $scope.parsedObservations = [];
    $scope.loading = false;
    $scope.modalItem = null;
    $scope.showModal = false;

    $scope.gridOptions = {
        enableFullRowSelection: true,
        enableRowSelection: true,
        multiSelect: false,
        enableRowHeaderSelection: false,
        data: $scope.parsedObservations,
        enableFiltering: true,
        enableSorting: true,
        rowHeight: 40,
        columnDefs: [
            {
                name: ' ',
                cellTemplate: './html/templates/buttonCell.html',
                enableFiltering: false,
                enableSorting: false,
                enableHiding: false
            },
            {
                field: 'users',
                enableHiding: false
            },
            {
                field: 'device',
                enableHiding: false
            },
            {
                field: 'tool',
                enableHiding: false
            }
        ],
        onRegisterApi: function (gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    var parseGridFriendly = function (data) {
        var newData = [];
        data.forEach(function (observation) {
            var newObs = angular.copy(observation);
            if (observation.files && observation.files.length > 0) {
                newObs.files = observation.files.length;
            } else {
                newObs.files = 0;
            }

            //cleanup users display
            var userStr = "";
            observation.users.forEach(function (user) {
                userStr += user.full_name + ",\n";
            });
            userStr = userStr.slice(0, -2);
            newObs.users = userStr;

            //cleanup device display
            var dev = observation.device;
            var devStr = dev.manufacturer + " " + dev.model;
            if (dev.version != null) {
                devStr += " v" + dev.version;
            }
            if (dev.year_manufactured != null) {
                devStr += " (" + dev.year_manufactured + ")";
            }
            newObs.device = devStr;

            //cleanup tool display
            newObs.tool = observation.tool.name;

            newData.push(newObs);
        });

        return newData;
    };

    var loadObservations = function () {
        $scope.loading = true;
        API.observation.getAll()
            .then(function (data) {
                $scope.observations = angular.copy(data.data.data);
                $scope.parsedObservations = parseGridFriendly(data.data.data);
                $scope.gridOptions.data = $scope.parsedObservations;
            }, function (error) {
                console.log(error);
            })
            .finally(function () {
                $scope.loading = false;
            });
    };

    loadObservations();

    $scope.onClick = function (value) {
        $scope.loading = true;
        API.observation.getById(value)
            .then(function (data) {
                $scope.modalItem = data.data.data;
                console.log($scope.modalItem);
                $scope.showModal = true;
            }, function (error) {
                console.log(error);
            })
            .finally(function () {
                $scope.loading = false;
            });
    };

    $scope.hideModal = function () {
        $scope.showModal = false;
    }

}]);