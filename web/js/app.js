var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
    $http.get("http://localhost:8000/listdata")
        .then(function(response) {
            $scope.contacts = response.data;
        }, function(response) {
            $scope.contacts = "Something went wrong";
        });

});


var app2 = angular.module('formApp', []);
app2.controller('formCtrl', function($scope, $http) {
    $scope.data = {};

    $scope.update = function(con) {
        $scope.data = angular.copy(con);

        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        $http.post('http://localhost:8000/saveContact', data, config)
            .success(function (data, status, headers, config) {
                //$scope.PostDataResponse = data;
                $scope.PostDataResponse = "sucsess";
            })
            .error(function (data, status, header, config) {
                $scope.ResponseDetails = "Data: " + data +
                    "<hr />status: " + status +
                    "<hr />headers: " + header +
                    "<hr />config: " + config;
            });

    };

});