  @extends('layouts.backend.master')
  <!-- page content -->
  @section('title','Order List')
  @section('content')
    <!-- page content -->
      <div class="right_col" role="main">
            <div class="">
              <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2> Order List </h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-3" >
                        <form action="{{ route('downloadOrders') }}" method="post">
                            @csrf
                            <input type="hidden" name="shift_id" value="{{$id}}" />
                            <button type="submit" class="btn btn-success"><i class="fa fa-solid fa-download"></i> Download</button>
                        </form>
                        </div>
                      </div>
                    </br>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                          <thead>
                            <tr class="headings">
                              <th class="column-title"> Order No </th>
                              <th class="column-title"> Order Time </th>
                              <th class="column-title"> Payment </th>
                              <th class="column-title"> Refund </th>
                              <th class="column-title"> Total Amount </th>
                              <th class="column-title"> Status </th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($orders as $order)
                                <tr class="even pointer">
                                  <td>{{ $order->order_no }}</td>
                                  <td>{{ $order->order_time }}</td>
                                  <td>{{ $order->payment }}</td>
                                  <td>{{ $order->refund }}</td>
                                  <td>{{ $order->total_amount }}</td>
                                  <td>
                                   @if($order->status == "unpaid")
                                    <span class="badge badge-primary">unpaid</span>
                                   @elseif($order->status == "paid")
                                    <span class="badge badge-success">paid</span>
                                   @else
                                    <span class="badge badge-danger">cancel</span>
                                   @endif
                                  </td>
                              </tr>
                           @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
  @include('layouts.backend.partial.footer_start')	

  <!-- /footer end -->
  @include('layouts.backend.partial.footer_end')
  <!-- /footer end -->
  <!-- jquery is here -->

  <!-- jquery end -->
  @include('layouts.backend.partial.footer_end_html')
  @endsection