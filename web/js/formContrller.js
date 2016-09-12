function FormCntl($scope, $compile) {
    // Consider using FosJsRouting bundle, if you want to use a Symfony2 route
    $scope.formUrl = "http://url-to-fetch-my-form";

    // Data from the form will be binded here
    $scope.data = {};

    // Method called when submitting the form
    $scope.submit = function() {
        // Add your own logic, for example show the response your received from Symfony2
        // We have to explictly compile the data received, to parse AngularJS tags
        $scope.formResponse = $compile(data)($scope);
    }
}