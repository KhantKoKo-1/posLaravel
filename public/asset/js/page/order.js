var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope, $http) {
    $scope.base_url = base_url;
    $scope.categories = [];
    $scope.items = [];
    $scope.allItems = [];
    $scope.itemDatas = [];
    $scope.showCategories = true;
    $scope.showItem = false;
    $scope.sameItem = false;
    $scope.checkResult = "";
    $scope.subTotal = 0;
    $scope.subDiscount = {};
    $scope.totalPrice = 0;
    $scope.totalDiscount = 0;
    $scope.searchData = "";
    $scope.init = function ($id) {
        $scope.fetchCategory(0);
        $scope.fetchAllItem();
        if ($id != 0) {
            $scope.fetchOrderItems($id);
        }
    };

    $scope.getChildCategory = function (parent_id) {
        $scope.fetchCategory(parent_id);
    };

    $scope.getParentCategory = function (parent_id) {
        $scope.fetchCategory(parent_id);
    };

    $scope.fetchCategory = function (parent_id) {
        $(".loading").show();
        $scope.showCategories = true;
        $scope.showItem = false;
        $scope.categories = [];
        var data = {
            parent_id: parent_id,
        };
        const url = base_url + "api/get-category";
        $http
            .post(url, data, parent_id)
            .then(function (response) {
                if (response.data.data.length <= 0) {
                    $scope.fetchItem(parent_id);
                } else {
                    $scope.categories = response.data.data;
                }
                $(".loading").hide();
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.fetchItem = function (category_id) {
        $(".loading").show();
        $scope.showCategories = false;
        $scope.showItem = true;
        var data = {
            category_id: category_id,
        };
        const url = base_url + "api/get-items";
        $http
            .post(url, data)
            .then(function (response) {
                $scope.items = response.data.data;
                $(".loading").hide();
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.fetchAllItem = function () {
        var data = {};
        const url = base_url + "api/get-all-items";
        $http
            .post(url, data)
            .then(function (response) {
                $scope.allItems = response.data.data;
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.fetchItemId = function (item_id) {
        $(".loading").show();
        $scope.sameItem = false;
        let data = {
            item_id: item_id,
        };
        const url = base_url + "api/order-item";
        $http
            .post(url, data)
            .then(function (response) {
                var found = false;
                $scope.itemDatas = $scope.itemDatas.map(function (item) {
                    if (item_id === item.id) {
                        found = true;
                        item.quantity += 1;
                        item.total_amount =
                            item.original_amount * item.quantity;
                        item.discount_amount =
                            $scope.subDiscount[item_id] * item.quantity;
                    }
                    return item;
                });
                $scope.sameItem = found;
                if (!$scope.sameItem) {
                    let id = response.data.data[0].id;
                    $scope.itemDatas.push(response.data.data[0]);
                    $scope.subDiscount[id] = parseInt(
                        response.data.data[0].discount_amount
                    );
                }
                $scope.calculationSubTotable();
                $(".loading").hide();
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.itemQuantity = function (type, itemId) {
        $scope.itemDatas = $scope.itemDatas.map(function (item) {
            if (itemId == item.id) {
                item.total_amount +=
                    type === "minus" && item.quantity > 1
                        ? -item.original_amount
                        : type === "plus"
                        ? +item.original_amount
                        : 0;
                item.quantity +=
                    type === "minus" && item.quantity > 1
                        ? -1
                        : type === "plus"
                        ? 1
                        : 0;
                item.discount_amount =
                    $scope.subDiscount[itemId] * item.quantity;
            }
            return item;
        });
        $scope.calculationSubTotable();
    };

    $scope.cancelItem = function (itemId) {
        let removedItem = $scope.itemDatas.find((item) => itemId === item.id);
        if (removedItem) {
            $scope.itemDatas = $scope.itemDatas.filter(
                (item) => itemId !== item.id
            );
        }
        $scope.calculationSubTotable();
    };

    $scope.calculationSubTotable = function () {
        $scope.subTotal = 0;
        $scope.totalDiscount = 0;
        $scope.totalPrice = 0;
        if ($scope.itemDatas.length === 0) {
            $scope.haveItem = false;
        } else {
            $scope.haveItem = true;
        }
        for (i = 0; i < $scope.itemDatas.length; i++) {
            $scope.subTotal += $scope.itemDatas[i].total_amount;
            $scope.totalDiscount += parseInt(
                $scope.itemDatas[i].discount_amount
            );
            $scope.totalPrice += parseInt(
                $scope.itemDatas[i].price * $scope.itemDatas[i].quantity
            );
        }
    };

    $scope.searchItem = function () {
        let searchData = $scope.searchData;
        if (searchData == "") {
            $scope.showCategories = true;
            $scope.showItem = false;
            $scope.fetchCategory(0);
        } else {
            $scope.showCategories = false;
            $scope.showItem = true;
            $scope.items = $scope.allItems.filter((item) => {
                return (
                    item.code_no.startsWith(searchData) ||
                    item.name.toLowerCase().startsWith(searchData.toLowerCase())
                );
            });
        }
    };

    $scope.returnBack = function () {
        $scope.fetchCategory(0);
    };

    $scope.orderConfirm = function (type, orderId = 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Order Now!",
        }).then((result) => {
            if (result.isConfirmed) {
                if (type == "edit") {
                    $scope.editOrder(orderId);
                } else {
                    $scope.makeOrder();
                }
            }
        });
    };

    $scope.makeOrder = function () {
        let data = {
            item: $scope.itemDatas,
            sub_total: $scope.subTotal,
            shift_id: shift_id,
        };
        const url = base_url + "api/make-order";
        $http
            .post(url, data)
            .then(function (response) {
                if (response.data.status === 200) {
                    window.location.href = base_url + "order-list";
                }
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };

    $scope.fetchOrderItems = function (orderId) {
        $http({
            method: "POST",
            url: base_url + "api/fetch_order_items",
            data: { order_id: orderId },
        }).then(
            function (response) {
                if (response.status == 200) {
                    $scope.itemDatas = response.data.data;
                    $scope.itemDatas.map(function (item) {
                        $scope.subDiscount[item.id] = item.discount_amount;
                    });

                    for (i = 0; i < $scope.itemDatas.length; i++) {
                        $scope.itemDatas[i].discount_amount *=
                            $scope.itemDatas[i].quantity;
                        $scope.itemDatas[i].total_amount *=
                            $scope.itemDatas[i].quantity;
                    }
                    $scope.calculationSubTotable();
                } else {
                    console.log("Error:" + response.status);
                }
            },
            function (error) {
                console.error(error);
            }
        );
    };

    $scope.editOrder = function (orderId) {
        let data = {
            item: $scope.itemDatas,
            sub_total: $scope.subTotal,
            shift_id: shift_id,
            order_id: orderId,
        };
        const url = base_url + "api/order-edit";
        $http
            .post(url, data)
            .then(function (response) {
                if (response.data.status === 200) {
                    window.location.href = base_url + "order-list";
                }
            })
            .catch(function (error) {
                console.error("Error fetching data:", error);
            });
    };
});
