app.factory('API', ['config', '$http', function (config, $http) {

    var factory = {};

    var observation = {};
    var category = {};
    var user = {};
    var device = {};
    var tool = {};

    observation.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/observations'
        });
    };

    observation.getById = function (id) {
        return $http({
            method: 'GET',
            url: config.url + '/observation/' + id
        });
    };

    observation.create = function (obsData) {
        var data = {
            user_1: obsData.user_1,
            user_2: !obsData.user_2 ? undefined : obsData.user_2,
            device: obsData.device,
            categories: obsData.categories,
            tool: obsData.tool,
            toolParams: obsData.toolParams,
            observations: obsData.observations,
            implications: !obsData.implications ? undefined : obsData.implications,
            files: !obsData.files || obsData.files.length == 0 ? undefined : obsData.files
        };
        return $http({
            method: 'POST',
            url: config.url + '/observation',
            headers: {
                'Content-Type': 'application/json'
            },
            data: data
        });
    };

    category.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/categories'
        });
    };
    
    user.getAll = function() {
        return $http({
            method: 'GET',
            url: config.url + '/users'
        });
    };
    
    device.getAll = function() {
        return $http({
            method: 'GET',
            url: config.url + '/devices'
        });
    };
    
    tool.getAll = function() {
        return $http({
            method: 'GET',
            url: config.url + '/tools'
        });
    };


    factory.observation = observation;
    factory.category = category;
    factory.user = user;
    factory.device = device;
    factory.tool = tool;
    return factory;

}]);