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
                              <h2> Daily Report </h2>
                              <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                              <form action="" id="searchForm" method="get">
                                  <div class="row">
                                      <label for="start_date_picker" class="col-form-label label-align">Start Date<span
                                              class="required">*</span></label>
                                      <div class="col-2">
                                          <input type="text" placeholder="Start Date"
                                              class="form-control has-feedback-left" name="start_date_picker"
                                              id="start_date_picker" value="{{ $start }}"
                                              aria-describedby="inputSuccess2Status" readonly>
                                          <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                          <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                      </div>
                                      <label for="end_date_picker" class="col-form-label label-align">End Date<span
                                              class="required">*</span></label>
                                      <div class="col-2">
                                          <input type="text" placeholder="End Date"
                                              class="form-control has-feedback-left" name="end_date_picker"
                                              id="end_date_picker" value="{{ $end }}"
                                              aria-describedby="inputSuccess2Status" readonly>
                                          <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                          <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                      </div>

                                      <div class="col-4 ml-10">
                                          <button type="button" id="search" class="btn btn-primary"><i
                                                  class="glyphicon glyphicon-search"></i> Search</button>
                                      </div>
                              </form>
                              <div class="col-3">
                                  <form action="{{ route('dailyItemReportDownload') }}" id="downloadForm" method="post">
                                      @csrf
                                      <input type="hidden" id="start_date" name="start_date" />
                                      <input type="hidden" id="end_date" name="end_date" />
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
                                          <th class="column-title">Item Name</th>
                                          <th class="column-title">Total Price</th>
                                          <th class="column-title">Total Quantity</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($sale_datas as $sale_data)
                                          <tr class="even pointer">
                                              <td>{{ $sale_data->date }}</td>
                                              <td>{{ $sale_data->item_name }}</td>
                                              <td>{{ $sale_data->total_price }}</td>
                                              <td>{{ $sale_data->total_quantity }}</td>
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
              let start_date = $('#start_date_picker').val();
              let end_date = $('#end_date_picker').val();
              if (start_date == '' || end_date == '') {
                  new PNotify({
                      title: "Oh No!",
                      text: "Please Choice Start Date And End Date",
                      type: "error",
                      styling: "bootstrap3"
                  });
              } else {
                  $('#searchForm').submit();
              }
          });

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
