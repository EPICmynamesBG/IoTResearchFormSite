app.controller('SearchController', ['$scope', '$state', 'API', function ($scope, $state, API) {

    $scope.observations = [];
    $scope.parsedObservations = [];

    var parseGridFriendly = function (data) {
        console.log(data);
        var newData = [];
        data.forEach(function (observation) {
            var newObs = angular.copy(observation);
            if (observation.files && observation.files.length > 0) {
                //expand files to comma delimited string
                var fileStr = "";
                observation.files.forEach(function (file) {
                    fileStr += file + ",\n";
                });
                fileStr = fileStr.slice(0, -2);
                newObs.files = fileStr;
            }
            
            //cleanup users display
            var userStr = "";
            observation.users.forEach(function (user) {
                userStr += user.full_name + ",\n";
            });
            userStr = userStr.slice(0, -3);
            newObs.users = userStr;
            
            //cleanup device display
            var dev = observation.device;
            var devStr = dev.manufacturer + " " + dev.model;
            if (dev.version != null) {
                devStr += " v" + dev.version; 
            }
            if (dev.year_manufactured != null){
                devStr += " (" + dev.year_manufactured + ")";
            }
            newObs.device = devStr;
            
            //cleanup tool display
            newObs.tool = observation.tool.name;

            newData.push(newObs);
        });
        console.log(newData);
        return newData;
    };

    var loadObservations = function () {
        API.observation.getAll()
            .then(function (data) {
                $scope.observations = angular.copy(data.data.data);
                $scope.parsedObservations = parseGridFriendly(data.data.data);
            }, function (error) {
                console.log(error);
            });
    };

    loadObservations();

}]);