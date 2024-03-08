  @extends('layouts.backend.master')
  <!-- page content -->
  @section('title','Daily Report')
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
                              <input type="text" id="startMonth" name="start_month" value="{{$start_month}}" placeholder="From"/>
                            </div>
                            <div class="col-2">
                              <input type="text" id="endMonth" name="end_month" value="{{$end_month}}" placeholder="To"/>
                            </div>
                            <div class="col-5 mr-10">
                              <button type="button" id="search" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Search</button>
                            </div>
                            </form>
                            <div class="col-3">
                            <form action="{{ route('monthlyItemReportDownload') }}" id="downloadForm" method="post">
                                @csrf
                                <input type="hidden" id="start_month" name="start" />
                                <input type="hidden" id="end_month" name="end" />
                                <button type="button" id="download" class="btn btn-success"><i class="fa fa-solid fa-download"></i> Download</button>
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
                              @foreach($sale_datas as $sale_data)
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
          </div>
        
  @include('layouts.backend.partial.footer_start')	

  <!-- /footer end -->
  @include('layouts.backend.partial.footer_end')
  <!-- /footer end -->
  <!-- jquery is here -->
  <script>

    $('#search').click(function() {
            let start_month = $('#startMonth').val();
            let end_month   = $('#endMonth').val();
            if(start_month == '' || end_month == ''){
              new PNotify({
                title: "Oh No!",
                text: "Please Choice Start Month And End Month",
                type: "error",
                styling: "bootstrap3"
              });
            }else {
                $('#searchForm').submit();
            }
    });

      $('#download').click(function() {
          let start = $('#startMonth').val();
          let end = $('#endMonth').val();
          $('#start_month').val(start);
          $('#end_month').val(end);
          $('#downloadForm').submit();
      });
  </script>
  <!-- jquery end -->
  @include('layouts.backend.partial.footer_end_html')
  @endsection