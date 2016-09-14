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

