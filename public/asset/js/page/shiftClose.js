var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope, $http) {
    $scope.baseUrl = base_url; //using base_url from template/template_header.php
    $scope.shiftId = shift_id; //using shift_id from template/template_header.php
    $scope.shiftDate = [];
    $scope.daysOfWeek = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
    ];

    $scope.init = function () {
        $scope.fetchDate($scope.shiftId);
    };

    $scope.fetchDate = function (shiftId) {
        var data = {
            shift_id: shiftId,
        };
        const url = $scope.baseUrl + "api/get_week_date";
        $http
            .post(url, data)
            .then(function (response) {
                $scope.shiftDate = response.data;
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };
});
