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
                            <!-- <a href="#" class="btn btn-sm btn-primary pull-left"><i class="fa fa-plus-circle"></i> Add New</a> -->
                            <form class="form-horizontal pull-left">
                                <div class="form-group">
                                    <label>Show : </label>
                                    <select class="form-control">
                                        <option>5</option>
                                        <option>10</option>
                                        <option>15</option>
                                        <option>20</option>
                                    </select>
                                </div>
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
                                    <a href="" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Detail</a>
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
                        <div class="col-sm-6 col-xs-6">showing <b>5</b> out of <b>25</b> entries</div>
                        <div class="col-sm-6 col-xs-6">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
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