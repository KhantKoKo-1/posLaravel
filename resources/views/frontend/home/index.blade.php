@extends('layouts.frontend.master')
@section('title', 'DASHBOARD')
@section('content')
    <!-- ========================= SECTION CONTENT ========================= -->
    <div class="content ">
        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                <span class="badge badge-pill badge-success">Success</span> You successfully read this important alert
                message.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <a href="{{ url('order/') }}">
            <div class="col-sm-6 col-lg-6">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-2">
                        <div class="float-right">
                            <h1><i class="fa fa-cart-plus"></i></h1>
                        </div>
                        <p class="text-light">Order</p>
                        <div class="chart-wrapper px-0" style="height:200px;" height="70">
                            <canvas id="widgetChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ url('order-list/') }}">
            <div class="col-sm-6 col-lg-6">
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-2">
                        <div class="float-right">
                            <h1><i class="fa fa-list"></i></h1>
                        </div>
                        <p class="text-light">Order List</p>
                        <div class="chart-wrapper px-0" style="height:200px;" height="70">
                            <canvas id="widgetChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-money text-success border-success"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Profit</div>
                            <div class="stat-digit">1,012</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="fa fa-cart-plus text-primary border-primary"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Order</div>
                            <div class="stat-digit">961</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="fa fa-cart-plus text-primary border-primary"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Cancle Order</div>
                            <div class="stat-digit">961</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="fa-check-square text-primary border-primary"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Paid Order</div>
                            <div class="stat-digit">961</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================= SECTION CONTENT END// ========================= -->
@endsection
