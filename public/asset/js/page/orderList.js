var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope, $http) {
    $scope.baseUrl = base_url; //using base_url from template/template_header.php
    $scope.shiftId = shift_id; //using shift_id from template/template_header.php
    $scope.orderDatas = [];
    $scope.originalOrderDatas = [];
    $scope.searchData = [];

    $scope.init = function () {
        $scope.fetchOrder();
    };

    $scope.fetchOrder = function () {
        var data = {
            shift_id: $scope.shiftId,
        };
        const url = $scope.baseUrl + "api/get-orders";
        $http
            .post(url, data)
            .then(function (response) {
                $scope.orderDatas = response.data.data;
                $scope.originalOrderDatas = response.data.data;
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.confirmBox = function (orderId, status) {
        let icon, text;

        if (status === 2) {
            icon = "warning";
            text = "Order Cancel";
        } else {
            icon = "info";
            text = "Active";
        }

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!!",
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: text,
        }).then((result) => {
            if (result.isConfirmed) {
                $scope.orderStatus(orderId, status);
            }
        });
    };

    $scope.orderStatus = function (orderId, status) {
        var data = {
            order_id: orderId,
            status: status,
        };
        const url = $scope.baseUrl + "api/change-order-status";
        $http
            .post(url, data)
            .then(function (response) {
                if (response.data.status == 200) {
                    $scope.init();
                }
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.orderDetailPage = function (orderId) {
        window.location.href =
            base_url + `sg_frontend/order_detail?id=${orderId}`;
    };

    $scope.payOrder = function (orderId) {
        window.location.href = base_url + `payment/${orderId}`;
    };

    $scope.searchOrder = function () {
        let searchData = $scope.searchData;
        let orderData = $scope.originalOrderDatas;
        if (searchData == "") {
            $scope.fetchOrder();
        } else {
            $scope.orderDatas = orderData.filter((order) => {
                return order.order_no.startsWith(searchData);
            });
        }
    };
});
