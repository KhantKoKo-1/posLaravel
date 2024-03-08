@extends('layouts.frontend.master')
@section('title','Order List')
@section('content')
<div class="wrapper" ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form class="form-horizontal pull-left">
                            <button class="btn btn-danger" style="margin-right: 100%;" onclick="backPage()">
                                <span class="fas fa-arrow-left fa-lg"></span>
                            </button>
                            </form>
                            <form class="form-horizontal pull-right">
                                <div class="form-group">
                                    <label for="search" >Search : </label>
                                    <input id="search" name="search" type="text" class="form-control" style="width: 200px;"></input>       
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th style="width:300px !important;">Order No</th>
                                <th style="width:200px !important;">Order Time</th>
                                <th style="width:100px !important;">View</th>
                                <th style="width:200px !important;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="orderData in orderDatas">
                                <!-- <td></td> -->
                                <td>
                                    
                                <span ng-class="{ 'underline-button': orderData.status === 2 }">@{{orderData.order_no}}</span>
                                    <span ng-if="orderData.status == 0" class="badge badge-primary">unpaid</span>
                                    <span ng-if="orderData.status == 1" class="badge badge-success">paid</span>
                                    <span ng-if="orderData.status == 2" class="badge badge-danger">cancel</span>
                                </td>
                                <td> @{{orderData.created_at.time}}</td>
                                <td>
                                    <a href="{{asset('order-detail')}}/@{{orderData.id}}" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Detail</a>
                               </td>
                                <td>
                                <a class="btn btn-outline-success" href="{{ url('order_edit/') }}/@{{orderData.id}}"  ng-if="orderData.status === 0">
                                    <i class="fas fa-credit-card"></i>&nbsp;Edit
                                </a>
                                
                                <button class="btn btn-primary" ng-if="orderData.status === 0" ng-click="payOrder(orderData.id)"><i class="fas fa-credit-card"></i>&nbsp;To Pay</button>
                                <a href="#" class="btn btn-info" ng-if="orderData.status === 2" ng-click="confirmBox(orderData.id,0)"><i class="fas fa-check">&nbsp;Active</i></a>    
                                <a href="#" class="btn btn-danger" ng-if="orderData.status === 0" ng-click="confirmBox(orderData.id,2)"><i class="fas fa-times">&nbsp;Cancel</i></a>    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="footer text-center">
    <img src="">
</div><!-- footer -->
</div><!-- wrapper -->
<script src="{{asset('asset/js/page/orderList.js')}}"></script>
@endsection