//Angular Application for get data from "http://localhost:8000/listdata" API and set them to scope variable

var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {

    $http.get("http://localhost:8000/listdata")
        .then(function(response) {
            $scope.contacts = response.data;
        }, function(response) {
            $scope.contacts = "Something went wrong";
        });

    $scope.data = {};
    $scope.delete = function (id) {
        $scope.id = id;
        $scope.data = {
            "id": $scope.id
        };

        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };

        var x;
        if (confirm('Are you sure?\nDo you want to delete this contact?\n Contact id : '+$scope.id) == true) {
            $http.post('http://localhost:8000/deleteContact', $scope.data, config)
                .success(function (data, status, headers, config) {
                    $http.get("http://localhost:8000/listdata")
                        .then(function(response) {
                            $scope.contacts = response.data;
                        }, function(response) {
                            $scope.contacts = "Something went wrong";
                        });
                })
                .error(function (data, status, header, config) {
                    $scope.ResponseDetails = "Data: " + data +
                        "<hr />status: " + status +
                        "<hr />headers: " + header +
                        "<hr />config: " + config;
                });
        } else {
            x = "You pressed Cancel!";
        }

    };

    $scope.data = {};
    $scope.edit = function (id) {
        $scope.id = id;
        $scope.data = {
            "id": $scope.id
        };

        $http.get("http://localhost:8000/listdata")
            .then(function(response) {
                $scope.contact = response.data;
                return $scope.contact.id === $scope.id;

            }, function(response) {
                $scope.contacts = "Something went wrong";
            });

        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };

            $http.post('http://localhost:8000/getContact', $scope.data, config)
                .success(function (data, status, headers, config) {
                    $http.get("http://localhost:8000/listdata")
                        .then(function(response) {
                            $scope.contacts = response.data;
                        }, function(response) {
                            $scope.contacts = "Something went wrong";
                        });
                })
                .error(function (data, status, header, config) {
                    $scope.ResponseDetails = "Data: " + data +
                        "<hr />status: " + status +
                        "<hr />headers: " + header +
                        "<hr />config: " + config;
                });


    };

});
