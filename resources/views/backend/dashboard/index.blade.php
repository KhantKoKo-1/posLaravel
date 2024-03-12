@extends('layouts.backend.master')
@section('title', 'Dashboard')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <h2>
                    Daily Sale Report
                </h2>
                <div id="graph_bar" style="height:400px;"></div>
            </div>
            <div class="col-sm-6 col-md-6">
                <h2>
                    Daily Best Selling Item Report
                </h2>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        <div class="clearFix"></div>
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <h2>
                    Monthly Sale Report
                </h2>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="col-sm-6 col-md-6">
                <h2>
                    Monthly Best Selling Item Report
                </h2>
                <canvas id="canvasDoughnut"></canvas>
            </div>
        </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    @include('layouts.backend.partial.footer_start')
    <!-- /footer content -->

    <!-- /footer end -->
    @include('layouts.backend.partial.footer_end')
    <!-- /footer end -->

    <!-- jquery is here -->
    <!-- jquery end -->

    </html>
@endsection
