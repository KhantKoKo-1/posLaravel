var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope,$http) {
   $scope.base_url =  base_url;
   $scope.orderDetail = [];
   $scope.orderItems = [];
   $scope.totalQty = 0;
   $scope.totalAmount = 0;

  $scope.init = function(orderId){
      $scope.orderDetail(orderId)
  }

  $scope.orderDetail = function (orderId) {
    $http({
      method: "POST",
      url: base_url + "api/fetch-order-detail",
      data: {
            order_id:orderId,
            shift_id:shift_id
         },
    }).then(
      function (response) {
        if (response.status == 200) {
          $scope.orderDetail= response.data.data;
          $scope.orderItems =$scope.orderDetail['orderDetail'];
          $scope.totalQty = 0;
          $scope.orderItems.forEach(items => {
            $scope.totalQty += items.quantity 
            $scope.totalAmount += items.total_amount; 
          });
          console.log($scope.totalAmount);
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