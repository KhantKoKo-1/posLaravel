var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope, $http) {
    $scope.base_url = base_url;
    $scope.orderItems = [];
    $scope.orderDetail = [];
    $scope.cashAmounts = [];
    $scope.selectIndex = [];
    $scope.totalAmount = 0;
    $scope.paymentQty = "";
    $scope.payMoney = 0;
    $scope.refund = 0;
    $scope.isDisabled = false;

    $scope.init = function (orderId) {
        $http({
            method: "POST",
            url: base_url + "api/payment/get-order-detail",
            data: {
                order_id: orderId,
                shift_id: shift_id,
            },
        }).then(
            function (response) {
                if (response.status == 200) {
                    $scope.orderItems = response.data.data["orderDetail"];
                    $scope.orderDetail = response.data.data;
                    $scope.orderItems.forEach((orders) => {
                        $scope.totalAmount += orders.total_amount;
                    });
                } else {
                    console.log("Error:" + response.status);
                }
            },
            function (error) {
                console.error(error);
            }
        );
    };

    $scope.cashPayment = function (money) {
        let payment = {
            cash: money,
            origin_amount: money,
            index: $scope.cashAmounts.length + 1,
            quantity: 1,
        };
        let total_amount = $scope.totalAmount;
        if ($scope.paymentQty != "" && $scope.paymentQty != 1) {
            let amount = parseInt(money * $scope.paymentQty);
            $scope.payMoney = $scope.payMoney + amount;
            payment = {
                cash: parseInt(amount),
                origin_amount: money,
                index: $scope.cashAmounts.length + 1,
                quantity: $scope.paymentQty,
            };
            $scope.cashAmounts.push(payment);
        } else {
            $scope.payMoney += parseInt(money);
            $scope.cashAmounts.push(payment);
        }
        $scope.paymentQty = "";

        if ($scope.payMoney >= total_amount) {
            $scope.refund = $scope.payMoney - total_amount;
            $scope.isDisabled = true;
        }
    };

    $scope.numberClick = function (number) {
        $scope.paymentQty += number;
    };

    $scope.cashMoneyClick = function (index) {
        let indexExists = $scope.selectIndex.includes(index);
        indexExists
            ? $scope.selectIndex.splice($scope.selectIndex.indexOf(index), 1)
            : $scope.selectIndex.push(index);
    };

    $scope.void = function () {
        let total_amount = $scope.totalAmount;
        $scope.cashAmounts = $scope.cashAmounts.filter(
            (item) => !$scope.selectIndex.includes(item.index)
        );
        $scope.payMoney = 0;
        for (let i = 0; i < $scope.cashAmounts.length; i++) {
            $scope.payMoney += $scope.cashAmounts[i].cash;
            $scope.cashAmounts[i].index = i + 1;
            $scope.selectIndex = [];
        }
        if ($scope.payMoney < total_amount) {
            $scope.refund = 0;
            $scope.isDisabled = false;
        } else {
            $scope.refund = $scope.payMoney - total_amount;
        }
    };

    $scope.clearInput = function () {
        $scope.paymentQty = "";
    };

    $scope.storePayment = function (orderId) {
        var data = {
            order_id: orderId,
            shift_id: shift_id,
            cash_amount: $scope.cashAmounts,
            payment: $scope.payMoney,
            refund: $scope.refund,
        };
        $http({
            method: "POST",
            url: base_url + "api/payment/store-payment",
            data: data,
        }).then(
            function (response) {
                if (response.data["status"] == 200) {
                    window.location.href = base_url + `order-list`;
                } else {
                    console.log("Error:" + response.status);
                }
            },
            function (error) {
                console.error(error);
            }
        );
    };
});
