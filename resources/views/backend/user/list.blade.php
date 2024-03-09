@extends('layouts.backend.master')
<!-- page content -->
@section('title','Account List')
@section('content')
	<!-- page content -->
    <div class="right_col" role="main">
          <div class="">
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Account List </h2>
                    <div class="clearfix"></div>
                  </div>
                  <form id="accountSwitch" action="{{ url('sg-backend/account/list/') }}" method="GET">
                      <button type="button" value="admin" class="btn {{ isset($accountType) && $accountType === 'admin' ? 'btn-primary active' : 'btn-default' }}"
                              @if(!isset($accountType) || $accountType !== 'admin') onclick="confirmBox('Are you sure switch admin account type', 'accountSwitch', event)" @endif>
                          Admin
                      </button>
                      <button type="button" value="cashier" class="btn {{ !isset($accountType) || $accountType === 'cashier' ? 'btn-primary active' : 'btn-default' }}"
                              @if(isset($accountType) && $accountType !== 'cashier') onclick="confirmBox('Are you sure switch cashier account type', 'accountSwitch', event)" @endif>
                          Cashier
                      </button>
                </form>
                  <div class="x_content">
                  <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title"> Name </th>
                            <th class="column-title"> Status</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions
                              ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                            @foreach($accounts as $account)
                              <tr class="even pointer">
                              <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records">
                              </td>
                              <td class=" ">{{ $account->username }}</td>
                              <td class=" ">
                              <span class="badge badge-primary" style="display:{{ $account->status === 0 ? 'inline' : 'none' }}">Enable</span>
                              <span class="badge badge-secondary" style="display:{{ $account->status === 1 ? 'inline' : 'none' }}">Disable</span>
                              </td>
                              <td class="last">
                              <div class="row">
                                <div class='col-2 col-md-2'>
                                    <a href="{{ url('sg-backend/account/edit/' . $accountType .'/account_info/' . $account->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                </div>
                                <div class='col-3 col-md-3'>
                                    <a href="{{ url('sg-backend/account/edit/'. $accountType .'/password/' . $account->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Change Password </a>
                                </div>
                                <div class='col-3 col-md-3'>
                                <form id="accountDelete" action="{{ url('sg-backend/account/delete') }}" method="POST">
                                  @csrf
                                    <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete('accountDelete',{{ $account->id }})">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </button>
                                    <input type="hidden" name="id" id="delete_id" value="">
                                </form>
                                </div>
                              </div>
                              </td>
                            </tr>
                           @endforeach
                        </tbody>
                      </table>
                      <ul class="pagination" style="margin-left:82%;">
                        {{ $accounts->links() }}
                      </ul>
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

</script>
<!-- jquery end -->
@include('layouts.backend.partial.footer_end_html')
@endsection
