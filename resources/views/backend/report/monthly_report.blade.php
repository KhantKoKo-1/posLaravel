  @extends('layouts.backend.master')
  @section('title', 'Daily Report')
  @section('content')
      <!-- page content -->
      <div class="right_col" role="main">
          <div class="">
              <div class="row" style="display: block;">
                  <div class="col-md-12 col-sm-12  ">
                      <div class="x_panel">
                          <div class="x_title">
                              <h2> Monthly Report </h2>
                              <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                              <form action="" id="searchForm" method="get">
                                  <div class="row">
                                      <div class="col-2">
                                          <input type="text" id="startMonth" name="start_month"
                                              value="{{ $start_month }}" placeholder="From" />
                                      </div>
                                      <div class="col-2">
                                          <input type="text" id="endMonth" name="end_month" value="{{ $end_month }}"
                                              placeholder="To" />
                                      </div>
                                      <div class="col-4 ml-10">
                                          <button type="button" id="search" class="btn btn-primary"><i
                                                  class="glyphicon glyphicon-search"></i> Search</button>
                                      </div>
                              </form>
                              <div class="col-3">
                                  <form action="{{ route('monthlyReportDownload') }}" id="downloadForm" method="post">
                                      @csrf
                                      <input type="hidden" id="start" name="start" />
                                      <input type="hidden" id="end" name="end" />
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
                                          <th class="column-title">Date</th>
                                          <th class="column-title">Amount</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($sale_reports as $sale_report)
                                          <tr class="even pointer">
                                              @if ($sale_report->total == '')
                                                  <td>{{ dateFormatYmToYF($sale_report->date) }}</td>
                                                  <td>{{ $sale_report->amount }}</td>
                                              @else
                                                  <th>Total</th>
                                                  <th>{{ $sale_report->total }}</th>
                                              @endif
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
      <!-- /page content -->
      <!-- footer start -->
      @include('layouts.backend.partial.footer_start')
      <!-- /footer start -->

      <!-- /footer end -->
      @include('layouts.backend.partial.footer_end')
      <!-- /footer end -->
      <!-- jquery is here -->
      <script>
          $('#search').click(function() {
              let start_month = $('#startMonth').val();
              let end_month = $('#endMonth').val();
              if (start_month == '' || end_month == '') {
                  new PNotify({
                      title: "Oh No!",
                      text: "Please Choice Start Month And End Month",
                      type: "error",
                      styling: "bootstrap3"
                  });
              } else {
                  $('#searchForm').submit();
              }
          });

          $('#download').click(function() {
              let start = $('#startMonth').val();
              let end = $('#endMonth').val();
              $('#start').val(start);
              $('#end').val(end);
              $('#downloadForm').submit();
          });
      </script>
      <!-- jquery end -->

      @include('layouts.backend.partial.footer_end_html')
  @endsection
