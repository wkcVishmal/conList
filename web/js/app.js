//Angular Application for get data from "http://localhost:8000/listdata" API and set them to scope variable
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
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
    };

    $scope.hide = function (id) {
        $scope.id = id;

    };

    $scope.open = function() {
        $scope.showModal = true;
    };

    $scope.ok = function() {
        $scope.showModal = false;
    };

    $scope.cancel = function() {
        $scope.showModal = false;
    };


    $http.get("http://localhost:8000/listdata")
        .then(function(response) {
            $scope.contacts = response.data;
        }, function(response) {
            $scope.contacts = "Something went wrong";
        });




});

//Angular application for create new contact API
//Send data through POST request (http://labs.qandidate.com/blog/2014/08/13/handling-angularjs-post-requests-in-symfony)
var app2 = angular.module('formApp', []);
app2.controller('formCtrl', function($scope, $http) {
    $scope.data = {};
    $scope.show = false;
    $scope.update = function(con) {
        $scope.data = angular.copy(con);

        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        $http.post('http://localhost:8000/saveContact', $scope.data, config)
            .success(function (data, status, headers, config) {
                $scope.show = true;
                $scope.PostDataResponse = data;

                //$scope.PostDataResponse = "sucsess";
            })
            .error(function (data, status, header, config) {
                $scope.ResponseDetails = "Data: " + data +
                    "<hr />status: " + status +
                    "<hr />headers: " + header +
                    "<hr />config: " + config;
            });

    };



});

