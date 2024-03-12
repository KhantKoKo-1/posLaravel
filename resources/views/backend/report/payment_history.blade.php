  @extends('layouts.backend.master')
  @section('title', 'Payment History')
  @section('content')
      <!-- page content -->
      <div class="right_col" role="main">
          <div class="">
              <div class="row" style="display: block;">
                  <div class="col-md-12 col-sm-12  ">
                      <div class="x_panel">
                          <div class="x_title">
                              <h2> Payment History </h2>
                              <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                              <div class="">
                                  <form action="{{ route('paymentHistoryDownload') }}" id="downloadForm" method="post">
                                      @csrf
                                      <input type="hidden" id="shift_date" name="shift_date" value="{{ $shift_date }}" />
                                      <button type="button" id="download" class="btn btn-success"><i
                                              class="fa fa-solid fa-download"></i> Download</button>
                                  </form>
                              </div>
                          </div>
                          </br>
                          <div class="table-responsive">
                              <table class="table table-striped jambo_table bulk_action">
                                  <thead>
                                      <tr class="headings">
                                          <th class="column-title">Cash</th>
                                          <th class="column-title">Quantity</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($payments as $payment)
                                          <tr class="even pointer">
                                              @if ($payment->total == '')
                                                  <td>{{ $payment->cash }}</td>
                                                  <td>{{ $payment->total_quantity }}</td>
                                              @else
                                                  <th>Total</th>
                                                  <th>{{ $payment->total }}</th>
                                              @endif
                          </div>
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
      <!-- /page content -->
      <!-- footer start -->
      @include('layouts.backend.partial.footer_start')
      <!-- /footer start -->

      <!-- /footer end -->
      @include('layouts.backend.partial.footer_end')
      <!-- /footer end -->
      <!-- jquery is here -->
      <script>
          $('#download').click(function() {
              let start = $('#start_date_picker').val();
              let end = $('#end_date_picker').val();
              $('#start_date').val(start);
              $('#end_date').val(end);
              $('#downloadForm').submit();
          });
      </script>
      <!-- jquery end -->

      @include('layouts.backend.partial.footer_end_html')
  @endsection
