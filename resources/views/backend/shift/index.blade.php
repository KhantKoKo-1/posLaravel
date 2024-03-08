@extends('layouts.backend.master')
@section('title', 'Shift List')
<!-- page content -->
@section('content')
		<!-- page content -->
		<div class="right_col" role="main">
          <div class="">
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Shift List </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div>
                  <form action="" id="shift" method="POST">
                    @csrf
                    <input type="hidden" name="id" value='' />
                  <button type="button" class="btn btn-primary btn-lg" onclick="confirmBox('Do you want to open shift?','shift',event)" style="display: {{ $shiftOpened == 0 ? 'block' : 'none' }}">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                    <span class="glyphicon-class">Open-Time</span>
                  </button>
                  <button type="button" class="btn btn-secondary btn-lg" onclick="confirmBox('Do you want to close shift?','shift',event)" style="display: {{ $shiftOpened == 0 ? 'none' : 'block' }}">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                    <span class="glyphicon-class">Close-Time</span>
                  </button>
                  </form>
                  </div>
                  <div class="x_content">
                  <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Start Date Time </th>
                            <th class="column-title">End Date Time </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                            @foreach ($shifts as $shift)
                            <tr class="even pointer">
                            <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td class=" ">{{ $shift->start_date_time }}</td>
                            <td class=" ">{{ $shift->end_date_time }}</td>
                            <td class="last">
                            <a href="{{ url('sg-backend/shift/order-list/' . $shift->id) }}" class="btn btn-info btn-xs" style="width:50%;"><i class="fa fa-pencil"></i> View Order List </a>
                            </tr>
                           @endforeach
                        </tbody>
                      </table>
                      <ul class="pagination" style="margin-left:82%;">
                        {{ $shifts->links() }}
                      </ul>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- /page content -->

		<!-- footer content -->

		<!-- footer content -->
    @include('layouts.backend.partial.footer_start')
		<!-- /footer content -->
</div>
</div>
<!-- /footer end -->
@include('layouts.backend.partial.footer_end')
<!-- /footer end -->

<!-- jquery is here -->
@if($shiftOpened == 0)
    <script>
        document.getElementById('shift').action = "{{ url('sg-backend/shift/start') }}";
    </script>
@else
    <script>
        document.getElementById('shift').action = "{{ url('sg-backend/shift/end') }}";
    </script>
@endif
<!-- jquery end -->
@include('layouts.backend.partial.footer_end_html')
@endsection